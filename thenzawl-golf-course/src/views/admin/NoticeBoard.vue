<template>
    <v-container fluid ml-6 mt-6>
      <v-overlay :value="show">
        <v-progress-circular indeterminate size="64"></v-progress-circular>
      </v-overlay>
      <v-data-table
        :headers="headers"
        :items="items"
        sort-by="calories"
        class="elevation-1">

        
        <template v-slot:top>
          <v-toolbar flat>
            <v-toolbar-title>Notice Board</v-toolbar-title>
            <v-divider class="mx-4" inset vertical></v-divider>
            <v-spacer></v-spacer>
            <v-btn @click="addDocument()" icon><v-icon>mdi-plus</v-icon></v-btn>
          </v-toolbar>
        </template>
        <template v-slot:item.created_at="{ item }">
    <span>{{ item.created_at | formatDate }}</span>
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

      <v-dialog v-model="addModal" max-width="500">
      <v-form v-model="valid" ref="form">
        <v-card>
          <v-card-title class="text-h5 grey lighten-2">
            Add Notice
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
            <v-label>Content</v-label>
            <v-textarea
              :rules="[(v) => !!v || 'Content is required']"
              v-model="excerpt"
              solo
              class="my-input"
              mb-3
            ></v-textarea>
            <!-- <v-label>Date</v-label> -->
            <!-- <v-text-field
              :rules="[(v) => !!v || 'Date is required']"
              v-model="date"
              solo
              class="my-input"
              mb-3
            ></v-text-field> -->
            <!-- <v-menu
            ref="menu"
            v-model="menu"
            :close-on-content-click="false"
            :return-value.sync="date"
            transition="scale-transition"
            offset-y
            min-width="auto"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                class="my-input"
                solo
                v-model="date"
                label="Date"
                readonly
                v-bind="attrs"
                v-on="on"
              ></v-text-field>
            </template>
            <v-date-picker
              :min="new Date().toISOString()"
              v-model="date"
              no-title
              scrollable
              @input="showCheckinDate(date)"
            >
            </v-date-picker>
          </v-menu> -->
        
          </v-card-text>

          <v-divider></v-divider>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn @click="validate" color="primary" text> Add </v-btn>
          </v-card-actions>
        </v-card>
      </v-form>
    </v-dialog>
      <v-dialog v-model="editModal" max-width="500">
      <v-form v-model="valid" ref="form">
        <v-card>
          <v-card-title class="text-h5 grey lighten-2">
            Edit Notice
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
            <v-label>Content</v-label>
            <v-textarea
              v-model="editExcerpt"
              solo
              class="my-input"
              mb-3
            ></v-textarea>
            <!-- <v-label>Date</v-label>
            <v-text-field
              v-model="editDate"
              solo
              class="my-input"
              mb-3
            ></v-text-field> -->
            <!-- <v-menu
            ref="menu"
            v-model="menu"
            :close-on-content-click="false"
            :return-value.sync="editDate"
            transition="scale-transition"
            offset-y
            min-width="auto"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                class="my-input"
                solo
                v-model="editDate"
                label="Date"
                readonly
                v-bind="attrs"
                v-on="on"
              ></v-text-field>
            </template>
            <v-date-picker
              :min="new Date().toISOString()"
              v-model="editDate"
              no-title
              scrollable
              @input="showCheckinDate(editDate)"
            >
            </v-date-picker>
          </v-menu> -->
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
        title: "",
        excerpt: "",
        document: null,
        editId: "",
        editTitle: "",
        editExcerpt: "",
        
      
        addModal: false,
        editModal: false,
        show: false,
        dialog: false,
        deleteDialog: false,
        deleteId: "",
        valid: false,
        menu: false,
        headers: [
          {
            text: "Date",
            align: "start",
            sortable: false,
            value: "created_at",
            scopedSlots: { customRender: "date" }, // Use a custom render for this column
          },
          { text: "Title", value: "title", sortable: false },
          { text: "Content", value: "content", sortable: false },
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
    filters: {
      formatDate: function (inputDate) {
        const options = { day: 'numeric', month: 'short', year: 'numeric' };
        const formattedDate = new Date(inputDate).toLocaleDateString('en-GB', options);
        return formattedDate;
      },
    },
    methods: {
      deleteItem(id) {
        this.deleteId = id;
        this.deleteDialog = true;
      },
      confirmDelete() {
        let self = this;
        this.$axios
          .post("delete-notice/" + self.deleteId)
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
      edit(item) {
      this.editId = item.id;
      this.editModal = true;
      this.editTitle = item.title;
      this.editExcerpt = item.content;
      console.log(item)
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

    updateDocument() {
      let self = this;
      let formData = new FormData();
      self.show = true;

      formData.append("title", self.editTitle);
      formData.append("content", self.editExcerpt);
      self.$axios
        .post("/update-notice/" + self.editId, formData,)
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
    uploadDocument() {
      let self = this;
      let formData = new FormData();
      self.show = true;
      formData.append("title", self.title);
      formData.append("content", self.excerpt);
      self.$axios
        .post("/add-notice", formData, {
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
    showCheckinDate(date) {
      this.$refs.menu.save(date);
      this.menu = false;
    },

      getItems() {
        let self = this;
        self.show = true;
        self.$axios
          .get("admin-notice/")
          .then((res) => {
            self.show = false;
            self.items = res.data.noticeBoard;
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
