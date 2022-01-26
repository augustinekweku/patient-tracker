<template>
        <div class="page container animate__animated animate__fadeIn">
        <v-row>
            <v-col>
                <h3>Welcome</h3>
                <v-row>
                    <v-col>
                        <v-card  class="px-3 py-5 total-patients-card">
                            <div class="d-flex justify-content-between align-items-center">
                            <div class="text-light font-weight-bold m">
                                <h2 class="fs-2 mb-0  pb-0">{{patientsCount}}</h2>
                                <p class="mb-0">
                                    Total Patients
                                </p>
                            </div>
                            <div class="">
                                <v-icon class="large-icon">mdi-account-group</v-icon>
                            </div>
                            </div>
                        </v-card>
                    </v-col>
                    
                    <v-col>
                        <v-card class="px-3 py-5 total-patients-card">
                            <div class="d-flex justify-content-between align-items-center">
                            <div class="text-light font-weight-bold m">
                                <h2 class="fs-2 mb-0  pb-0">{{appointmentsCount}}</h2>
                                <p class="mb-0">
                                    Upcoming Appointments
                                </p>
                            </div>
                            <div class="">
                                <v-icon class="large-icon">mdi-calendar</v-icon>
                            </div>
                            </div>
                        </v-card>
                    </v-col>
                    <v-col >
                        <v-card class="px-3 py-5 total-patients-card">
                            <div class="d-flex justify-content-between align-items-center">
                            <div class="text-light font-weight-bold m">
                                <h2 class="fs-2 mb-0  pb-0">10</h2>
                                <p class="mb-0">
                                    Upcoming Birthdays
                                </p>
                            </div>
                            <div class="">
                                <v-icon class="large-icon">mdi-cake</v-icon>
                            </div>
                            </div>
                        </v-card>
                    </v-col>

                </v-row>
                <v-row class="mt-2">
                    <v-col cols="12" sm="3" md="3" lg="3">
                                            
                        
                        <v-card @click="showAddAppointmentDialog" class="mb-6">
                            <div class="row  justify-content-evenly px-2">
                            <div class=" bg-primary  px-3 rounded-start col-3">
                                <v-icon class="text-light" x-large>mdi-account-plus</v-icon>
                            </div>
                            <div class="col-9 font-weight-bold text-center">
                                <h6 class="">Add <br>
                                Appointments</h6>
                            </div>
                            </div>
                        </v-card>
                        
                        <v-card @click="addPatientDialog = true" class="mb-6">
                            <div class="row  justify-content-evenly px-2">
                            <div class=" bg-primary  px-3 rounded-start col-3">
                                <v-icon class="text-light" x-large>mdi-account-plus</v-icon>
                            </div>
                            <div class="col-9 font-weight-bold text-center">
                                <h6 class="">Add <br>
                                Patients</h6>
                            </div>
                            </div>
                        </v-card>
                        


                    </v-col>
                    <v-col cols="12"  sm="9" md="9" lg="9">
                        <h4>Upcoming Appointments</h4>
                        <div>
                            <vue-good-table
                            @on-row-dblclick="onRowDoubleClick"
                            :line-numbers="true"
                            :pagination-options="{
                                enabled: true
                                }"
                            :columns="columns"
                            :rows="Appointments"/>
                        </div>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>

                <!-- MODAL FOR ADDING MEDICAL NOTES -->

        <v-dialog v-model="addMedicalNotesDialog" persistent max-width="600px" class="px-2">
            <v-card>
                <v-card-title>
                    <span class="text-h5">Add Medical Notes</span>
                </v-card-title>
                <v-card-text>
                    <v-row class="mb-2">
                        <label class="form-label">Patient</label>
                          <input type="text" v-model="medicalNotes.patient_name" class="form-control" placeholder="Date">
                    </v-row>
                    <v-row class="mb-2">
                        <label class="form-label">Diagnosis</label>
                          <textarea  v-model="medicalNotes.diagnosis" class="form-control" placeholder="Diagnosis"/>
                    </v-row>
                    <v-row class="mb-2">
                        <v-col>
                        <label class="form-label">Prescription</label>
                          <textarea v-model="medicalNotes.prescription" class="form-control" placeholder="Prescription"/>
                        </v-col>
                        <v-col>
                        <label class="form-label">Next review date</label>
                          <input type="date" v-model="medicalNotes.next_review_date" class="form-control" placeholder="End time">
                        </v-col>
                    </v-row>
                    <v-row class="mb-2">
                        <label class="form-label">Notes</label>
                          <textarea v-model="medicalNotes.notes"  class="form-control" placeholder="Notes"> </textarea>
                    </v-row>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        class="white--text"
                        color="red darken-1"
                        @click="addMedicalNotesDialog= false"
                    >
                        Close
                    </v-btn>
                    <v-btn
                        @click="addMedicalNotes"
                        color="blue darken-1"
                        class="white--text"
                    >
                        Save
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- END OF MODAL FOR MEDICAL NOTES -->

                <!-- MODAL FOR ADDING APPOINTMENT -->

        <v-dialog v-model="addAppointmentDialog" persistent max-width="600px" class="px-2">
            <v-card>
                <v-card-title>
                    <span class="text-h5">Add Appointment</span>
                </v-card-title>
                <v-card-text>
                    <v-row class="mb-2">
                        <label class="form-label">Patient</label>
                        <select v-model="appointment.patient_id" class="form-control" >
                        <option v-for="(patient, i) in Patients" :value="patient.id" :key="i" >
                            {{patient.first_name}} {{patient.last_name}}</option>
                        </select>
                    </v-row>
                    <v-row class="mb-2">
                        <label class="form-label">Date</label>
                          <input type="date" v-model="appointment.date" class="form-control" placeholder="Date">
                    </v-row>
                    <v-row class="mb-2">
                        <v-col>
                        <label class="form-label">Start time</label>
                          <input type="time" v-model="appointment.start_time" class="form-control" placeholder="Start time">
                        </v-col>
                        <v-col>
                        <label class="form-label">End time</label>
                          <input type="time" v-model="appointment.end_time" class="form-control" placeholder="End time">
                        </v-col>
                    </v-row>
                    <v-row class="mb-2">
                        <label class="form-label">Notes</label>
                          <textarea v-model="appointment.notes"  class="form-control" placeholder="Notes"> </textarea>
                    </v-row>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        class="white--text"
                        color="red darken-1"
                        @click="addAppointmentDialog= false"
                    >
                        Close
                    </v-btn>
                    <v-btn
                        @click="addAppointment"
                        color="blue darken-1"
                        class="white--text"
                    >
                        Save
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- END OF MODAL FOR ADDING APPOINTMENT -->

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



        </div>
