<template>
  <img :src="notification" alt="notification" />
</template>
<script>
export default {
  name: "Notification",
  data() {
    return {
      notification: require("@/assets/icons/notification.svg"),
    };
  },
};
</script>