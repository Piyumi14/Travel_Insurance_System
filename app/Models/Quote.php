<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'destination',
        'start_date',
        'end_date',
        'medical_expenses',
        'trip_cancellation',
        'number_of_travelers',
        'total_price',
    ];
}

