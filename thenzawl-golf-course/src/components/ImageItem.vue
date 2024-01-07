<template>
  <figure class="image__wrapper">
    <img :data-url="source" alt="page image" class="image__item" />
  </figure>
</template>

<script>
export default {
  name: "ImageItem",
  props: {
    source: {
      type: String,
      required: true,
    },
  },
};
</script>