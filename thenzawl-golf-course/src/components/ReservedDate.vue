<template>
  <div>
    <v-data-table
      :headers="headers"
      :items="reserveDates"
      sort-by="calories"
      class="elevation-1 mt-5"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Reserved Dates</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>
          <v-dialog v-model="dialog" max-width="500px" persistent>
            <template v-slot:activator="{ on, attrs }">
              <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
                Add New
              </v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="text-h5">New Reserved</span>
              </v-card-title>

              <v-card-text>
                <v-container>
                  <v-col class="d-flex" cols="12">
                    <v-select
                      v-model="form.items"
                      :items="itemLists"
                      label="Select Items"
                      multiple
                      item-text="name_of_item"
                      item-value="id"
                    >
                      <template v-slot:prepend-item>
                        <v-list-item ripple @click="toggle">
                          <v-list-item-action>
                            <v-icon
                              :color="
                                form.items.length > 0 ? 'indigo darken-4' : ''
                              "
                            >
                              {{ icon }}
                            </v-icon>
                          </v-list-item-action>
                          <v-list-item-content>
                            <v-list-item-title> Select All </v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>
                        <v-divider class="mt-2"></v-divider>
                      </template>
                    </v-select>
                  </v-col>

                  <v-col cols="12">
                    <v-dialog
                      ref="menu"
                      v-model="menu"
                      :close-on-content-click="false"
                      :return-value.sync="form.dates"
                      persistent
                      width="290px"
                    >
                      <template v-slot:activator="{ on, attrs }">
                        <v-combobox
                          v-model="form.dates"
                          multiple
                          chips
                          small-chips
                          label="Select Dates (multiple)"
                          prepend-icon="mdi-calendar"
                          readonly
                          v-bind="attrs"
                          v-on="on"
                          required
                          :rules="[(v) => !!v || 'Please Select Date']"
                        ></v-combobox>
                      </template>
                      <v-date-picker
                        v-model="form.dates"
                        :min="new Date().toISOString()"
                        multiple
                        no-title
                        scrollable
                      >
                        <v-spacer></v-spacer>
                        <v-btn text color="primary" @click="menu = false">
                          Cancel
                        </v-btn>
                        <v-btn
                          text
                          color="primary"
                          @click="$refs.menu.save(form.dates)"
                        >
                          OK
                        </v-btn>
                      </v-date-picker>
                    </v-dialog>
                  </v-col>
                </v-container>
              </v-card-text>

              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="close">
                  Cancel
                </v-btn>
                <v-btn type="submit" color="blue darken-1" text @click="save">
                  Save
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
          <v-dialog v-model="dialogDelete" max-width="500px" persistent>
            <v-card>
              <v-card-title class="text-h5"
                >Are you sure you want to delete this item?</v-card-title
              >
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="closeDelete"
                  >Cancel</v-btn
                >
                <v-btn color="blue darken-1" text @click="deleteItemConfirm"
                  >OK</v-btn
                >
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>

      <template #item.dates="{ value }">
        <div class="text-truncate my-truncate">
          {{ value }}
        </div>
      </template>

      <template v-slot:item.actions="{ item }">
        <v-icon color="blue" class="mr-2" @click="editItem(item)">
          mdi-pencil
        </v-icon>
        <v-icon color="red" @click="deleteItem(item)"> mdi-delete </v-icon>
      </template>
    </v-data-table>

    <v-dialog v-model="dialogEdit" max-width="500px" persistent>
      <v-card>
        <v-card-title>
          <span class="text-h5">Edit Reserved</span>
        </v-card-title>

        <v-card-text>
          <v-container>
            <v-col class="d-flex" cols="12">
              <v-select
                :items="itemLists"
                label="Select Item"
                required
                :rules="[(v) => !!v || 'Please Select Item']"
                item-text="name_of_item"
                item-value="id"
                v-model="form.item"
              ></v-select>
            </v-col>

            <v-col cols="12">
              <v-dialog
                ref="editMenu"
                v-model="editMenu"
                :close-on-content-click="false"
                :return-value.sync="form.dates"
                persistent
                width="290px"
              >
                <template v-slot:activator="{ on, attrs }">
                  <v-combobox
                    v-model="form.dates"
                    multiple
                    chips
                    small-chips
                    label="Select Dates (multiple)"
                    prepend-icon="mdi-calendar"
                    readonly
                    v-bind="attrs"
                    v-on="on"
                    required
                    :rules="[(v) => !!v || 'Please Select Date']"
                  ></v-combobox>
                </template>
                <v-date-picker
                  v-model="form.dates"
                  :min="new Date().toISOString()"
                  multiple
                  no-title
                  scrollable
                >
                  <v-spacer></v-spacer>
                  <v-btn text color="primary" @click="editMenu = false">
                    Cancel
                  </v-btn>
                  <v-btn
                    text
                    color="primary"
                    @click="$refs.editMenu.save(form.dates)"
                  >
                    OK
                  </v-btn>
                </v-date-picker>
              </v-dialog>
            </v-col>
          </v-container>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="closeEdit"> Cancel </v-btn>
          <v-btn type="submit" color="blue darken-1" text @click="saveEdit">
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-snackbar v-model="snackbar.snackbar" class="bg-red">
      {{ snackbar.text }}

      <template v-slot:action="{ attrs }">
        <v-btn color="red" text v-bind="attrs" @click="snackbar = false">
          Close
        </v-btn>
      </template>
    </v-snackbar>
  </div>
