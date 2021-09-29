<template>
    <div class="page container animate__animated animate__fadeIn">
        <v-row justify="center">
            <v-col cols="12" sm="12" md="6" lg="6">
                <!-- SNACKBAR FOR ALERTS -->
                <v-snackbar top :color="snackbarColor" v-model="snackbar">
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
                <!-- END OF SNACKBAR FOR ALERTS -->
                <v-list two-line subheader>
                    <v-subheader>
                        <h3>Patients</h3> 
                    </v-subheader>

                    <v-list-item class="" v-for="(patient, i) in patients" :key="i" link>
                        <v-list-item-avatar>
                            <v-icon class="grey lighten-1 white--text">
                                mdi-account-circle
                            </v-icon>
                        </v-list-item-avatar>

                        <v-list-item-content>
                            <v-list-item-title>{{
                                patient.first_name + ' ' + patient.last_name
                            }}</v-list-item-title>

                            <v-list-item-subtitle>{{
                               patient.created_at | formatDate
                            }}</v-list-item-subtitle>
                        </v-list-item-content>

                        <v-list-item-action>
                            <v-btn @click="showPatientId(patient, i)" icon>
                                <v-icon color="grey lighten-1">
                                    mdi-information
                                </v-icon>
                            </v-btn>
                        </v-list-item-action>
                    </v-list-item>

                    <v-divider inset></v-divider>

                    <v-subheader inset>
                        Files
                    </v-subheader>

                    <v-list-item v-for="item in items2" :key="item.title" link>
                        <v-list-item-avatar>
                            <v-icon :class="[item.iconClass]">
                                {{ item.icon }}
                            </v-icon>
                        </v-list-item-avatar>

                        <v-list-item-content>
                            <v-list-item-title>{{
                                item.title
                            }}</v-list-item-title>

                            <v-list-item-subtitle>{{
                                item.subtitle
                            }}</v-list-item-subtitle>
                        </v-list-item-content>

                        <v-list-item-action>
                            <v-btn icon ripple>
                                <v-icon color="grey lighten-1">
                                    mdi-information
                                </v-icon>
                            </v-btn>
                        </v-list-item-action>
                    </v-list-item>
                </v-list>
            </v-col>

            <v-btn elevation="2" fab right fixed icon @click="addPatientDialog = true">
                <v-icon>mdi-plus</v-icon>
            </v-btn>
        </v-row>

        <!-- MODAL FOR ADDING A PATIENT -->

        <v-dialog v-model="addPatientDialog" persistent max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="text-h5">Add Patient</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-form ref="form" v-model="valid">
                            <v-row>
                                <v-col cols="12" sm="6" md="6">
                                    <v-text-field
                                        label="First Name*"
                                        dense
                                        v-model="patient.first_name"
                                        :rules="[
                                            v => !!v || 'First name is required'
                                        ]"
                                        required
                                        outlined
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="6">
                                    <v-text-field
                                        outlined
                                        dense
                                        v-model="patient.last_name"
                                        label="Last Name*"
                                        :rules="[
                                            v => !!v || 'Last name is required'
                                        ]"
                                        hint="enter your last name"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="patient.address"
                                        outlined
                                        dense
                                        :rules="[
                                            v => !!v || 'Address is required'
                                        ]"
                                        label="Address*"
                                        required
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <vue-tel-input
                                        validCharactersOnly
                                        mode="international"
                                        v-model="patient.phone"
                                    ></vue-tel-input>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="patient.email"
                                        outlined
                                        dense
                                        :rules="emailRules"
                                        label="Email*"
                                        required
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <v-text-field
                                        v-model="patient.age"
                                        outlined
                                        dense
                                        label="Age*"
                                        required
                                        type="number"
                                        :rules="[v => !!v || 'Age is required']"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <v-select
                                        dense
                                        outlined
                                        v-model="patient.gender"
                                        :items="genderItems"
                                        :rules="[
                                            v => !!v || 'Gender is required'
                                        ]"
                                        label="Gender"
                                        required
                                    ></v-select>
                                </v-col>
                            </v-row>
                        </v-form>
                    </v-container>
                    <small>*indicates required field</small>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        class="white--text"
                        color="red darken-1"
                        @click="addPatientDialog = false"
                    >
                        Close
                    </v-btn>
                    <v-btn
                        @click="addPatient"
                        color="blue darken-1"
                        class="white--text"
                        :disabled="!valid"
                    >
                        Save
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- END OF MODALFOR ADDING A PATIENT -->

        <!-- MODAL FOR VIEW AND EDITING A PATIENT -->

        <v-dialog v-model="viewPatientDialog" persistent max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="text-h5">Patient ID: {{viewPatientObj.patient_id}}</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-form ref="form" v-model="valid">
                            <v-row>
                                <v-col cols="12" sm="6" md="6">
                                    <v-text-field
                                        label="First Name*"
                                        dense
                                        v-model="viewPatientObj.first_name"
                                        :rules="[
                                            v => !!v || 'First name is required'
                                        ]"
                                        required
                                        outlined
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="6">
                                    <v-text-field
                                        outlined
                                        dense
                                        v-model="viewPatientObj.last_name"
                                        label="Last Name*"
                                        :rules="[
                                            v => !!v || 'Last name is required'
                                        ]"
                                        hint="enter your last name"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="viewPatientObj.address"
                                        outlined
                                        dense
                                        :rules="[
                                            v => !!v || 'Address is required'
                                        ]"
                                        label="Address*"
                                        required
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <vue-tel-input
                                        validCharactersOnly
                                        mode="international"
                                        v-model="viewPatientObj.phone"
                                    ></vue-tel-input>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="viewPatientObj.email"
                                        outlined
                                        dense
                                        :rules="emailRules"
                                        label="Email*"
                                        required
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <v-text-field
                                        v-model="viewPatientObj.age"
                                        outlined
                                        dense
                                        label="Age*"
                                        required
                                        type="number"
                                        :rules="[v => !!v || 'Age is required']"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <v-select
                                        dense
                                        outlined
                                        v-model="viewPatientObj.gender"
                                        :items="genderItems"
                                        :rules="[
                                            v => !!v || 'Gender is required'
                                        ]"
                                        label="Gender"
                                        required
                                    ></v-select>
                                </v-col>
                            </v-row>
                        </v-form>
                    </v-container>
                    <small>*indicates required field</small>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        class="white--text"
                        color="red darken-1"
                        @click="viewPatientDialog = false"
                    >
                        Close
                    </v-btn>
                    <v-btn
                        @click="addPatient"
                        color="blue darken-1"
                        class="white--text"
                        :disabled="!valid"
                    >
                        Save
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- END OF MODALFOR EDITING AND VIEWING A PATIENT -->
    </div>
