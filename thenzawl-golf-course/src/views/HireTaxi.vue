<template>
    <div>
        <v-container class="header" fluid>
            <v-img
                height="300"
                src="@/assets/banners/hiretaxi.jpg"
                class="d-none d-md-flex d-lg-flex"
            >
                    <div class="title-container">
                        <v-col style="padding: 0" md-4 offset="2">
                            <div class="my-title-2">Hire Taxi</div>
                        </v-col>
                    </div>
            </v-img>

            <div class="d-flex d-md-none">
                <v-img height="150" src="@/assets/mobile-bg.png"></v-img>
                <div class="pageTitle">Hire Taxi</div>
            </div>
            <br />
        </v-container>

        <v-container class="rent-a-car-container">
            <!-- <Guide /> -->
            <v-row>
                <v-col md="6">
                    <h3>Select your desire service</h3>
                    <v-list>
                        <v-list-item
                            v-for="(guide, i) in guides"
                            :key="i"
                            style="
                                border: #ededed solid 1px;
                                border-radius: 20px;
                                margin-top: 5px;
                                padding: 8px;
                              "
                        >
                            <v-list-item-avatar v-if="!!guide.image">
                                <v-img style="border-radius: 10px" :src="guide.image"></v-img>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title>
                                    <b v-if="!!guide.owner">{{ guide.owner}}</b>
                                </v-list-item-title>
                                <v-list-item-subtitle v-if="!!guide.contact"
                                    class="mobile-number"
                                    style="
                    color: #04d39b;
                    font-weight: bold;
                    padding-top: 5px;
                    letter-spacing: 1px;
                  "
                                >{{ guide.contact }}</v-list-item-subtitle
                                >
                                <v-list-item-subtitle v-if="!!guide.address">{{ guide.address }}</v-list-item-subtitle>
                            </v-list-item-content>
                            <v-list-item-action class="phone-icon">
                                <v-btn v-if="!!guide.contact"
                                    :href="`tel:${guide.contact}`"
                                    icon
                                    outlined
                                    rounded
                                    color="#04d39b"
                                >
                                    <v-icon>mdi-phone</v-icon>
                                </v-btn>
                            </v-list-item-action>
                        </v-list-item>
                    </v-list>
                </v-col>
            </v-row>
            <v-row>
                <v-col v-if="numberOfPages > 1" md="6" class="justify-start">
                    <v-pagination
                        @input="onPageChange"
                        v-model="page"
                        :length="numberOfPages"
                    ></v-pagination>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script>
export default {
    data() {
        return {
            page: 1,
            guides: [],
            numberOfPages: 0,
        };
    },
    mounted() {
        this.getGuide();
    },
    methods: {
        getGuide() {
            this.$axios
                .get("/v2/taxi?page=" + this.page)
                .then((res) => {
                    this.numberOfPages = res.data.list.last_page;
                    this.page = res.data.list.current_page;
                    this.guides = res.data.list.data;
                })
                .catch((err) => {
                    throw err;
                });
        },
        onPageChange() {
            this.getGuide();
        },
    },
};
</script>

<style scoped>
.header {
    padding: 0;
}

.rent-a-car-container {
    width: 70% !important;
}

@media screen and (max-width: 950px) {
    .rent-a-car-container {
        width: 100% !important;
    }
}
@media screen and (min-width: 1024px) {
    .phone-icon {
        display: none !important;
    }
}
@media screen and (max-width: 480px) {
    .mobile-number {
        display: none !important;
    }
}
.my-title-2 {
    font-family: "Poppins",serif;
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
