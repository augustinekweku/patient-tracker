<template>
    <div class="login-page">
        <v-container fluid>
            <v-row justify="center">
                <v-col
                cols="12"
                md="6"
                lg="4"
                sm="12"
                >
                        <v-snackbar
                        top
                        :color="snackbarColor"
                        v-model="snackbar"
                        >
                        {{ snackbar_msg }}

                        <template v-slot:action="{ attrs }">
                            <v-btn
                            color="white"
                            text
                            v-bind="attrs"
                            @click="snackbar = false"
                            icon
                            >
                            <v-icon>mdi-close</v-icon>
                            </v-btn>
                        </template>
                        </v-snackbar>
                    <v-card class="pa-5 mt-16 animate__animated animate__fadeIn">
                        <h2 class="text-center">Patient Tracker</h2>
                        <h3 class="text-center py-2">Login</h3>
                        <v-form ref="form" v-model="valid">
                            <v-text-field
                                v-model="loginForm.email"
                                label="E-mail"
                                required
                                :rules="emailRules"
                                outlined
                                dense
                            ></v-text-field>
                            <v-text-field
                                v-model="loginForm.password"
                                label="Password"
                                required
                                type="password"
                                :rules="[v => !!v || 'Password is required']"
                                outlined
                                dense
                            ></v-text-field>
                            <v-row justify="center">
                            <v-btn color="primary" class="mb-1" :disabled="!valid" @click="login">
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
            valid: true,
            snackbar: false,
            snackbarColor: "",
            snackbar_msg: "",
            emailRules: [
                v => !!v || 'E-mail is required',
                v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
            ],
            drawer: false,
            group: null,
            loginForm :{
            email: "",
            password: ""
            }
        };
    },
    methods: {
            async login() {
            this.isLogging = true
            const res = await this.callApi('post','app/login', this.loginForm)
            if (res.status == 200) {
                this.successMsg(res.data.msg)
                window.location = '/dashboard'
            }else{
                if (res.status == 401) {
                    return this.errorMsg(res.data.msg)
                }else if (res.status == 422) {
                for(let i in res.data.errors){
						this.errorMsg(res.data.errors[i][0])
					}    
                }
                else{
                    this.swrMsg()
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
