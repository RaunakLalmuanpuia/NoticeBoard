<template>
  <img :src="where_to_stay" alt="where_to_stay" />
</template>
<script>
export default {
  name: "WhereToStay",
  data() {
    return {
      where_to_stay: require("@/assets/icons/where_to_stay.svg"),
    };
  },
};
</script>