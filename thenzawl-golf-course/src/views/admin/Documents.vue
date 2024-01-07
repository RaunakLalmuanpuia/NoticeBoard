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
      <template v-slot:top>
        <v-toolbar flat style="margin-right: 20px">
          <v-toolbar-title>Notice/Order</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>
          <v-btn @click="addDocument()" icon><v-icon>mdi-plus</v-icon></v-btn>
        </v-toolbar>
      </template>
      <template v-slot:[`item.actions`]="{ item }">
        {{ item.actions }}
        <v-icon @click="edit(item)" small class="mr-2"> mdi-pencil </v-icon>
        <v-icon @click="deleteItem(item.id)" small> mdi-delete </v-icon>
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
    <v-dialog v-model="addModal" max-width="290">
      <v-form v-model="valid" ref="form">
        <v-card>
          <v-card-title class="text-h5 grey lighten-2">
            Add Document
          </v-card-title>

          <v-card-text>
            <v-label>Title</v-label>
            <v-text-field
              :rules="[(v) => !!v || 'Title is required']"
              v-model="title"
              solo
              class="my-input"
              mb-3
            ></v-text-field>
            <v-label>Excerpt</v-label>
            <v-text-field
              :rules="[(v) => !!v || 'Excerpt is required']"
              v-model="excerpt"
              solo
              class="my-input"
              mb-3
            ></v-text-field>
            <v-label>Document</v-label>
            <v-file-input
              :rules="[(v) => !!v || 'Document is required']"
              v-model="document"
              solo
              class="my-input"
              mb-3
              append-icon="mdi-paperclip"
              prepend-icon=""
              accept="application/pdf"
            ></v-file-input>
          </v-card-text>

          <v-divider></v-divider>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn @click="validate" color="primary" text> Add </v-btn>
          </v-card-actions>
        </v-card>
      </v-form>
    </v-dialog>
    <v-dialog v-model="editModal" max-width="290">
      <v-form v-model="valid" ref="form">
        <v-card>
          <v-card-title class="text-h5 grey lighten-2">
            Edit Document
          </v-card-title>

          <v-card-text>
            <v-label>Title</v-label>
            <v-text-field
              :rules="[(v) => !!v || 'Title is required']"
              v-model="editTitle"
              solo
              class="my-input"
              mb-3
            ></v-text-field>
            <v-label>Excerpt</v-label>
            <v-text-field
              :rules="[(v) => !!v || 'Excerpt is required']"
              v-model="editExcerpt"
              solo
              class="my-input"
              mb-3
            ></v-text-field>
            <v-label>Document</v-label>
            <v-file-input
              v-model="document"
              solo
              class="my-input"
              mb-3
              append-icon="mdi-pdf"
              prepend-icon=""
              accept="application/pdf"
            ></v-file-input>
          </v-card-text>

          <v-divider></v-divider>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn @click="validate2" color="primary" text> Update </v-btn>
          </v-card-actions>
        </v-card>
      </v-form>
    </v-dialog>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      show: false,
      valid: false,
      dialog: false,
      deleteDialog: false,
      addModal: false,
      editModal: false,
      title: "",
      excerpt: "",
      document: null,

      editId: "",
      editTitle: "",
      editExcerpt: "",

      deleteId: "",
      headers: [
        {
          text: "Title",
          align: "start",
          sortable: false,
          value: "title",
        },
        { text: "Excerpt", value: "excerpt", sortable: false },
        { text: "File", value: "file", sortable: false },
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
    deleteItem(id) {
      this.deleteId = id;
      this.deleteDialog = true;
    },
    validate() {
      this.$refs.form.validate();
      if (this.$refs.form.validate() == true) {
        this.uploadDocument();
      }
    },
    validate2() {
      this.$refs.form.validate();
      if (this.$refs.form.validate() == true) {
        this.updateDocument();
      }
    },
    uploadDocument() {
      let self = this;
      let formData = new FormData();
      self.show = true;
      formData.append("title", self.title);
      formData.append("document", self.document);
      formData.append("excerpt", self.excerpt);
      self.$axios
        .post("/add-document", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then(function (res) {
          self.addModal = false;
          self.show = false;
          self.$refs.form.reset();
          self.dialog = false;
          self.getItems();
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
    edit(item) {
      this.editId = item.id;
      this.editModal = true;
      this.editTitle = item.title;
      this.editExcerpt = item.excerpt;
    },
    updateDocument() {
      let self = this;
      let formData = new FormData();
      self.show = true;
      formData.append("title", self.editTitle);
      formData.append("document", self.document);
      formData.append("excerpt", self.editExcerpt);
      self.$axios
        .post("/update-document/" + self.editId, formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then(function (res) {
          self.editModal = false;
          self.show = false;
          self.$refs.form.reset();
          self.dialog = false;
          self.getItems();
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
    addDocument() {
      this.addModal = true;
    },
    confirmDelete() {
      let self = this;
      this.$axios
        .post("delete-document/" + self.deleteId)
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

    getItems() {
      let self = this;
      self.show = true;
      self.$axios
        .get("notice-and-orders/")
        .then((res) => {
          self.show = false;
          self.items = res.data.documents;
        })
        .catch((err) => {
          self.show = false;
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