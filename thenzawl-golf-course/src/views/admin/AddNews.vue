<template>
  <v-container fluid ml-6 mt-6>
    <v-overlay :value="show">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <v-row>
      <v-col md="4" offset="4">
        <v-form ref="form" v-model="valid" lazy-validation>
          <v-card style="padding: 18px">
            <v-card-title>Add News & Event</v-card-title>
            <v-card-text>
              <v-row>
                <v-col>
                  <v-label>Date</v-label>
                  <v-text-field
                    required
                    :rules="[(v) => !!v || 'Date is required']"
                    v-model="form.date"
                    solo
                    class="my-input"
                    mb-3
                    type="date"
                  ></v-text-field>
                  <v-label>Title</v-label>
                  <v-text-field
                    required
                    :rules="[(v) => !!v || 'Title is required']"
                    v-model="form.title"
                    solo
                    class="my-input"
                  ></v-text-field>
                  <v-label>File</v-label>
                  <v-file-input
                    required
                    solo
                    label="Click to select file"
                    class="my-input"
                    append-icon="mdi-paperclip"
                    prepend-icon=""
                    v-model="form.file"
                    accept="application/pdf"
                  ></v-file-input>
                  <v-label>Content</v-label>
                  <v-textarea
                    required
                    v-model="form.content"
                    solo
                    class="my-input"
                  ></v-textarea>
                </v-col>
              </v-row>
            </v-card-text>
            <v-card-actions>
              <v-btn
                @click="validate"
                elevation="0"
                rounded
                color="#04d39b"
                class="text-white"
                >Add Items</v-btn
              >
            </v-card-actions>
          </v-card>
        </v-form>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      show: false,
      valid: true,
      form: {
        date: "",
        title: "",
        content: "",
        file: null,
      },
    };
  },
  methods: {
    validate() {
      this.$refs.form.validate();
      if (this.$refs.form.validate() == true) {
        this.addData();
      }
    },
    addData() {
      this.show = true;
      let formData = new FormData();
      formData.append("date", this.form.date);
      formData.append("title", this.form.title);
      formData.append("content", this.form.content);
      formData.append("file", this.form.file);
      this.$axios
        .post("/add-news-event", formData, {
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
</style>