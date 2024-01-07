<template>
  <v-container mt-5 class="downloadContainer">
    <h2 class="pb-3 text-center">
      <b>Notice & Orders</b>
    </h2>

    <v-row>
      <v-col md="6">
        <v-list>
          <v-list-item
            v-for="(guide, i) in guides"
            :key="i"
            style="
              border: #ededed solid 1px;
              border-radius: 20px;
              margin-top: 5px;
              padding: 8px;
            "
          >
            <v-list-item-content>
              <v-list-item-title>
                <b>{{ guide.title }}</b>
              </v-list-item-title>
              <v-list-item-subtitle>{{ guide.excerpt }}</v-list-item-subtitle>
            </v-list-item-content>
            <v-list-item-action>
              <v-btn :href="guide.file" icon outlined rounded color="#04d39b">
                <v-icon>mdi-download</v-icon>
              </v-btn>
            </v-list-item-action>
          </v-list-item>
        </v-list>
      </v-col>
    </v-row>
    <v-row>
      <v-col v-if="numberOfPages > 1" md="6" class="justify-start">
        <v-pagination
          @input="onPageChange"
          v-model="page"
          :length="numberOfPages"
        ></v-pagination>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
export default {
  data() {
    return {
      page: 1,
      guides: [],
      numberOfPages: 0,
    };
  },
  mounted() {
    this.getGuide();
  },
  methods: {
    getGuide() {
      this.$axios
        .get("/customer-get-downloads?page=" + this.page)
        .then((res) => {
          this.numberOfPages = res.data.documents.last_page;
          this.page = res.data.documents.current_page;
          this.guides = res.data.documents.data;
        })
        .catch((err) => {
          throw err;
        });
    },
    onPageChange() {
      this.getGuide();
    },
  },
};
</script>

<style scoped>
.downloadContainer {
  width: 70% !important;
}

@media screen and (max-width: 950px) {
  .downloadContainer {
    width: 95% !important;
  }
}
</style>