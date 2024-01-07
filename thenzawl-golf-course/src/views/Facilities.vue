<template>
  <div :class="{ 'blur-content': dialog }">
    <v-container class="header" fluid>
      <v-img
        height="300"
        src="@/assets/banners/facilities.jpg"
        class="d-none d-md-flex d-lg-flex"
      >
        <v-row>
          <div class="title-container">
            <v-col md-4 offset="2">
              <div class="my-title-2">Facilities</div>
            </v-col>
          </div>
        </v-row>
      </v-img>

      <div class="d-flex d-md-none">
        <v-img height="150" src="@/assets/mobile-bg.png"></v-img>
        <div class="pageTitle">Facilities</div>
      </div>
      <br />
    </v-container>

    <v-container class="facilities-container">
      <v-row>
        <v-col v-for="(facility, i) in facilities" :key="i" md="4">
          <v-card elevation="0" class="facility">
            <v-img
              v-if="facility.image != null"
              height="200px"
              :src="facility.image"
            >
            </v-img>
            <v-img height="200px" v-else src="@/assets/dummy3.png"></v-img>
            <v-card-title style="font-size: 13px">
              <b>{{ facility.title }}</b>
            </v-card-title>

            <v-card-text style="font-size: 13px" class="text--primary">
              <div>
                {{ facility.description | subStr }}
              </div>
            </v-card-text>
            <v-card-actions>
              <v-btn text small color="#04d39b" @click="showDetails(facility)"
                >READ MORE</v-btn
              >
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </v-container>

    <!-- dialog -->
    <v-dialog v-model="dialog" width="500">
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
          v-if="facilityDetail.image != null"
          class="white--text align-end imageDialog"
          :src="facilityDetail.image"
        >
        </v-img>
        <v-img
          v-else
          class="white--text align-end imageDialog"
          height="250px"
          src="@/assets/dummy3.png"
        >
        </v-img>
        <v-card-title v-html="facilityDetail.title"></v-card-title>

        <v-card-text class="text--primary">
          <div v-html="facilityDetail.detail"></div>
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
      facilities: [],
      numberOfPages: 0,
      facilityDetail: {
        title: "",
        detail: "",
        image: "",
      },
    };
  },
  async mounted() {
    this.placeOfInterest();
  },
  filters: {
    subStr: function (string) {
      return string.substring(0, 90) + "...";
    },
  },
  methods: {
    showDetails(facility) {
      this.facilityDetail.title = facility.title;
      this.facilityDetail.detail = facility.description;
      this.facilityDetail.image = facility.image;
      this.dialog = true;
    },
    placeOfInterest() {
      this.$axios
        .get("/get-facilities")
        .then((res) => {
          this.facilities = res.data.facilities;
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

<style>
.header {
  padding: 0;
}

.blur-content {
  filter: blur(5px);
}
@media screen and (max-height: 480px) {
  .my-title-2 {
    color: white;
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

.facilities-container {
  width: 70% !important;
}

@media screen and (max-width: 950px) {
  .facilities-container {
    width: 95% !important;
  }
}

.facility {
  border-radius: 10px;
  border: 1px solid rgba(242, 242, 242, 0.679) !important;
}

.facility:hover {
  box-shadow: 0px 0px 23px -7px rgba(194, 194, 194, 0.6) !important;
  -webkit-box-shadow: 0px 0px 23px -7px rgba(194, 194, 194, 0.6) !important;
  -moz-box-shadow: 0px 0px 23px -7px rgba(194, 194, 194, 0.6) !important;
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
  top: 50px;
  font-size: 1.8rem;
  margin-left: 20px;
  font-weight: 700;
}
</style>
