<template>
<v-card flat style="background-color: #f7f9f7">
    <v-card-text>
      <div class="logInfo">
        <div>
          <v-icon color="green">mdi-information-outline</v-icon>
          <span class="font-weight-bold ml-2">Things you must know</span>
        </div>
        <ol>
          <li>Log hut day starts from 10:00 AM to 5:00 PM</li>
          <li>
            Maximum 2 Adults and 2 children below 12. Must bring document for
            proff.
          </li>
        </ol>
      </div>
    </v-card-text>
    <v-card-title>Wellness Log</v-card-title>
    <v-card-subtitle>(Please select date to start booking)</v-card-subtitle>
    <v-card-text>
      <v-row>
        <v-col md="6" sm="12" cols="12">
          <v-menu
            ref="menu"
            v-model="menu"
            :close-on-content-click="false"
            :return-value.sync="date_from"
            transition="scale-transition"
            offset-y
            min-width="auto"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                class="my-input"
                solo
                v-model="date_from"
                label="Checkin Date"
                readonly
                v-bind="attrs"
                v-on="on"
              ></v-text-field>
            </template>
            <v-date-picker
              @change="checkDate()"
              :min="new Date().toISOString()"
              v-model="date_from"
              no-title
              scrollable
              @input="showCheckinDate(date_from)"
              :allowed-dates="allowedDates"
            >
            </v-date-picker>
          </v-menu>
        </v-col>
        <v-col md="6" sm="12" cols="12">
          <v-menu
            ref="menu2"
            v-model="menu2"
            :close-on-content-click="false"
            :return-value.sync="date_to"
            transition="scale-transition"
            offset-y
            min-width="auto"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                class="my-input"
                solo
                v-model="date_to"
                label="Checkout Date"
                readonly
                v-bind="attrs"
                v-on="on"
              ></v-text-field>
            </template>
            <v-date-picker
              @change="checkDate()"
              :min="date_from == '' ? new Date().toISOString() : date_from"
              v-model="date_to"
              no-title
              scrollable
              @input="showCheckoutDate(date_to)"
              :allowed-dates="allowedDates"
            >
            </v-date-picker>
          </v-menu>
        </v-col>
      </v-row>
      <div
        v-if="
          checkingResult != 'No more huts available for this date.' &&
          checkingResult != ''
        "
      >
        <v-row>
          <v-col md="6">
            <span>Expected Arrival Time</span>
            <v-dialog
              ref="dialog"
              v-model="timePicker"
              :return-value.sync="expectedArrival"
              persistent
              width="290px"
            >
              <template v-slot:activator="{ on, attrs }">
                <v-text-field
                  class="my-input"
                  solo
                  v-model="expectedArrival"
                  label="Expected arrival time"
                  readonly
                  v-bind="attrs"
                  v-on="on"
                ></v-text-field>
              </template>
              <v-time-picker
                v-if="timePicker"
                v-model="expectedArrival"
                full-width
              >
                <v-spacer></v-spacer>
                <v-btn text color="primary" @click="timePicker = false">
                  Cancel
                </v-btn>
                <v-btn
                  text
                  color="primary"
                  @click="$refs.dialog.save(expectedArrival)"
                >
                  OK
                </v-btn>
              </v-time-picker>
            </v-dialog>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" md="8">
            <v-row>
              <v-col cols="12" md="4">
                {{ checkingResult }}
                <p class="font-weight-bold" style="color: #000">
                  {{ noOfHuts }}
                </p>
              </v-col>

              <v-col cols="12" md="8">
                No. of Day Selected
                <p class="font-weight-bold" style="color: #000">
                  {{ noOfDays }}
                </p>
              </v-col>
            </v-row>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" md="4">
            <v-label>No. Of Children</v-label>
            <v-row class="mt-2 justify-space-between">
              <v-btn
                @click="removeChildren()"
                fab
                x-small
                class="ml-3 personButton"
              >
                <v-icon>mdi-minus</v-icon>
              </v-btn>
              <span style="color: #000">{{ noOfChildren }} </span>
              <v-btn
                @click="addChildren()"
                fab
                x-small
                class="mr-3 personButton"
              >
                <v-icon>mdi-plus</v-icon>
              </v-btn>
            </v-row>
          </v-col>
          <v-col cols="12" md="4">
            <v-label>No. Of Adult</v-label>
            <v-row class="mt-2 justify-space-between">
              <v-btn
                @click="removeAdult()"
                fab
                x-small
                class="ml-3 personButton"
              >
                <v-icon>mdi-minus</v-icon>
              </v-btn>
              <span style="color: #000">{{ noOfAdult }} </span>
              <v-btn @click="addAdult()" fab x-small class="mr-3 personButton">
                <v-icon>mdi-plus</v-icon>
              </v-btn>
            </v-row>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" md="4">
            <v-label>No. Of Huts</v-label>
            <v-row class="mt-2 justify-space-between">
              <v-btn
                @click="removePerson()"
                fab
                x-small
                class="ml-3 personButton"
              >
                <v-icon>mdi-minus</v-icon>
              </v-btn>
              <span style="color: #000">{{ numberOfPerson }} </span>
              <v-btn @click="addPerson()" fab x-small class="mr-3 personButton">
                <v-icon>mdi-plus</v-icon>
              </v-btn>
            </v-row>
            <v-col> </v-col>
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            Price per head
            <p class="font-weight-bold" style="color: #000">{{ price }}</p>
          </v-col>
        </v-row>
        <v-col class="pt-8 border-top">
          <v-row>
            <span>
              <v-icon small color="black" class="rounded-circle"
                >mdi-currency-inr
              </v-icon>
              <span class="font-weight-bold" style="color: #000">Total</span>
              <p class="font-weight-bold total">
                {{ totalPayable * noOfDays }}
              </p>
            </span>
            <v-spacer></v-spacer>
            <v-btn
              @click="detailsDialog = !detailsDialog"
              elevation="0"
              outlined
              class="nextButton"
              rounded
              >Proceed</v-btn
            >
          </v-row>
        </v-col>
      </div>
      <div v-else>
        {{ checkingResult }}
      </div>
    </v-card-text>

    <!-- details -->
    <v-dialog v-model="detailsDialog" width="500">
      <v-form ref="form" v-model="valid">
        <v-card>
          <v-card-title class="text-h5 grey lighten-2">
            Please Enter Your Details
          </v-card-title>

          <v-card-text>
            <v-label>Name</v-label>
            <v-text-field
              required
              :rules="[(v) => !!v || 'This field is required']"
              v-model="name"
              solo
              class="my-input"
            ></v-text-field>
            <v-label>Email</v-label>
            <v-text-field
              required
              :rules="[(v) => !!v || 'This field is required']"
              v-model="email"
              type="email"
              solo
              class="my-input"
            ></v-text-field>
            <v-label>Whatsapp Number</v-label>
            <v-text-field
              required
              :rules="[(v) => !!v || 'This field is required']"
              v-model="contact"
              type="number"
              solo
              class="my-input"
            ></v-text-field>
          </v-card-text>

          <v-divider></v-divider>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn type="button" @click="validate()" color="primary" text>
              Submit
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-form>
    </v-dialog>

    <!-- payment modal -->
    <v-dialog v-model="dialog" width="500">
      <v-card>
        <v-card-title class="text-h5 grey lighten-2"> Payment </v-card-title>

        <v-card-text>
          {{ message }}
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            v-if="!canPay"
            type="button"
            @click="dialog = !dialog"
            color="primary"
            text
          >
            Try Again
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-card>
</template>

