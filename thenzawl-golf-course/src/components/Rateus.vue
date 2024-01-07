<template>
  <div>
    <v-overlay :value="show">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <v-snackbar v-model="snackbar" timeout="2000" shaped>
      {{ text }}
    </v-snackbar>
    <v-layout row justify-center>
      <v-dialog v-model="dialog" persistent max-width="600">
        <v-card>
          <v-card-title class="headline"
            >Give your thoughts about<br />
            Thenzawl Golf Resort</v-card-title
          >
          <v-card-text style="font-size: 23px">Rate us</v-card-text>
          <v-container style="padding-left: 20px; padding-right: 20px">
            <v-row>
              <v-col cols="12" md="12" sm="12">
                <v-rating
                  v-model="data.rate"
                  background-color="grey"
                  color="red"
                  size="44"
                ></v-rating>
              </v-col>
              <v-col cols="12" md="12" sm="12">
                <v-text-field
                  placeholder="Enter Name"
                  v-model="data.name"
                  rounded
                  outlined
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="12" sm="12">
                <v-textarea
                  placeholder="Remarks"
                  v-model="data.comment"
                  rounded
                  outlined
                ></v-textarea>
              </v-col>
            </v-row>
          </v-container>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              color="green darken-1"
              rounded
              text
              outlined
              width="100px"
              @click.native="close"
              >Close</v-btn
            >
            <v-btn
              color="green"
              rounded
              outlined
              text
              width="100px"
              @click="submitRatings()"
              >Submit</v-btn
            >
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-layout>
  </div>
</template>

<script>
export default {
  props: {
    dialog: {
      default: false,
    },
  },
  data() {
    return {
      show: false,
      snackbar: false,
      text: "",
      data: {
        comment: "",
        name: "",
        rate: "",
      },
    };
  },
  methods: {
    close() {
      this.$emit("update:dialog", false);
    },
    submitRatings() {
      this.$axios.post("/give-rating", this.data).then((res) => {
        this.snackbar = true;
        this.text = res.data.success + ". Thank you for your feedback!";
        this.show = false;
        this.dialog = false;
      });
    },
  },
};
</script>
