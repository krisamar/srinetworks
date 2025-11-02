@extends('layouts.header')

@section('title', 'Employee View')

@section('content')
<script>
    function deleteImage(employeeId, index) {
        let destroyUrl = `/employee/${employeeId}/image/${index}`;

        $.ajax({
            url: destroyUrl,
            type: 'POST', // Laravel only supports GET & POST natively
            data: {
                _method: 'DELETE',
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                Swal.fire('Deleted!', 'Image deleted successfully.', 'success').then(() => {
                    location.reload(); // or remove the image from DOM instead of reloading
                });
            },
            error: function(error) {
                Swal.fire('Error!', 'Something went wrong.', 'error');
            }
        });
    }
</script>
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
                        <tr>
                            <td>Documents</td>
                            <td>
                            @foreach($employee->image as $key => $img)
                                                            
                                                                <div class="row col-md-12">
                                                                    <img src="{{ asset($img['image']) }}" alt="image"
                                                                        style="height: 150px; width: 150px; object-fit:contain; margin-left: 20px;">
                                                                </div>
                                                                <a href="#" class="btn btn-danger" onclick="deleteImage({{ $employee->id }}, {{$key}})">Delete</a>
                                                            
                                                    @endforeach
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection