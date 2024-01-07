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
        <v-toolbar flat>
          <v-toolbar-title>Settings</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>
        </v-toolbar>
      </template>
      <template v-slot:[`item.actions`]="{ item }">
        {{ item.actions }}
        <v-icon @click="edit(item)" small class="mr-2"> mdi-pencil </v-icon>
      </template>
    </v-data-table>

    <reserved-date />

    <v-dialog v-model="editDialog" max-width="290">
      <v-form v-model="valid" ref="form">
        <v-card>
          <v-card-title class="text-h5 grey lighten-2">
            Edit Setting
          </v-card-title>

          <v-card-text>
            <v-label style="text-transform: capitalize">{{ editKey }}</v-label>

            <v-select
              :items="selectOptions"
              v-model="editValue"
              solo
              class="my-input"
              mb-3
            >
            </v-select>
            <v-label>Notes</v-label>
            <v-textarea
              v-model="editNotes"
              solo
              class="my-input"
              mb-3
              prepend-icon=""
            ></v-textarea>
          </v-card-text>

          <v-divider></v-divider>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn @click="update" color="primary" text> Update </v-btn>
          </v-card-actions>
        </v-card>
      </v-form>
    </v-dialog>
  </v-container>
</template>

<script>
import ReservedDate from "../../components/ReservedDate.vue";

export default {
  components: { ReservedDate },
  data() {
    return {
      valid: true,
      selectOptions: ["on", "off"],
      show: false,
      dialog: false,
      editDialog: false,
      editKey: "",
      editValue: "",
      editNotes: "",
      editId: "",
      headers: [
        { text: "Key", value: "key", sortable: false },
        { text: "Value", value: "value", sortable: false },
        { text: "Notes", value: "notes", sortable: false },
        { text: "Actions", value: "actions", sortable: false, align: "right" },
      ],
      items: [],
    };
  },
  mounted() {
    this.getItems();
  },
  methods: {
    edit(item) {
      this.editDialog = true;
      this.editId = item.id;
      this.editKey = item.key;
      this.editValue = item.value;
      this.editNotes = item.notes;
    },

    update() {
      let self = this;
      self.show = true;
      self.editDialog = false;
      self.$axios
        .post("update-setting", {
          id: self.editId,
          value: self.editValue,
          notes: self.editNotes,
        })
        .then((res) => {
          self.$emit("show-snackbar", {
            message: res.data.success,
            color: "success",
          });
          self.show = false;
          self.getItems();
        })
        .catch((err) => {
          self.show = false;
          throw err;
        });
    },

    getItems() {
      let self = this;
      self.show = true;
      self.$axios
        .get("get-settings/")
        .then((res) => {
          self.show = false;
          self.items = res.data.settings;
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