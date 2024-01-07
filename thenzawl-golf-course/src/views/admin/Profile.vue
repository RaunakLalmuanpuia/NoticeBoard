<template>
  <v-container fluid ml-6 mt-6>
    <v-overlay :value="show">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>

    <v-row>
      <v-col md="4">
        <v-form ref="form" v-model="valid" lazy-validation>
          <v-card style="padding: 18px">
            <v-card-title>Update Profile</v-card-title>
            <v-card-text>
              <v-row>
                <v-col>
                  <v-label>Name</v-label>
                  <v-text-field
                    required
                    :rules="[(v) => !!v || 'Name is required']"
                    v-model="form.name"
                    solo
                    class="my-input"
                  ></v-text-field>
                  <v-label>Email</v-label>
                  <v-text-field
                    type="email"
                    required
                    :rules="[(v) => !!v || 'Email is required']"
                    v-model="form.email"
                    solo
                    class="my-input"
                  ></v-text-field>
                  <v-label>Password</v-label>
                  <v-text-field
                    type="password"
                    v-model="form.password"
                    solo
                    class="my-input"
                    hint="password must be greater than 6 characters"
                  ></v-text-field>
                  <!-- <v-label>Confirm Password</v-label>
                  <v-text-field
                    type="password"
                    v-model="form.password_confirmation"
                    solo
                    class="my-input"
                  ></v-text-field> -->
                </v-col>
              </v-row>
            </v-card-text>
            <v-card-actions>
              <v-btn
                @click="validate"
                elevation="0"
                rounded
                color="#04d39b"
                class="text-white"
                >Update</v-btn
              >
            </v-card-actions>
          </v-card>
        </v-form>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      show: false,
      valid: true,
      form: {
        name: null,
        email: null,
        password: null,
        password_confirmation: null,
      },
    };
  },

  created() {
    this.getAuthUser();
  },

  methods: {
    async getAuthUser() {
      var { data } = await this.$axios.get("/auth/user");
      this.form.name = data.name;
      this.form.email = data.email;
    },

    validate() {
      this.$refs.form.validate();
      if (this.$refs.form.validate() == true) {
        this.updateProfile();
      }
    },

    async updateProfile() {
      let fd = new FormData();
      fd.append("name", this.form.name);
      fd.append("email", this.form.email);
      fd.append("password", this.form.password);
      // fd.append("password_confirmation", this.form.password_confirmation);

      await this.$axios.post("/update/profile", fd);
      this.$emit("show-snackbar", {
        message: "Profile updated successfully",
        color: "success",
      });
      this.$router.push("/admin");
    },
  },
};
</script>

<style scoped>
.text-white {
  color: white !important;
  text-transform: capitalize;
}
</style>