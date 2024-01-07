<template>
  <div class="box-card" :style="cssProps">
    <h4>{{ title }}</h4>
    <p class="sub-title">{{ subtitle }}</p>
  </div>
</template>
<script>
export default {
  name: "CustomCards",
  props: ["title", "subtitle", "color"],
  computed: {
    cssProps() {
      return {
        "--color": this.color,
      };
    },
  },
};
</script>

<style>
.box-card {
  font-family: "Poppins";
  background-color: white;
  border-left: 5px solid var(--color);
  padding: 15px 30px 5px 30px;
}
.box-card .sub-title {
  font-family: "Poppins";
  color: var(--color);
  font-weight: bold;
  font-size: 40px;
}
</style>