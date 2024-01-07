<template>
  <div>
    <v-overlay :value="show">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <v-container class="header" fluid>
      <v-img
        height="300"
        src="@/assets/banners/booking.jpg"
        class="d-none d-md-flex d-lg-flex">
        <v-row>
          <div class="title-container">
            <v-col md-4 offset="2">
              <div class="my-title-2">Booking</div>
            </v-col>
          </div>
        </v-row>
      </v-img>

      <div class="d-flex d-md-none">
        <v-img height="150" src="@/assets/mobile-bg.png"></v-img>
        <div class="pageTitle">Booking</div>
      </div>
      <br />
    </v-container>
    <v-container class="booking-home">
      <v-alert class="tandc" style="padding: 13px" color="#f7ffdb">
        <v-icon color="#04d39b">mdi-information-outline</v-icon>
        Booking of facilities online and offline mode means that you accepted
        the terms & condition policy laid down in this
        <a href="/terms-and-conditions"
          >Agreement/Terms & Conditions/Cancellation Policy.</a
        >
      </v-alert>
      <!-- <Guide /> -->
      <br />
      <v-row align-content="space-between">
        <v-col v-if="!bookingOpen" md="6">
          <b
            ><h4>
              {{ closedBookingNote }}
            </h4></b
          >
        </v-col>
        <v-col v-else md="6">
          <v-card flat>
            <v-card-title>Let's Start Booking</v-card-title>
            <v-card-text>
              <h6>Choose Your Item</h6>
              <v-row>
                <v-col
                  v-for="(booking, i) in bookings"
                  :key="i"
                  md="6"
                  sm="12"
                  cols="12"
                >
                  <div
                    @click="
                      selectBooking(
                        booking.name_of_item,
                        booking.rate,
                        booking.id,
                        booking
                      )
                    "
                    class="link"
                  >
                    <div
                      class="guide-container"
                      style="background-color: #f7f9f7"
                    >
                      <v-row>
                        <v-col cols="4">
                          <v-img
                            height="40"
                            width="40"
                            :src="'/' + booking.picture"
                          />
                        </v-col>
                        <v-col class="text-left" cols="8">
                          {{ booking.name_of_item }}
                        </v-col>
                      </v-row>
                    </div>
                  </div>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
          <br />
          <!-- day pass -->
          <div ref="selectedBooking">
            <DayPass :id="id" :rate="price" v-if="bookingType == 'Day Pass'" />

              <!-- Log Hut Day -->
              <WellnessHut
                  :id="id"
                  :rate="price"
                  v-if="bookingType === 'Wellness Log'"
              />
            <!-- convention center -->
            <ConventionHall
              :id="id"
              :rate="price"
              v-if="bookingType == 'Convention Hall'"
            />

            <!-- Log Hut Day -->
            <LogHutDay
              :id="id"
              :rate="price"
              v-if="bookingType == 'Log Hut (Day)'"
            />

            <!-- log hut (day & ight) -->
            <LogHutNight
              :id="id"
              :rate="price"
              v-if="bookingType == 'Log Hut (Day & Night)'"
            />
            <!-- Photography -->
            <Photography
              :id="id"
              :rate="price"
              v-if="bookingType == 'Photography' || bookingType == 'Camera'"
            />

            <!-- VideoGraphy -->
            <Videography
              :id="id"
              :rate="price"
              v-if="
                bookingType == 'Videography' || bookingType == 'Video Camera'
              "
            />
          </div>
        </v-col>
        <v-col md="6" cols="12">
          <h3>Check our Tariff</h3>
          <v-list three-line style="background-color: transparent" dense>
            <v-list-item
              v-for="(offer, index) in offers"
              :key="index"
              class="tariff"
              two-line
            >
              <v-list-item-avatar>
                <v-img
                  height="40"
                  width="40"
                  :src="'/' + offer.picture"
                ></v-img>
              </v-list-item-avatar>
              <v-list-item-content>
                <v-list-item-title>
                  <h3>
                    <b> {{ offer.name_of_item }} </b>
                  </h3>
                </v-list-item-title>
                <v-list-item-subtitle>
                  <div v-for="(rate, index) in offer.rate" :key="index">
                    {{
                      rate.type == "Amount"
                        ? "₹" + rate.rate
                        : " per " + rate.type
                    }}
                  </div>
                </v-list-item-subtitle>
                <v-list-item-subtitle>{{ offer.remark }}</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
          </v-list>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>
<script>
import Photography from "@/components/booking/Photography";
import DayPass from "@/components/booking/DayPass";
import ConventionHall from "@/components/booking/ConventionHall";
import LogHutNight from "@/components/booking/LogHutNight";
import LogHutDay from "@/components/booking/LogHutDay";
import Videography from "@/components/booking/Videography";
import WellnessHut from "@/components/booking/WellnessHut";

export default {
  components: {
      WellnessHut,
    Photography,
    DayPass,
    ConventionHall,
    LogHutNight,
    LogHutDay,
    Videography,
  },
  data() {
    return {
      show: false,
      bookingOpen: false,
      closedBookingNote: "",
      name: "",
      email: "",
      contact: "",
      valid: false,
      detailsDialog: false,
      dialog: false,
      canPay: false,
      message: "",
      accessCode: "",
      encrypted: "",
      menu: false,
      bookingType: "",
      selectedItem: "",
      offers: [],
      bookings: [],
      addons: [],
      id: "",
      selectedAddon: [],
      totalPayable: 0,
      today: new Date().toISOString().substr(0, 10),
      date_from: new Date().toISOString().substr(0, 10),
      numberOfPerson: 1,
      total: 0,
      price: 0,
      allowedDates: {
        to: new Date(Date.now() - 8640000),
      },
    };
  },
  mounted() {
    this.getOffers();
  },
  methods: {
    selectBooking(type, rate, booking, item) {
      const el = this.$refs.selectedBooking;
      if (el) {
        // Use el.scrollIntoView() to instantly scroll to the element
        el.scrollIntoView({ behavior: "smooth" });
      }
      this.selectedItem = item;
      this.id = booking;
      this.bookingType = type;
      this.numberOfPerson = 1;
      for (let i = 0; i < rate.length; i++) {
        if (rate[i].type == "Amount") {
          this.totalPayable = this.price = rate[i].rate;
        }
      }
    },

    getOffers() {
      let self = this;
      self.show = true;
      self.$axios
        .get("user-get-settings")
        .then((res) => {
          console.log(res.data);
          if (res.data.setting.value == "on") {
            self.bookingOpen = true;
          } else {
            self.closedBookingNote = res.data.setting.notes;
            self.bookingOpen = false;
          }
        })
        .catch((err) => {
          throw err;
        });
      self.$axios
        .get("/offers")
        .then((res) => {
          self.show = false;
          self.offers = res.data.offers;
          self.bookings = res.data.bookings;
          self.addons = res.data.addons;
        })
        .catch((err) => {
          self.show = false;
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
.link {
  text-decoration: none;
  color: black !important;
  font-weight: bold;
}
.guide-container {
  padding: 12px 30px 12px 30px;
  margin: auto;
  border: 1px solid #efefef;
  border-radius: 1rem;
  text-align: center;
}
.guide-container:hover {
  background-color: #efefef;
  cursor: pointer;
}

.tariff.v-list-item {
  background-color: white;
  border-bottom: 1px solid #efefef;
  /* border-radius: 20px; */
  margin-bottom: 5px;
}

.booking-home {
  width: 70%;
}

@media screen and (max-width: 480px) {
  .booking-home {
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
