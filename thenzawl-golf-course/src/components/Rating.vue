<template>
  <div class="rating">{{ rate }} &#9733;</div>
</template>
<script>
export default {
  name: "Rating",
  props: ["rate"],
};
</script>
<style>
.rating {
  display: flex;
  flex-wrap: wrap;
  height: 23px;
  padding: 10px 5px 10px 5px;
  align-content: center;
  font-size: 14px;
  color: yellow !important;
  border: 1px solid white !important;
  border-radius: 5px;
}
</style>