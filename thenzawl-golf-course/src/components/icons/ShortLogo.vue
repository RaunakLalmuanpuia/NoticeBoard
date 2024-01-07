<template>
  <img height="60" :src="short_logo" alt="short_logo" />
</template>
<script>
export default {
  name: "ShortLogo",
  data() {
    return {
      short_logo: require("@/assets/tgr_logo.svg"),
    };
  },
};
</script>