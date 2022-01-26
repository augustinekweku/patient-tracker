<template>
    <div class="page container animate__animated animate__fadeIn">
        <v-row>
            <v-col>
                <h3>Appointments</h3>
                <calendar-view
                    @click-date="onClickDay"
                    :items="newAppointments"
                    :show-date="showDate"
                >
                    <calendar-view-header
                        slot="header"
                        slot-scope="t"
                        :header-props="t.headerProps"
                        @input="setShowDate"
                    />
                </calendar-view>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import { CalendarView, CalendarViewHeader } from "vue-simple-calendar";
export default {
    name: "appointments",
    data() {
        return {
            newAppointments: [],
            showDate: new Date(),
            /* Show the current month, and give it some fake items to show */
            showDate: new Date(),
            message: "",
            startingDayOfWeek: 0,
            disablePast: false,
            disableFuture: false,
            displayPeriodUom: "month",
            displayPeriodCount: 1,
            displayWeekNumbers: false,
            showTimes: true,
            selectionStart: null,
            selectionEnd: null,
            newItemTitle: "",
            newItemStartDate: "",
            newItemEndDate: "",
            useDefaultTheme: true,
            useHolidayTheme: true,
            useTodayIcons: false,
            appointments:[],
        };
    },
    components: {
        CalendarView,
        CalendarViewHeader
    },
    methods: {
        async getAppointments() {
            const getAllAppointmentsApi = await this.callApi(
                "get",
                "app/get_all_appointments"
            );
            if ((getAllAppointmentsApi.status = 200)) {
                this.appointments = getAllAppointmentsApi.data.allAppointments;
                console.log(getAllAppointmentsApi.data.allAppointments);
                var newAppointments = []
                getAllAppointmentsApi.data.allAppointments.map((appointment)=>{
                    const {id, notes, patient, date } = appointment;
                    let patient_name = appointment.patient.first_name
                    if (appointment.status === "unfinished") {
                        newAppointments.push({id:id, title:patient_name,  startDate: date, classes: "orange"})
                        
                    } else{
                        newAppointments.push({id:id, title:patient_name,  startDate: date, classes: "green"})
                    }
                })
                    console.log("testing map " + JSON.stringify(newAppointments));
                    this.newAppointments = newAppointments
            } else {
                this.swr();
            }
        },
        onClickDay(d) {
            this.selectionStart = null;
            this.selectionEnd = null;
            //this.message = `You clicked: ${d.toLocaleDateString()}`
            console.log("you clicked " + d);
        },
        setShowDate(d) {
            this.showDate = d;
        }
    },
    created() {
        this.getAppointments()
        console.log("today's date is " + new Date("1994-05-11"));
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
