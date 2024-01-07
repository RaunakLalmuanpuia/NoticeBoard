<template>
  <div>
    <v-container class="header" fluid>
      <v-img height="300" src="@/assets/banners/club_member.jpg" class="d-none d-md-flex d-lg-flex">
        <v-row>
          <div class="title-container">
            <v-col md-4 offset="2">
              <div class="my-title-2">Club Member</div>
            </v-col>
          </div>
        </v-row>
      </v-img>

      <div class="d-flex d-md-none">
        <v-img height="150" src="@/assets/mobile-bg.png"></v-img>
        <div class="pageTitle">Club Member</div>
      </div>
      <br />
    </v-container>

    <v-container class="memberContainer">
      <h2 style="text-align: center">MEMBERSHIP CATEGORY</h2>
      <br />
      <v-row>
        <v-col cols="12" order-md="1" order="2" md="6" style="font-size: 14px;">
          <p>
            <ol type="none">
              <li><b>INDIVIDUAL MEMBER</b>
                <ol type="none">
                  <li>Permanent residents of India</li>
                  <li>Non-Resident Indians (NRI)</li>
                  <li>Foreign nationals, residing in or visiting India i.e., expatriates</li>
                  <li>
                    <a href="/documents/Individual Membership Agreement.pdf">Download Membership Agreement Here</a>
                  </li>
                </ol>
              </li>
              <br>
              <li><b>CORPORATE MEMBER</b>
                <ul type="none">
                  <li>The Corporate Members shall be Companies incorporated in India or abroad, partnership firms or any other body incorporated under any national jurisdiction. Such Corporate Members may nominate their directors, partners or employees, as the case may be ("Corporate Nominee"), to use the facilities in Thenzawl Golf Course & Resort subject to the Terms and Conditions and the Rules and Regulations made in this regard. A Corporate Member may request for more than one nomination for a period of time and the fee as specified in the Fee Structure attached there under.</li>
                  <li>
                    <a href="/documents/Corporate Membership Agreement.pdf">Download Membership Agreement Here</a>
                  </li>
                </ul>
              </li>
            </ol>
          </p>
        </v-col>
        <v-col cols="12" order-md="2" order="1" md="6" style="margin: auto;">
          <v-container class="membership-card">
            <div class="justify-center mb-2">
              <center>
                <v-img height="50" width="50" src="@/assets/tgr_logo_white.svg"></v-img>
              </center>
            </div>
            <p class="membership-card-content mb-6">
              Want to be a Club Member?
            </p>
            <v-btn to="/membership" style="color: white;" rounded color="#04d39b">
              Join Now
            </v-btn>
          </v-container>
        </v-col>
      </v-row>
      <v-row class="mb-3">
        <v-col md="6" order-md="1" order="2">
          <v-img
            style="border-radius: 20px"
            height="300"
            src="@/assets/golf_cart.jpg"
          ></v-img>
        </v-col>
        <v-col md="6" order-md="2" order="1" style="font-size: 14px;">
          <h3>SUB CATEGORIES: (INDIVIDUAL & CORPORATE MEMBERSHIP)</h3>
          <br />
          The club is offering two sub categories of membership as below:
          <ol type="A">
            <li>
              <h5><b> GOLF MEMBERSHIP</b></h5>
              This membership entitles the member to use all sports facilities including Golf course/Practice Range.
            </li>
            <li>
              <h5><b>CLUB MEMBERSHIP</b></h5>
              This membership entitles the applicant to use all sports except for Golf and Golf Course/Practice Range.
            </li>
          </ol>
          <br>
          <p>
            A CLUB MEMBERSHIP can be switched to a GOLF MEMBERSHIP by paying the difference of applicable fee for the duration of his/her membership tenure on a pro-rata basis. However a GOLF MEMBERSHIP cannot be switched to a CLUB MEMBERSHIP.
          </p>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>
<script>
export default {};
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
.membership-card {
  align-content: center !important;
  text-align: center;
  background-color: #272727;
  border-radius: 20px;
  padding: 35px !important;
}
.membership-card > .membership-img {
  width: 100%;
  margin: auto !important;
  align-content: center !important;
  background-position: top !important;
}
.membership-card-content {
  color: white;
  font-size: 20px;
  font-weight: bold;
}

.memberContainer {
  width: 70% !important;
}

@media screen and (max-width: 950px) {
  .memberContainer {
    width: 90% !important;
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
