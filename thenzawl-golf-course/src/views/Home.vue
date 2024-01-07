<template>
  <div>
    <v-container class="carousel-image-card" fluid>
      <v-carousel
        :continuous="false"
        :show-arrows="false"
        class="carousel-image"
        cycle
        delimiter-icon="mdi-minus"
        height="500"
        hide-delimiter-background
      >
        <v-carousel-item
          :key="n"
          :src="require('@/assets/carousel/carousel' + n + '.jpg')"
          v-for="n in 5"
        >
        </v-carousel-item>
      </v-carousel>
    </v-container>
    <v-container class="homeContainer">
      <Explore />
    </v-container>
    <br />
    <br />
    <div class="member-container">
      <v-container style="width: 70%">
        <v-row>
          <v-container class="b-member-main" style="display: inline-flex">
            <v-col class="become-member mb-10" cols="12" md="6" sm="12">
              <v-container class="b-member-first-container becomeMember">
                <v-container >
                  <h2 style="padding-left: 15px; padding-top: 5px; font-size: 1rem; margin-bottom: -15px;">NOTICE BOARD</h2>
                  <div v-if="notices.length > 0">
                    <v-list style="background-color: #0dc190;">
                      <v-list-item
                        class="events"
                        v-for="(notices, i) in notices"
                        :key="i"
                        to="/notice-board"
                      >
                        <v-list-item-content style="padding-bottom: 5px;">
                          <div style="display: flex; align-items: center;">
                            <img src="../assets/Group 453.png" style="width: 15px; height: 15px; margin-right: 3px; margin-left: 3px; padding-top: 2px;" />
                            <v-list-item-title style="color: white; font-weight: bolder; font-size: 0.8rem;">
                              <b>{{ notices.title }}</b>
                            </v-list-item-title>
                          </div>
                          <div>
                            <v-list-item-subtitle style="margin-left: 20px; font-size: 0.7rem; color: white;">{{ notices.created_at | formatDate }}</v-list-item-subtitle>
                            <v-list-item-subtitle style="margin-left: 20px; padding-top: 4px; color: white; font-size: 0.8rem;">{{ notices.content | subStr }}</v-list-item-subtitle>
                          </div>
                        </v-list-item-content>
                      </v-list-item>
                    </v-list>
                    <v-btn
                      style="margin-left: 10px; margin-bottom: 10px; font-size: 0.8rem;"
                      color="white"
                      outlined
                      rounded
                      to="/notice-board"
                    >View All</v-btn>
                  </div>
                  <div v-else>
                    <p style="text-align: center; padding-top: 70px;">No notices available at the moment.</p>
                  </div>
                </v-container>
              </v-container>
            </v-col>


            <v-col
              class="become-member mb-10 ratingCount"
              md="6"
              sm="12"
              cols="12"
              style="padding-left: 100px; display: inline-flex;"
              
            >
              <v-row>
                <v-container class="abc">
                  <v-container cols="12">
                    <v-row>
                      <v-col cols="6" md="3" class="mb-5">
                        <v-row>
                          <v-container style="text-align: center">
                            <img src="../assets/mask1.png" />
                            <p
                              style="
                                color: #04d39b;
                                font-weight: 900;
                                margin-bottom: 0;
                              "
                            >
                              {{ siteVisitors }}
                            </p>
                            <p>Today's Visitor</p>
                          </v-container>
                        </v-row>
                      </v-col>
                      <v-col cols="6" md="3" class="mb-5">
                        <v-row>
                          <v-container style="text-align: center">
                            <img
                              src="../assets/total_visitor.png"
                              height="52"
                              width="52"
                            />
                            <p
                              style="
                                color: #04d39b;
                                font-weight: 900;
                                margin-bottom: 0;
                              "
                            >
                              {{ siteVisitorsAll }}
                            </p>
                            <p>Total No. of Visitors</p>
                          </v-container>
                        </v-row>
                      </v-col>
                      <v-col cols="6" md="3" class="mb-5">
                        <v-row>
                          <v-container style="text-align: center">
                            <img src="../assets/mask2.png" />
                            <p
                              style="
                                color: #04d39b;
                                font-weight: 900;
                                margin-bottom: 0;
                              "
                            >
                              {{ 15346 + resortVisitors }}
                            </p>
                            <p>Resort Visitors</p>
                          </v-container>
                        </v-row>
                      </v-col>
                      <v-col cols="6" md="3" class="mb-5">
                        <v-row>
                          <v-container style="text-align: center">
                            <img src="../assets/mask.png" />
                            <p
                              style="
                                color: #04d39b;
                                font-weight: 900;
                                margin-bottom: 0;
                              "
                            >
                              {{ rating }}
                            </p>
                            <p>Ratings</p>
                          </v-container>
                        </v-row>
                      </v-col>
                    </v-row>
                  </v-container>
                  <v-col
                    style="flex: 1"
                    cols="12"
                    md="12"
                    sm="12"
                    class="b-items"
                  >
                    <v-container class="rate-us" style="text-align: center">
                      <p style="cursor: pointer" @click="dialogClick()">
                        Rate us!
                      </p>
                    </v-container>
                  </v-col>
                </v-container>
              </v-row>
            </v-col>
          </v-container>
        </v-row>
      </v-container>
    </div>
    <br />
    <v-container class="poiContainer">
      <PlaceOfInterest />
    </v-container>
    <Rateus :dialog.sync="dialog" />
  </div>
