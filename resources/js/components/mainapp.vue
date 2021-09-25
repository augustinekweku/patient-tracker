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
                                Sandra Adams
                            </v-list-item-title>
                            <v-list-item-subtitle
                                >sandra_a88@gmail.com</v-list-item-subtitle
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
    data() {
        return {
            drawer: false,
            group: null
        };
    },
    methods: {},
    created() {}
};
</script>

<style scoped>
/* .left-nav {
    height: 100vh;
} */
</style>
