<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicalnote extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id',
        'notes',
        'next_review_date',
        'diagnosis',
        'prescription',
        'appointment_id',
        'user_id',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
