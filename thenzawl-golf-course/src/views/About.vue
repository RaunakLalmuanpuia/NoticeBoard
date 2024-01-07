<template>
    <div>
        <v-container class="header" fluid>
            <v-img height="300" src="@/assets/banners/whoweare.jpg" class="d-none d-md-flex d-lg-flex">
                <v-row>
                    <div class="title-container">
                        <v-col md-4 offset="2">
                            <div class="my-title-2">Who Are We</div>
                        </v-col>
                    </div>
                </v-row>
            </v-img>

            <div class="d-flex d-md-none">
                <v-img height="150" src="@/assets/mobile-bg.png"></v-img>
                <div class="pageTitle">Who Are We</div>
            </div>
        </v-container>
        <v-container mt-5 class="aboutContainer">
            <v-row>
                <v-col md="12">
                    <p style="font-weight: bold; font-size: 30px">About Us</p>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="6" sm="12" style="font-size: 14px">
                    <p>
                        Thenzawl Golf Course & Resort is owned by the Tourism Department,
                        Government of Mizoram and managed and operated by the Mizoram
                        Tourism Development Authority (MTDA), a society under the Government
                        of Mizoram.
                    </p>
                    <p>
                        Thenzawl Golf Course & Resort is one of the best golf courses in the
                        North East India, featuring a 18 hole international design 72 Par
                        Golf Course & an Eco-friendly resort with a modern Convention
                        Centre, Tourist Reception Center, Cafeteria, 30 numbers of fully
                        furnished Eco Log Huts, Food Court, Watch Tower, Open Air Theater.
                    </p>
                    <p>
                        The Project was completed within the stipulated time i.e, the 3rd
                        December 2019 and the assets created under Swadesh Darshan were
                        handed over to the Mizoram Tourism Development Authority (MTDA),
                        Tourism Department, Government of Mizoram on 10th January 2020. Shri
                        Prahlad Singh Patel, the Hon’ble Union Minister for Tourism also
                        inaugurated Thenzawl Golf Course on 4th August 2020 through virtual
                        platform.
                    </p>
                    <p>
                        Indian Golf Union recognizes the Thenzawl Golf Course as a Category
                        B Course which is a very prominent achievement for the Tourism
                        Department of Mizoram.
                    </p>
                    <p>
                        The MTDA has been the prime mover in the progressive development,
                        promotion and expansion of tourism in the state of Mizoram. Mizoram
                        Tourism Development Authority (MTDA) constituted General Committee
                        for Thenzawl Golf Course & Resort on 23<sup>rd</sup> september 2020
                    </p>
                    <p>
                        Operation and maintenance of Thenzawl Golf Course & Resort is in the
                        hands of the Mizoram Tourism Development Authority (MTDA) under
                        Tourism Department, which is a registered society under Government
                        of Mizoram
                    </p>
                    <p>
                        The MTDA has been the prime mover in the progressive development,
                        promotion and expansion of tourism in the state of Mizoram.
                    </p>
                </v-col>
                <v-col cols="12" md="6" sm="12">
                    <FollowI />

                    <v-container class="follow-us mt-12">
                        <p class="mt-5" style="font-size: 16px">
                            For inquiries, complaints, suggestions and feedback, feel free to
                            reach us at the following contacts:
                        </p>
                        <v-row class="mt-5 mb-5" justify="space-between">
                            <v-col md="12" style="font-size: 14px">
                                <div>
                                    <v-icon style="float: left" class="rounded" color="#04d39b" small>
                                        mdi-email
                                    </v-icon>
                                    <div>
                                        <a class="email-link" style="color: black; text-decoration: none"
                                            href="mailto:thenzawlgolfresort@gmail.com">thenzawlgolfresort@gmail.com</a>
                                        <br />
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <a class="email-link" style="color: black; text-decoration: none"
                                            href="mizoram.tourism@gmail.com">mizoram.tourism@gmail.com</a>
                                    </div>
                                </div>
                            </v-col>

                            <v-col md="12" style="font-size: 14px">
                                <v-icon class="rounded" color="#04d39b" small>
                                    mdi-phone
                                </v-icon>
                                <a class="email-link" style="color: black; text-decoration: none"
                                    href="tel:+913892333475">+91
                                    3892333475</a>
                            </v-col>
                            <v-col md="12">
                                For booking and related inquiries
                                <br>
                                Please contact
                                <br>
                                <v-icon class="rounded" color="#04d39b" small>
                                    mdi-phone
                                </v-icon>
                                <a class="email-link" style="color: black; text-decoration: none"
                                    href="tel:+918414092865">+91 8414092865</a>
                                <br>
                                Pu Benjamin Lalhruaitluanga,
                                <br>MIS Coordinator
                            </v-col>
                        </v-row>
                    </v-container>
                </v-col>
            </v-row>
        </v-container>
        <v-container class="mt-4 general-committee" fluid>
            <div class="committee-container mb-8">
                <p class="header mt-8">General Committee</p>
                <v-row>
                    <v-col :key="m.url" md="4" sm="6" v-for="m in members">
                        <Committee :caption1="m.caption1" :caption2="m.caption2" :caption3="m.caption3"
                            :heading="m.heading" :url="m.url" />
                    </v-col>
                </v-row>
            </div>
        </v-container>
    </div>
