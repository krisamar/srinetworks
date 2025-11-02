@extends('layouts.header')

@section('title', 'Employee Create')

@section('content')
    <style>
        .input-group-text {
            height: calc(1.5em + 0.75rem + 2px); /* Match input size */
            display: flex;
            align-items: center;
        }

        .breadcrumb-item a {
            text-decoration: none;
        }

        .breadcrumb-item .active {
            color: #6c757d; /* Bootstrap default breadcrumb active color */
            pointer-events: none;
        }
    </style>

    <div class="wrapper">
        <div class="wrapper">
            <div class="wrapper-content">
                <div class="container-fluid">
                    <h1>Register Employee</h1>
                    <div class="col-sm-12 d-flex justify-content-between">
                        <a href="{{route('index')}}" class="btn btn-primary"><i class="fa-solid fas fa-arrow-left"></i>Back</a>
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{route('index')}}">List</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Register</a>
                            </li>
                        </ol>
                    </div>
                    <form action="{{route('store')}}" method="POST" enctype="multipart/form-data">
                        @csrf 
                        <div class="col-md-12 mt-2">
                            <div class="row">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="fields-group">
                                            <div class="form-group row mt-2">
                                                <label for="name" class="col-form-label col-sm-2">Name</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <div class="input-group-pretend">
                                                            <span class="input-group-text bg-secondary"><i class="fas fa-pencil-alt"></i></span>
                                                        </div>
                                                        <input type="text" name="name" class="form-control input-sm" placeholder="Name">
                                                    </div>
                                                    @if($errors->has('name'))
                                                        <span class="form-text form-danger fwb">
                                                            <i class="fa-solid fa-info-circle"></i>{{$errors->first('name')}}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row mt-2">
                                                <label for="email" class="col-form-label col-sm-2">Email</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <div class="input-group-pretend">
                                                            <span class="input-group-text bg-secondary"><i class="fas fa-pencil-alt"></i></span>
                                                        </div>
                                                        <input type="text" name="email" class="form-control input-sm" placeholder="Email">
                                                    </div>
                                                    @if($errors->has('email'))
                                                        <span class="form-text form-danger fwb">
                                                            <i class="fa-solid fa-info-circle"></i>{{$errors->first('email')}}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row mt-2">
                                                <label for="mobile" class="col-form-label col-sm-2">Mobile</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <div class="input-group-pretend">
                                                            <span class="input-group-text bg-secondary"><i class="fas fa-pencil-alt"></i></span>
                                                        </div>
                                                        <input type="text" name="mobile" class="form-control input-sm" placeholder="Mobile">
                                                    </div>
                                                    @if($errors->has('mobile'))
                                                        <span class="form-text form-danger fwb">
                                                            <i class="fa-solid fa-info-circle"></i>{{$errors->first('mobile')}}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            @php $role = config('const.role'); @endphp
                                            <div class="form-group row mt-2">
                                                <label for="role" class="col-form-label col-sm-2">Role</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <div class="input-group-pretend">
                                                            <span class="input-group-text bg-secondary"><i class="fas fa-pencil-alt"></i></span>
                                                        </div>
                                                        <select name="role" id="role" class="form-control input-sm">
                                                            <option value="">Select a Role</option>
                                                            @foreach($role as $key => $value)
                                                            <option value="{{$key}}" {{ old('role', $employee->role ?? '') == $key ? 'selected' : '' }}>{{$value}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @if($errors->has('role'))
                                                        <span class="form-text form-danger fwb">
                                                            <i class="fa-solid fa-info-circle"></i>{{$errors->first('role')}}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row mt-2">
                                                <label for="salary" class="col-form-label col-sm-2">Salary</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <div class="input-group-pretend">
                                                            <span class="input-group-text bg-secondary"><i class="fas fa-pencil-alt"></i></span>
                                                        </div>
                                                        <input type="text" name="salary" class="form-control input-sm" placeholder="Salary">
                                                    </div>
                                                    @if($errors->has('salary'))
                                                        <span class="form-text form-danger fwb">
                                                            <i class="fa-solid fa-info-circle"></i>{{$errors->first('salary')}}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row mt-2">
                                                <label for="city" class="col-form-label col-sm-2">City</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <div class="input-group-pretend">
                                                            <span class="input-group-text bg-secondary"><i class="fas fa-pencil-alt"></i></span>
                                                        </div>
                                                        <input type="text" name="city" class="form-control input-sm"  placeholder="City">
                                                    </div>
                                                    @if($errors->has('city'))
                                                        <span class="form-text form-danger fwb">
                                                            <i class="fa-solid fa-info-circle"></i>{{$errors->first('city')}}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row mt-2">
                                                <label for="password" class="col-form-label col-sm-2">Password</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <div class="input-group-pretend">
                                                            <span class="input-group-text bg-secondary"><i class="fas fa-pencil-alt"></i></span>
                                                        </div>
                                                        <input type="password" name="password" class="form-control input-sm" placeholder="Password">
                                                    </div>
                                                    @if($errors->has('password'))
                                                        <span class="form-text form-danger fwb">
                                                            <i class="fa-solid fa-info-circle"></i>{{$errors->first('password')}}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row mt-2">
                                                <label for="image" class="col-form-label col-sm-2">Image</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <div class="input-group-pretend">
                                                            <span class="input-group-text bg-secondary"><i class="fas fa-pencil-alt"></i></span>
                                                        </div>
                                                        <input type="file" name="image[]" multiple class="form-control input-sm" placeholder="Image" >
                                                    </div>
                                                    @if($errors->has('image'))
                                                        <span class="form-text form-danger fwb">
                                                            <i class="fa-solid fa-info-circle"></i>{{$errors->first('image')}}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="card-footer mt-3">
                                                <div class="col-sm-12 mt-3 text-center">
                                                    <div class="btn-group">
                                                        <input type="submit" class="btn btn-success" value="Submit">
                                                    </div>
                                                    <div class="btn-group">
                                                        <input type="reset" class="btn btn-danger" value="Reset">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection