<template>
    <v-app id="inspire">
        <v-navigation-drawer v-model="drawer" app>
            <v-list class="my-list" dense>
                <template v-for="item in items">
                    <v-row v-if="item.heading" :key="item.heading" align="center">
                        <v-col cols="6">
                            <v-subheader v-if="item.heading">
                                {{ item.heading }}
                            </v-subheader>
                        </v-col>
                        <v-col class="text-center" cols="6">
                            <a class="body-2 black--text" href="#!">EDIT</a>
                        </v-col>
                    </v-row>
                    <v-list-group
                        v-else-if="item.children"
                        :key="item.text"
                        v-model="item.model"
                        :append-icon="item.model ? item.icon : item['icon-alt']"
                        prepend-icon=""
                    >
                        <template v-slot:activator>
                            <v-list-item-content>
                                <v-list-item-title>
                                    {{ item.text }}
                                </v-list-item-title>
                            </v-list-item-content>
                        </template>

                        <v-list-item
                            v-for="(child, i) in item.children"
                            :key="i"
                            :to="child.link"
                            link
                            style="margin-left: 20px"
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
                    <v-list-item v-else :key="item.text" :to="item.link" link>
                        <v-list-item-action class="no-icon-display">
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
            class="custom"
            color="white"
            dark
            elevation="0"
            to="/"
        >
            <v-app-bar-nav-icon
                class="hidden-md-and-up"
                style="color: black"
                @click.stop="drawer = !drawer"
            ></v-app-bar-nav-icon>
            <v-toolbar-title class="pl-2">
                <a href="/">
                    <v-img
                        height="50"
                        src="@/assets/tgrlogo-margin.svg"
                        width="150"
                    ></v-img>
                </a>
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-title>
                <v-btn
                    class="nextButton hidden-md-and-up"
                    elevation="0"
                    outlined
                    rounded
                    to="/booking"
                >Book Now
                </v-btn
                >
            </v-toolbar-title>
                <MainNavigation/>
        </v-app-bar>
        <v-main>
            <router-view/>
        </v-main>
        <Footer/>
    </v-app>
</template>
<style scoped>

.nextButton {
    border-color: #44d39b;
    text-transform: capitalize;
    font-weight: 600;
    color: #fff;
    background-color: #44d39b;
}

.no-icon-display.v-list-item__action {
    display: none !important;
}

.v-list-item--dense .v-list-item__content,
.v-list--dense .v-list-item .v-list-item__content {
    padding: 8px 0;
    margin-right: 10px !important;
}

#inspire {
    font-family: "Poppins";
}

.title-container {
    width: 100%;
    height: 51rem;
    position: relative;
}

.card-title-custom {
    margin-top: 45%;
    margin-left: 2rem;
    font-weight: bolder !important;
}

.v-app-bar.custom {
    padding-left: 18rem;
    box-shadow: -1px -1px 19px -5px rgba(0, 0, 0, 0.45) !important;
    -webkit-box-shadow: -1px -1px 19px -5px rgba(0, 0, 0, 0.45) !important;
    -moz-box-shadow: -1px -1px 19px -5px rgba(0, 0, 0, 0.45) !important;
}

.container.header {
    padding: unset !important;
}

.my-input.v-input .v-input__slot {
    border-radius: 5px;
    border: 1px solid rgba(0, 0, 0, 0.35);
    box-shadow: unset !important;
}

@media screen and (max-width: 960px) {
    .v-app-bar.custom {
        padding-left: 0;
    }
}

@media screen and (min-width: 961px) {
    .v-toolbar__content,
    .v-toolbar__extension {
        position: relative;
        margin-left: -130px !important;
    }
}

@media screen and (min-width: 1024px) {
    .v-toolbar__content,
    .v-toolbar__extension {
        position: relative;
        margin-left: -100px !important;
    }
}
</style>
<script>
import Footer from "@/components/Footer.vue";
import MainNavigation from "@/components/MainNavigation.vue";

export default {
    components: {
        Footer,
        MainNavigation,
    },
    data() {
        return {
            drawer: false,
            items: [
                {
                    text: "Home",
                    link: "/",
                },
                {
                    text: "Booking",
                    link: "/booking",
                },
                {
                    text: "Explore",
                    icon: "mdi-chevron-up",
                    "icon-alt": "mdi-chevron-down",
                    model: false,
                    children: [
                        {
                            text: "Glimpse Of Thenzawl",
                            link: "/glimpse-of-thenzawl",
                        },
                        {
                            text: "Club Member",
                            link: "/club-member",
                        },
                        {
                            text: "Gallery",
                            link: "/gallery",
                        },
                        {
                            text: "Video",
                            link: "/video",
                        },
                        {
                            text: "Environment",
                            link: "/environment",
                        },
                        {
                            text: "Who Are We",
                            link: "/who-are-we",
                        },
                    ],
                },
                {
                    text: "Guides",
                    model: false,
                    icon: "mdi-chevron-up",
                    "icon-alt": "mdi-chevron-down",
                    children: [
                        {
                            text: "Tour Guide",
                            link: "/tour-guide",
                        },
                        {
                            text: "Rent a Car",
                            link: "/rent-a-car",
                        },
                        {
                            text: "Hire Taxi",
                            link: "/hire-taxi",
                        },
                        {
                            text: "Hire Auto-Rickshow",
                            link: "/hire-auto",
                        },
                        {
                            text: "Where to Stay",
                            link: "/where-to-stay",
                        },
                        {
                            text: "Find me Food",
                            link: "/find-me-food",
                        },

                    ],
                },
                {
                    text: "Places of Interest",
                    link: "/place-of-interest-near-thenzawl",
                },
                {
                    text: "Facilities",
                    link: "/facilities",
                },
            ],
        };
    },
};
</script>
