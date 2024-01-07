<template>
  <v-card flat style="background-color: #f7f9f7">
    <v-card-title>Day Pass</v-card-title>
    <v-card-text>
      <v-row>
        <v-col md="6">
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
                label="Date"
                readonly
                v-bind="attrs"
                v-on="on"
              ></v-text-field>
            </template>
            <v-date-picker
              :min="new Date().toISOString()"
              v-model="date_from"
              no-title
              scrollable
              @input="showCheckDate(date_from)"
              :allowed-dates="allowedDates"
            >
            </v-date-picker>
          </v-menu>
        </v-col>
      </v-row>
      <v-row v-if="date_from != ''">
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
      <v-row v-if="date_from != ''">
        <v-col md="4">
          <v-label>No. Of Person</v-label>
          <v-row class="mt-1 justify-space-between">
            <v-btn
              @click="removePerson()"
              fab
              x-small
              class="ml-3 personButton"
            >
              <v-icon>mdi-minus</v-icon>
            </v-btn>
            <span style="color: #000" class="font-weight-bold"
              >{{ numberOfPerson }}
            </span>
            <v-btn @click="addPerson()" fab x-small class="mr-3 personButton">
              <v-icon>mdi-plus</v-icon>
            </v-btn>
          </v-row>
        </v-col>
      </v-row>

      <v-col v-if="date_from != ''" cols="12" class="mb-5 pt-10">
        <span>Price</span>
        <p style="color: #000" class="font-weight-bold">{{ price }}</p>
      </v-col>
      <v-col v-if="date_from != ''" cols="12" class="pt-8 border-top">
        <v-row>
          <span>
            <v-icon small color="black" class="rounded-circle"
              >mdi-currency-inr
            </v-icon>
            <span class="font-weight-bold" style="color: #000">Total</span>
            <p class="font-weight-bold total">{{ totalPayable }}</p>
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
      canPay: false,
      dialog: false,
      message: "",
      valid: false,
      detailsDialog: false,
      menu: false,
      numberOfPerson: 1,
      totalPricePerson: 0,
      totalPayable: 0,
      price: this.rate,
      selectedAddon: "",
      name: "",
      email: "",
      contact: "",
      discount: 0,
      today: new Date().toISOString().substr(0, 10),
      date_from: "",
      disabledDates: [],
      timePicker: false,
      expectedArrival: new Date().toLocaleTimeString().substring(0, 5),
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

    showCheckDate(date) {
      this.$refs.menu.save(date);
      this.menu = false;
    },

    addPerson() {
      this.totalPayable += this.price;
      this.numberOfPerson += 1;
    },
    removePerson() {
      if (this.numberOfPerson > 1) {
        this.numberOfPerson -= 1;
        this.totalPayable -= this.price;
      }
    },
    validate() {
      this.$refs.form.validate();
      if (this.$refs.form.validate() == true) {
        this.proceedBooking();
      }
    },
    proceedBooking() {
      this.totalPricePerson = this.numberOfPerson * this.price;
      if (this.numberOfPerson >= 21) {
        this.discount = this.totalPricePerson * 0.6;
      } else if (this.numberOfPerson >= 11) {
        this.discount = this.totalPricePerson * 0.4;
      } else if (this.numberOfPerson >= 5) {
        this.discount = this.totalPricePerson * 0.3;
      } else {
        this.discount = 0;
      }

      this.totalPayable = this.totalPayable - this.discount;
      this.merchantData = {
        billing_notes: "",
        amount: this.totalPayable,
        item_id: this.id,
        quantity: this.numberOfPerson,
        date_from: this.date_from,
        addons: this.selectedAddon,
        name: this.name,
        email: this.email,
        contact: this.contact,
        expected_arrival: this.expectedArrival,
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
                days: 1,
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