</template>
<style scoped>
.scrollable-container {
  height: 200px; /* Adjust the max-height according to your needs */
  overflow-y: auto;
}
.event:hover {
    box-shadow: 2px 2px 2px -15px rgb(240, 248, 4);
  } 
.poiContainer {
  width: 70%;
  margin-top: 3rem;
}

.becomeMember {
  background-color: #0dc190;
  position: absolute;
  width: 500px;
  height: 437px;
  margin-top: -100px;
  overflow: hidden;
  border-radius: 1rem;
}

.container {
  padding: unset;
}

.my-title {
  font-family: "Poppins";
  color: white;
  font-size: 2.3rem;
  font-weight: bolder;
  margin-bottom: 1rem;
  margin-top: 15rem;
}

.booking-button {
  width: 136px;
  color: #04d39b !important;
  font-size: 0.7rem !important;
}

.member-container {
  background-color: #22242a;
}

.become-member {
  color: white;
  margin-top: 4rem;
  font-family: "Poppins";
}

.become-member-subtitle {
  margin-top: 30px;
  width: 90%;
}

.styling {
  color: white;
  text-shadow: 0 0 1px #000000, 0 0 1px #494949;
}

#videowrapper {
  position: relative;
  overflow: hidden;
}

/* full screen video */
#fullScreenDiv {
  min-height: 100%;
  height: 70vh;
  width: 100vw;
  padding: 0;
  margin: 0;
  position: relative;
  background-color: black;
}

.blur {
  opacity: 0.3;
}

#video {
  width: 100vw;
  height: auto;
  margin: auto;
  display: block;
}

@media (min-aspect-ratio: 18/9) {
  #video {
    width: 100vw;
    height: auto;
  }
}

@media (max-aspect-ratio: 18/9) {
  #video {
    height: 100vh;
    width: auto;
    margin-left: 50vw;
    transform: translate(-50%);
  }
}

/* @media screen and (min-width: 1281px) {
        .b-member-first-container {
            height: 340px !important;
            width: 650px !important;
        }

        .b-member-first-p {
            font-size: 2rem;
        }
    } */
