<template>
  <div>
    <v-container class="header" fluid>
      <v-img
        height="300"
        src="@/assets/banners/glimps.jpg"
        class="d-none d-md-flex d-lg-flex"
      >
        <v-row>
          <div class="title-container">
            <v-col md-4 offset="2">
              <div class="my-title-2">Glimpse of Thenzawl</div>
            </v-col>
          </div>
        </v-row>
      </v-img>

      <div class="d-flex d-md-none">
        <v-img height="150" src="@/assets/mobile-bg.png"></v-img>
        <div class="pageTitle">Glimpse of Thenzawl</div>
      </div>
      <br />
    </v-container>

    <v-container class="g-container">
      <v-row>
        <v-col md="6">
          <p class="p1">
            Thenzawl is a census town in Serchhip district in the Indian state
            of Mizoram. It is an important center for the traditional Mizo
            handloom industry. Thenzawl is about 92 km from Aizawl and it is
            about two and half hour drive from Aizawl.
            <br /><br />
            Thenzawl was a dense forest with many wild animals until it was
            cultivated in 1961 and inhabited. Bengkhuaia Sailo established a
            village in 1863 in Thenzawl. Kamlova's son, Lalngurchhina was the
            last chief of Thenzawl. Due to the March 1966 Mizo National Front
            uprising, Thenzawl was a village where people were grouped together
            in 1968.
            <br /><br />
            As of 2011 Indian census, Thenzawl had a population of 7529. Males
            constitute 49.8% of the population and females 50.2%. Female Sex
            Ratio is of 1007 against state average of 976. Moreover Child Sex
            Ratio in Thenzawl is around 915 compared to Mizoram state average of
            970. Thenzawl has an average literacy rate of 98.1%, higher than the
            state average of 91.33%: male literacy is 98.07%, and female
            literacy is 98.23%. In Thenzawl, 13.58% of the population is under 6
            years of age.
          </p>
        </v-col>
        <v-col md="6">
          <v-img
            class="g-i-1"
            src="@/assets/Glimpseoftz.jpg"
            style="border-radius: 10px; height: 540px"
          ></v-img>
        </v-col>
      </v-row>
      <v-row>
        <v-col md="6">
          <v-img
            class="g-i-2"
            this.color="success"
            src="@/assets/Glimpseoftz2.jpg"
            style="border-radius: 10px"
            height="600"
          ></v-img>
        </v-col>
        <v-col md="6" class="p2">
          Thenzawl is located at 23.32°N 92.75°E.[2] It has an average elevation
          of 783 metres (2568 feet). Thenzawl is the largest handloom centre in
          Mizoram.
          <br /><br />
          Thenzawl boasts of its Thenzawl Golf Course & Resorts with many
          tourist attractions such as Deer Park; Thenzawl Lake (Dilpui); Lau
          River which was the place where one Mizo Chief and British India made
          oral communication on the agreement to release an English girl named
          Mary Winchester; Vaibiak, where one Mizo Chief and British India sat
          down for agreement; Vaibiak Falls; Tualvungi Thlan (Tualvungi Tomb),
          it is said that, Zawlpala, Chief of Phulpui village, married the
          "legendary beauty", Tualvungi of Thenzawl. Tualvungi was subsequently
          married to the enemy chief called Phuntiha. But, Tualvungi could not
          forget Zawlpala, her previous husband. After many years when Zawlpala
          died, grief stricken Tualvungi came and dug a pit by the side of
          Zawlpala's grave and asked an old woman to kill her and bury her in
          the grave; Chawngchilhi Puk (Chawngchilhi Cave), a woman who had love
          affairs with a big snake, Bengkhuaia Thlan (Bengkhuaia Tomb), a Mizo
          Chief who captured an English girl named Mary Winchester at Alexdrapur
          (near modern Silchar) which brought about the British to Mizoram. He
          died around 1879; Vantawng Falls, the highest waterfall in Mizoram.
          <br /><br />
          Tuirihiau, which is located in Buangpui village, 15 minutes drive from
          Thenzawl; is a waterfall which one can look from behind and it is one
          of the most spectacular sights in Mizoram. The uniqueness of this
          waterfall is that you see from behind as it caves in behind the fall
          like an arc.
          <br /><br />
          Thenzawl offers plethora of tourism activities from ecotourism,
          adventure tourism, golf tourism, wellness tourism and sports tourism
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

@media screen and (max-width: 480px) {
  .my-title-2 {
    font-family: "Poppins";
    color: black;
    font-size: 1.9rem !important;
    font-weight: bolder;
    margin-bottom: 1rem;
    margin-top: 10rem;
  }
  .p2 {
    text-align: justify;
    padding-bottom: 40px !important;
  }
  .p1 {
    text-align: justify;
  }
  .g-i-1 {
    height: 300px !important;
  }
  .g-i-2 {
    height: 300px !important;
  }

  .v-application--is-ltr .offset-2 {
    margin-left: 50px !important;
  }
  .col-xl,
  .col-xl-auto,
  .col-xl-12,
  .col-xl-11,
  .col-xl-10,
  .col-xl-9,
  .col-xl-8,
  .col-xl-7,
  .col-xl-6,
  .col-xl-5,
  .col-xl-4,
  .col-xl-3,
  .col-xl-2,
  .col-xl-1,
  .col-lg,
  .col-lg-auto,
  .col-lg-12,
  .col-lg-11,
  .col-lg-10,
  .col-lg-9,
  .col-lg-8,
  .col-lg-7,
  .col-lg-6,
  .col-lg-5,
  .col-lg-4,
  .col-lg-3,
  .col-lg-2,
  .col-lg-1,
  .col-md,
  .col-md-auto,
  .col-md-12,
  .col-md-11,
  .col-md-10,
  .col-md-9,
  .col-md-8,
  .col-md-7,
  .col-md-6,
  .col-md-5,
  .col-md-4,
  .col-md-3,
  .col-md-2,
  .col-md-1,
  .col-sm,
  .col-sm-auto,
  .col-sm-12,
  .col-sm-11,
  .col-sm-10,
  .col-sm-9,
  .col-sm-8,
  .col-sm-7,
  .col-sm-6,
  .col-sm-5,
  .col-sm-4,
  .col-sm-3,
  .col-sm-2,
  .col-sm-1,
  .col,
  .col-auto,
  .col-12,
  .col-11,
  .col-10,
  .col-9,
  .col-8,
  .col-7,
  .col-6,
  .col-5,
  .col-4,
  .col-3,
  .col-2,
  .col-1 {
    width: 100% !important;
    padding: 12px 0 0 0 !important;
  }
}

.g-container {
  width: 70% !important;
}

@media screen and (max-width: 950px) {
  .g-container {
    width: 90% !important;
  }
}

.my-title-2 {
  font-family: "Poppins";
  color: black;
  font-size: 2.3rem;
  font-weight: bolder;
  margin-bottom: 1rem;
  margin-top: 10rem;
}

.pageTitle {
  position: absolute;
  top: 50px;
  font-size: 1.8rem;
  margin-left: 20px;
  font-weight: 700;
}
</style>