</template>

<script>
export default {
  name: 'my-component',
  data(){
    return {
        patientsCount: 0,
        appointmentsCount: 0,
        addMedicalNotesDialog: false,
        medicalNotes: {
            patient_name: "",
            patient_id: null,
            diagnosis: "",
            prescription: "",
            next_review_date: "",
            appointment_id: null,
            notes: "",
        },
        addPatientDialog: false,
        genderItems: ["male", "female"],
            emailRules: [
                v => !!v || "E-mail is required",
                v => /.+@.+\..+/.test(v) || "E-mail must be valid"
            ],
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
        valid: false,
        Appointments: [],
        Patients: [],
    addAppointmentDialog: false,
    appointment:{
        patient_id: "",
        user_id: "",
        notes: "",
        start_time: "",
        end_time: "",
    },
      columns: [
        {
          label: 'Date',
          field: 'date',
        },
        {
          label: 'Patient Name',
          field: this.PatientNameFn,
          type: 'number',
        },
        {
          label: 'Time',
          field: this.TimeFn,
        },
        {
          label: 'Notes',
          field: 'notes',
        },
      ],
      Appointments: [],
    }
  },
    methods: {
        async addMedicalNotes(){
            if (this.medicalNotes.patient_name.trim() == "") {
                return this.errorMsg("Patient name is required");
            }
            const res = await this.callApi(
                "post",
                "app/add_medical_notes",
                this.medicalNotes
            );
            if (res.status == 200) {
            this.successMsg("Medical Notes added successfully");
            this.getAppointments();
            this.addMedicalNotesDialog = false;
            }  else {
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
        onRowDoubleClick(params){
            console.log(params.row);
            this.addMedicalNotesDialog = true
            this.medicalNotes.patient_id = params.row.patient.id
            this.medicalNotes.patient_name = params.row.patient.first_name + " " + params.row.patient.last_name
            this.medicalNotes.appointment_id = params.row.id

        },
        TimeFn(rowObj) {
            return  rowObj.start_time + " - " + rowObj.end_time;
        },
        PatientNameFn(rowObj){
            return rowObj.patient.first_name + ' ' + rowObj.patient.last_name
        },
        closePatientDialog(){
            this.viewPatientDialog = false;
            this.addPatientDialog = false;
            this.isEditDialog = false;
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
        async addAppointment(){
            if (!this.appointment.patient_id) {
                return this.errorMsg("Patient is required");
            }
            if (this.appointment.notes.trim() == "") {
                return this.errorMsg("Notes is required");
            }
            if (this.appointment.start_time.trim() == "") {
                return this.errorMsg("Start time  is required");
            }
            if (this.appointment.end_time.trim() == "") {
                return this.errorMsg("End time is required");
            }
            if (this.appointment.date.trim() == "") {
                return this.errorMsg("Appointment Date is required");
            }
            
            const res = await this.callApi(
                "post",
                "app/add_appointment",
                this.appointment
            );
            if (res.status == 201) {
                this.successAlert("Appointment added successfully");
                this.getAppointments();
                this.addAppointmentDialog = false;
                this.appointment.patient_id = null;
                this.appointment.date = "";
                this.appointment.end_time = "";
                this.appointment.start_time = "";
                this.appointment.notes = "";

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
        showAddAppointmentDialog(){
            this.addAppointmentDialog =true;
        },
        async getPatients() {
            const getPatientsApi = await this.callApi(
                "get",
                "app/get_patients"
            );
            if ((getPatientsApi.status = 200)) {
                this.Patients = getPatientsApi.data.patients;
                this.patientsCount = getPatientsApi.data.patientsCount;
                //console.log(getCompanies.data);
            } else {
                this.swr();
            }
        },
        async getAppointments() {
            const getAppointmentsApi = await this.callApi(
                "get",
                "app/get_appointments"
            );
            if ((getAppointmentsApi.status = 200)) {
                this.Appointments = getAppointmentsApi.data.appointments;
                this.appointmentsCount = getAppointmentsApi.data.appointmentsCount
                console.log(getAppointmentsApi);
            } else {
                this.swr();
            }
        },
    },
    created() {
        this.getAppointments();
        this.getPatients();
    }


  }

</script>

<style scoped>
.total-patients-card {
 background-image: linear-gradient(to right top, #2631b5, #5157c5, #767cd3, #9ba1de, #c2c7e7); 
 }
 .row{
     margin-top: 0;
 }

</style>