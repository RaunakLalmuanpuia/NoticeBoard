<template>
  <div>
    <v-container>
      <v-row>
        <v-col md="3">
          <h2>Get Direction</h2>
        </v-col>
        <v-col md="9">
          <GoogleMap />
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import GoogleMap from "@/components/GoogleMap.vue";

export default {
  components: {
    GoogleMap,
  },
};
</script>