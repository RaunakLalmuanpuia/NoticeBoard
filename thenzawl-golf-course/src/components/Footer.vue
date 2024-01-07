<template>
  <v-footer
    class="mt-10"
    style="width: 100%; background-color: #f5f5f5; padding-top: 30px"
    padless
  >
    <v-container>
      <v-card
        flat
        tile
        class="text-center"
        style="background-color: #f5f5f5; width: 100%"
      >
        <v-card-text class="black--text">
          <ShortLogo />
          <br />
          {{ new Date().getFullYear() }} <strong>© Thenzawl Golf Resort</strong>
        </v-card-text>

        <v-card-text class="black--text">
          <v-row class="justify-center">
            <v-col sm="4" md="2" cols="12">
              <router-link
                style="text-decoration: none"
                class="black--text"
                to="/notice-and-orders"
              >
                Downloads
              </router-link>
            </v-col>
            <v-col sm="4" md="2" cols="12">
              <router-link
                style="text-decoration: none"
                class="black--text"
                to="/news-and-events"
              >
                News & Events
              </router-link>
            </v-col>
            <v-col sm="4" md="2" cols="12">
              <router-link
                style="text-decoration: none"
                class="black--text"
                to="/notice-board"
              >
                Notice Board
              </router-link>
            </v-col>
            <v-col sm="4" md="2" cols="12">
              <router-link
                style="text-decoration: none"
                class="black--text"
                to="/privacy-policy"
                >Website Policy</router-link
              >
            </v-col>
            <v-col sm="4" md="2" cols="12">
              <router-link
                style="text-decoration: none"
                class="black--text"
                to="/terms-and-conditions"
              >
                Terms & Conditions
              </router-link>
            </v-col>
            <v-col sm="4" md="2" cols="12">
              <router-link
                style="text-decoration: none"
                class="black--text"
                to="/who-are-we"
              >
                Reach Us
              </router-link>
            </v-col>
          </v-row>
        </v-card-text>

        <v-card-text class="black--text pt-0">
          <v-row class="justify-space-around">
            <v-col md="4" sm="12" cols="12">
              <v-list color="#f5f5f5">
                <v-list-item class="text-left">
                  <v-list-item-avatar style="border-radius: 0 !important">
                    <v-img src="@/assets/msegs_logo.png"></v-img>
                  </v-list-item-avatar>
                  <v-list-item-content>
                    <v-list-item-subtitle
                      >Designed & Developed by</v-list-item-subtitle
                    >
                    <v-list-item-title style="font-size: 12px"
                      ><a
                        href="https://msegs.in/"
                        target="blank"
                        style="text-decoration: none; color: #343434"
                        class="link"
                      >
                        Mizoram State e-Governance Society</a
                      ></v-list-item-title
                    >
                  </v-list-item-content>
                </v-list-item>
              </v-list>
            </v-col>
            <v-col md="4" sm="12" cols="12">
              <v-list color="#f5f5f5">
                <v-list-item class="text-left">
                  <v-list-item-avatar style="border-radius: 0 !important">
                    <v-img src="@/assets/tourism_logo.png"></v-img>
                  </v-list-item-avatar>
                  <v-list-item-content>
                    <v-list-item-subtitle>Initiative of</v-list-item-subtitle>
                    <v-list-item-title style="font-size: 12px"
                      >Mizoram Tourism Development Authority</v-list-item-title
                    >
                  </v-list-item-content>
                </v-list-item>
              </v-list>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </v-container>
  </v-footer>
</template>

<script>
import ShortLogo from "@/components/icons/ShortLogo.vue";
export default {
  components: {
    ShortLogo,
  },
  data() {
    return {};
  },
};
</script>

<style>
@media screen and (min-width: 1600px) {
  .justify-center {
    margin-left: 300px !important;
    margin-right: 300px !important;
  }
}
.link:hover {
  color: green !important;
}
.footer {
  border-top: 2px solid #f5f5f5 !important;
}
</style>
