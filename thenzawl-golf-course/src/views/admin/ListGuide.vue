<template>
  <v-container fluid ml-6 mt-6>
    <v-overlay :value="show">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <v-data-table
      :headers="headers"
      :items="items"
      sort-by="calories"
      class="elevation-1"
    >
      <template v-slot:[`item.image`]="{ item }">
        <v-img :src="'/' + item.image" style="width: 50px; height: 50px" />
      </template>
      <template v-slot:[`item.category`]="{ item }">
        <td>{{ item.category.name }}</td>
      </template>
      <template v-slot:[`item.actions`]="{ item }">
        {{ item.actions }}
        <v-icon @click="edit(item.id)" small class="mr-2"> mdi-pencil </v-icon>
        <v-icon @click="deleteItem(item.id)" small> mdi-delete </v-icon>
      </template>
    </v-data-table>
    <v-dialog v-model="deleteDialog" max-width="290">
      <v-card>
        <v-card-title class="text-h5">
          Are you sure you want to delete this guide?
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
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      show: false,
      dialog: false,
      deleteDialog: false,
      deleteId: "",
      headers: [
        {
          text: "Category",
          align: "start",
          value: "category",
        },
        { text: "Title", value: "title", sortable: false },
        { text: "Address", value: "address", sortable: false },
        { text: "Contact", value: "contact", sortable: false },
        { text: "Email", value: "email", sortable: false },
        { text: "Image", value: "image", sortable: false },
        { text: "Actions", value: "actions", sortable: false },
      ],
      items: [],
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
    this.getGuides();
  },
  methods: {
    getGuides() {
      let self = this;
      self.show = true;
      self.$axios
        .get("get-guide/")
        .then((res) => {
          self.show = false;
          self.items = res.data.guides;
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
    edit(id) {
      let route = "list-guide/" + id + "/edit";
      this.$router.push(route);
    },
    confirmDelete() {
      let self = this;
      this.$axios
        .post("delete-guide/" + self.deleteId)
        .then(function (res) {
          self.deleteDialog = false;
          self.getGuides();
          self.$emit("show-snackbar", {
            message: res.data.success,
            color: "success",
          });
        })
        .catch(function (err) {
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
.my-input.v-input .v-input__slot {
  border-radius: 10px;
  border: 1px solid black;
  box-shadow: unset !important;
}
.custom-padding {
  margin-top: -45px;
}
</style>