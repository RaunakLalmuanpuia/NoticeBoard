<template>
  <img :src="menu_dots" alt="menu_dots" />
</template>
<script>
export default {
  name: "Menu_Dots",
  data() {
    return {
      menu_dots: require("@/assets/icons/menu_dots.svg"),
    };
  },
};
</script>