<script>
export default {
  props: ["rate", "id"],
  data() {
    return {
      noOfDays: "0",
      canPay: false,
      dialog: false,
      message: "",
      valid: false,
      detailsDialog: false,
      menu: false,
      menu2: false,
      numberOfPerson: 1,
      totalPayable: 0,
      price: this.rate,
      date_from: "",
      date_to: "",
      selectedAddon: "",
      name: "",
      email: "",
      contact: "",
      noOfHuts: 10,
      today: new Date().toISOString().substr(0, 10),
      checkingResult: "",
      disabledDates: [],
      timePicker: false,
      expectedArrival: new Date().toLocaleTimeString().substring(0, 5),
      noOfChildren: 0,
      noOfAdult: 1,
      maxNoOfChildren: 2,
      maxNoOfAdult: 2,
    };
  },
  mounted() {
    this.totalPayable = this.rate;
    this.getReservedDate();
  },
  methods: {
    getReservedDate() {
      this.$axios
        .get("/get-reserved-date/" + this.id)
        .then((res) => {
          let newDate = [];
          for (let i = 0; i < res.data.length; i++) {
            newDate += res.data[i].dates + ",";
          }
          this.disabledDates = newDate.split(",");
        })
        .catch((e) => {
          throw e;
        });
    },

    allowedDates(val) {
      for (var i = 0; i < this.disabledDates.length; i++) {
        if (this.disabledDates[i] == val) {
          return false;
        }
      }
      return true;
    },

    showCheckinDate(date) {
      this.$refs.menu.save(date);
      this.menu = false;
    },

    showCheckoutDate(date) {
      this.$refs.menu2.save(date);
      this.menu2 = false;
    },

    checkDate() {
      let self = this;
      if (self.date_from != "" && self.date_to != "") {
        self.$axios
          .get(
            "/check-date?date_from=" +
              self.date_from +
              "&date_to=" +
              self.date_to +
              "&type=" +
              self.id
          )
          .then(function (res) {
            self.checkingResult = res.data.message;
            self.noOfHuts = res.data.hutsAvailable;
            self.noOfDays = res.data.no_of_days;
          })
          .catch(function (err) {
            throw err;
          });
      }
    },
    addPerson() {
      if (this.numberOfPerson < this.noOfHuts) {
        this.numberOfPerson += 1;
        this.totalPayable += this.rate;
        this.maxNoOfChildren += 2;
        this.maxNoOfAdult += 2;
      }
    },
    removePerson() {
      if (this.numberOfPerson > 1) {
        this.numberOfPerson -= 1;
        this.totalPayable -= this.rate;
        this.maxNoOfChildren -= 2;
        this.maxNoOfAdult -= 2;
      }
    },
    addChildren() {
      if (this.noOfChildren < this.maxNoOfChildren) {
        this.noOfChildren += 1;
      }
    },
    removeChildren() {
      if (this.noOfChildren > 0) {
        this.noOfChildren -= 1;
      }
    },
    addAdult() {
      if (this.noOfAdult < this.maxNoOfAdult) {
        this.noOfAdult += 1;
      }
    },
    removeAdult() {
      if (this.noOfAdult > 1) {
        this.noOfAdult -= 1;
      }
    },

    validate() {
      this.$refs.form.validate();
      if (this.$refs.form.validate() == true) {
        this.proceedBooking();
      }
    },
    proceedBooking() {
      this.merchantData = {
        billing_notes: "",
        amount: this.totalPayable * this.noOfDays,
        item_id: this.id,
        quantity: this.numberOfPerson,
        date_from: this.date_from,
        date_to: this.date_to,
        addons: this.selectedAddon,
        name: this.name,
        email: this.email,
        contact: this.contact,
        no_of_days: this.noOfDays,
        expected_arrival: this.expectedArrival,
        no_of_children: this.noOfChildren,
        no_of_adult: this.noOfAdult,
      };
      this.$axios
        .post("/pay", this.merchantData)
        .then((res) => {
          this.dialog = true;
          if (res.data["error"]) {
            this.canPay = false;
            this.message = res.data["error"];
          } else {
            this.$router.push({
              name: "BookingConfirmation",
              params: {
                id: res.data.ss,
                days: res.data.no_of_days,
                booking_id: res.data.sss,
                amount: res.data.amount,
              },
            });
          }
        })
        .catch((err) => {
          throw err;
        });
    },
  },
};
</script>

<style scoped>
.border-top {
  background-image: linear-gradient(
    to right,
    #d9d9d9 40%,
    rgba(255, 255, 255, 0) 20%
  );
  background-position: top;
  background-size: 20px 2px;
  background-repeat: repeat-x;
}

.logInfo {
  background-color: #f9fbd7;
  color: #000 !important;
  padding: 15px !important;
}

.total {
  color: #04d39b !important;
  font-size: 1.5rem;
}

.personButton {
  border: 1px solid #04d39b;
  color: #04d39b;
  box-shadow: none !important;
}

.personButton:hover {
  background-color: #04d39b;
  color: #fff;
}

.nextButton {
  border-color: #44d39b;
  text-transform: capitalize;
  font-weight: 700;
  padding: 0 30px !important;
}
</style>
