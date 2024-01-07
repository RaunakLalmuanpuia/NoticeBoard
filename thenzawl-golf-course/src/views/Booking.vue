<template>
  <div>
    <v-container class="header" fluid>
      <v-img height="300" src="@/assets/banners/booking.jpg">
        <v-row>
          <div class="title-container">
            <v-col md="4" offset="2">
              <div class="my-title-2">Booking</div>
            </v-col>
          </div>
        </v-row>
      </v-img>
      <br />
    </v-container>
    <v-container style="width: 80%">
      <Guide />
      <br />
      <Offers />
      <br />
    </v-container>
    <div class="member-container">
      <v-container style="width: 80%">
        <Explore />
      </v-container>
    </div>
  </div>
</template>
<script>
import Offers from "@/components/Offers.vue";
import Explore from "@/components/Explore.vue";
import Guide from "@/components/Guide.vue";

export default {
  components: {
    Offers,
    Explore,
    Guide,
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

.header {
  padding: 0;
}
</style>
