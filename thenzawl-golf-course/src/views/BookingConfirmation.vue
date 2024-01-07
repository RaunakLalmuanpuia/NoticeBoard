<template>
  <div class="pb-10">
    <v-overlay :value="show">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <v-container>
      <v-row>
        <v-col md="6" sm="12" cols="12" class="mx-auto">
          <v-card class="shadow">
            <v-card-title class="font-weight-bold"> Your Order </v-card-title>
            <v-card-text>
              <v-simple-table>
                <thead>
                  <tr>
                    <th>Item</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Price</th>
                    <th class="text-right">Total</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(orderdItem, i) in items" :key="i">
                    <td>{{ orderdItem.name }}</td>
                    <td class="text-center">{{ orderdItem.quantity }}</td>
                    <td class="text-center">
                      {{ orderdItem.price }}
                    </td>
                    <td class="text-right">
                      {{ orderdItem.total * noOfDays }}
                    </td>
                  </tr>
                  <tr v-if="discount != 0">
                    <td colspan="3">Sub Total:</td>
                    <td class="text-right">{{ subTotal }}</td>
                  </tr>
                  <tr v-if="discount != 0">
                    <td colspan="3">
                      Discount ({{ discountPercent }}%) of Day Pass
                    </td>
                    <td class="text-right">{{ discount }}</td>
                  </tr>
                </tbody>
              </v-simple-table>
            </v-card-text>
            <v-card-actions>
              <v-col cols="12" class="pt-8 border-top" style="padding: 0 25px">
                <v-row>
                  <span>
                    <v-icon small color="black" class="rounded-circle">mdi-currency-inr
                    </v-icon>
                    <span class="font-weight-bold">Grand Total</span>
                    <p class="font-weight-bold total">
                      {{ (subTotal - discount) * noOfDays }}
                    </p>
                  </span>
                  <v-spacer></v-spacer>
                  <v-btn
                    elevation="0"
                    outlined
                    class="nextButton"
                    rounded
                    type="button"
                    @click="initPaytm()"
                    >Make Payment</v-btn
                  >
                </v-row>
              </v-col>
            </v-card-actions>
            <v-card-text>
              <v-col class="text-center">
                <v-img
                  src="@/assets/paytm_link.jpg"
                  class="d-inline-block"
                  style="cursor: pointer"
                  @click="paytmAdDialog = true"
                ></v-img>
              </v-col>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>

    <v-dialog v-model="paytmAdDialog" max-width="300">
      <v-img
        src="@/assets/paytm_know_more.jpg"
        @click="paytmAdDialog = false"
      ></v-img>
    </v-dialog>
  </div>
