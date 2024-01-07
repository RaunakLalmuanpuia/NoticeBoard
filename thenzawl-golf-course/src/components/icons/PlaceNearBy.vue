<template>
  <img :src="place_near_by" alt="place_near_by" />
</template>
<script>
export default {
  name: "PlaceNearBy",
  data() {
    return {
      place_near_by: require("@/assets/icons/place_near_by.svg"),
    };
  },
};
</script>