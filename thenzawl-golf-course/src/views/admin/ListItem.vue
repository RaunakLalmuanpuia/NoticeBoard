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
      <template v-slot:[`item.picture`]="{ item }">
        <v-img :src="'/' + item.picture" style="width: 50px; height: 50px" />
      </template>
      <template v-slot:[`item.actions`]="{ item }">
        {{ item.actions }}
        <v-icon small @click="editItem(item.id)" class="mr-2">
          mdi-pencil
        </v-icon>
        <v-icon small @click="deleteItem(item.id)"> mdi-delete </v-icon>
      </template>
    </v-data-table>
    <v-dialog v-model="deleteDialog" max-width="290">
      <v-card>
        <v-card-title class="text-h5">
          Are you sure you want to delete this item?
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
          text: "Item Name",
          align: "start",
          sortable: false,
          value: "name_of_item",
        },
        { text: "Image", value: "picture", sortable: false },
        { text: "Type", value: "type", sortable: false },
        { text: "Instructions", value: "remark", sortable: false },
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
    this.getItems();
  },
  methods: {
    editItem(id) {
      this.$router.push("/admin/list-item/" + id + "/edit");
    },
    getItems() {
      let self = this;
      self.show = true;
      self.$axios
        .get("get-items/")
        .then((res) => {
          self.show = false;
          self.items = res.data.items.data;
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
      this.$axios
        .post("delete-item/" + self.deleteId)
        .then(function (res) {
          self.deleteDialog = false;
          self.getItems();
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