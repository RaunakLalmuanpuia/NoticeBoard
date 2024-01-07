<template>
  <v-container fluid ml-6 mt-6>
    <v-overlay :value="show">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <v-card>
      <v-card-title>
        Tracking refund status for Order Id: {{ id }}
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
      refundId: "",
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
        .post("refund-status-api", {
          order_id: this.id,
        })
        .then((res) => {
          self.currentStatus = res.data.orderDetail.payment_status;
          self.show = false;
          self.orderId = res.data[0].body.orderId;
          self.paymentMode = res.data[0].body.paymentMode;
          self.amount = res.data[0].body.txnAmount;
          self.transactionDate = res.data[0].body.txnDate;
          self.transactionID = res.data[0].body.txnId;
          if (res.data[0].body.resultInfo.resultCode == 10) {
            self.transactionStatus = "Refund Successful";
          } else if (
            res.data[0].body.resultInfo.resultCode == 601 ||
            res.data[0].body.resultInfo.resultCode == 501
          ) {
            self.transactionStatus =
              "Refund request was raised for this transaction. But it is pending state.";
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