<template>
  <v-container mt-5 class="newsContainer">
    <h2 class="pb-3 text-center">
      <b>News & Events</b>
    </h2>

    <v-row>
      <v-col md="6">
        <v-list>
          <v-list-item
            class="event"
            v-for="(guide, i) in guides"
            :key="i"
            style="
              border: #ededed solid 1px;
              border-radius: 20px;
              margin-top: 5px;
              padding: 8px;
              cursor: pointer;
            "
          >
            <v-list-item-content @click="viewEvent(guide)">
              <v-list-item-title>
                <b>{{ guide.title }}</b>
              </v-list-item-title>
              <v-list-item-subtitle>{{
                guide.content | subStr
              }}</v-list-item-subtitle>
            </v-list-item-content>
            <v-list-item-action v-if="guide.file != null">
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

    <!-- dialog -->
    <v-dialog v-model="dialog" width="1000">
      <v-card>
        <v-card-title class="justify-space-between">
          {{ title }}
          <v-btn color="#c21d00" @click="dialog = false" icon>
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text>
          <v-row>
            <v-col md="6" v-html="content"> </v-col>
          </v-row>
        </v-card-text>
        <v-card-actions v-if="file != null">
          <v-btn :href="file" elevation="0" outlined color="green"
            >Download <v-icon>mdi-download</v-icon></v-btn
          >
        </v-card-actions>
        <v-divider></v-divider>
      </v-card>
    </v-dialog>
  </v-container>
</template>
<script>
export default {
  data() {
    return {
      dialog: false,
      title: "",
      content: "",
      file: "",
      page: 1,
      guides: [],
      numberOfPages: 0,
    };
  },
  mounted() {
    this.getGuide();
  },
  filters: {
    subStr: function (string) {
      return string.substring(0, 90) + "...";
    },
  },
  methods: {
    viewEvent(item) {
      this.dialog = true;
      this.title = item.title;
      this.content = item.content;
      this.file = item.file;
    },
    getGuide() {
      this.$axios
        .get("/customer-get-news-page?page=" + this.page)
        .then((res) => {
          this.numberOfPages = res.data.news.last_page;
          this.page = res.data.news.current_page;
          this.guides = res.data.news.data;
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
.event:hover {
  box-shadow: 2px 2px 20px -15px grey;
}

.newsContainer {
  width: 70% !important;
}

@media screen and (max-width: 950px) {
  .newsContainer {
    width: 95% !important;
  }
}
</style>