</template>

<script>
export default {
  data: () => ({
    dialog: false,
    dialogEdit: false,
    dialogDelete: false,
    headers: [
      {
        text: "Booking Item",
        align: "start",
        value: "item.name_of_item",
        sortable: false,
      },
      { text: "Dates Reserved", value: "dates", sortable: false },
      { text: "Actions", value: "actions", align: "right", sortable: false },
    ],
    reserveDates: [],
    itemLists: [],
    menu: false,
    editMenu: false,
    form: {
      item: "",
      date: "",
      dates: [],
      items: [],
    },
    itemId: "",
    deleteId: "",
    snackbar: {
      snackbar: false,
      text: "Provide Item and Dates",
    },
  }),

  computed: {
    likesAllItem() {
      return this.form.items.length === this.itemLists.length;
    },
    likesSomeItem() {
      return this.form.items.length > 0 && !this.likesAllItem;
    },
    icon() {
      if (this.likesAllItem) return "mdi-close-box";
      if (this.likesSomeItem) return "mdi-minus-box";
      return "mdi-checkbox-blank-outline";
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
  },

  created() {
    this.initialize();
    this.getItems();
  },

  methods: {
    toggle() {
      this.$nextTick(() => {
        if (this.likesAllItem) {
          this.form.items = [];
        } else {
          this.form.items = this.itemLists.slice();
        }
      });
    },

    async initialize() {
      await this.$axios
        .get("/get-reserved-dates")
        .then((res) => {
          this.reserveDates = res.data;
        })
        .catch((e) => {
          throw e;
        });
    },

    async getItems() {
      await this.$axios
        .get("/get-all-items")
        .then((res) => {
          this.itemLists = res.data;
        })
        .catch((e) => {
          throw e;
        });
    },

    deleteItem(item) {
      this.deleteId = item.id;
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      this.$axios
        .post("/delete-reserve-date/" + this.deleteId)
        .then(() => {
          this.initialize();
        })
        .catch((err) => {
          throw err;
        });
      this.closeDelete();
    },

    editItem(item) {
      this.editedIndex = this.reserveDates.indexOf(item);
      const dateEnter = item.dates;
      this.form.item = item.item_id;
      this.form.dates = dateEnter.split(",");
      this.itemId = item.id;
      this.dialogEdit = true;
    },

    closeEdit() {
      this.dialogEdit = false;
      this.form.item = "";
      this.form.items = [];
      this.form.dates = [];
    },

    close() {
      this.dialog = false;
      this.form.item = "";
      this.form.items = [];
      this.form.dates = [];
    },

    closeDelete() {
      this.dialogDelete = false;
    },

    save() {
      if (this.form.items == "" || this.form.dates == "") {
        this.snackbar.snackbar = true;
      } else {
        const fd = new FormData();
        fd.append("dates", this.form.dates);
        if (this.form.items.length > 1) {
          for (let i = 0; i < this.form.items.length; i++) {
            fd.append("items[]", this.form.items[i].id);
          }
        } else {
          fd.append("items[]", this.form.items[0]);
        }

        this.$axios
          .post("/add-reserve-date", fd)
          .then(() => {
            this.initialize();
            this.form.dates = [];
            this.form.items = [];
          })
          .catch((err) => {
            throw err;
          });

        this.close();
      }
    },

    saveEdit() {
      if (this.form.item == "" || this.form.dates == "") {
        this.snackbar.snackbar = true;
      } else {
        const fd = new FormData();
        fd.append("dates", this.form.dates);
        fd.append("item", this.form.item);

        this.$axios
          .post("/update-reserve-date/" + this.itemId, fd)
          .then(() => {
            this.initialize();
            this.form.dates = [];
            this.form.item = "";
            this.form.items = [];
          })
          .catch((err) => {
            throw err;
          });
        this.closeEdit();
      }
    },
  },
};
</script>

<style scoped>
.my-truncate {
  width: 800px;
}

@media screen and (max-width: 480px) {
  .my-truncate {
    width: 180px;
  }
}
</style>