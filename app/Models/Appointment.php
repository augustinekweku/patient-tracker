<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id',
        'notes',
        'start_time',
        'end_time',
        'date',
        'user_id',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
