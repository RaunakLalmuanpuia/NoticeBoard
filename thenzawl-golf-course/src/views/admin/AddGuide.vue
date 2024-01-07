<template>
  <v-container fluid ml-6 mt-6>
    <v-overlay :value="show">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <v-container mt-6>
      <v-row>
        <v-col md="8" offset="2">
          <v-card style="padding: 18px">
            <v-card-title>Add Guide</v-card-title>
            <v-card-text>
              <v-form ref="form" v-model="valid" lazy-validation>
                <v-row>
                  <v-col md="6">
                    <v-label>Category</v-label>
                    <v-select
                      required
                      :rules="[(v) => !!v || 'Please Select Category']"
                      :items="categories"
                      item-text="name"
                      item-value="id"
                      solo
                      label="Select Category"
                      v-model="category"
                      class="my-input"
                    ></v-select>
                    <v-label>Title</v-label>
                    <v-text-field
                      required
                      :rules="[(v) => !!v || 'Title is required']"
                      solo
                      v-model="title"
                      class="my-input"
                      label="Title"
                    ></v-text-field>

                    <v-label>Image</v-label>
                    <v-file-input
                      required
                      :rules="[(v) => !!v || 'Please pick an image']"
                      solo
                      label="Click to select image"
                      class="my-input"
                      append-icon="mdi-camera"
                      prepend-icon=""
                      v-model="image"
                      accept="image/*"
                    ></v-file-input>
                  </v-col>
                  <v-col md="6">
                    <v-label>Address</v-label>
                    <v-text-field
                      required
                      :rules="[(v) => !!v || 'Enter an address']"
                      solo
                      v-model="address"
                      class="my-input"
                      label="Address"
                    ></v-text-field>

                    <v-label>Contact</v-label>
                    <v-text-field
                      required
                      :rules="[(v) => !!v || 'Contact is required']"
                      solo
                      v-model="contact"
                      class="my-input"
                      label="Contact"
                    ></v-text-field>

                    <v-label>Email</v-label>
                    <v-text-field
                      required
                      :rules="[(v) => !!v || 'Email is required']"
                      type="email"
                      solo
                      v-model="email"
                      class="my-input"
                      label="Email"
                    ></v-text-field>
                    <p class="text-right">
                      <v-btn
                        @click="validate()"
                        elevation="0"
                        rounded
                        color="#04d39b"
                        class="text-white"
                        >Add Guide</v-btn
                      >
                    </p>
                  </v-col>
                </v-row>
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
      category: "",
      categories: [],
      title: "",
      image: null,
      address: "",
      contact: "",
      email: "",
    };
  },
  mounted() {
    this.getCategories();
  },
  methods: {
    getCategories() {
      this.$axios
        .get("/get-guide-categories")
        .then((res) => {
          this.categories = res.data.categories;
        })
        .catch((e) => {
          throw e;
        });
    },

    validate() {
      this.$refs.form.validate();
      if (this.$refs.form.validate() == true) {
        this.addGuide();
      }
    },

    addGuide() {
      this.show = true;
      let formData = new FormData();
      formData.append("category", this.category);
      formData.append("title", this.title);
      formData.append("image", this.image);
      formData.append("address", this.address);
      formData.append("contact", this.contact);
      formData.append("email", this.email);
      this.$axios
        .post("add-guide/", formData, {
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