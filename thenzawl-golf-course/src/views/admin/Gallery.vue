<template>
  <v-container fluid ml-6 mt-6 ml-4 pr-10>
    <v-overlay :value="show">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <v-card>
      <v-card-title>
        <h2>Gallery</h2>
        <v-spacer></v-spacer>
        <v-btn icon @click="dialog = !dialog">
          <v-icon>mdi-plus</v-icon>
        </v-btn>
      </v-card-title>
      <v-card-text>
        <v-row>
          <v-col md="2" sm="12" v-for="(image, i) in galleries" :key="i">
            <v-card>
              <v-card-subtitle>
                <v-btn @click="deleteImage(image.id)" icon x-small
                  ><v-icon>mdi-delete</v-icon></v-btn
                >
              </v-card-subtitle>
              <v-card-text>
                <v-img height="200" width="200" :src="image.image"></v-img>
              </v-card-text>
              <v-card-title style="height: 5rem; padding-bottom: 100px">
                {{ image.title }}
              </v-card-title>
            </v-card>
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>

    <!-- add video dialog -->
    <v-dialog v-model="dialog" width="500">
      <v-form v-model="valid" ref="form">
        <v-card>
          <v-card-title class="text-h5 grey lighten-2">
            Add Image To Gallery
          </v-card-title>

          <v-card-text>
            <v-label>Title</v-label>
            <v-text-field
              :rules="[(v) => !!v || 'Title is required']"
              v-model="data.title"
              solo
              class="my-input"
              mb-3
            ></v-text-field>
            <v-label>Image</v-label>
            <v-file-input
              :rules="[(v) => !!v || 'Image is required']"
              v-model="data.image"
              solo
              class="my-input"
              mb-3
              append-icon="mdi-camera"
              prepend-icon=""
              accept="image/*"
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

    <v-dialog v-model="deleteDialog" max-width="290">
      <v-card>
        <v-card-title class="text-h5">
          Are you sure you want to delete this image?
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
      deleteDialog: false,
      deleteId: "",
      valid: true,
      dialog: false,
      galleries: [],
      data: {
        title: "",
        image: null,
      },
    };
  },

  mounted() {
    this.initializeData();
  },

  methods: {
    initializeData() {
      let self = this;
      self.show = true;
      self.$axios
        .get("/gallery")
        .then(function (res) {
          self.galleries = res.data.galleries;
          self.show = false;
        })
        .catch(function (err) {
          self.show = false;
          throw err;
        });
    },
    validate() {
      this.$refs.form.validate();
      if (this.$refs.form.validate() == true) {
        this.addImage();
      }
    },
    addImage() {
      let self = this;
      let formData = new FormData();
      self.show = true;
      formData.append("title", self.data.title);
      formData.append("image", self.data.image);
      self.$axios
        .post("/add-gallery", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then(function (res) {
          self.show = false;
          self.$refs.form.reset();
          self.dialog = false;
          self.initializeData();
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
    deleteImage(id) {
      this.deleteId = id;
      this.deleteDialog = true;
    },
    confirmDelete() {
      let self = this;
      this.$axios
        .post("delete-image/" + self.deleteId)
        .then(function (res) {
          self.deleteDialog = false;
          self.initializeData();
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
.my-input.v-input .v-input__slot {
  border-radius: 10px;
  border: 1px solid black;
  box-shadow: unset !important;
}
</style>