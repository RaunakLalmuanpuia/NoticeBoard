<template>
  <img :src="heart" alt="heart" />
</template>
<script>
export default {
  name: "Heart",
  data() {
    return {
      heart: require("@/assets/icons/heart.svg"),
    };
  },
};
</script>