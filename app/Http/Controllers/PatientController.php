<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\appointment;
use App\Models\Medicalnote;
use Illuminate\Http\Request;
use App\Models\ClinicProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentEmail;

class PatientController extends Controller
{
    public function addMedicalNotes(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'appointment_id' => 'required',
            'notes' => 'required',
            'patient_name' => 'required',
            'patient_id' => 'required',
            'prescription' => 'required',
            'diagnosis' => 'required',
        ]);

        $medicalnotes = Medicalnote::create([
            'appointment_id' => $request->appointment_id,
            'patient_id' => $request->patient_id,
            'notes' => $request->notes,
            'patient_name' => $request->patient_name,
            'next_review_date' => $request->next_review_date,
            'prescription' => $request->prescription,
            'diagnosis' => $request->diagnosis,
            'user_id' => $user->id,
        ]);

        $medicalnotes->save();
        appointment::where('id', $request->appointment_id)->update([
            'status' => 'finished',
        ]);
        DB::commit();


    }
    public function addAppointment(Request $request)
    {
        $user = Auth::user();
        //validate request
        //validate request
        $this->validate($request, [
            'patient_id' => 'required',
            'notes' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'date' => 'required',
        ]);

        $appointment = appointment::create([
            'patient_id' => $request->patient_id,
            'notes' => $request->notes,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'date' => $request->date,
            'user_id' => $user->id,
        ]);
        $patient = Patient::where('id', $request->patient_id)->get();
        $appointment_mail = [];
        array_push($appointment_mail, ['firstName' => $patient[0]->first_name, 'last_name' => $patient[0]->last_name, 'start_time' => $request->start_time, 'appointment_date' => $request->date]);
        //return $appointment_mail;
        Mail::to($patient[0]->email)->send( new AppointmentEmail($appointment_mail[0]));
        return $appointment;

        
    }
    public function deletePatient(Request $request)
    {
        //validate request
        $this->validate($request, [
            'id' => 'required'
        ]);
        return Patient::where('id', $request->id)->delete();
    }
    public function getPatients(Request $request)
    {
        $patientsCount = Patient::orderBy('id', 'asc')->count();
        $patients =  Patient::orderBy('id', 'desc')->get();
        return response()->json(['patientsCount' => $patientsCount,
                                'patients' => $patients
                                ]);
    }

    public function editPatient(Request $request)
    {
        $this->validate($request, [
            'first_name' =>'required',
            'last_name' =>'required',
            'address' =>'required',
            'age' =>'required',
            'gender' =>'required',
            'email' =>"bail|required|email|unique:patients,email,$request->id",
            'phone' =>"bail|required|unique:patients,phone,$request->id",
        ]);
        return Patient::where('id', $request->id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'age' => $request->age,
            'gender' => $request->gender,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
    
    }

    public function addPatient(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'first_name' =>'required',
            'last_name' =>'required',
            'address' =>'required',
            'age' =>'required',
            'gender' =>'required',
            'email' =>'bail|email|unique:patients',
            'phone' =>'required|unique:patients',
        ]);
        $user = Patient::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'address' => $request->address,
            'age' => $request->age,
            'phone' => $request->phone,
            'patient_id' => $request->patient_id,
            'gender' => $request->gender,
            'user_id' => $user->id,
        ]);
    
    return $user;
    }

    public function getAppointments(Request $request)
    {
        $appointmentsCount = Appointment::where('status', 'unfinished')->count();
        $appointments = Appointment::with('patient')->where('status', 'unfinished')->orderBy('date', 'asc')->get();
        return response()->json(['appointmentsCount' => $appointmentsCount,
                                'appointments' => $appointments
                                ]);

    }
    public function getAllAppointments(Request $request)
    {
        $allAppointmentsCount = Appointment::orderBy('id', 'desc')->count();
        $allAppointments = Appointment::with('patient')->orderBy('date', 'asc')->get();
        return response()->json(['allAppointmentsCount' => $allAppointmentsCount,
                                'allAppointments' => $allAppointments
                                ]);

    }
    public function addClinicProfile(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'clinic_name' =>'required',
            'country' =>'required',
            'address' =>'required',
            'city' =>'required',
            'phone' =>'required'
        ]);
        $ProfilesCount = ClinicProfile::where('user_id', $user->id)->count();
        $clinicProfile = ClinicProfile::create([
            'clinic_name' => $request->clinic_name,
            'country' => $request->country,
            'address' => $request->address,
            'city' => $request->city,
            'phone' => $request->phone,
            'user_id' => $user->id,
        ]);
        return $clinicProfile;
    }
    
    public function getClinicProfile()
    {
        $user = Auth::user();
        $getProfile = ClinicProfile::where('user_id', $user->id)->get();
        return $getProfile;
    }
    
    public function updateClinicProfile(Request $request)
    {
        $this->validate($request, [
            'clinic_name' =>'required',
            'country' =>'required',
            'address' =>'required',
            'city' =>'required',
            'phone' =>'required'
        ]);
        
        $updateProfile =  ClinicProfile::where('id', $request->id)->update([
            'clinic_name' => $request->clinic_name,
            'country' => $request->country,
            'address' => $request->address,
            'city' => $request->city,
            'phone' => $request->phone,
        ]);
        return $updateProfile;
    }
    public function getAllMedicalNotes(Request $request)
    {
        $allMedicalNotes = Medicalnote::with('patient')->orderBy('id', 'desc')->get();
        return $allMedicalNotes;
    
    }



}
