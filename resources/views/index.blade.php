@extends('layouts.header')

@section('title', 'Employee Index')

@section('content')
<script>
     $(document).ready(function() {
        initializeDataTable('#employee-table', {
            scrollY: '520px',
            order: [[1, 'desc']]  
        });
    });
</script>
<div class="container-fluid">
    <h1>Employee Details</h1>
    <div class="row">
        <div class="col-sm-12">
            <a href="{{ route('create') }}" class="btn btn-success float-end">Add User</a>
        </div>
    </div>
    <div class="col-sm-12 mt-3">
        <table class="table table-bordered text-wrap table-hover employee-table" id="employee-table">
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Picture</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>City</th>
                    <th>Salary</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employee as $employees)
                    <tr>
                        <td>{{ $employees->empid }}</td>
                        <td>
                            <img src="images/{{ $employees->image }}" alt="profile"
                                style="height: 50px; width: 50px; object-fit:contain">
                        </td>
                        <td>
                            <a href="{{ route('show', ['employee' => $employees]) }}">{{ $employees->name }}</a>
                        </td>
                        <td>{{ $employees->email }}</td>
                        @php $roleName = config('const.role'); @endphp
                        <td>{{ $roleName[$employees->role] ?? 'Unknown' }}</td>
                        <td>{{ $employees->city }}</td>
                        <td>{{ $employees->Salary }}</td>
                        <td>
                            <button class="btn btn-danger" onclick="deleteUser('{{ $employees->id }}')">
                                <i class="fa fa-trash"></i>
                            </button>
                            <a href="{{ route('edit', ['employee' => $employees]) }}" class="btn btn-info ml-2 text-white">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function deleteUser(employee) {
        var destroyUrl = "{{ route('destroy', ':employee') }}".replace(':employee', employee);

        Swal.fire({
            title: "Are you sure you want to delete?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Delete",
            confirmButtonColor: "#f44336",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: destroyUrl,
                    type: 'DELETE',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        Swal.fire('Deleted!', 'The employee has been deleted.', 'success');
                        location.reload();
                    },
                    error: function (response) {
                        Swal.fire('Error!', 'There was an issue.', 'error');
                    }
                });
            }
        });
    }
</script>
@endsection
