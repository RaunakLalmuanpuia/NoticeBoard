<template>
  <v-row>
    <v-col cols="12" md="6" class="mt-3">
      <v-row>
        <v-col cols="6">
          <v-card
            to="/glimpse-of-thenzawl"
            width="400"
            style="background-color: transparent; position: relative"
            elevation="0"
            class="card-custom-explore"
          >
            <v-img class="explore-image" src="@/assets/glimpse.png"></v-img>
            <v-card-title
              class="white--text card-title-custom"
              style="position: absolute; top: 0"
              >Glimpse of TGR</v-card-title
            >
          </v-card>
        </v-col>
        <v-col cols="6">
          <v-card
            to="/gallery"
            width="400"
            style="background-color: transparent; position: relative"
            elevation="0"
            class="card-custom-explore"
          >
            <v-img class="explore-image" src="@/assets/gallery.png">
              <v-card-title
                class="white--text card-title-custom"
                style="position: absolute; top: 0"
                >Gallery</v-card-title
              >
            </v-img>
          </v-card>
        </v-col>
        <v-col cols="6">
          <v-card
            to="/video"
            width="400"
            style="background-color: transparent; position: relative"
            elevation="0"
            class="card-custom-explore"
          >
            <v-img class="explore-image" src="@/assets/video.png">
              <v-card-title
                class="white--text card-title-custom"
                style="position: absolute; top: 0"
                >Video</v-card-title
              >
            </v-img>
          </v-card>
        </v-col>
        <v-col cols="6">
          <v-card
            to="/who-are-we"
            width="400"
            style="background-color: transparent; position: relative"
            elevation="0"
            class="card-custom-explore"
          >
            <v-img class="explore-image" src="@/assets/who3.png">
              <v-card-title
                class="white--text card-title-custom"
                style="position: absolute; top: 0"
                >Who are we</v-card-title
              >
            </v-img>
          </v-card>
        </v-col>
        <v-col cols="12">
          <v-card
            to="/who-are-we"
            width="900"
            height="200"
            style="background-color: rgba(85, 24, 113, 0.929); position: relative; border-radius: 2.3rem;"
            elevation="0"
            
          >
            
              <v-card-title
               style="color: #fff;margin-left: 15px;" 
              
                >Become a member</v-card-title
              >
              <v-card-subtitle  style="color: #fff;font-size: small;margin-left: 15px;">
                    A CLUB MEMBERSHIP can be switched to a GOLF MEMBERSHIP by
                    paying the difference of applicable fee for the duration of
                    his/her membership tenure on a pro-rata basis.
                  </v-card-subtitle>
               
                  <v-btn color="white" style="margin-left: 30px; background-color: #0dc190;" outlined rounded to="/membership"
                    >Join Now
                  </v-btn>
          </v-card>
        </v-col>
      </v-row>
    </v-col>
    <v-col cols="12" md="6" class="mt-3">
      <v-card
        style="padding: 10px; border-radius: 10px"
        color="#f2f7ff"
        elevation="0"
      >
        <v-card-text style="text-align: justify; color: #0b1f40">
          <p
            style="
              font-size: 20px;
              color: #5e9bff;
              font-weight: bold;
              text-align: center;
            "
            class="text-center"
          >
            Why Us
          </p>
          <p style="color: #0b1f40">
            <i>
              Rated as one of the best all season Golf courses in the North East
              India, Thenzawl Golf Course & Resort offers one of the best Pay &
              Play facility that caters to all levels of ability. It is the
              first and only golf course funded by the Ministry of Tourism,
              Government of India. Designed by Graham Cooke and Associates, one
              of the top-ranked Canada based Golf Course architectural firm. The
              total site area is 105 acres and the play area is 75 acres - 18
              Hole Golf Course with Sharing Fairway and automated sprinkler
              irrigation system by Rain Bird, USA. It is designed to have
              facilities of international standards. There are 30 Eco-Log Huts,
              Cafeteria, Open Air Food Court, Reception area and Waiting Lounge
              etc, all constructed with Siberian Pinewood and fully furnished
              with world class furniture and fixtures.
              <br />
              <br />
              Thenzawl Golf Course & Resort is a Golf course with green
              philosophy in a peaceful surroundings and breathtaking views.
            </i>
            <br /><br />
            <b><i> Nestled in nature…a delight for beginners!!! </i></b>
          </p>
          <v-btn
            @click="detailsDialog = !detailsDialog"
            elevation="0"
            outlined
            to="/booking"
            class="nextButton"
            rounded
            >Book Now</v-btn
          >
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: "Explore",
  data() {
    return {
      news: {},
    };
  },
  async mounted() {
    this.getNews();
  },
  methods: {
    getNews() {
      this.$axios
        .get("/customer-get-news")
        .then((res) => {
          this.news = res.data.news;
        })
        .catch((err) => {
          throw err;
        });
    },
  },
};
</script>
<style scoped>
.nextButton {
  border-color: #44d39b;
  text-transform: capitalize;
  font-weight: 600;
  padding: 0 30px !important;
}

@media screen and (max-width: 480px) {
  .news-card {
    margin-top: 20px;
  }

  .card-title-custom {
    font-size: 14px !important;
    margin-left: 0 !important;
  }
}
@media screen and (min-width: 1024px) {
  /* .g-1{
            display: inline-flex!important;
            
        } */
}
.explore-container {
  margin: auto;
  padding: 12px 30px 12px 30px;
  height: 243px;
  width: 20px;
  border-radius: 1rem;
}
.v-image__image--cover.explore-image {
  background-size: cover;
  /* height: 100px; */

}
.v-card:hover.card-custom-explore {
  background-color: black;
  border-radius: 1.3rem;
  box-shadow: 0px 0px 23px -7px rgba(0, 0, 0, 0.6) !important;
  -webkit-box-shadow: 0px 0px 23px -7px rgba(0, 0, 0, 0.6) !important;
  -moz-box-shadow: 0px 0px 23px -7px rgba(0, 0, 0, 0.6) !important;
}
.card-title-custom {
  font-size: 17px;
  margin-top: 45%;
  margin-left: 1rem;
  font-weight: bolder !important;
}
</style>
