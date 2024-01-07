<template>
  <v-container fluid ml-6 mt-6>
    <h2>Booked</h2>
    <v-tabs v-model="tab" align-with-title>
      <v-tabs-slider color="yellow"></v-tabs-slider>
      <v-tab href="#booking">Today's Booking</v-tab>
      <v-tab href="#failed">Failed Payments</v-tab>
      <v-tab href="#history">History</v-tab>
      <v-tab href="#refunds">Refunds</v-tab>
    </v-tabs>
    <v-tabs-items v-model="tab">
      <v-tab-item value="booking">
        <TodaysBooking />
      </v-tab-item>
      <v-tab-item value="failed">
        <FailedPayments />
      </v-tab-item>
      <v-tab-item value="history">
        <BookingHistory />
      </v-tab-item>
      <v-tab-item value="refunds">
        <BookingRefunds />
      </v-tab-item>
    </v-tabs-items>
  </v-container>
</template>
<style>
tbody tr:nth-of-type(odd) {
  background-color: rgba(0, 0, 0, 0.05);
}
</style>
<script>
import TodaysBooking from "@/components/bookedItems/TodaysBooking";
import FailedPayments from "@/components/bookedItems/FailedPayments";
import BookingHistory from "@/components/bookedItems/BookingHistory";
import BookingRefunds from "@/components/bookedItems/BookingRefunds";

export default {
  components: {
    TodaysBooking,
    FailedPayments,
    BookingHistory,
    BookingRefunds,
  },
  data() {
    return {
      tab: null,
    };
  },
};
</script>