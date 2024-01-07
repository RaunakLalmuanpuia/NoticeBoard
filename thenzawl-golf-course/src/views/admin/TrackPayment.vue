<template>
  <v-container fluid ml-6 mt-6>
    <v-overlay :value="show">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <v-card>
      <v-card-title>
        Tracking payment status for Order Id: {{ id }}
      </v-card-title>
      <v-card-text>
        <v-simple-table class="table">
          <tbody>
            <tr>
              <td>Transaction ID</td>
              <td>{{ transactionID }}</td>
            </tr>
            <tr>
              <td>Payment Mode</td>
              <td>{{ paymentMode }}</td>
            </tr>
            <tr>
              <td>Transaction Status</td>
              <td>{{ transactionStatus }}</td>
            </tr>
            <tr>
              <td>Amount</td>
              <td>{{ amount }}</td>
            </tr>
            <tr>
              <td>Transaction Date</td>
              <td>{{ transactionDate }}</td>
            </tr>
          </tbody>
        </v-simple-table>
      </v-card-text>

      <v-card-actions>
        <v-btn @click="refund()" outlined color="red">Refund</v-btn>
        <v-btn @click="resendEmail()" outlined color="green">Resend QR</v-btn>
      </v-card-actions>
    </v-card>
    <br />
  </v-container>
</template>

<script>
export default {
  props: ["id"],
  data() {
    return {
      show: false,
      orderId: "",
      paymentMode: "",
      transactionStatus: "",
      currentStatus: "",
      amount: "",
      transactionDate: "",
      transactionID: "",
    };
  },
  mounted() {
    this.getItems();
  },
  methods: {
    getItems() {
      let self = this;
      self.show = true;
      self.$axios
        .post("api-test", {
          order_id: this.id,
        })
        .then((res) => {
          self.currentStatus = res.data.orderDetail.payment_status;
          self.show = false;
          self.orderId = res.data[0].body.orderId;
          self.paymentMode = res.data[0].body.paymentMode;
          self.transactionStatus =
            res.data[0].body.resultInfo.resultStatus == "TXN_SUCCESS"
              ? "Success"
              : "Failure";
          self.amount = res.data[0].body.txnAmount;
          self.transactionDate = res.data[0].body.txnDate;
          self.transactionID = res.data[0].body.txnId;
        })
        .catch((err) => {
          self.show = false;
          throw err;
        });
    },

    refund() {
      let self = this;
      self.show = true;
      self.$axios
        .post("refund", {
          orderId: self.id,
          transactionId: self.transactionID,
          amount: self.amount,
        })
        .then((res) => {
          self.show = false;
          if (res.data.error) {
            this.$emit("show-snackbar", {
              message: res.data.error,
              color: "error",
            });
          } else if (
            res.data.response.body.resultInfo.resultStatus == "TXN_FAILURE"
          ) {
            this.$emit("show-snackbar", {
              message: res.data.response.body.resultInfo.resultMsg,
              color: "error",
            });
          } else if (
            res.data.response.body.resultInfo.resultStatus == "PENDING"
          ) {
            this.$emit("show-snackbar", {
              message: res.data.response.body.resultInfo.resultMsg,
              color: "success",
            });
          }
        })
        .catch((err) => {
          self.show = false;
          throw err;
        });
    },

    resendEmail() {
      let self = this;
      self.show = true;
      self.$axios
        .post("resend-qr", {
          orderId: self.orderId,
          tracking_id: self.transactionID,
          payment_mode: self.paymentMode,
          amount: self.amount,
          transactionDate: self.transactionDate,
        })
        .then((res) => {
          self.show = false;
          this.$emit("show-snackbar", {
            message: res.data.success,
            color: "success",
          });
        })
        .catch((err) => {
          self.show = false;
          throw err;
        });
    },
  },
};
</script>

<style>
.text-white {
  color: white !important;
  text-transform: capitalize;
}
.my-input.v-input .v-input__slot {
  border-radius: 10px;
  border: 1px solid black;
  box-shadow: unset !important;
}
.custom-padding {
  margin-top: -45px;
}
</style>