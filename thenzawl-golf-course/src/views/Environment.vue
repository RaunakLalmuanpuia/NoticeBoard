<template>
  <div :class="{ 'blur-content': dialog }">
    <v-container class="header" fluid>
      <v-img
        height="300"
        src="@/assets/banners/environment.jpg"
        class="d-none d-md-flex d-lg-flex"
      >
        <v-row>
          <div class="title-container">
            <v-col md-4 offset="2">
              <div class="my-title-2">Environment</div>
            </v-col>
          </div>
        </v-row>
      </v-img>

      <div class="d-flex d-md-none">
        <v-img height="150" src="@/assets/mobile-bg.png"></v-img>
        <div class="pageTitle">Environment</div>
      </div>
      <br />
    </v-container>
    <v-container class="enviContainer">
      <!-- <Guide /> -->
      <v-row>
        <v-col
          cols="12"
          v-for="(content, index) in contents"
          :key="index"
          md="6"
        >
          <v-card
            style="padding: 10px"
            :color="content.bgcolor"
            class="rounded-card"
            elevation="0"
          >
            <v-card-title
              :style="'color: ' + content.btnColor + '; font-weight: bold'"
              >{{ content.title }}</v-card-title
            >
            <v-card-text style="color: #0b1f40">
              {{ content.content | subStr }}
            </v-card-text>
            <v-card-actions>
              <v-btn
                small
                text
                @click="displayDetail(index)"
                :color="content.btnColor"
                style="text-decoration: underline"
                >Read More</v-btn
              >
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
      <br />
      <PlaceOfInterest />
    </v-container>

    <!-- dialog -->
    <v-dialog v-model="dialog" width="1000">
      <v-card>
        <div style="padding: 20px">
          <v-btn
            color="#c21d00"
            @click="dialog = false"
            icon
            style="float: right"
          >
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <span>{{ title }}</span>
        </div>
        <v-card-text>
          <v-row>
            <v-col md="6" v-html="display"> </v-col>
            <v-col md="6">
              <v-img style="border-radius: 10px" v-bind:src="url"></v-img>
            </v-col>
          </v-row>
        </v-card-text>
        <v-divider></v-divider>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
import PlaceOfInterest from "@/components/PlaceOfInterest.vue";

export default {
  components: {
    PlaceOfInterest,
  },
  data() {
    return {
      dialog: false,
      display: "",
      title: "",
      url: "",
      contents: [
        {
          textColor: "#0b1f40",
          bgcolor: "#f2f7ff",
          btnColor: "#5e9bff",
          url: require("../assets/watercon.jpg"),
          title: "Water Conservation And Management",
          content:
            "All water used at Thenzawl Golf Course & Resort for non-human consumption needs such as construction, irrigation, watering and filling of lakes is “recycled” water provided by a STP (Sewage Treatment Plant) at the Golf Course. Water is used “efficiently” at the golf course through use of latest technology which reduces consumption to minimum. Some of these practices are as follows: <ul><li>Effective use of over head irrigation using automated irrigation systems.</li><li>The use of latest technology enables accurate and precise irrigation applications and minimize wastage</li><li>Correct irrigation practices promote healthy turf which require less pesticide inputs and in turn resulting in a healthier environment</li></ul>",
        },
        {
          textColor: "#02210b",
          bgcolor: "#f5fffa",
          btnColor: "#50a368",
          url: require("../assets/GreenPhilosophy.jpg"),
          title: "Green Philosophy",
          content:
            "Conservation of forest and tree plantation has been at the core of Thenzawl Golf Course & Resort’s philosophy while creating the golf courses in line with the Mizoram Responsible Tourism Policy 2020. The main objective of the project was not just to create a beautiful golf course but one that is built on the foundation of environmental sustainability. Internationally accepted best practices were followed during construction and are still followed to manage the running of the golf courses. Water management depends on recycling resources and minimum use of natural resources. Thenzawl Golf Course & Resort has actually enhanced the surrounding environment by creating an oasis that releases clean air and provides a micro eco-system conducive to enhancement of flora and fauna. Thenzawl Golf Course & Resorts prohibits usage of non-biodegrable items such as plastics etc. We expect the patrons and visitors to honour our endeavours towards environmental sustainability.",
        },
        {
          textColor: "#211c02",
          bgcolor: "#fffbf2",
          btnColor: "#ebaf38",
          url: require("../assets/TreePlantation.jpg"),
          title: "Tree Plantation",
          content:
            "In order to conserve forest ecology and to make the place a conducive habitat for various migratory species of birds and small animals, Thenzawl Golf Course & Resorts has painstakingly planted various species of trees from its conception. It aims to provide green lungs for the town and Thenzawl and its surrounding villages by providing green cover in its entire Golf Course.<br><br> Tree plantation by individuals and groups are encouraged by Thenzawl Golf Course & Resort. Donation of wild orchids by individuals or groups are also welcome.",
        },
        {
          textColor: "#0b1f40",
          bgcolor: "#f2f7ff",
          btnColor: "#5e9bff",
          url: require("../assets/Flora.jpg"),
          title: "FLORA AND FAUNA",
          content:
            "Many native species of trees and vegetations were planted at the Golf Courses to enhance its green cover. In recent years, the golf course has become the home of several migratory bird species and small wild animals. A large lake which is being developed will be used for entertainment purposes and fishing. The shaded areas provide an ideal habitat for many species of birds and small animals. Tourism Department with Environment, Forest & Climate Change Department are taking pro-active initiative in preservation and conservation of green covers in the Golf Course. ",
        },
        {
          textColor: "#02210b",
          bgcolor: "#f5fffa",
          btnColor: "#50a368",
          url: require("../assets/obp.jpg"),
          title: "OTHER BEST PRACTICES",
          content:
            "Thenzawl Golf Course & Resort follows the objectives enshrined in the Mizoram Responsible Tourism Policy 2020 where non-invasive indigenous plants are planted to prevent soil erosion and make it a natural habitat for various species of birds and small animals. <br><br> We also believe in scientific management of pest control for the greens and fairways in order not to destroy its natural environment. Designated places of no spray zones, pesticide and fertilizer management, buffer zones around lakes are put in place.",
        },
      ],
    };
  },
  filters: {
    subStr: function (string) {
      return string.substring(0, 200) + "...";
    },
  },
  methods: {
    displayDetail(id) {
      this.dialog = true;
      this.display = this.contents[id].content;
      this.title = this.contents[id].title;
      this.url = this.contents[id].url;
    },
  },
};
</script>
<style scoped>
.header {
  padding: 0;
}

.blur-content {
  filter: blur(5px);
}
.rounded-card {
  border-radius: 10px !important;
}
.my-title-2 {
  font-family: "Poppins";
  color: black;
  font-size: 2.3rem;
  font-weight: bolder;
  margin-bottom: 1rem;
  margin-top: 10rem;
}
.member-container {
  background-color: #22242a;
  padding-bottom: 20px;
}

.enviContainer {
  width: 70% !important;
}

@media screen and (max-width: 950px) {
  .enviContainer {
    width: 97% !important;
  }
}

.pageTitle {
  position: absolute;
  top: 50px;
  font-size: 1.8rem;
  margin-left: 20px;
  font-weight: 700;
}
</style>
