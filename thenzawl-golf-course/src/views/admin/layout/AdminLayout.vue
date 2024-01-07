<template>
  <v-app id="inspire">
      <v-snackbar
          v-model="snackbar"
          :color="color"
          :timeout="timeout"
          shaped
          centered
      >
          {{ text }}
      </v-snackbar>
      <v-overlay :value="show">
          <v-progress-circular indeterminate size="64"></v-progress-circular>
      </v-overlay>
      <v-navigation-drawer
          v-model="drawer"
          :clipped="$vuetify.breakpoint.lgAndUp"
          app
      >
          <v-list dense>
              <template v-for="item in items">
                  <v-row
                      v-if="item.heading"
                      :key="item.heading"
                      align="center"
                  >
                      <v-col cols="6">
                          <v-subheader v-if="item.heading">
                              {{ item.heading }}
                          </v-subheader>
                      </v-col>
                  </v-row>
                  <v-list-group
                      v-else-if="item.children"
                      :key="item.text"
                      v-model="item.model"
                      :prepend-icon="
                          item.model ? item.icon : item['icon-alt']
                      "
                      append-icon=""
                  >
                      <v-list-item-content>
                          <v-list-item-title>
                              {{ item.text }}
                          </v-list-item-title>
                      </v-list-item-content>

                      <v-list-item
                          v-for="(child, i) in item.children"
                          :key="i"
                          link
                      >
                          <v-list-item-action v-if="child.icon">
                              <v-icon>{{ child.icon }}</v-icon>
                          </v-list-item-action>
                          <v-list-item-content>
                              <v-list-item-title>
                                  {{ child.text }}
                              </v-list-item-title>
                          </v-list-item-content>
                      </v-list-item>
                  </v-list-group>
                  <v-list-item v-else :key="item.text" link :to="item.link">
                      <v-list-item-action>
                          <v-icon>{{ item.icon }}</v-icon>
                      </v-list-item-action>
                      <v-list-item-content>
                          <v-list-item-title>
                              {{ item.text }}
                          </v-list-item-title>
                      </v-list-item-content>
                  </v-list-item>
              </template>
          </v-list>
      </v-navigation-drawer>

      <v-app-bar
          :clipped-left="$vuetify.breakpoint.lgAndUp"
          app
          color="white darken-2"
          dark
      >
          <v-app-bar-nav-icon
              class="hidden-md-and-up"
              style="color: black"
              @click.stop="drawer = !drawer"
          ></v-app-bar-nav-icon>
          <v-toolbar-title class="ml-0 pl-4">
              <v-img
                  height="50"
                  width="130"
                  src="@/assets/tgrlogo-margin.svg"
              ></v-img>
          </v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-title>
              <div class="hidden-md-and-up">
                  <v-menu offset-y>
                      <template v-slot:activator="{ on, attrs }">
                          <v-btn icon v-bind="attrs" v-on="on"
                              ><Menu_Dots />
                          </v-btn>
                      </template>
                      <v-list>
                          <v-list-item @click="goToAccount">
                              <v-list-item-icon
                                  ><v-icon
                                      >mdi-account</v-icon
                                  ></v-list-item-icon
                              >
                              <v-list-item-title>Account</v-list-item-title>
                          </v-list-item>
                          <v-list-item @click="logout">
                              <v-list-item-icon>
                                  <v-icon>mdi-logout</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title>Logout</v-list-item-title>
                          </v-list-item>
                      </v-list>
                  </v-menu>
              </div>
          </v-toolbar-title>
          <AdminNav @show="showOverlay" />
      </v-app-bar>
      <v-main style="background-color: #f2f2f2">
          <router-view @show-snackbar="showSnackbar" />
      </v-main>
  </v-app>
</template>
<style>
.my-input.v-input .v-input__slot {
  border-radius: 5px;
  border: 1px solid rgba(0, 0, 0, 0.35);
  box-shadow: unset !important;
}
</style>
<script>
import AdminNav from "@/views/admin/layout/AdminNav.vue";
import Menu_Dots from "@/components/icons/Menu_dots.vue";
export default {
  components: {
      AdminNav,
      Menu_Dots,
  },
  data() {
      return {
          snackbar: false,
          text: "",
          color: "success",
          timeout: 2000,
          dialog: false,
          drawer: null,
          show: false,
          items: [
              {
                  icon: "mdi-view-dashboard-outline",
                  text: "Dashboard",
                  link: "/admin",
              },
              { heading: "Booking" },
              {
                  icon: "mdi-ticket-confirmation",
                  text: "Booked",
                  link: "/admin/booked",
              },
              { icon: "mdi-plus", text: "Add Item", link: "/admin/add-item" },
              {
                  icon: "mdi-format-list-checkbox",
                  text: "List Item",
                  link: "/admin/list-item",
              },
              {
                  icon: "mdi-format-list-checkbox",
                  text: "Make Reservation",
                  link: "/admin/reservation",
              },
              { heading: "Guides" },
              {
                  icon: "mdi-plus",
                  text: "Add Guide",
                  link: "/admin/add-guide",
              },
              {
                  icon: "mdi-format-list-checkbox",
                  text: "List Guides",
                  link: "/admin/list-guide",
              },
              { heading: "Interest" },
              {
                  icon: "mdi-plus",
                  text: "Add Place of Interest",
                  link: "/admin/add-place-of-interest",
              },
              {
                  icon: "mdi-format-list-checkbox",
                  text: "List Place of Interest",
                  link: "/admin/list-place-of-interest",
              },
              {
                  heading: "News & Events",
              },
              {
                  icon: "mdi-plus",
                  text: "Add News And Events",
                  link: "/admin/add-news",
              },
              {
                  icon: "mdi-format-list-checkbox",
                  text: "News And Events",
                  link: "/admin/news-and-events",
              },
              {
                  icon: "mdi-format-list-checkbox",
                  text: "Notice/Order",
                  link: "/admin/notice-and-orders",
              },
              {
                  heading: "Gallery",
              },
              {
                  icon: "mdi-image",
                  text: "AdminGallery",
                  link: "/admin/gallery",
              },
              {
                  icon: "mdi-video",
                  text: "Videos",
                  link: "/admin/videos",
              },
              {
                  icon: "mdi-plus", // Notice Board
                  text: "Notice Board",
                  link: "/admin/noticeboard",
              },
              {
                  heading: "Facilities",
              },
              {
                  icon: "mdi-plus",
                  text: "Add Facilities",
                  link: "/admin/add-facility",
              },
              {
                  icon: "mdi-format-list-checkbox",
                  text: "List Facilities",
                  link: "/admin/facilities",
              },
              {
                  heading: "Membership",
              },
              {
                  icon: "mdi-format-list-checkbox",
                  text: "Applicants",
                  link: "/admin/membership-applicant",
              },
              {
                  heading: "Settings",
              },
              {
                  icon: "mdi-cog-outline",
                  text: "Admin Settings",
                  link: "/admin/setting",
              },
          ],
      };
  },
  methods: {
      showOverlay() {
          this.show = true;
      },
      showSnackbar(value) {
          this.snackbar = true;
          this.text = value.message;
          this.color = value.color;
      },
      logout() {
          this.$emit("show", true);
          this.$auth.logout().then(this.$router.push("/login"));
      },
      goToAccount() {
          this.$router.push("/admin/profile");
      },
  },
};
</script>
