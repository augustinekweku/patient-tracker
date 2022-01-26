<div class="mail_page">
    <div class="mail_card">
    <h1 style="text-align: center">Clinic App </h1>
    <h3>Appointment scheduled for {{$appointment_data['firstName']}}  {{$appointment_data['last_name']}}  on {{$appointment_data['appointment_date']}}</h3>
    <p>Please keep the date in mind</p>
    <p>Time:  {{$appointment_data['start_time']}}</p>
    </div>
    </div>
    
    <style>
    .mail_page{
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .mail_card {
    width: 230px;
    border: 1px solid black;
    }
    </style>