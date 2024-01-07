<template>
  <v-container mt-12 style="width: 70%">
    <v-overlay :value="show">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <v-row class="justify-center">
      <v-col md="4">
        <v-card v-if="paymentStatus == 'Success'">
          <v-card-title class="text-center" style="background-color: #8dc99d">{{
            paymentStatus
          }}</v-card-title>
          <v-card-text class="text-center">
            {{ message }}
            <div>
              Please save the QR Code sent to your email and whatsapp number.
            </div>
          </v-card-text>
        </v-card>
        <v-card v-else-if="paymentStatus == 'Failure'">
          <v-card-title>{{ paymentStatus }}</v-card-title>
          <v-card-text>
            {{ message }}
          </v-card-text>
        </v-card>
        <v-card v-else-if="paymentStatus == 'Aborted'">
          <v-card-title>Aborted</v-card-title>
          <v-card-text>{{ message }}</v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
export default {
  props: ["id"],
  data() {
    return {
      show: false,
      paymentStatus: "",
      message: "",
    };
  },
  mounted() {
    this.getOrder();
  },
  methods: {
    getOrder() {
      this.show = true;
      this.$axios
        .get("/get-order-detail/" + this.id)
        .then((res) => {
          this.paymentStatus = res.data.status;
          this.message = res.data.message;
          this.show = false;
        })
        .catch((err) => {
          throw err;
        });
    },
  },
};
</script>
<style>
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
