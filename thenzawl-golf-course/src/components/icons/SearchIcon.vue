<template>
  <img :src="search" alt="search" />
</template>
<script>
export default {
  name: "Search",
  data() {
    return {
      search: require("@/assets/icons/search.svg"),
    };
  },
};
</script>