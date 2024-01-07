<template>
  <v-container fluid ml-6 mt-6 ml-4 pr-10>
    <v-overlay :value="show">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <v-card>
      <v-card-title>
        <h2>Videos</h2>
        <v-spacer></v-spacer>
        <v-btn icon @click="dialog = !dialog">
          <v-icon>mdi-plus</v-icon>
        </v-btn>
      </v-card-title>
      <v-card-text>
        <v-row>
          <v-col md="6" sm="12" cols="12" v-for="(video, i) in videos" :key="i">
            <v-card>
              <v-card-subtitle>
                <v-btn @click="deleteVideo(video.id)" icon x-small
                  ><v-icon>mdi-delete</v-icon></v-btn
                >
              </v-card-subtitle>
              <v-card-text>
                <youtube
                  width="100%"
                  :video-id="video.video_id"
                  ref="youtube"
                ></youtube>
              </v-card-text>
              <v-card-title style="height: 5rem; padding-bottom: 100px">
                {{ video.title }}
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
            Add Video
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
            <v-label>Youtube Video ID</v-label>
            <v-text-field
              :rules="[(v) => !!v || 'Video ID is required']"
              v-model="data.videoId"
              solo
              class="my-input"
              mb-3
            ></v-text-field>
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
          Are you sure you want to delete this video?
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
      videos: [],
      data: {
        title: "",
        videoId: "",
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
        .get("/video")
        .then(function (res) {
          self.show = false;
          self.videos = res.data.videos;
        })
        .catch(function (err) {
          self.show = false;
          throw err;
        });
    },
    validate() {
      this.$refs.form.validate();
      if (this.$refs.form.validate() == true) {
        this.addVideo();
      }
    },
    addVideo() {
      let self = this;
      self.$axios
        .post("/add-video", self.data)
        .then(function (res) {
          self.$refs.form.reset();
          self.dialog = false;
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
    deleteVideo(id) {
      this.deleteId = id;
      this.deleteDialog = true;
    },
    confirmDelete() {
      let self = this;
      this.$axios
        .post("delete-video/" + self.deleteId)
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