</template>
<script>
// import Guide from "@/components/Guide.vue";

import Committee from "../components/Committee";
import FollowI from "../components/FollowI";

export default {
    components: {
        FollowI,
        Committee,
        // Guide,
    },
    data() {
        return {
            members: [
                {
                    url: require("../assets/minister.jpg"),
                    heading: "CHAIRMAN",
                    caption1: "Pi Lalrinpuii",
                    caption2: "Minister, Tourism",
                    caption3: "Chairman, MTDA",
                },
                {
                    url: require("../assets/manisha.jpg"),
                    heading: "VICE CHAIRMAN",
                    caption1: "Manisha Saxena IAS",
                    caption2: "Principal Secretary, Tourism",
                    caption3: "Vice Chairman, MTDA",
                },
                {
                    url: require("../assets/ms.jpg"),
                    heading: "MEMBER SECRETARY",
                    caption1: "Pu V Lalengmawia",
                    caption2: "Joint Secretary, Tourism",
                    caption3: "Member Secretary, MTDA",
                },
               
                // {
                //   url: require("../assets/ds.jpg"),
                //   heading: "MEMBER",
                //   caption1: "Pi Zonunthari",
                //   caption2: "Deputy Secretary, Tourism",
                //   caption3: "Member, MTDA",
                // },
                {
                    url: require("../assets/dd.jpg"),
                    heading: "MEMBER",
                    caption1: "Pi Lalthakimi Pachuau",
                    caption2: "Deputy Director, Tourism",
                    caption3: "Treasurer, MTDA",
                },
            ],
        };
    },
};
</script>
<style scoped>
.header {
    padding: 0;
}

@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap");

.media-link {
    text-decoration: none;
}

.my-title-2 {
    font-family: "Poppins";
    color: black;
    font-size: 2.3rem;
    font-weight: bolder;
    margin-bottom: 1rem;
    margin-top: 10rem;
}

.container.follow-us {
    margin-left: 0;
    padding: 28px 50px 30px 20px;
    border-radius: 20px !important;
    border: 1px solid rgba(0, 0, 0, 0.11);
    box-shadow: 0px 0px 30px -20px rgba(0, 0, 0, 0.51);
    -webkit-box-shadow: 0px 0px 30px -20px rgba(0, 0, 0, 0.51);
    -moz-box-shadow: 0px 0px 30px -20px rgba(0, 0, 0, 0.51);
}

.v-icon.rounded {
    padding: 3px;
    border: 1px solid #04d39b;
    border-radius: 50% !important;
    margin-right: 5px;
}

.general-committee {
    /* background-color: #f8f8f8; */
    display: flex;
}

.committee-container {
    margin: auto;
    font-family: "Poppins";
    color: rgb(0, 0, 54);
    width: 70%;
}

.header {
    font-size: 25px;
    text-align: center;
}

.email-link:hover {
    color: #04d39b !important;
}

.aboutContainer {
    width: 70% !important;
}

@media screen and (max-width: 950px) {
    .aboutContainer {
        width: 95% !important;
    }

    .committee-container {
        width: 95% !important;
    }

    .container.follow-us {
        padding: 15px;
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
