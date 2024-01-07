<template>
  <v-toolbar-items class="hidden-md-and-down">
    <v-menu bottom offset-y>
      <template v-slot:activator="{ on, attrs }">
        <v-btn small text color="black" v-bind="attrs" v-on="on"
          >Explore<v-icon small>mdi-menu-down</v-icon>
        </v-btn>
      </template>
      <v-list>
        <v-list-item
          to="/glimpse-of-thenzawl"
          style="border-top: solid 2px #04d39b"
        >
          <v-list-item-title>Glimpse of Thenzawl</v-list-item-title>
        </v-list-item>
        <v-list-item to="/club-member">
          <v-list-item-title>Club Member</v-list-item-title>
        </v-list-item>
        <v-list-item to="/gallery">
          <v-list-item-title>Gallery</v-list-item-title>
        </v-list-item>
        <v-list-item to="/video">
          <v-list-item-title>Video</v-list-item-title>
        </v-list-item>
        <v-list-item to="/environment">
          <v-list-item-title>Environment</v-list-item-title>
        </v-list-item>
        <v-list-item to="/who-are-we">
          <v-list-item-title>Who are we</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu>
    <v-menu bottom offset-y>
      <template v-slot:activator="{ on, attrs }">
        <v-btn small text color="black" v-bind="attrs" v-on="on"
          >Guides<v-icon small>mdi-menu-down</v-icon>
        </v-btn>
      </template>
      <v-list>
        <v-list-item to="/get-direction" style="border-top: solid 2px #04d39b">
          <v-list-item-title>Get Direction</v-list-item-title>
        </v-list-item>
        <v-list-item to="/rent-a-car">
          <v-list-item-title>Rent a Car</v-list-item-title>
        </v-list-item>
        <v-list-item to="/where-to-stay">
          <v-list-item-title>Where to Stay</v-list-item-title>
        </v-list-item>
        <v-list-item to="/find-me-food">
          <v-list-item-title>Find me Food</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu>
    <v-btn to="/place-of-interest-near-thenzawl" small text color="black"
      >Places of Interest</v-btn
    >
    <v-menu offset-y>
      <template v-slot:activator="{ on, attrs }">
        <v-btn icon v-bind="attrs" v-on="on"><Menu_Dots /> </v-btn>
      </template>
      <v-list>
        <v-list-item @click="goToAccount">
          <v-list-item-icon><v-icon>mdi-account</v-icon></v-list-item-icon>
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
  </v-toolbar-items>
</template>

<script>
import Menu_Dots from "@/components/icons/Menu_dots.vue";

export default {
  name: "AdminNav",
  components: {
    Menu_Dots,
  },
  data() {
    return {
      drawer: null,
    };
  },
  methods: {
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
