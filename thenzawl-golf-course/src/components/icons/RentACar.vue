<template>
  <img :src="rent_a_car" alt="rent_a_car" />
</template>
<script>
export default {
  name: "RentACar",
  data() {
    return {
      rent_a_car: require("@/assets/icons/rent_a_car.svg"),
    };
  },
};
</script>