<template>
  <v-container fluid ml-6 mt-6>
    <v-row>
      <v-col md="4">
        <CustomCards
          title="New Booking"
          :subtitle="newBooking"
          color="#3859ff"
        />
      </v-col>
      <v-col md="4">
        <CustomCards title="Check In" :subtitle="checkin" color="#79ba98" />
      </v-col>
      <!-- <v-col md="3">
        <CustomCards title="Check Out" subtitle="348" color="#8c34eb" />
      </v-col> -->
      <v-col md="4">
        <CustomCards
          title="Visitors (In month)"
          :subtitle="visitors"
          color="#c93b1e"
        />
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import CustomCards from "@/components/CustomCards.vue";
export default {
  components: {
    CustomCards,
  },
  data() {
    return {
      newBooking: "",
      checkin: "",
      visitors: "",
    };
  },
  mounted() {
    this.getVisitorData();
  },
  methods: {
    getVisitorData() {
      this.$axios
        .get("get-visitor-data")
        .then((res) => {
          this.newBooking = res.data.newBooking;
          this.checkin = res.data.checkin;
          this.visitors = res.data.monthVisitors;
        })
        .catch((err) => {
          throw err;
        });
    },
  },
};
</script>
