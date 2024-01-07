<template>
  <v-toolbar-items class="hidden-md-and-down" style="width: 55rem">
    <v-btn class="v-nav" color="black" small text to="/">Home</v-btn>
    <v-btn color="black" small text to="/booking">Booking</v-btn>
    <v-menu bottom offset-y>
      <template v-slot:activator="{ on, attrs }">
        <v-btn v-bind="attrs" v-on="on" color="black" small text
          >Explore<v-icon small>mdi-menu-down</v-icon>
        </v-btn>
      </template>
      <v-list>
        <v-list-item to="/glimpse-of-thenzawl">
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
        <v-btn v-bind="attrs" v-on="on" color="black" small text
          >Guides<v-icon small>mdi-menu-down</v-icon>
        </v-btn>
      </template>
      <v-list>
          <v-list-item to="/tour-guide">
              <v-list-item-title>Tour Guide</v-list-item-title>
          </v-list-item>
        <v-list-item to="/rent-a-car">
          <v-list-item-title>Rent a Car</v-list-item-title>
        </v-list-item>


          <v-list-item to="/hire-taxi">
              <v-list-item-title>Hire Taxi</v-list-item-title>
          </v-list-item>
          <v-list-item to="/hire-auto">
              <v-list-item-title>Hire Auto-Rickshow</v-list-item-title>
          </v-list-item>
        <v-list-item to="/where-to-stay">
          <v-list-item-title>Where to Stay</v-list-item-title>
        </v-list-item>
        <v-list-item to="/find-me-food">
          <v-list-item-title>Find me Food</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu>
    <v-btn color="black" small text to="/place-of-interest-near-thenzawl">
      Places of Interest
    </v-btn>
    <v-btn color="black" small text to="/facilities"> Facilities </v-btn>
    <v-btn color="black" icon small to="/news-and-events">
      <Notification />
      <v-img
        v-if="events != 0"
        class="notification-alert"
        height="15"
        src="@/assets/notify-2.gif"
        width="15"
      ></v-img>
    </v-btn>
  </v-toolbar-items>
</template>

<script>
import Notification from "@/components/icons/Notification.vue";

export default {
  name: "MainNavigation",
  components: {
    Notification,
  },
  data() {
    return {
      events: 0,
      items: [
        { icon: "mdi-account", title: "Account" },
        { icon: "mdi-ticket", title: "Bookings" },
        { icon: "mdi-logout", title: "Logout" },
      ],
    };
  },
  mounted() {
    this.getNotification();
  },
  methods: {
    getNotification() {
      let self = this;
      self.$axios
        .get("/get-notifications")
        .then(function (res) {
          self.events = res.data.notifications;
        })
        .catch(function (err) {
          throw err;
        });
    },
  },
};
</script>

<style scoped>
.theme--dark.v-btn--active:hover::before,
.theme--dark.v-btn--active::before {
  opacity: 0.6;
  background-color: #04d39b;
}
.notification-alert {
  position: absolute;
  margin-top: -10px;
  margin-right: -15px;
}
</style>
