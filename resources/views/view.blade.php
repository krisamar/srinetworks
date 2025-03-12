@extends('layouts.header')

@section('title', 'Employee View')

@section('content')
    <div class="container-fluid">
        <h1>Employee View</h1>
        <div class="col-sm-12 d-flex justify-content-between">
            <a href="{{route('index')}}" class="btn btn-primary"><i class="fa-solid fas fa-arrow-left"></i> Back</a>
        </div>
        <div class="row mt-3">
            <div class="col-sm-12 d-flex justify-content-between">
                <table class="table table-bordered text-wrap table-striped">
                    <tbody>
                        <tr>
                            <td>Employee ID</td>
                            <td>{{$employee->empid}}</td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>{{$employee->name}}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{$employee->email}}</td>
                        </tr>
                        <tr>
                            <td>Mobile</td>
                            <td>{{$employee->mobile}}</td>
                        </tr>
                        <tr>
                            <td>Role</td>
                            <td>{{ config('const.role')[$employee->role]??'Unknown'}}</td>
                        </tr>
                        <tr>
                            <td>Salary</td>
                            <td>{{$employee->Salary}}</td>
                        </tr>
                        <tr>
                            <td>City</td>
                            <td>{{$employee->city}}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="row col-sm-2">
                    <img src="{{asset('images/'.$employee->image)}}" alt="image" style="height: 150px; width: 150px; object-fit:contain;margin-left: 20px;">
                </div>
            </div>
        </div>
    </div>

@endsection