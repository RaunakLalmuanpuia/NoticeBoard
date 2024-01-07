<template>
  <v-container fluid ml-6 mt-6>
    <v-overlay :value="show">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <v-snackbar
      v-model="snackbar"
      color="success"
      timeout="2000"
      shaped
      centered
    >
      {{ text }}
    </v-snackbar>
    <v-row>
      <v-col md="4" offset="4">
        <v-card>
          <v-card-title>Scan Barcode</v-card-title>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      show: false,
      text: "",
      snackbar: false,
    };
  },
  created() {
    this.$barcodeScanner.init(this.onBarcodeScanned);
  },
  destroyed() {
    this.$barcodeScanner.destroy();
  },
  methods: {
    onBarcodeScanned(barcode) {
      let self = this;
      self.show = true;
      let code = barcode.substring(0, barcode.length - 5);
      this.$axios
        .post("/scan-barcode", { barcode: code })
        .then(function (res) {
          self.show = false;
          self.snackbar = true;
          self.text = res.data.order;
        })
        .catch(function (err) {
          self.show = false;
          throw err;
        });
    },
    // resetBarcode() {
    //   let barcode = this.$barcodeScanner.getPreviousCode();

    // },
  },
};
</script>