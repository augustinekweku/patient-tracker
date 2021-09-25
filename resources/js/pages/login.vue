<template>
    <div class="login-page">
        <v-container>
            <v-row justify="center">
                <v-col
                cols="12"
                md="6"
                lg="4"
                sm="12"
                >
                    <v-card class="pa-5 mt-16 animate__animated animate__fadeIn">
                        <h2 class="text-center">Patient Tracker</h2>
                        <h3 class="text-center py-2">Login</h3>
                        <v-form ref="form">
                            <v-text-field
                                v-model="email"
                                label="E-mail"
                                required
                                outlined
                                dense
                            ></v-text-field>
                            <v-text-field
                                v-model="password"
                                label="Password"
                                required
                                type="password"
                                outlined
                                dense
                            ></v-text-field>
                            <v-row justify="center">
                            <v-btn color="primary" class="mb-1" @click="login">
                                LOGIN
                            </v-btn>
                            </v-row>
                            <v-row class="mt-3" justify="end">
                                <router-link to="/register">
                                <small class="font-italic py-3" >Not registered? Sign up!</small>
                                </router-link>
                            </v-row>
                        </v-form>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script>
export default {
    data() {
        return {
            drawer: false,
            group: null,
            email: "",
            password: "",
        };
    },
    methods: {
            async login() {
			if (this.email.trim()=='') return this.error('Email is required');
			if (this.password.trim()=='') return this.error('Password is required');
            if (this.password.length < 6) return this.error('Incorrect Login credentials');
            this.isLogging = true
            const res = await this.callApi('post','app/login', this.data)
            if (res.status === 200) {
                this.success(res.data.msg)
                window.location = '/'
            }else{
                if (res.status === 401) {
                    this.error(res.data.msg)
                }else if (res.status === 422) {
                for(let i in res.data.errors){
						this.error(res.data.errors[i][0])
					}    
                }
                else{
                    this.swr()
                }
            }
            this.isLogging = false
        }
    },
    created() {
        console.log("route", this.$route.path);
    }
};
</script>

<style scoped>
/* .left-nav {
    height: 100vh;
} */
</style>
