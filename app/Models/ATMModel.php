<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Pagination\Paginator;

class ATMModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'date',
        'method',
        'mobile_number',
        'acc_no',
        'ifsc',
        'name',
        'amount',
        'via_app',
        'via_bank',
        'sender_name',
        'sender_mobile',
        'remarks',
        'images'
    ];
    protected static function boot()
    {
        parent::boot(); // ✅ Call the parent boot method
        Paginator::useBootstrap(); // ✅ Enables Bootstrap pagination styles
    }

}
