<template>
    <div class="profile container">
        <v-row>
            <v-col>
                <v-card class="p-3">
                    <div class="d-flex justify-content-between">
                        <div>
                        <h3 class="my-2 pb-2">Clinic Information</h3>
                        </div>
                        <div>
                            <v-btn v-if="!clinic_profile_array.length" @click="addClinicProfileDialog = true">Edit Profile</v-btn>
                            <v-btn v-if="clinic_profile_array.length" @click="showUpdateProfileDialog">Edit Clinic Profile</v-btn>
                        </div>
                    </div>
                        <div><p> <b> Clinic Name:</b> {{ clinic_profile.clinic_name ? clinic_profile.clinic_name : "Not Set"}} </p></div>
                        <div><p> <b> Address:</b> {{ clinic_profile.address ? clinic_profile.address : "Not Set"}} </p></div>
                        <div><p> <b>Phone Number: </b>  {{ clinic_profile.phone ? clinic_profile.phone : "Not Set"}} </p></div>
                        <div><p> <b>Country: </b>  {{ clinic_profile.country ? clinic_profile.country : "Not Set"}} </p></div>
                    
                </v-card>
            </v-col>
                        <v-col>
                <v-card class="mx-auto" >
                    <v-img
                        class="white--text align-end"
                        height="200px"
                        src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
                    >
                        <v-card-title>Clinic Profile</v-card-title>
                    </v-img>
                    <div class="d-flex justify-content-center">
                        <div>
                    <v-list-item-avatar size="87" class=" profileImage ">
                    <v-img  src="https://randomuser.me/api/portraits/women/85.jpg"></v-img>
                    </v-list-item-avatar>
                        </div>
                    </div>

                    <v-card-text class="text--primary">
                        <div><p> <b> Doctor Name:</b> {{state_user.first_name + " " + state_user.last_name}} </p></div>
                        <div><p> <b> Email:</b> {{ state_user.email}} </p></div>
                        <div><p> <b>Phone Number: </b>  {{ state_user.phone}} </p></div>

                        <div></div>
                    </v-card-text>

                </v-card>
            </v-col>
        </v-row>


                <!-- MODAL FOR ADDING A CLINIC PROFILE -->

        <v-dialog v-model="addClinicProfileDialog" persistent max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="text-h5">Edit Profile</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-form ref="form2">
                            <v-row>
                                <v-col cols="12" sm="6" md="6">
                                    <v-text-field
                                        label="Clinic Name*"
                                        dense
                                        v-model="clinic_profile_data.clinic_name"
                                        required
                                        outlined
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="6">
                                    <v-text-field
                                        outlined
                                        dense
                                        v-model="clinic_profile_data.city"
                                        label="City*"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="clinic_profile_data.country"
                                        outlined
                                        dense
                                        label="Country*"
                                        required
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <vue-tel-input
                                        validCharactersOnly
                                        mode="international"
                                        v-model="clinic_profile_data.phone"
                                    ></vue-tel-input>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="clinic_profile_data.address"
                                        outlined
                                        dense
                                        label="Email*"
                                        required
                                    ></v-text-field>
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
                        @click="addClinicProfileDialog = false"
                    >
                        Close
                    </v-btn>
                    <v-btn
                        @click="addClinicProfile"
                        color="blue darken-1"
                        class="white--text"
                        
                    >
                        Save
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- END OF MODAL FOR ADDING CLINIC PROFILE -->

                <!-- MODAL FOR UPDATING A CLINIC PROFILE -->

        <v-dialog v-model="updateClinicProfileDialog" persistent max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="text-h5">Update Profile</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-form ref="form2">
                            <v-row>
                                <v-col cols="12" sm="6" md="6">
                                    <v-text-field
                                        label="Clinic Name*"
                                        dense
                                        v-model="updateProfileObj.clinic_name"
                                        required
                                        outlined
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="6">
                                    <v-text-field
                                        outlined
                                        dense
                                        v-model="updateProfileObj.city"
                                        label="City*"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="updateProfileObj.country"
                                        outlined
                                        dense
                                        label="Country*"
                                        required
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <vue-tel-input
                                        validCharactersOnly
                                        mode="international"
                                        v-model="updateProfileObj.phone"
                                    ></vue-tel-input>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="updateProfileObj.address"
                                        outlined
                                        dense
                                        label="Email*"
                                        required
                                    ></v-text-field>
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
                        @click="updateClinicProfileDialog = false"
                    >
                        Close
                    </v-btn>
                    <v-btn
                        @click="updateClinicProfile"
                        color="blue darken-1"
                        class="white--text"
                        
                    >
                        Save
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- END OF MODAL FOR UPDATING CLINIC PROFILE -->
    </div>
</template>
<script>
export default {
    data() {
        return {
            updateClinicProfileDialog : false,
            addClinicProfileDialog : false,
            state_user: null,
            clinic_profile:[],
            clinic_profile_array:[],
            clinic_profile_data: {
                clinic_name: "",
                city: "",
                country: "",
                address: "",
                phone: "",
            },
            updateProfileObj:{
                clinic_name: "",
                city: "",
                country: "",
                address: "",
                phone: "",
                id: null              
            }
        }
    },
        methods: {
            async updateClinicProfile() {
                const updateClinicProfileApi = await this.callApi(
                    "post",
                    "app/update_clinic_profile",
                    this.updateProfileObj
                );
                if (updateClinicProfileApi.status == 200) {
                this.updateClinicProfileDialog = false;

                this.successMsg("Profile updated successfully");
                this.getClinicProfile()
                } else {
                if (updateClinicProfileApi.status == 401) {
                    return this.errorMsg(updateClinicProfileApi.data.msg);
                } else if (updateClinicProfileApi.status == 422) {
                    for (let i in updateClinicProfileApi.data.errors) {
                        this.errorMsg(updateClinicProfileApi.data.errors[i][0]);
                    }
                } else {
                    this.swrMsg();
                }
            }
                
            },
            showUpdateProfileDialog(){
                let obj = {
                    clinic_name: this.clinic_profile_array[0].clinic_name,
                city: this.clinic_profile_array[0].city,
                country: this.clinic_profile_array[0].country,
                address: this.clinic_profile_array[0].address,
                phone: this.clinic_profile_array[0].phone, 
                id : this.clinic_profile_array[0].id
                }
                this.updateProfileObj = obj;
                this.updateClinicProfileDialog = true

            },
           async addClinicProfile(){
            
            const addClinicProfileApi = await this.callApi(
                "post",
                "app/add_clinic_profile",
                this.clinic_profile_data
            );
            },
            async getClinicProfile(){
                const addClinicProfileApi = await this.callApi(
                    "get",
                    "app/get_clinic_profile"
                );
            if (addClinicProfileApi.status == 200) {
                this.clinic_profile = addClinicProfileApi.data[0]
                this.clinic_profile_array = addClinicProfileApi.data
                } else {
                if (addClinicProfileApi.status == 401) {
                    return this.errorMsg(addClinicProfileApi.data.msg);
                } else if (addClinicProfileApi.status == 422) {
                    for (let i in addClinicProfileApi.data.errors) {
                        this.errorMsg(addClinicProfileApi.data.errors[i][0]);
                    }
                } else {
                    this.swrMsg();
                }
            }
                
            }

        },
        created() {
            this.getClinicProfile()
            this.state_user = this.$store.state.user
        }

    
};
</script>
<style scoped>
.profileImage {
    margin-top: -40px;
    border: 1px solid whitesmoke;
}
</style>
