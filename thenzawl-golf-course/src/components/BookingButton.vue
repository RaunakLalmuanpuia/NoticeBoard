<template>
  <div class="text-center book-container">
    Want to book our service?
    <v-btn text class="booking-link" to="/booking">Check Tariff</v-btn>
  </div>
</template>
<script>
export default {
  name: "BookingButton",
};
</script>
<style>
.book-container {
  margin-top: 20px;
  width: 25%;
  padding: 15px 0px 15px 0px;
  border-radius: 20px;
  box-shadow: 0px 0px 20px -5px #888888;
  margin-left: auto;
  margin-right: auto;
}
.booking-link {
  padding: unset !important;
  margin: unset !important;
  font-family: "Poppins" !important;
  text-transform: capitalize;
  color: #04d39b !important;
}
.booking-link:hover {
  background-color: transparent !important;
}

@media screen and (max-width: 950px) {
  .book-container {
    width: 100% !important;
  }
}
</style>