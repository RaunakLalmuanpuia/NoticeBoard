<template>
  <div>
    <v-container class="header" fluid>
      <v-img
        class="header-image d-none d-md-flex d-lg-flex"
        height="300"
        src="@/assets/banners/video.jpg"
      >
        <v-row>
          <div class="title-container">
            <v-col md-4 offset="2">
              <div class="my-title-2">Videos</div>
            </v-col>
          </div>
        </v-row>
      </v-img>

      <div class="d-flex d-md-none">
        <v-img height="150" src="@/assets/mobile-bg.png"></v-img>
        <div class="pageTitle">Videos</div>
      </div>
      <br />
    </v-container>
    <v-container class="videoContainer">
      <v-row>
        <v-col md="6" sm="12" cols="12" v-for="(video, i) in videos" :key="i">
          <v-card class="videoCard">
            <youtube
              width="100%"
              :video-id="video.video_id"
              ref="youtube"
              class="youtube"
            ></youtube>
            <v-card-title style="font-size: 14px; line-height: 20px">
              {{ video.title }}
            </v-card-title>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>
<script>
export default {
  data() {
    return {
      videos: [],
    };
  },
  mounted() {
    this.initializeData();
  },
  methods: {
    initializeData() {
      let self = this;
      self.$axios
        .get("/video")
        .then(function (res) {
          self.videos = res.data.videos;
        })
        .catch(function (err) {
          throw err;
        });
    },
  },
};
</script>
<style scoped>
.header {
  padding: 0;
}
@media screen and (max-width: 480px) {
  .youtube {
    max-height: 188px;
  }
}
.my-title-2 {
  font-family: "Poppins";
  color: black;
  font-size: 2.3rem;
  font-weight: bolder;
  margin-bottom: 1rem;
  margin-top: 10rem;
}

.videoContainer {
  width: 70% !important;
}

.videoCard {
  border: 1px solid #e4e4e4 !important;
  box-shadow: none !important;
}

.videoCard:hover {
  box-shadow: 0px 0px 23px -7px rgba(194, 194, 194, 0.6) !important;
  -webkit-box-shadow: 0px 0px 23px -7px rgba(194, 194, 194, 0.6) !important;
  -moz-box-shadow: 0px 0px 23px -7px rgba(194, 194, 194, 0.6) !important;
}

@media screen and (max-width: 950px) {
  .videoContainer {
    width: 95% !important;
  }
}

.pageTitle {
  position: absolute;
  top: 50px;
  font-size: 1.8rem;
  margin-left: 20px;
  font-weight: 700;
}
</style>