</template>

<script>
export default {
    data() {
        return {
            viewPatientDialog: false,
            snackbar: false,
            snackbarColor: "",
            snackbar_msg: "",
            valid: true,
            addPatientDialog: false,
            patients: [],
            genderItems: ["male", "female"],
            emailRules: [
                v => !!v || "E-mail is required",
                v => /.+@.+\..+/.test(v) || "E-mail must be valid"
            ],
            patient_id: "",
            viewPatientObj: {
                patient_id: "",
                first_name: "",
                last_name: "",
                gender: "",
                age: null,
                address: "",
                email: "",
                phone: ""                
            },
            patient: {
                patient_id: "",
                first_name: "",
                last_name: "",
                gender: "",
                age: null,
                address: "",
                email: "",
                phone: ""
            },
            items: [
                {
                    icon: "mdi-folder",
                    iconClass: "grey lighten-1 white--text",
                    title: "Photos",
                    subtitle: "Jan 9, 2014"
                },
                {
                    icon: "mdi-folder",
                    iconClass: "grey lighten-1 white--text",
                    title: "Recipes",
                    subtitle: "Jan 17, 2014"
                },
                {
                    icon: "mdi-folder",
                    iconClass: "grey lighten-1 white--text",
                    title: "Work",
                    subtitle: "Jan 28, 2014"
                }
            ],
            items2: [
                {
                    icon: "mdi-clipboard-text",
                    iconClass: "blue white--text",
                    title: "Vacation itinerary",
                    subtitle: "Jan 20, 2014"
                },
                {
                    icon: "mdi-gesture-tap-button",
                    iconClass: "amber white--text",
                    title: "Kitchen remodel",
                    subtitle: "Jan 10, 2014"
                }
            ]
        };
    },
    methods: {
        async showPatientId(patient, i){
           this.viewPatientObj = patient;
           this.viewPatientDialog = true;
        },
        generatePatientId() {
            const alphabet = "QWERTYUIOPASDFGHJKLZXCVBNM";
            const randomCharacter =
                alphabet[Math.floor(Math.random() * alphabet.length)];
            const randomCharacter2 =
                alphabet[Math.floor(Math.random() * alphabet.length)];
            //get random number between 10000 and 99000
            let randomNumber = Math.random() * (99999 - 10000) + 10000;
            let patient_id =
                randomCharacter + randomCharacter2 + Math.floor(randomNumber);
            console.log(patient_id);
            this.patient.patient_id = patient_id;
        },
        async addPatient() {
            if (this.patient.phone.trim() == "") {
                this.errorMsg("phone is required");
            }
            const res = await this.callApi(
                "post",
                "app/add_patient",
                this.patient
            );
            if (res.status == 201) {
                this.successMsg("Patient added successfully");
                this.patients.unshift(res.data)
                this.addPatientDialog = false;
                this.patient.patient_id = null;
                this.patient.first_name = "";
                this.patient.last_name = "";
                this.patient.gender = "";
                this.patient.address = "";
                this.patient.email = "";
                this.patient.age = "";
                this.patient.phone = "";
                this.generatePatientId()
            } else {
                if (res.status == 401) {
                    return this.errorMsg(res.data.msg);
                } else if (res.status == 422) {
                    for (let i in res.data.errors) {
                        this.errorMsg(res.data.errors[i][0]);
                    }
                } else {
                    this.swrMsg();
                }
            }
        },
        async getPatients() {
            const getPatientsApi = await this.callApi(
                "get",
                "app/get_patients"
            );
            if ((getPatientsApi.status = 200)) {
                this.patients = getPatientsApi.data;
                //console.log(getCompanies.data);
            } else {
                this.swr();
            }
        }
    },
    created() {
        this.generatePatientId();
        this.getPatients();
    }
};
</script>

<style scoped>
/* .page{
    height: 100vh;
} */
</style>
