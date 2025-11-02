<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AEPSModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'date',
        'aadhar_no',
        'phone',
        'name',
        'amount',
        'bank',
        'apps',
        'image',
        'remarks'
    ];
}
