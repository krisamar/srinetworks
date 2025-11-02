@extends('layouts.header')

@section('title', 'Employee Index')

@section('content')

<style>
    /* 🧭 Page Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        border-bottom: 3px solid #0078d7;
        padding-bottom: 0.5rem;
    }

    .page-header h1 {
        font-weight: 600;
        color: #004aad;
        font-size: 1.8rem;
    }

    .btn-success {
        background: linear-gradient(90deg, #198754, #22b573);
        border: none;
        transition: 0.3s;
    }

    .btn-success:hover {
        background: linear-gradient(90deg, #22b573, #198754);
        transform: translateY(-2px);
    }

    /* 📊 Table Style */
    .dataTables_wrapper .dataTables_filter input {
        border-radius: 6px;
        border: 1px solid #ccc;
        padding: 5px 10px;
    }

    .table thead {
        background: #004aad;
        color: #fff;
    }

    .table tbody tr:hover {
        background-color: #f2f9ff;
    }

    .table td, .table th {
        vertical-align: middle !important;
        text-align: center;
    }

    .btn {
        border-radius: 6px;
    }

    .btn-info {
        background-color: #0078d7;
        border: none;
    }

    .btn-info:hover {
        background-color: #005fa3;
    }

    .btn-danger {
        background-color: #dc3545;
        border: none;
    }

    .btn-danger:hover {
        background-color: #b71c1c;
    }

    /* 📦 Card Container */
    .card {
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        border-radius: 10px;
    }

    /* ⚙️ Footer */
    footer {
        text-align: center;
        padding: 15px;
        background: #f1f1f1;
        border-top: 2px solid #0078d7;
        margin-top: 40px;
        color: #555;
        font-size: 0.9rem;
    }

</style>

<script>
    $(document).ready(function() {
        initializeDataTable('#employee-table', {
            scrollY: '520px',
            order: [[1, 'desc']],
            responsive: true
        });
    });
</script>

<div class="container-fluid mt-4">

    {{-- 🌟 PAGE HEADER --}}
    <div class="page-header">
        <h1><i class="fa-solid fa-users me-2"></i> Employee Management</h1>
        <a href="{{ route('create') }}" class="btn btn-success shadow-sm">
            <i class="fa-solid fa-user-plus me-1"></i> Add Employee
        </a>
    </div>

    {{-- 📋 EMPLOYEE TABLE --}}
    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-bordered align-middle text-center" id="employee-table" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
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
                                <img src="{{ asset('images/' . $employees->image) }}" 
                                     alt="profile" class="rounded-circle"
                                     style="height: 50px; width: 50px; object-fit: cover;">
                            </td>
                            <td>
                                <a href="{{ route('show', ['employee' => $employees]) }}" 
                                   class="fw-semibold text-primary text-decoration-none">
                                   {{ $employees->name }}
                                </a>
                            </td>
                            <td>{{ $employees->email }}</td>
                            @php $roleName = config('const.role'); @endphp
                            <td>{{ $roleName[$employees->role] ?? 'Unknown' }}</td>
                            <td>{{ $employees->city }}</td>
                            <td>₹ {{ number_format($employees->Salary, 2) }}</td>
                            <td>
                                <a href="{{ route('edit', ['employee' => $employees]) }}" 
                                   class="btn btn-info btn-sm me-1 text-white">
                                   <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-danger btn-sm" 
                                        onclick="deleteUser('{{ $employees->id }}')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- 🌟 FOOTER --}}
<footer>
    © {{ date('Y') }} Sri Networks. All rights reserved.
</footer>

<script>
    function deleteUser(employee) {
        var destroyUrl = "{{ route('destroy', ':employee') }}".replace(':employee', employee);

        Swal.fire({
            title: "Are you sure?",
            text: "This employee record will be permanently deleted!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: destroyUrl,
                    type: 'DELETE',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function () {
                        Swal.fire('Deleted!', 'Employee record removed.', 'success');
                        setTimeout(() => location.reload(), 1000);
                    },
                    error: function () {
                        Swal.fire('Error!', 'Something went wrong.', 'error');
                    }
                });
            }
        });
    }
</script>

@endsection