.rate-us {
  color: #04d39b;
  text-decoration: underline;
}
.rate-us:hover {
  color: yellow !important;
}
@media screen and (max-width: 480px) {
  .col-xl,
  .col-xl-auto,
  .col-xl-12,
  .col-xl-11,
  .col-xl-10,
  .col-xl-9,
  .col-xl-8,
  .col-xl-7,
  .col-xl-6,
  .col-xl-5,
  .col-xl-4,
  .col-xl-3,
  .col-xl-2,
  .col-xl-1,
  .col-lg,
  .col-lg-auto,
  .col-lg-12,
  .col-lg-11,
  .col-lg-10,
  .col-lg-9,
  .col-lg-8,
  .col-lg-7,
  .col-lg-6,
  .col-lg-5,
  .col-lg-4,
  .col-lg-3,
  .col-lg-2,
  .col-lg-1,
  .col-md,
  .col-md-auto,
  .col-md-12,
  .col-md-11,
  .col-md-10,
  .col-md-9,
  .col-md-8,
  .col-md-7,
  .col-md-6,
  .col-md-5,
  .col-md-4,
  .col-md-3,
  .col-md-2,
  .col-md-1,
  .col-sm,
  .col-sm-auto,
  .col-sm-12,
  .col-sm-11,
  .col-sm-10,
  .col-sm-9,
  .col-sm-8,
  .col-sm-7,
  .col-sm-6,
  .col-sm-5,
  .col-sm-4,
  .col-sm-3,
  .col-sm-2,
  .col-sm-1,
  .col,
  .col-auto,
  .col-12,
  .col-11,
  .col-10,
  .col-9,
  .col-8,
  .col-7,
  .col-6,
  .col-5,
  .col-4,
  .col-3,
  .col-2,
  .col-1 {
    width: 100%;
    padding: 12px 0 0 0;
  }
  .b-items {
    display: inline-flex !important;

    padding-top: 40px !important;
  }
  /* .member-container {
        display: hidden !important;
            width: 400px !important;
        } */
  .become-member {
    padding-left: 0px !important;
  }
  .b-member-2 {
    width: 200px !important;
    display: inline-block !important;
  }
  .b-member-first-container {
    height: 200px !important;
    width: 90% !important;
  }
  .member-container {
    margin-top: 10px !important;
  }
  .become-member-subtitle {
    margin-top: 0 !important;
    font-size: 12px !important;
    width: 100% !important;
  }
  .b-member-second-container {
    padding: 20px !important;
  }
  .b-member-main {
    display: block !important;
  }
  .b-member-first-p {
    padding-left: 10px !important;
  }

  .becomeMember {
    background-color: #0dc190;
    position: absolute;
    width: 500px;
    height: 437px;
    margin-top: -100px;
    overflow: hidden;
    border-radius: 1rem;
    left: 22px;
  }

  .ratingCount {
    padding-top: 50px;
  }

  .poiContainer {
    width: 90%;
    margin-top: unset !important;
  }
}

/* @media screen and (min-width: 1023px) {
        .b-member-first-container {
            height: 420px !important;
            width: 730px !important;
        }

        .b-member-first-p {
            font-size: 2rem;
        }

        .b-member-second-container {
            padding: 20px 0 0 50px !important;
        }
        .b-member-main{
            display: inline-flex !important;
        }
        .become-member{
            padding-top: 25px !important;
        }

    } */
