<template>
  <v-list color="#f8f8f8" rounded>
    <v-list-item>
      <v-list-item-avatar style="background-color: white" size="60">
        <v-img v-bind:src="url"></v-img>
      </v-list-item-avatar>
      <v-list-item-content>
        <v-list-item-title style="font-size: 14px; font-weight: bold">
          {{ heading }}
        </v-list-item-title>
        <v-list-item-subtitle style="font-size: 14px">
          <b>{{ caption1 }}</b>
          <br />
          {{ caption2 }}
          <br />
          {{ caption3 }}
        </v-list-item-subtitle>
      </v-list-item-content>
    </v-list-item>
  </v-list>
</template>

<script>
export default {
  name: "Committee",
  props: {
    url: String,
    heading: String,
    caption1: String,
    caption2: String,
    caption3: String,
  },
};
</script>

<style scoped>
</style>
