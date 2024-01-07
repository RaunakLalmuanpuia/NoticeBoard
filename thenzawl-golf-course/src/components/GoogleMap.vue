<template>
  <div>
    <GmapMap :center="center" :zoom="12" style="width: 100%; height: 400px">
      <GmapMarker
        :key="index"
        v-for="(m, index) in markers"
        :position="m.position"
        @click="center = m.position"
      />
    </GmapMap>
  </div>
</template>

<script>
export default {
  name: "GoogleMap",
  data() {
    return {
      markers: [],
      center: { lat: 23.279197092987783, lng: 92.74943989572974 },
    };
  },
  mounted() {
    this.geolocate();
    const marker = {
      lat: 23.279197092987783,
      lng: 92.74943989572974,
    };
    this.markers.push({ position: marker });
  },
  methods: {
    geolocate: function () {
      navigator.geolocation.getCurrentPosition((position) => {
        const marker = {
          lat: position.coords.latitude,
          lng: position.coords.longitude,
        };
        this.markers.push({ position: marker });
        this.center = {
          lng: position.coords.longitude,
        };
      });
    },
  },
};
</script>