@media screen and (min-width: 1024px) {
  .b-member-first-container {
    height: 230px !important;
    width: 735px !important;
  }

  .b-member-first-p {
    font-size: 20px;
  }

  .b-member-second-container {
    padding: 20px 0 0 50px !important;
  }
  .b-member-main {
    display: block !important;
  }
  .become-member-subtitle {
    font-size: 15px !important;
  }
  .b-member-2 {
    width: 700px !important;
    margin-left: -50px !important;
    padding-top: 40px !important;
  }
  .rate-us {
    margin-left: -50px !important;
  }
}
@media screen and (min-width: 1200px) {
  .rate-us {
    margin-left: -50px !important;
  }
  .abc {
    display: block !important;
  }
  .b-member-first-container {
    height: 345px !important;
    width: 435px !important;
  }
  /* .become-member{
            display:  block !important;
        } */
  .b-member-2 {
    width: 500px !important;
    margin-top: -50px !important;

    padding-top: 40px !important;
  }
  .become-member-subtitle {
    font-size: 15px !important;
  }
  .rate-us {
    margin-left: -0 !important;
  }
  .b-member-first-p {
    font-size: 1rem;
  }

  .b-member-second-container {
    padding: 20px 0 0 50px !important;
  }
  .b-member-main {
    display: inline-flex !important;
  }
}
@media screen and (min-width: 1600px) {
  .rate-us {
    margin-left: -40px !important;
  }
  .abc {
    display: block !important;
  }
  .b-member-first-container {
    height: 370px !important;
    width: 655px !important;
  }
  /* .become-member{
              display:  block !important;
          } */
  .b-member-2 {
    width: 500px !important;
    margin-top: -50px !important;

    padding-top: 40px !important;
  }
  .become-member-subtitle {
    font-size: 15px !important;
  }
  .rate-us {
    margin-left: -0 !important;
  }
  .b-member-first-p {
    font-size: 20px;
    font-weight: bold;
  }

  .b-member-second-container {
    padding: 60px 0 0 50px !important;
  }
  .b-member-main {
    display: inline-flex !important;
  }
}
#videoMessage {
  width: 100%;
  height: 100%;
  position: absolute;
  top: 0;
  left: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
}

.content-center {
  display: flex;
  flex-wrap: wrap;
  align-content: center;
}
</style>

<style scoped>

.noticeButton {
  margin-left: 20px;
  margin-bottom: 20px;
}
.homeContainer {
  width: 70%;
}

@media screen and (max-width: 480px) {
  .homeContainer {
    width: 90%;
  }
}
</style>

<script>
import Explore from "@/components/Explore.vue";
import PlaceOfInterest from "@/components/PlaceOfInterest.vue";
import Rateus from "@/components/Rateus.vue";

export default {
  components: {
    Explore,
    PlaceOfInterest,
    Rateus,
  },
  data() {
    return {
      resortVisitors: 0,
      siteVisitors: 0,
      siteVisitorsAll: 0,
      notices: [],
      rating: 0,
      dialog: false,
      slides: [
        {
          src: "@/assets/carousel/carousel1.jpg",
        },
        {
          src: "@/assets/carousel/carousel2.jpg",
        },
        {
          src: "@/assets/carousel/carousel3.jpg",
        },
        {
          src: "@/assets/carousel/carousel4.jpg",
        },
        {
          src: "@/assets/carousel/carousel5.jpg",
        },
      ],
    };
  },
  mounted() {
    this.getRating();
    this.getNotices();
  },
  filters: {
      subStr: function (string) {
        return string.substring(0, 55) + "..."; // Dont let this dissapear
      },
      formatDate: function (inputDate) {
        const options = { day: 'numeric', month: 'short', year: 'numeric' };
        const formattedDate = new Date(inputDate).toLocaleDateString('en-GB', options);
        return formattedDate;
      },
    },
  methods: {
    dialogClick() {
      this.dialog = true;
    },
    getRating() {
      let self = this;
      self.$axios
        .get("get-rating")
        .then(function (res) {
          self.rating = res.data.averageRating;
          self.resortVisitors = res.data.visitors;
          self.siteVisitors = res.data.siteVisitors;
          self.siteVisitorsAll = res.data.siteVisitorsAll;
        })
        .catch(function (err) {
          throw err;
        });
    },
    getNotices(){
      let self =this;
      self.$axios
      .get("customer-get-noticeboard")
      .then(function (res){
        self.notices = res.data.noticeBoard;
        console.log(self.notices);
      })
       .catch(function (err) {
          throw err;
        });
    }
  },
};
</script>
