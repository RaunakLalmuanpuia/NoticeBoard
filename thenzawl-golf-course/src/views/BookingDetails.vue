<template>
  <div style="background-color: #d6d6d6">
    <v-container class="header" fluid>
      <v-img height="300" src="@/assets/banners/booking.jpg">
        <v-row>
          <div class="title-container">
            <v-col md-4 offset="2">
              <div class="my-title-2">{{ title }}</div>
            </v-col>
          </div>
        </v-row>
      </v-img>
      <br />
    </v-container>
    <v-container style="width: 70%">
      <v-row>
        <v-col style="background-color: white" md="6">
          <v-row>
            <v-col md="6">Date From</v-col>
            <v-col md="6">Date To</v-col>
          </v-row>
          <v-row>
            <v-col md="6">
              <input
                class="date-picker"
                type="date"
                name="dateFrom"
                v-model="date_from"
                id="dateFrom"
              />
            </v-col>
            <v-col md="6">
              <input
                class="date-picker"
                type="date"
                v-model="date_to"
                name="dateTo"
                id="dateTo"
              />
            </v-col>
          </v-row>
          <v-row>
            <v-col md="6"> Time From </v-col>
            <v-col md="6"> Time To </v-col>
          </v-row>
          <v-row>
            <v-col md="6">
              <v-row>
                <v-col md="4">
                  <select class="time-picker" name="hour" id="hour">
                    <option v-for="i in 12" :key="i" :value="i">
                      {{ i }}
                    </option>
                  </select>
                </v-col>
                <v-col md="4">
                  <select class="time-picker" name="minutes" id="moinutes">
                    <option v-for="i in 59" :key="i" :value="i">
                      {{ i }}
                    </option>
                  </select>
                </v-col>
                <v-col md="4">
                  <select class="time-picker" name="am" id="am">
                    <option value="AM">AM</option>
                    <option value="PM">PM</option>
                  </select>
                </v-col>
              </v-row>
            </v-col>
            <v-col md="6">
              <v-row>
                <v-col md="4">
                  <v-text-field
                    solo
                    flat
                    label="H"
                    class="my-input"
                    min="1"
                    max="12"
                  ></v-text-field>
                </v-col>
                <v-col md="4">
                  <v-text-field
                    class="my-input"
                    solo
                    label="i"
                    type="number"
                    max="59"
                    min="1"
                  ></v-text-field>
                </v-col>
                <v-col md="4">
                  <select class="time-picker" name="am" id="am">
                    <option value="AM">AM</option>
                    <option value="PM">PM</option>
                  </select>
                </v-col>
              </v-row>
            </v-col>
          </v-row>
          <v-row>
            <v-col md="6"> Number of {{ priceType }} </v-col>
            <v-col md="6"> Number of Children </v-col>
          </v-row>
          <v-row>
            <v-col md="4">
              <v-row>
                <v-col md="4" class="text-center">
                  <v-btn @click="removePerson()" fab small color="success">
                    <v-icon>mdi-minus</v-icon>
                  </v-btn>
                </v-col>
                <v-col md="4" class="text-center">{{ numberOfPerson }}</v-col>
                <v-col md="4" class="text-center">
                  <v-btn @click="addPerson()" fab small color="success">
                    <v-icon>mdi-plus</v-icon>
                  </v-btn>
                </v-col>
              </v-row>
            </v-col>
            <v-col md="4" offset="2">
              <v-row>
                <v-col md="4" class="text-center">
                  <v-btn @click="removeChildren()" fab small color="success">
                    <v-icon>mdi-minus</v-icon>
                  </v-btn>
                </v-col>
                <v-col md="4" class="text-center">{{ numberOfChildren }}</v-col>
                <v-col md="4" class="text-center">
                  <v-btn @click="addChildren()" fab small color="success">
                    <v-icon>mdi-plus</v-icon>
                  </v-btn>
                </v-col>
              </v-row>
            </v-col>
          </v-row>
          <v-row>
            <v-col> Total </v-col>
          </v-row>
          <v-row>
            <v-col>{{ total }}</v-col>
          </v-row>
          <v-row>
            <v-col md="6">
              <v-btn elevation="2" rounded class="booking-button">
                Add To Cart
              </v-btn>
            </v-col>
            <v-col md="6">
              <v-btn @click="postPayment()" elevation="2" rounded>
                Book Now
              </v-btn>
            </v-col>
          </v-row>
        </v-col>
        <v-col md="6"></v-col>
      </v-row>
    </v-container>

    <!-- payment modal -->
    <v-dialog v-model="dialog" width="500">
      <form
        action="https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction"
        method="post"
      >
        <input type="hidden" name="encRequest" v-model="encrypted" />
        <input type="hidden" name="access_code" v-model="accessCode" />
        <input type="hidden" name="request_type" value="STRING" />
        <input type="hidden" name="command" value="orderStatusTracker" />
        <v-card>
          <v-card-title class="text-h5 grey lighten-2"> Payment </v-card-title>

          <v-card-text>
            {{ message }}
          </v-card-text>

          <v-divider></v-divider>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn v-if="canPay" type="submit" color="primary" text>
              I accept
            </v-btn>
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
      </form>
    </v-dialog>
  </div>
