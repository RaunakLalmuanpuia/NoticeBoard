<template>
  <v-container fluid ml-6 mt-6>
    <v-overlay :value="show">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <v-data-table
      :headers="headers"
      :items="applicants"
      sort-by="calories"
      class="elevation-1"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Membership Applicants</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
        </v-toolbar>
      </template>
      <template v-slot:[`item.image`]="{ item }">
        <v-img :src="'/' + item.image" style="width: 50px; height: 50px" />
      </template>
      <template v-slot:[`item.category`]="{ item }">
        <td>{{ item.category.name }}</td>
      </template>
      <template v-slot:[`item.actions`]="{ item }">
        <v-icon
          v-if="item.staus == 'Pending'"
          @click="approveReject('Reject', item.id)"
          small
          class="mr-2"
          color="red"
        >
          mdi-close
        </v-icon>
        <v-icon
          v-if="item.staus == 'Pending'"
          @click="approveReject('Approve', item.id)"
          small
          class="mr-2"
          color="green"
          >mdi-check</v-icon
        >
        <v-icon color="orange" @click="deleteItem(item.id)" small>
          mdi-delete
        </v-icon>
      </template>
    </v-data-table>
    <v-dialog v-model="deleteDialog" max-width="290">
      <v-card>
        <v-card-title class="text-h5">
          Are you sure you want to delete this applicant?
        </v-card-title>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" text @click="deleteDialog = false">
            No
          </v-btn>
          <v-btn color="green darken-1" text @click="confirmDelete">
            Yes
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- approve -->
    <v-dialog v-model="approveDialog" max-width="290">
      <v-card>
        <v-card-title class="text-h5"> Approve applicant? </v-card-title>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" text @click="approveDialog = false">
            No
          </v-btn>
          <v-btn color="green darken-1" text @click="updateApplicationStatus()">
            Yes
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- reject -->
    <v-dialog v-model="rejectDialog" max-width="290">
      <v-card>
        <v-card-title class="text-h5"> Reject applicant? </v-card-title>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" text @click="rejectDialog = false">
            No
          </v-btn>
          <v-btn color="green darken-1" text @click="updateApplicationStatus()">
            Yes
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      show: false,
      dialog: false,
      deleteDialog: false,
      approveDialog: false,
      rejectDialog: false,
      deleteId: "",
      updateStatus: "",
      updateId: "",
      headers: [
        { text: "Name", value: "name", sortable: false },
        { text: "Email", value: "email", sortable: false },
        { text: "Contact", value: "contact", sortable: false },
        { text: "Status", value: "staus", sortable: false },
        { text: "Actions", value: "actions", sortable: false, align: "center" },
      ],
      applicants: [],
      editedIndex: -1,
      editedItem: {
        name: "",
        calories: 0,
        fat: 0,
        carbs: 0,
        protein: 0,
      },
      defaultItem: {
        name: "",
        calories: 0,
        fat: 0,
        carbs: 0,
        protein: 0,
      },
    };
  },
  mounted() {
    this.getPlaceOfInterest();
  },
  methods: {
    getPlaceOfInterest() {
      let self = this;
      self.show = true;
      self.$axios
        .get("get-membership-applicants/")
        .then((res) => {
          self.applicants = res.data.memberships;
          self.show = false;
        })
        .catch((err) => {
          self.show = false;
          throw err;
        });
    },
    deleteItem(id) {
      this.deleteId = id;
      this.deleteDialog = true;
    },
    confirmDelete() {
      let self = this;
      self.show = true;
      this.$axios
        .post("delete-applicant/" + self.deleteId)
        .then(function (res) {
          self.show = false;
          self.deleteDialog = false;
          self.getPlaceOfInterest();
          self.$emit("show-snackbar", {
            message: res.data.success,
            color: "success",
          });
        })
        .catch(function (err) {
          self.show = false;
          self.$emit("show-snackbar", {
            message: "Oops! Something Went Wrong",
            color: "red",
          });
          throw err;
        });
    },
    approveReject(status, id) {
      this.updateId = id;
      if (status == "Approve") {
        this.approveDialog = true;
        this.updateStatus = "Confirmed";
      } else if (status == "Reject") {
        this.rejectDialog = true;
        this.updateStatus = "Rejected";
      }
    },
    updateApplicationStatus() {
      let self = this;
      let formData = new FormData();
      formData.append("status", self.updateStatus);
      self.show = true;
      self.$axios
        .post("/update-application-status/" + self.updateId, formData)
        .then(function (res) {
          self.getPlaceOfInterest();
          self.approveDialog = false;
          self.rejectDialog = false;
          self.show = false;
          self.$emit("show-snackbar", {
            message: res.data.success,
            color: "success",
          });
        })
        .catch(function (err) {
          self.show = false;
          self.$emit("show-snackbar", {
            message: "Oops! Something Went Wrong",
            color: "red",
          });
          throw err;
        });
    },
  },
};
</script>

<style>
.text-white {
  color: white !important;
  text-transform: capitalize;
}
.custom-padding {
  margin-top: -45px;
}
</style>