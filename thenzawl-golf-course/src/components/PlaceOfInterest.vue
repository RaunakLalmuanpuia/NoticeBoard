<template>
  <v-container
    class="place-of-interest"
    @click="changeRoute('place-of-interest-near-thenzawl')"
  >
    <br />
    <h3>Places of Interest Near Thenzawl</h3>
    <br />
    <v-row>
      <v-col
        v-for="(interest, index) in interests"
        :key="index"
        md="3"
        cols="6"
      >
        <v-card style="border-radius: 10px">
          <v-img
            :src="'/' + interest.image"
            class="white--text align-end poiHeight"
            gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
          >
            <div class="text-truncate px-3 pb-5">
              {{ interest.title }}
            </div>
            <!-- <v-card-title class="">{{ interest.title }}</v-card-title> -->
            <!-- <v-card-subtitle style="color: white">
              {{ interest.address }}
            </v-card-subtitle> -->
          </v-img>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: "PlaceOfInterest",
  data() {
    return {
      interests: [],
    };
  },
  mounted() {
    this.getPlaceOfInterests();
  },
  methods: {
    changeRoute(route) {
      this.$router.push(route);
    },
    getPlaceOfInterests() {
      this.$axios
        .get("customer-place-of-interest")
        .then((res) => {
          this.interests = res.data.placeOfInterests;
        })
        .catch((err) => {
          throw err;
        });
    },
  },
};
</script>
<style scoped>
@media screen and (max-width: 480px) {
  .place {
    font-size: 1rem !important;
  }

  .poiHeight {
    height: 150px !important;
  }
}

.poiHeight {
  height: 400px;
}
</style>
