<template>
  <v-app id="inspire">
    <!-- mamawh chuan navigation drawer a dah theih -->
    <v-overlay :value="show">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>

    <v-main style="padding: unset">
      <v-container fluid>
        <v-row>
          <v-col md="9" class="hidden-sm-and-down">
            <v-img aspect-ratio="1.45" src="@/assets/Glimpseoftz2.jpg"></v-img>
          </v-col>
          <v-col md="3" sm="12" class="login-area">
            <br />
            <div class="mt-15">
              <v-img
                height="50"
                width="150"
                src="@/assets/tgrlogo-margin.svg"
              ></v-img>
              <br />
              <h2>Login to Admin Pannel</h2>
            </div>

            <br /><br />
            <v-form @prevent="submit">
              <v-label>Email Id</v-label>
              <v-text-field v-model="credentials.email" outlined></v-text-field>

              <v-label>Password</v-label>
              <v-text-field
                v-model="credentials.password"
                type="password"
                outlined
              ></v-text-field>
              <v-alert v-if="error" type="error" align="center" dense>{{
                error
              }}</v-alert>
              <v-btn
                @click="submit"
                class="login-button mb-5"
                block
                color="#04d39b"
                >Login <v-spacer></v-spacer>
                <v-icon>mdi-arrow-right-circle</v-icon></v-btn
              >
            </v-form>
          </v-col>
        </v-row>
      </v-container>
    </v-main>

    <!-- footer -->
    <v-footer
      style="
        width: 100%;
        background-color: #f5f5f5;
        border-top: #cccccc 1px solid;
      "
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
            {{ new Date().getFullYear() }}
            <strong>© Thenzawl Golf Resort</strong>
          </v-card-text>
          <v-card-text class="black--text pt-0" cols="12">
            <v-row class="justify-space-between">
              <v-col md="3" sm="12" cols="12">
                <v-list color="#f5f5f5">
                  <v-list-item class="text-left">
                    <v-list-item-avatar>
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
              <v-col md="3" sm="12" cols="12">
                <v-list color="#f5f5f5">
                  <v-list-item class="text-left">
                    <v-list-item-avatar>
                      <v-img src="@/assets/tourism_logo.png"></v-img>
                    </v-list-item-avatar>
                    <v-list-item-content>
                      <v-list-item-subtitle>Initiative of</v-list-item-subtitle>
                      <v-list-item-title style="font-size: 12px"
                        >Mizoram Tourism Development
                        Authority</v-list-item-title
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
  </v-app>
</template>

<style scoped>
.container {
  padding: unset;
}
.create-account-link {
  color: #04d39b;
  text-decoration: none;
}
.account-create {
  text-align: center !important;
  font-size: smaller;
}
.login-area {
  padding-left: 50px;
  padding-right: 40px;
}
.login-button {
  padding-top: 25px !important;
  padding-bottom: 25px !important;
  margin-left: 0 !important;
  color: white !important;
}
.social-login {
  margin-left: 0 !important;
  padding-top: 25px !important;
  padding-bottom: 25px !important;
  color: white !important;
}

.v-label {
  font-size: small;
}
.v-input {
  padding: 0px !important;
  border-radius: 0%;
}

.separator {
  display: flex;
  align-items: center;
  text-align: center;
}

.separator::before,
.separator::after {
  content: "";
  flex: 1;
  border-bottom: 1px solid #000;
}

.separator:not(:empty)::before {
  margin-right: 0.25em;
}

.separator:not(:empty)::after {
  margin-left: 0.25em;
}

@media only screen and (max-width: 600px) {
  .main-container {
    padding: 0px 0px 0px;
    margin: 0px;
  }
  .col {
    width: 100% !important;
  }
}
</style>

<script>
import ShortLogo from "@/components/icons/ShortLogo.vue";
export default {
  components: { ShortLogo },
  data() {
    return {
      credentials: {
        email: "",
        password: "",
      },
      show: false,
      error: "",
      source:
        "https://app.zeplin.io/project/6049dda810ef2e9f677b1381/screen/60654843628bdb0577091955",
      dialog: false,
      drawer: null,
      items: [
        { icon: "mdi-contacts", text: "Contacts" },
        { icon: "mdi-history", text: "Frequently contacted" },
        { icon: "mdi-content-copy", text: "Duplicates" },
        {
          icon: "mdi-chevron-up",
          "icon-alt": "mdi-chevron-down",
          text: "Labels",
          model: true,
          children: [{ icon: "mdi-plus", text: "Create label" }],
        },
        {
          icon: "mdi-chevron-up",
          "icon-alt": "mdi-chevron-down",
          text: "More",
          model: false,
          children: [
            { text: "Import" },
            { text: "Export" },
            { text: "Print" },
            { text: "Undo changes" },
            { text: "Other contacts" },
          ],
        },
        { icon: "mdi-cog", text: "Settings" },
        { icon: "mdi-message", text: "Send feedback" },
        { icon: "mdi-help-circle", text: "Help" },
        { icon: "mdi-cellphone-link", text: "App downloads" },
        { icon: "mdi-keyboard", text: "Go to the old version" },
      ],
    };
  },
  methods: {
    submit() {
      let valid = this.validate();
      if (valid) {
        this.login();
      } else {
        this.error = "Please enter email and password";
      }
    },
    validate() {
      if (this.credentials.email != "" && this.credentials.password != "") {
        return true;
      }
      return false;
    },
    login() {
      this.show = true;
      this.$auth
        .login(this.credentials)
        .then((res) => {
          this.response = res.data;
          this.$router.push(this.$route.query.redirect || "/admin");
        })
        .catch((err) => {
          this.show = false;
          this.error = "Invalid Email or Password";
          throw err;
        });
    },
  },
};
</script>
