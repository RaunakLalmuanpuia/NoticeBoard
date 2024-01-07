<template>
  <img :src="find_me_food" alt="find_me_food" />
</template>
<script>
export default {
  name: "FindMeFood",
  data() {
    return {
      find_me_food: require("@/assets/icons/find_me_food.svg"),
    };
  },
};
</script>