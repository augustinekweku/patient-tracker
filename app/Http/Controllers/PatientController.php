<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
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
        return Patient::orderBy('id', 'desc')->get();
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
}
