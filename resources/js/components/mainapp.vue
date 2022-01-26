<template>
    <v-app app>
        <div class="mainapp">
            <v-app-bar
                fixed
                dense
                dark
                color="indigo darken-2"
                style="z-index:99;"
                v-if="$route.path != '/login' && $route.path != '/register'"
            >
                <v-app-bar-nav-icon
                    @click="drawer = true"
                    class="d-lg-none"
                ></v-app-bar-nav-icon>

                <v-toolbar-title>Patient tracker</v-toolbar-title>

                <v-spacer></v-spacer>
                <v-spacer></v-spacer>

                <v-btn icon>
                    <v-icon>mdi-heart</v-icon>
                </v-btn>

                <v-btn icon>
                    <v-icon>mdi-magnify</v-icon>
                </v-btn>
                <v-menu offset-y>
                    <template v-slot:activator="{ on, attrs }">
                        <v-list-item-avatar v-bind="attrs" v-on="on">
                            <v-img
                                src="https://randomuser.me/api/portraits/women/85.jpg"
                            ></v-img>
                        </v-list-item-avatar>
                    </template>
                    <v-list>
                        <v-list-item link to="/profile">
                            <v-list-item-title >
                                <v-icon  color="green darken-2">
                                    mdi-account-circle </v-icon
                                > Profile</v-list-item-title
                            >
                        </v-list-item>
                        <v-list-item link @click="logout">
                            <v-list-item-title >
                                <v-icon  color="red darken-2">
                                    mdi-power </v-icon
                                > Log out</v-list-item-title
                            >
                        </v-list-item>
                    </v-list>
                </v-menu>
            </v-app-bar>
            <!-- SIDE NAV DRAWER FOR MOBILE  VIEW -->
            <v-navigation-drawer
                v-model="drawer"
                absolute
                temporary
                hide-overlay
            >
                <v-list class="mt-10">
                    <v-list-item class="px-2">
                        <v-list-item-avatar>
                            <v-img
                                src="https://randomuser.me/api/portraits/women/85.jpg"
                            ></v-img>
                        </v-list-item-avatar>
                    </v-list-item>

                    <v-list-item link>
                        <v-list-item-content>
                            <v-list-item-title class="text-h6">
                                {{
                                    this.user.first_name +
                                        " " +
                                        this.user.last_name
                                }}
                            </v-list-item-title>
                            <v-list-item-subtitle>{{
                                this.user.email
                            }}</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>

                <v-divider class="mb-2 "></v-divider>
                <v-list nav dense>
                    <v-list-item-group
                        v-model="group"
                        
                    >
                        <v-list-item to="/dashboard">
                            <v-list-item-icon>
                                <v-icon>mdi-home</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title>Dashboard</v-list-item-title>
                        </v-list-item>

                        <v-list-item>
                            <v-list-item-icon>
                                <v-icon>mdi-account</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title>Account</v-list-item-title>
                        </v-list-item>
                    </v-list-item-group>
                </v-list>
                <template v-slot:append>
                    <div class="pa-2">
                        <v-btn color="error" @click="logout" block>
                            Logout <v-icon right>mdi-exit-to-app</v-icon>
                        </v-btn>
                    </div>
                </template>
            </v-navigation-drawer>
                        <!--END OF  SIDE NAV DRAWER FOR MOBILE  VIEW -->

            <!-- Sizes your content based upon application components -->
            <v-main class="mt-10">
                <!-- Provides the application the proper gutter -->
                <v-container fluid>
                    <v-row
                        v-if="
                            $route.path != '/login' &&
                                $route.path != '/register'
                        "
                    >
                        <v-col cols="3" class="ps-5 d-none d-md-block">
                            <v-card
                                v-if="
                                    $route.path != '/login' &&
                                        $route.path != '/register'
                                "
                                elevation="12"
                                width="266"
                                
                                color="indigo darken-2"
                                class="mt-7 mx-auto"
                            >
                            <!-- VERTICAL NAVIGATION MENU FOR DESKTOP -->
                                <v-navigation-drawer width="266" floating permanent>
                                            <v-list>
                                        <v-list-item>
                                            <div class="mx-auto">
                                            <v-list-item-avatar size="87">
                                            <v-img  src="https://randomuser.me/api/portraits/women/85.jpg"></v-img>
                                            </v-list-item-avatar>
                                            </div>
                                        </v-list-item>
                                        <v-list-item link class="text-center">
                                            <v-list-item-content>
                                            <v-list-item-title class="text-h6">
                                            {{
                                    this.user.first_name +
                                        " " +
                                        this.user.last_name
                                }}
                                            </v-list-item-title>
                                            <v-list-item-subtitle>{{this.user.email}}</v-list-item-subtitle>
                                            </v-list-item-content>
                                        </v-list-item>
                                        </v-list>

                                        <v-divider class="mb-1"></v-divider>
                                    <v-list  dense rounded class="mb-2">
                                        <v-list-item to="/dashboard" link>
                                            <v-list-item-icon>
                                                <v-icon>mdi-home</v-icon>
                                            </v-list-item-icon>

                                            <v-list-item-content>
                                                <v-list-item-title
                                                    >Dashboard</v-list-item-title
                                                >
                                            </v-list-item-content>
                                        </v-list-item>
                                        <v-list-item to="/clinic" link>
                                            <v-list-item-icon>
                                                <v-icon>mdi-hospital-building</v-icon>
                                            </v-list-item-icon>

                                            <v-list-item-content>
                                                <v-list-item-title
                                                    >My Clinic</v-list-item-title
                                                >
                                            </v-list-item-content>
                                        </v-list-item>
                                        <v-list-item to="/appointments" link>
                                            <v-list-item-icon>
                                                <v-icon>mdi-calendar-clock-outline</v-icon>
                                            </v-list-item-icon>

                                            <v-list-item-content>
                                                <v-list-item-title
                                                    >Appointments</v-list-item-title
                                                >
                                            </v-list-item-content>
                                        </v-list-item>
                                        <v-list-item link>
                                            <v-list-item-icon>
                                                <v-icon>mdi-hospital-box</v-icon>
                                            </v-list-item-icon>

                                            <v-list-item-content>
                                                <v-list-item-title
                                                    >Drugs List</v-list-item-title
                                                >
                                            </v-list-item-content>
                                        </v-list-item>
                                        <v-list-item to="/patients" link>
                                            <v-list-item-icon>
                                                <v-icon>mdi-clipboard-list-outline</v-icon>
                                            </v-list-item-icon>

                                            <v-list-item-content>
                                                <v-list-item-title
                                                    >My Patients</v-list-item-title
                                                >
                                            </v-list-item-content>
                                        </v-list-item>
                                        <v-list-item link to="/medicalrecords">
                                            <v-list-item-icon>
                                                <v-icon>mdi-view-list</v-icon>
                                            </v-list-item-icon>

                                            <v-list-item-content>
                                                <v-list-item-title
                                                    >Medical Records</v-list-item-title
                                                >
                                            </v-list-item-content>
                                        </v-list-item>
                                        <v-list-item to="/profile" link>
                                            <v-list-item-icon>
                                                <v-icon>mdi-account-circle</v-icon>
                                            </v-list-item-icon>

                                            <v-list-item-content>
                                                <v-list-item-title
                                                    >Profile</v-list-item-title
                                                >
                                            </v-list-item-content>
                                        </v-list-item>
                                    </v-list>
                                </v-navigation-drawer>
                                <!-- END OF VERTICAL NAVIGATION MENU FOR DESKTOP -->

                            </v-card>
                        </v-col>
                        <v-col cols="12" sm="12" md="9" lg="9" xl="9" class="mt-3">
                            <router-view></router-view>
                        </v-col>
                    </v-row>

                    <!-- FOR LOGIN PAGES -->
                    <v-row
                        v-if="
                            $route.path == '/login' ||
                                $route.path == '/register'
                        "
                    >
                        <v-col cols="12">
                            <router-view></router-view>
                        </v-col>
                    </v-row>
                </v-container>

                <!-- BOTTOM NAVIGATION -->
                <v-bottom-navigation
                    fixed
                    class="d-none"
                    color="primary"
                    v-if="$route.path != '/login' && $route.path != '/register'"
                >
                    <v-btn to="/patients">
                        <span>Dashboard</span>

                        <v-icon>mdi-home</v-icon>
                    </v-btn>

                    <v-btn>
                        <span>Favorites</span>

                        <v-icon>mdi-heart</v-icon>
                    </v-btn>

                    <v-btn>
                        <span>Nearby</span>

                        <v-icon>mdi-map-marker</v-icon>
                    </v-btn>
                    <v-btn>
                        <span>Search</span>

                        <v-icon>mdi-magnify</v-icon>
                    </v-btn>
                </v-bottom-navigation>
                <!-- END OF BOTTOM NAVIGATION -->
            </v-main>
        </div>
    </v-app>
</template>
<script>
export default {
    props: ["user"],
    data() {
        return {
            drawer: false,
            group: null
        };
    },
    methods: {
        async logout() {
            const res = await this.callApi("get", "/logout");
            if (res.status == 200) {
                window.location = "/login";
            } else {
                this.swrMsg();
            }
        }
    },
    created() {
        this.$store.commit("setUpdateUser", this.user);
    }
};
</script>

<style scoped>
/* .left-nav {
    height: 100vh;
} */
</style>
