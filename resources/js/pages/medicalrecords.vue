<template>
    <div class="page container animate__animated animate__fadeIn">
        <v-row>
            <v-col>
                <h3>Medical Records</h3>
                <vue-good-table
                :line-numbers="true"
                :columns="columns"
                :rows="medicalrecords"
                :search-options="{
    enabled: true,
                }"
                :pagination-options="{
                enabled: true
                }"
                />
            </v-col>
        </v-row>
    </div>
</template>

<script>
export default {
    name: "medicalrecords",
    data() {
        return {
        medicalrecords:[],
        columns: [
        {
          label: 'Patient',
          field: this.PatientNameFn,
        },
        {
          label: 'Diagnosis',
          field: 'diagnosis',
        },
        {
          label: 'Prescription',
          field: 'prescription',
        },
        {
          label: 'Date',
          field: this.dateFn,
        },
      ],
        };
    },

    methods: {
        dateFn(RowObj){
            //return RowObj.order
            let d = new Date( RowObj.created_at );
            let date = d.toDateString();
            return date
        },
        PatientNameFn(rowObj){
            return rowObj.patient.first_name + ' ' + rowObj.patient.last_name
        },
        async getMedicalNotes() {
            const getAllMedicalNotesApi = await this.callApi(
                "get",
                "app/get_all_medical_notes"
            );
            if ((getAllMedicalNotesApi.status = 200)) {
                this.medicalrecords = getAllMedicalNotesApi.data;
            } else {
                this.swr();
            }
        }
    },
    created() {
        this.getMedicalNotes()
    }
};
</script>

<style scoped>
.total-patients-card {
    background-image: linear-gradient(
        to right top,
        #2631b5,
        #5157c5,
        #767cd3,
        #9ba1de,
        #c2c7e7
    );
}
.row {
    margin-top: 0;
}
</style>
