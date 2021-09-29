<template>
    <v-app app>
        <div class="mainapp" 
        >
            <v-app-bar
                fixed
                dense
                dark
                color="indigo darken-2"
                style="z-index:99;"
                v-if="$route.path != '/login' &&
                $route.path != '/register'"
            >
                <v-app-bar-nav-icon @click="drawer = true"></v-app-bar-nav-icon>

                <v-toolbar-title>Patient tracker</v-toolbar-title>

                <v-spacer></v-spacer>
            </v-app-bar>

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
                                {{this.user.first_name + ' ' + this.user.last_name}}
                            </v-list-item-title>
                            <v-list-item-subtitle
                                >{{this.user.email}}</v-list-item-subtitle
                            >
                        </v-list-item-content>
                    </v-list-item>
                </v-list>

                <v-divider></v-divider>
                <v-list nav dense>
                    <v-list-item-group
                        v-model="group"
                        active-class="deep-purple--text text--accent-4"
                    >
                        <v-list-item>
                            <v-list-item-icon>
                                <v-icon>mdi-home</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title>Home</v-list-item-title>
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
                <v-btn color="error"  @click="logout" block>
                    Logout <v-icon right>mdi-exit-to-app</v-icon>
                </v-btn>
                </div>
            </template>
            </v-navigation-drawer>


            <!-- Sizes your content based upon application components -->
            <v-main class="mt-10">
                <!-- Provides the application the proper gutter -->
                <v-container fluid>
                    <!-- If using vue-router -->
                    <router-view></router-view>
                </v-container>

                <!-- BOTTOM NAVIGATION -->
                <v-bottom-navigation 
                fixed
                color="primary"
                v-if="$route.path != '/login' &&
                $route.path != '/register'"
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
    props: ['user'],
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
            window.location = "/login"
        } else {
            this.swrMsg()
        }
        }
    },
    created() {
        this.$store.commit('setUpdateUser', this.user)

    }
};
</script>

<style scoped>
/* .left-nav {
    height: 100vh;
} */
</style>
