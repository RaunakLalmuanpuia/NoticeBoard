<template>
  <div :class="{ 'blur-content': dialog }">
    <v-container class="header" fluid>
      <v-img
        height="300"
        src="@/assets/banners/gallery.jpg"
        class="d-none d-md-flex d-lg-flex"
      >
        <v-row>
          <div class="title-container">
            <v-col md-4 offset="2">
              <div class="my-title-2">Gallery</div>
            </v-col>
          </div>
        </v-row>
      </v-img>

      <div class="d-flex d-md-none">
        <v-img height="150" src="@/assets/mobile-bg.png"></v-img>
        <div class="pageTitle">Gallery</div>
      </div>
      <br />
    </v-container>
    <v-container class="galleryContainer">
      <v-row>
        <v-col v-for="(image, i) in images" :key="i" md="2" cols="6">
          <v-img
            @click="clickImage(image)"
            height="100%"
            style="border-radius: 10px"
            :src="image.image"
          ></v-img>
        </v-col>
      </v-row>
      <v-layout row justify-center>
        <v-dialog v-model="dialog" max-width="1000">
          <img v-bind:src="selectedImage !== null ? selectedImage.image : ''" />
        </v-dialog>
      </v-layout>
    </v-container>
  </div>
</template>
<script>
export default {
  props: {
    dialog: {
      default: false,
    },
  },
  data() {
    return {
      images: [],
      selectedImage: null,
    };
  },
  mounted() {
    this.initializeData();
  },
  methods: {
    clickImage(image) {
      this.selectedImage = image;
      this.dialog = true;
    },
    initializeData() {
      let self = this;
      self.$axios
        .get("/gallery")
        .then(function (res) {
          self.images = res.data.galleries;
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

.blur-content {
  filter: blur(5px);
}
.my-title-2 {
  font-family: "Poppins";
  color: black;
  font-size: 2.3rem;
  font-weight: bolder;
  margin-bottom: 1rem;
  margin-top: 10rem;
}
.member-container {
  background-color: #22242a;
  padding-bottom: 20px;
}

.galleryContainer {
  width: 70% !important;
}

@media screen and (max-width: 950px) {
  .galleryContainer {
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
