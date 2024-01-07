<template>
  <v-container>
    <h3 style="line-height: 5; margin-top: 20px">What We Offer</h3>
    <v-row>
      <v-col v-for="(offer, i) in offers" :key="i">
        <v-card class="mx-auto offer" max-width="344">
          <v-list-item three-line>
            <v-list-item-avatar tile size="80">
              <v-img class="my-image" :src="offer.picture"></v-img>
            </v-list-item-avatar>
            <v-list-item-content>
              <div class="mb-4">{{ offer.name_of_item }}</div>
              <v-list-item-title class="mb-1 pr-6">
                <v-row class="justify-space-between">
                  <v-col v-for="rate in offer.rate" :key="rate.id" md="3">
                    <span v-if="rate.type == 'Amount'">
                      <v-btn class="custom-btn" disabled x-small fab outlined>
                        <v-icon size="16">mdi-currency-inr</v-icon>
                      </v-btn>
                      {{ rate.rate }}
                    </span>
                    <span v-else-if="rate.type == 'Person'">
                      <v-btn disabled x-small fab outlined>
                        <v-icon size="16">mdi-account</v-icon>
                      </v-btn>
                      {{ rate.rate }}
                    </span>
                    <span v-else-if="rate.type == 'Hours'">
                      <v-btn disabled x-small fab outlined>
                        <v-icon size="25">mdi-clock-time-eight-outline</v-icon>
                      </v-btn>
                      {{ rate.rate }}
                    </span>
                  </v-col>
                </v-row>
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-card-actions class="my-card">
            <v-btn :to="'/booking/' + offer.id" text block> Book Now </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
    <br />
  </v-container>
</template>
<script>
export default {
  name: "offers",
  data() {
    return {
      offers: [],
    };
  },
  mounted() {
    this.getOffers();
  },
  methods: {
    getOffers() {
      this.$axios
        .get("/offers")
        .then((res) => {
          this.offers = res.data.offers;
        })
        .catch((err) => {
          throw err;
        });
    },
  },
};
</script>

<style>
.v-btn--fab.v-size--x-small.custom-btn {
  height: 20px !important;
  width: 20px !important;
  color: black !important;
}
.offer {
  background-color: #f0f0f0 !important;
  border-radius: 20px !important;
  box-shadow: 1px 2px 22px 1px rgba(0, 0, 0, 0.41) !important;
  -webkit-box-shadow: 1px 2px 22px 1px rgba(0, 0, 0, 0.41) !important;
  -moz-box-shadow: 1px 2px 22px 1px rgba(0, 0, 0, 0.41) !important;
}
.my-card.v-card__actions {
  background-color: white !important;
}

.my-image .v-image__image--cover {
  background-size: contain;
}
</style>