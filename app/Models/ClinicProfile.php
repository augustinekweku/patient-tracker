<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicProfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'clinic_name',
        'address',
        'country',
        'phone',
        'email',
        'city',
        'user_id',
    ];
}