</template>
<script>
export default {
  props: ["id"],
  name: "BookingDetails",
  data() {
    return {
      canPay: false,
      message: "",
      title: "",
      priceType: "",
      price: 0,
      total: 0,
      dialog: false,
      numberOfPerson: 1,
      numberOfChildren: 0,
      merchantData: {},
      accessCode: "",
      encrypted: "",
      totalPayable: 0,
      date_from: "",
      date_to: "",
    };
  },
  mounted() {
    this.getItem();
  },
  methods: {
    getItem() {
      this.$axios
        .get("/single-offer/" + this.id)
        .then((res) => {
          this.title = res.data.offer.name_of_item;
          for (let i = 0; i < res.data.offer.rate.length; i++) {
            if (res.data.offer.rate[i].type == "Amount") {
              this.price = this.total = res.data.offer.rate[i].rate;
            } else {
              this.priceType = res.data.offer.rate[i].type;
            }
          }
        })
        .catch((err) => {
          throw err;
        });
    },
    addPerson() {
      this.numberOfPerson += 1;
      this.total += this.price;
    },
    removePerson() {
      if (this.numberOfPerson > 1) {
        this.numberOfPerson -= 1;
        this.total -= this.price;
      }
    },
    addChildren() {
      this.numberOfChildren += 1;
    },
    removeChildren() {
      if (this.numberOfChildren > 0) {
        this.numberOfChildren -= 1;
      }
    },
    postPayment() {
      this.merchantData = {
        billing_notes: "",
        amount: this.total,
        item_id: this.id,
        quantity: this.numberOfPerson,
        date_from: this.date_from,
        date_to: this.date_to,
      };
      this.$axios
        .post("/pay", this.merchantData)
        .then((res) => {
          this.dialog = true;
          if (res.data["error"]) {
            this.canPay = false;
            this.message = res.data["error"];
          } else {
            this.canPay = true;
            this.message =
              "You are required to pay the amount of ₹" + this.total;
            this.encrypted = res.data.encrypted_data;
            this.accessCode = res.data.access_code;
          }
        })
        .catch((err) => {
          throw err;
        });
    },
  },
};
</script>
<style>
.booking-button {
  width: 136px;
  color: #04d39b !important;
  font-size: 0.7rem !important;
}
.date-picker,
.time-picker {
  border-radius: 10px;
  padding: 5px;
  border: 1px solid black;
  width: 100%;
  outline: none;
}
.rounded-card {
  border-radius: 10px !important;
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
.my-input.v-input .v-input__slot {
  border-radius: 10px;
  border: 1px solid black;
  box-shadow: unset !important;
}
</style>