</template>
<script>
export default {
  props: {
    id: {
      type: String,
    },
    booking_id: {
      type: String,
    },
    token: {
      type: String,
    },
    amount: {
      type: String,
    },
    encData: {
      type: String,
    },
    code: {
      type: String,
    },
    days: {
      type: String,
    },
  },
  data() {
    return {
      show: false,
      dataId: this.$route.params.id,
      items: [],
      grandTotal: 0,
      subTotal: 0,
      discount: 0,
      addOnPrice: 0,
      discountPercent: 0,
      noOfDays: this.$route.params.days,
      email: "",
      phone: "",

      paytmAdDialog: false,

      // razorpay
      rzpOptions: {
        key: "rzp_test_17L4YGExv28au1",
        amount: 0,
        currency: "INR",
        name: "Thenzawl Golf Resort",
        description: "",
        image: "/img/TGR_logo.png",
        handler: this.submit,
        prefill: {
          name: "",
          email: "",
          contact: "",
        },
        notes: {
          user_id: null,
          order_id: null,
        },
        theme: {
          color: "#ff7a7a",
        },
      },
    };
  },
  created() {
    var imported = document.createElement("script");
    imported.src =
      "https://securegw.paytm.in/merchantpgpui/checkoutjs/merchants/Thenza66312387975501.js";
    document.head.appendChild(imported);
  },
  mounted() {
    this.getBooking();
  },
  methods: {
    getBooking() {
      let self = this;
      self.show = true;
      let items = [];
      self.$axios
        .get("/get-my-booking/" + self.dataId)
        .then(function (res) {
          let orderedItems = res.data.orderDetail.ordered_item;
          self.rzpOptions.prefill.name = res.data.orderDetail.name;
          self.rzpOptions.prefill.email = res.data.orderDetail.email;
          self.rzpOptions.prefill.contact = res.data.orderDetail.contact;
          self.rzpOptions.notes.order_id = res.data.orderDetail.order_id;

          // paytm
          for (let i = 0; i < orderedItems.length; i++) {
            var currentItem = orderedItems[i];
            var prices = orderedItems[i].item.rate;
            let currentPrice = 0;
            for (let j = 0; j < prices.length; j++) {
              if (prices[j].type == "Amount") {
                currentPrice = prices[j].rate;
              }
            }
            if (currentItem.item.name_of_item == "Day Pass") {
              self.subTotal += currentPrice * currentItem.quantity;
              if (currentItem.quantity >= 21) {
                self.discount = self.subTotal * 0.6;
                self.discountPercent = 60;
              } else if (currentItem.quantity >= 11) {
                self.discount = self.subTotal * 0.4;
                self.discountPercent = 40;
              } else if (currentItem.quantity >= 5) {
                self.discount = self.subTotal * 0.3;
                self.discountPercent = 30;
              }
              items.push({
                name: currentItem.item.name_of_item,
                quantity: currentItem.quantity,
                price: currentPrice,
                total: currentPrice * currentItem.quantity,
              });
            } else if (
              currentItem.item.name_of_item == "Videography" ||
              currentItem.item.name_of_item == "Photography" ||
              currentItem.item.name_of_item == "Camera" ||
              currentItem.item.name_of_item == "Video Camera"
            ) {
              self.subTotal += currentPrice + 200 * currentItem.quantity;

              if (currentItem.quantity >= 21) {
                self.discount = 200 * currentItem.quantity * 0.6;
                self.discountPercent = 60;
              } else if (currentItem.quantity >= 11) {
                self.discount = 200 * currentItem.quantity * 0.4;
                self.discountPercent = 40;
              } else if (currentItem.quantity >= 5) {
                self.discount = 200 * currentItem.quantity * 0.3;
                self.discountPercent = 30;
              }
              items.push({
                name: currentItem.item.name_of_item,
                quantity: currentItem.quantity,
                price: currentPrice,
                total: currentPrice + 200 * currentItem.quantity,
              });
            } else {
              self.subTotal += currentPrice * currentItem.quantity;
              items.push({
                name: currentItem.item.name_of_item,
                quantity: currentItem.quantity,
                price: currentPrice,
                total: currentPrice * currentItem.quantity,
              });
            }
          }

          self.items = items;
        })
        .then(() => {
          self.show = false;
        })
        .catch(function (err) {
          throw err;
        });
    },

    initPaytm() {
      let self = this;
      self.show = true;
      var config = {
        root: "",
        flow: "DEFAULT",
        merchant: {
          name: "Thenzawl Golf Resort",
        },
        data: {
          orderId: "",
          token: "" /* update token value */,
          tokenType: "TXN_TOKEN",
          amount: "" /* update amount */,
        },
        handler: {
          notifyMerchant: function (eventName, data) {
            console.log("notifyMerchant handler function called");
            console.log("eventName => ", eventName);
            console.log("data => ", data);
          },
        },
      };
      self.$axios
        .post("/initiate-payment", {
          order_id: self.$route.params.booking_id,
          amount: self.$route.params.amount,
        })
        .then((res) => {
          const { orderId, token, amount } = res.data;
          config.data.orderId = orderId;
          config.data.token = token;
          config.data.amount = amount;
          window.Paytm.CheckoutJS.init(config)
            .then(function onSuccess() {
              self.show = false;
              // after successfully updating configuration, invoke JS Checkout
              window.Paytm.CheckoutJS.invoke();
            })
            .catch(function onError(error) {
              self.show = false;
              throw error;
            });
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

.nextButton {
  border-color: #44d39b;
  text-transform: capitalize;
  font-weight: 700;
  padding: 0 20px !important;
}
</style>
