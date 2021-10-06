<template>
    <div class="page container animate__animated animate__fadeIn">
        <v-row>
            <v-col cols="12" sm="12" md="6" lg="6">
                <!-- SNACKBAR FOR ALERTS -->
                <v-snackbar class="snackbar mt-5" top :color="snackbarColor" v-model="snackbar">
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

                        <v-list-item-content @click="showPatient(patient, i)">
                            <v-list-item-title>{{
                                patient.first_name + ' ' + patient.last_name
                            }}</v-list-item-title>

                            <v-list-item-subtitle>{{
                               patient.created_at | formatDate
                            }}</v-list-item-subtitle>
                        </v-list-item-content>

                        <v-list-item-action>
                            <v-row align="center">
                                <v-col cols="6"> 
                                <v-btn @click="showEditDialog(patient, i)" icon ripple>
                                <v-icon color="#303f9f ">
                                    mdi-pencil
                                </v-icon>
                                </v-btn>
                                    </v-col>
                                <v-col cols="6">
                                <v-btn @click="showDeletingDialog(patient, i)" icon ripple>
                                <v-icon color="red">
                                    mdi-delete
                                </v-icon>
                                </v-btn>
                                </v-col>
                            </v-row>
                        </v-list-item-action>
                    </v-list-item>

                    <v-divider ></v-divider>




                </v-list>
            </v-col>

            <v-btn elevation="2" small fab right fixed color="#303f9f"  @click="addPatientDialog = true">
                <v-icon color="white">mdi-plus</v-icon>
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
                        <v-form ref="form2" v-model="valid">
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
                        @click="closePatientDialog"
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
                    <span class="text-h5">Patient ID: {{editPatientObj.patient_id}}</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-form ref="form2" v-model="editValid">
                            <v-row>
                                <v-col cols="12" sm="6" md="6">
                                    <v-text-field
                                        label="First Name*"
                                        dense
                                        :rules="[
                                            v => !!v || 'First name is required'
                                        ]"
                                        :disabled="!isEditDialog"
                                        v-model="editPatientObj.first_name"
                                        required
                                        outlined
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="6">
                                    <v-text-field
                                        outlined
                                        dense
                                        :disabled="!isEditDialog"
                                        v-model="editPatientObj.last_name"
                                        label="Last Name*"
                                        :rules="[
                                            v => !!v || 'Last name is required'
                                        ]"
                                        hint="enter your last name"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="editPatientObj.address"
                                        outlined
                                        :disabled="!isEditDialog"
                                        :rules="[
                                            v => !!v || 'Address is required'
                                        ]"
                                        dense
                                        label="Address*"
                                        required
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <vue-tel-input
                                    :disabled="!isEditDialog"
                                        validCharactersOnly
                                        mode="international"
                                        v-model="editPatientObj.phone"
                                    ></vue-tel-input>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="editPatientObj.email"
                                        outlined
                                        dense
                                        :rules="emailRules"
                                        :disabled="!isEditDialog"
                                        label="Email*"
                                        required
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <v-text-field
                                        v-model="editPatientObj.age"
                                        outlined
                                        :disabled="!isEditDialog"
                                        :rules="[
                                            v => !!v || 'Address is required'
                                        ]"
                                        dense
                                        label="Age*"
                                        required
                                        type="number"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <v-select
                                        :disabled="!isEditDialog"
                                        dense
                                        outlined
                                        :rules="[
                                            v => !!v || 'Address is required'
                                        ]"
                                        v-model="editPatientObj.gender"
                                        :items="genderItems"
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
                        @click="closePatientDialog"
                    >
                        Close
                    </v-btn>
                    
                    <v-btn
                        v-if="isEditDialog"
                        @click="editPatient"
                        color="blue darken-1"
                        class="white--text"
                        :disabled="!editValid"
                    >
                        EDIT
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- END OF MODALFOR EDITING AND VIEWING A PATIENT -->


        <!-- DELETE CONFIRMATION -->
        <deleteDialog></deleteDialog>
        <!-- END OF DELETE CONFIRMATION -->
    </div>
</template>

<script>
import deleteDialog from "../components/deleteDialog.vue";
import { mapGetters } from "vuex";
export default {
    components: {
        deleteDialog
    },
    data() {
        return {
            viewPatientDialog: false,
            snackbar: false,
            isEditDialog: false,
            snackbarColor: "",
            snackbar_msg: "",
            editValid: true,
            valid: true,
            addPatientDialog: false,
            patients: [],
            genderItems: ["male", "female"],
            emailRules: [
                v => !!v || "E-mail is required",
                v => /.+@.+\..+/.test(v) || "E-mail must be valid"
            ],
            patient_id: "",
            editPatientObj: {
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
        }
    },
    methods: {
        async editPatient(){
            if (this.editPatientObj.phone.trim() == "") {
                return this.errorMsg("phone is required");
                }
            const res = await this.callApi(
                "post",
                "app/edit_patient",
                this.editPatientObj
            );                
            if (res.status == 200) {
                this.viewPatientDialog = false;
                this.isEditDialog = false

                this.successMsg("Patient edited successfully");
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
        showDeletingDialog(patient, i) {
            const deleteModalObj = {
                showDeleteDialog: true,
                deleteUrl: "app/delete_patient",
                data: patient,
                isDeleted: false,
                msg: `Are you sure you want to delete  ${patient.first_name}'s records?`,
                successMsg: "Patient deleted successfully"
            };
            this.$store.commit("setDeletingModalObj", deleteModalObj);
            //console.log('delete method called ')
        },
        closePatientDialog(){
            this.viewPatientDialog = false;
            this.addPatientDialog = false;
            this.isEditDialog = false;
        },
        async showPatient(patient, i){
           this.editPatientObj = patient;
           this.viewPatientDialog = true;
        },
        async showEditDialog(patient, i){
            //to prevent real time editing
            let obj = {
                id: patient.id,
                patient_id: patient.patient_id,
                first_name: patient.first_name,
                last_name: patient.last_name,
                gender: patient.gender,
                age: patient.age,
                address: patient.address,
                email: patient.email,
                phone: patient.phone,                    
                }
            this.isEditDialog = true;
            this.editPatientObj = obj;
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
                return this.errorMsg("phone is required");
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
    },
        computed: {
        ...mapGetters(["getDeleteModalObj"])
    },
    watch: {
        getDeleteModalObj(obj) {
            console.log(obj);
            if (obj.isDeleted) {
                console.log(obj);
                this.getPatients();
            }
        }
    }
};
</script>

<style scoped>
/* .page{
    height: 100vh;
} */
.snackbar{
    z-index: 999;
}

</style>
