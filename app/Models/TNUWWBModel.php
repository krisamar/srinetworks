<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TNUWWBModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'date',
        'application_no',
        'mobile',
        'name',
        'paid',
        'status',
        'id_no',
        'type',
        'remarks',
        'created_at',
        'updated_at'
    ];
}
