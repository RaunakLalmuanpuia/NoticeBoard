<template>
  <div>
    <v-container fluid class="header">
      <v-img
        height="300"
        src="@/assets/banners/placeofinterest.jpg"
        class="d-none d-md-flex d-lg-flex"
      >
        <v-row>
          <div class="title-container">
            <v-col md-4 offset="2">
              <div class="my-title-2">
                Places Of Interest<span> Near Thenzawl</span>
              </div>
            </v-col>
          </div>
        </v-row>
      </v-img>

      <div class="d-flex d-md-none">
        <v-img height="150" src="@/assets/mobile-bg.png"></v-img>
        <div class="pageTitle">Places Of Interest Near Thenzawl</div>
      </div>
      <br />
    </v-container>

    <v-container class="interestContainer">
      <!-- <Guide /> -->
      <v-row v-for="(interest, i) in placeOfInterests" :key="i">
        <v-col v-for="(inte, j) in interest" :key="j" md="3" cols="6">
          <v-card
            style="cursor: pointer; border-radius: 10px"
            @click="showDetails(inte)"
          >
            <v-img
              :src="inte.image"
              class="white--text align-end poiHeight"
              gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
            >
              <div class="text-truncate px-3 pb-5">
                {{ inte.title }}
              </div>
            </v-img>
          </v-card>
        </v-col>
      </v-row>
      <v-row>
        <v-col v-if="numberOfPages > 1" md="6" class="justify-start">
          <v-pagination
            @input="onPageChange"
            v-model="page"
            :length="numberOfPages"
          ></v-pagination>
        </v-col>
      </v-row>
    </v-container>

    <!-- dialog -->
    <v-dialog v-model="dialog" width="700">
      <v-card class="mx-auto poi-detail">
        <v-btn
          icon
          color="red"
          @click="dialog = false"
          class="float-right closeDialog"
        >
          <v-icon>mdi-close</v-icon>
        </v-btn>
        <v-img
          class="white--text align-end imageDialog"
          :src="interestDetail.image"
        >
        </v-img>
        <v-card-title>{{ interestDetail.title }}</v-card-title>

        <v-card-text class="text--primary">
          <div>
            {{ interestDetail.detail }}
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  data() {
    return {
      dialog: false,
      page: 1,
      placeOfInterests: [],
      numberOfPages: 0,
      interestDetail: {
        title: "",
        detail: "",
        image: "",
      },
    };
  },
  async mounted() {
    this.placeOfInterest();
  },
  methods: {
    showDetails(inte) {
      this.interestDetail.title = inte.title;
      this.interestDetail.detail = inte.address;
      this.interestDetail.image = inte.image;
      this.dialog = true;
    },
    placeOfInterest() {
      this.$axios
        .get("/place-of-interest?page=" + this.page)
        .then((res) => {
          this.numberOfPages = res.data.last_page;
          this.page = res.data.current_page;
          this.placeOfInterests = res.data.placeOfInterest;
        })
        .catch((err) => {
          throw err;
        });
    },
    onPageChange() {
      this.placeOfInterest();
    },
  },
};
</script>

<style scoped>
@media screen and (max-width: 480px) {
  .my-title-2 {
    font-size: 25px !important;
    outline-color: #f8f8f8;
  }

  .my-title-2 span {
    display: block !important;
  }

  .poiHeight {
    height: 150px !important;
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

.interestContainer {
  width: 70% !important;
}

.header {
  padding: 0;
}

.poiHeight {
  height: 250px;
}

@media screen and (max-width: 950px) {
  .interestContainer {
    width: 95% !important;
  }
}

.imageDialog {
  position: relative !important;
}

.closeDialog {
  position: absolute !important;
  top: 0;
  right: 0;
  z-index: 1;
}

.pageTitle {
  position: absolute;
  top: 30px;
  font-size: 1.8rem;
  margin-left: 20px;
  font-weight: 700;
}
</style>
