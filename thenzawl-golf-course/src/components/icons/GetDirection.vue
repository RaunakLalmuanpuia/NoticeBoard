<template>
  <img :src="get_direction" alt="get_direction" />
</template>
<script>
export default {
  name: "GetDirection",
  data() {
    return {
      get_direction: require("@/assets/icons/get_direction.svg"),
    };
  },
};
</script>