<template>
  <v-container>
    <v-row>
      <!-- <v-col>
        <router-link class="link" to="/get-direction">
          <div class="guide-container">
            <GetDirection />
            <br />
            Get Direction
          </div>
        </router-link>
      </v-col> -->
      <v-col>
        <router-link class="link" to="/place-of-interest-near-thenzawl">
          <div class="guide-container">
            <PlaceNearBy />
            <br />
            Place near By
          </div>
        </router-link>
      </v-col>
      <v-col>
        <router-link class="link" to="/find-me-food">
          <div class="guide-container">
            <FindMeFood />
            <br />
            Find Me Food
          </div>
        </router-link>
      </v-col>
      <v-col>
        <router-link class="link" to="/rent-a-car">
          <div class="guide-container">
            <RentACar />
            <br />
            Rent A Car
          </div>
        </router-link>
      </v-col>
      <v-col>
        <router-link class="link" to="/where-to-stay">
          <div class="guide-container">
            <WhereToStay />
            <br />
            Where To Stay
          </div>
        </router-link>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
// import GetDirection from "@/components/icons/GetDirection.vue";
import PlaceNearBy from "@/components/icons/PlaceNearBy.vue";
import FindMeFood from "@/components/icons/FindMeFood.vue";
import RentACar from "@/components/icons/RentACar.vue";
import WhereToStay from "@/components/icons/WhereToStay.vue";

export default {
  name: "guide",
  components: {
    // GetDirection,
    PlaceNearBy,
    FindMeFood,
    RentACar,
    WhereToStay,
  },
};
</script>
<style scoped>
.link {
  text-decoration: none;
  color: black;
}
.guide-container {
  padding: 12px 30px 12px 30px;
  margin: auto;
  border: 1px solid #efefef;
  border-radius: 1rem;
  text-align: center;
}
.guide-container:hover {
  cursor: pointer;

  box-shadow: 0px 0px 19px -6px rgba(0, 0, 0, 0.13);
  -webkit-box-shadow: 0px 0px 19px -6px rgba(0, 0, 0, 0.13);
  -moz-box-shadow: 0px 0px 19px -6px rgba(0, 0, 0, 0.13);
}
</style>