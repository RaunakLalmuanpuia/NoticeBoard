<template>
  <div style="padding-bottom: 20px">
    <v-overlay :value="show">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <v-snackbar v-model="snackbar" :color="color" timeout="2000" shaped>
      {{ text }}
    </v-snackbar>
    <v-container fluid class="header">
      <v-img
        height="300"
        src="@/assets/banners/club_member.jpg"
        class="d-none d-md-flex d-lg-flex"
      >
        <v-row>
          <div class="title-container">
            <v-col md-4 offset="2">
              <div class="my-title-2">Apply For Membership</div>
            </v-col>
          </div>
        </v-row>
      </v-img>

      <div class="d-flex d-md-none">
        <v-img height="150" src="@/assets/mobile-bg.png"></v-img>
        <div class="pageTitle">Apply For Membership</div>
      </div>
      <br />
    </v-container>
    <!--    <v-container p style="width: 70%" align-items="center" >-->
    <!--&lt;!&ndash;      <ApplyMembership/>&ndash;&gt;-->
    <!--    </v-container>-->
    <v-container class="pageContainer" align-items="center">
      <v-row>
        <v-col md="4" sm="6" cols="12">
          <v-text-field label="Name" outlined v-model="name"></v-text-field>
          <v-text-field
            label="Email"
            type="email"
            outlined
            v-model="email"
          ></v-text-field>
          <v-text-field
            label="Contact"
            type="number"
            outlined
            v-model="contact"
          ></v-text-field>
          <!-- <v-label>Name</v-label>
          <v-text-field v-model="name" class="my-input"></v-text-field>
          <v-label>Email</v-label>
          <v-text-field
            v-model="email"
            type="email"
            class="my-input"
          ></v-text-field>
          <v-label>Contact</v-label>
          <v-text-field v-model="contact" class="my-input"></v-text-field> -->
          <v-btn @click="applyMembership()" color="success" width="100%"
            >Apply</v-btn
          >
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>
<script>
// import ApplyMembership from "../components/ApplyMembership";
export default {
  // components: { ApplyMembership },
  data() {
    return {
      show: false,
      snackbar: false,
      color: "",
      text: "",
      name: "",
      email: "",
      contact: "",
      reference: "",
      member_type: [],
    };
  },
  methods: {
    applyMembership() {
      this.show = true;
      this.$axios
        .post("/apply-membership", {
          name: this.name,
          email: this.email,
          contact: this.contact,
          references: this.reference,
        })
        .then((res) => {
          this.snackbar = true;
          this.text = res.data.success;
          this.color = "success";
          this.name = "";
          this.email = "";
          this.contact = "";
          this.reference = "";
          this.show = false;
        })
        .catch((err) => {
          this.show = false;
          this.snackbar = true;
          this.text = "Oops! Something Went Wrong";
          this.color = "red";
          throw err;
        });
    },
  },
};
</script>
<style scoped>
.header {
  padding: 0;
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
.my-input {
  border-radius: 10px !important;
  border: 1px solid black;
  box-shadow: unset !important;
}
@media screen and (max-width: 480px) {
  .v-application--is-ltr .offset-2 {
    margin-left: 20px;
  }
  .my-title-2 {
    font-size: 40px !important;
  }
  .pageContainer {
    width: 95% !important;
  }
}
.pageContainer {
  width: 70%;
}
.pageTitle {
  position: absolute;
  top: 30px;
  font-size: 1.8rem;
  margin-left: 20px;
  font-weight: 700;
}

.my-input .v-text-field__details {
  display: none !important;
}
</style>
