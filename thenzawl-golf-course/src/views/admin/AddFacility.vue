<template>
  <v-container fluid ml-6 mt-6>
    <v-overlay :value="show">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <v-container mt-6>
      <v-row>
        <v-col md="4" offset="4">
          <v-card style="padding: 18px">
            <v-card-title>Add Facility</v-card-title>
            <v-card-text>
              <v-form ref="form" v-model="valid" lazy-validation>
                <v-label>Title</v-label>
                <v-text-field
                  required
                  :rules="[(v) => !!v || 'Title is required']"
                  solo
                  v-model="title"
                  class="my-input"
                ></v-text-field>

                <v-label>Image</v-label>
                <v-file-input
                  solo
                  label="Click here to select image"
                  class="my-input"
                  append-icon="mdi-camera"
                  prepend-icon=""
                  v-model="image"
                  accept="image/*"
                ></v-file-input>
                <v-label>Description</v-label>
                <v-textarea
                  required
                  :rules="[(v) => !!v || 'Enter a description']"
                  solo
                  v-model="description"
                  class="my-input"
                ></v-textarea>
                <p class="text-right">
                  <v-btn
                    @click="validate()"
                    elevation="0"
                    rounded
                    color="#04d39b"
                    class="text-white"
                    >Add Facility</v-btn
                  >
                </p>
              </v-form>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      show: false,
      valid: true,
      title: "",
      image: null,
      description: "",
    };
  },
  methods: {
    validate() {
      this.$refs.form.validate();
      if (this.$refs.form.validate() == true) {
        this.addGuide();
      }
    },

    addGuide() {
      this.show = true;
      let formData = new FormData();
      formData.append("title", this.title);
      formData.append("image", this.image);
      formData.append("description", this.description);
      this.$axios
        .post("add-facility", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((res) => {
          this.show = false;
          this.$refs.form.reset();
          this.$emit("show-snackbar", {
            message: res.data.success,
            color: "success",
          });
        })
        .catch((err) => {
          this.show = false;
          this.$emit("show-snackbar", {
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