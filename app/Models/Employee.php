<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'empid',
        'name',
        'email',
        'mobile',
        'role',
        'salary',
        'city',
        'image'
    ];

    public static function boot(){
        parent::boot();

        static::creating(function($employee){
            $lastEmployee = self::orderBy('empid','desc')->first();
            $newEmp = $lastEmployee ? (int)substr($lastEmployee->empid,3) : 100;
            $employee->empid = 'EMP'.($newEmp+1);
        });
    }

    public static function getEmployeeData($email){
        $query = DB::table('users')->where('email', $email)->first();

        return $query;
    }

}
