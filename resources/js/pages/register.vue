<template>
    <div class="register-page">
        <v-container>
            <v-row justify="center">
                <v-col class="mt-3" cols="12" md="6" lg="4" sm="12">
                        <v-snackbar
                        top
                        color="red darken-2"
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
                    <v-card
                        class="pa-5 animate__animated animate__fadeIn"
                    >
                        <h2 class="text-center">Patient Tracker</h2>
                        <h3 class="text-center py-2">Register</h3>
                        <v-form ref="form"    
                        v-model="valid"
                        >
                            <v-row>
                                <v-col cols="12" sm="6" md="6">
                                    <v-text-field
                                    v-model="registerForm.first_name"
                                        label="First Name*"
                                        :rules="[v => !!v || 'First name is required']"
                                        dense
                                        required
                                        outlined
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="6">
                                    <v-text-field
                                    v-model="registerForm.last_name"
                                        :rules="[v => !!v || 'Last name is required']"
                                        outlined
                                        dense
                                        label="Last Name*"
                                        hint="enter your last name"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        outlined
                                        dense
                                        label="Email*"
                                        :rules="emailRules"
                                        required
                                        type="email"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <vue-tel-input
                                        validCharactersOnly
                                        mode="international"
                                        v-model="registerForm.contact"
                                    ></vue-tel-input>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="registerForm.password"
                                        outlined
                                        dense
                                        :rules="[v => !!v || 'Password is required']"
                                        label="Password*"
                                        required
                                        type="password"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        :rules="[v => !!v || 'Password is required']"
                                        v-model="registerForm.password2"
                                        outlined
                                        dense
                                        label="Confirm Password"
                                        required
                                        type="password"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row justify="center">
                                <v-btn
                                    color="primary"
                                    class="mb-1"
                                    @click="register"
                                    :disabled="!valid"
                                >
                                    REGISTER
                                </v-btn>
                            </v-row>
                            <v-row class="mt-3" justify="end">
                                <router-link to="/login">
                                    <small class="font-italic py-3"
                                        >Already registered?Login!</small
                                    >
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
            snackbar: false,
            snackbar_msg: "",
            drawer: false,
            group: null,
            valid: true,
            emailRules: [
                v => !!v || 'E-mail is required',
                v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
            ],
            registerForm: {
                first_name: "",
                last_name: "",
                email: "",
                password: "",
                password2: "",
                contact: ""
            },
        };
    },
    methods: {
        async register() {
            if (this.registerForm.password !==  this.registerForm.password2) {
                this.snackbar_msg = "Passwords don't match"
                return this.snackbar = true
                };
            if (this.registerForm.contact.trim() ==  "") {
                this.snackbar_msg = "Contact field is empty"
                return this.snackbar = true
                };
            this.isLogging = true;
            const res = await this.callApi("post", "app/register", this.registerForm);
            if (res.status === 200) {
                this.success(res.data.msg);
                window.location = "/";
            } else {
                if (res.status === 401) {
                    this.error(res.data.msg);
                } else if (res.status === 422) {
                    for (let i in res.data.errors) {
                        this.error(res.data.errors[i][0]);
                    }
                } else {
                    this.swr();
                }
            }
            this.isLogging = false;
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
