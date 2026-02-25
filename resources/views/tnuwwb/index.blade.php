@extends('layouts.header')

@section('title', 'TNUWWB Index')

@section('content')
<script>

$(document).ready(function () {

    // Initialize DataTables
    var table = $('#tnuwwb-table').DataTable({
        scrollY: '520px',
        order: [],
        pageLength: 25,
        columnDefs: [
        { targets: 0, width: '50px', orderable: false, searchable: false, className: "text-center" },
        { targets: 1, width: '100px', orderable: true, searchable: true, className: "text-center" },
        { targets: 2, width: '150px', orderable: true, searchable: true, className: "text-primary fw-bold text-center" },
        { targets: 3, width: '120px', orderable: true, searchable: true, className: "text-center" },
        { targets: 4, width: '200px', orderable: true, searchable: true, className: "text-start" },
        { targets: 5, width: '80px', orderable: true, searchable: true, className: "text-center" },
        { targets: 6, width: '100px', orderable: true, searchable: true, className: "text-center" },
        { targets: 7, width: '100px', orderable: true, searchable: true, className: "text-center" },
        { targets: 8, width: '120px', orderable: true, searchable: true, className: "text-center" },
        { targets: 9, width: '250px', orderable: true, searchable: true, className: "text-start text-wrap" },
        { targets: 10, width: '150px', orderable: false, searchable: false, className: "text-center" }
    ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records...",
            paginate: {
                first: "<<",
                last: ">>",
                next: ">",
                previous: "<"
            }
        }
    });

    // 🔹 Custom filter for Status column (handles badge text)
    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        var selectedStatus = $('#statusFilter').val();
        var statusText = $(table.row(dataIndex).node()).find('td:eq(6)').text().trim();
        return (selectedStatus === '' || statusText === selectedStatus);
    });

    // 🔹 Status dropdown change event
    $('#statusFilter').on('change', function () {
        table.draw();
    });
});



    function deleteDetails(data) {
        var destroyUrl = "{{ route('tnuwwb.destroy', ':data') }}".replace(':data', data);

        Swal.fire({
            title: "Are you sure?",
            text: "This record will be permanently deleted.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Delete",
            confirmButtonColor: "#e74c3c",
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
                    success: function(response) {
                        Swal.fire('Deleted!', 'Record deleted successfully.', 'success');
                        location.reload();
                    },
                    error: function() {
                        Swal.fire('Error!', 'Something went wrong.', 'error');
                    }
                });
            }
        });
    }

    // 🔹 Change Status via AJAX
$(document).on('change', '.status-change', function () {

    let id = $(this).data('id');
    let status = $(this).val();

    $.ajax({
        url: "/tnuwwb/update-status/" + id,
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            status: status
        },
        success: function (response) {
            Swal.fire({
                icon: 'success',
                title: 'Updated!',
                text: 'Status updated successfully.',
                timer: 1500,
                showConfirmButton: false
            });
        },
        error: function () {
            Swal.fire('Error!', 'Something went wrong.', 'error');
        }
    });
});
</script>

<style>
/* 🌟 Modern Page Header */
.page-header {
    background: linear-gradient(90deg, #004aad, #0078d7);
    color: #fff;
    padding: 1.2rem 1.5rem;
    border-radius: 10px;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
}

.page-header h3 {
    font-weight: 600;
    letter-spacing: 0.5px;
    margin: 0;
}

.page-header .btn-group .btn {
    margin-left: 0.5rem;
    border-radius: 6px;
}

/* 📋 Table Styling */
.table-container {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
    padding: 1rem;
}

.table thead th {
    background: #004aad;
    color: #fff;
    text-align: center;
    vertical-align: middle;
    font-size: 0.9rem;
}

.table tbody td {
    text-align: center;
    vertical-align: middle;
    font-size: 0.9rem;
}

.table-hover tbody tr:hover {
    background-color: #f1f5ff;
    transition: 0.3s;
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: #fafbff;
}

.action-btns .btn {
    margin: 0 3px;
    padding: 5px 8px;
    border-radius: 6px;
}

.action-btns .btn i {
    font-size: 0.85rem;
}

/* 📱 Responsive Layout */
@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        text-align: center;
    }
    .page-header .btn-group {
        margin-top: 10px;
    }
}

/* ✨ Hover Effects */
.btn:hover {
    opacity: 0.9;
    transform: scale(1.03);
    transition: all 0.2s ease-in-out;
}

/* 🧊 Card Animation */
.card {
    border: none;
    border-radius: 10px;
    backdrop-filter: blur(6px);
    background-color: rgba(255, 255, 255, 0.9);
}

.badge {
    font-size: 0.8rem;
    padding: 0.5em 0.8em;
    letter-spacing: 0.3px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

</style>

<div class="container-fluid mt-4">
    <!-- 🔹 Header -->
    <div class="page-header mb-4">
        <h3><i class="fas fa-clipboard-list me-2"></i> TNUWWB Application Details</h3>
        <div class="btn-group">
            <a href="{{ route('dashboard') }}" class="btn btn-light text-dark">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <a href="https://tnuwwb.tn.gov.in/applications/status" class="btn btn-warning text-dark" target="_blank">
                <i class="fas fa-search me-1"></i> Check Status
            </a>
            <a href="{{ route('tnuwwb.create') }}" class="btn btn-success">
                <i class="fas fa-plus-circle me-1"></i> Add New
            </a>
        </div>
    </div>

    <div class="d-flex justify-content-end align-items-center mb-3">
    <div class="me-2 fw-semibold text-primary">
        <i class="fas fa-filter me-1"></i> Filter by Status:
    </div>
    <select id="statusFilter" class="form-select form-select-sm w-auto">
        <option value="">All</option>
        @foreach(config('const.status') as $key => $value)
            <option value="{{ $value }}">{{ $value }}</option>
        @endforeach
    </select>
</div>


    <!-- 🔹 Data Table -->
    <div class="card shadow-sm">
        <div class="card-body table-container">
            <table class="table table-bordered table-hover table-striped align-middle" id="tnuwwb-table" width="100%">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Date</th>
                        <th>Application No</th>
                        <th>Mobile</th>
                        <th>Name</th>
                        <th>Paid</th>
                        <th>Status</th>
                        <th>ID No</th>
                        <th>Type</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach($data as $datas)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ \Carbon\Carbon::parse($datas['date'])->format('d-m-Y') }}</td>
                            <td>
                                <!-- <a href="{{ route('tnuwwb.show', ['data' => $datas]) }}" class="fw-bold text-primary text-decoration-none">
                                    {{ $datas->application_no }}
                                </a> -->
                                {{ $datas->application_no }}
                            </td>
                            <td>{{ $datas['mobile'] }}</td>
                            <td>{{ $datas['name'] }}</td>

                            @php $app = config('const.paid_details'); @endphp
                            <td>{{ $app[$datas->paid] ?? 'Unknown' }}</td>

                            @php
                                $apps = config('const.status');
                                $statusText = $apps[$datas->status] ?? 'Unknown';

                                // Assign badge colors based on status
                                switch ($datas->status) {
                                    case 1:
                                        $badgeClass = 'bg-warning text-dark'; // Pending - yellow
                                        break;
                                    case 2:
                                        $badgeClass = 'bg-danger'; // Return - red
                                        break;
                                    case 3:
                                        $badgeClass = 'bg-success'; // Success - green
                                        break;
                                    case 4:
                                        $badgeClass = 'bg-secondary'; // Others - gray
                                        break;
                                    default:
                                        $badgeClass = 'bg-light text-dark'; // Unknown
                                }
                            @endphp

                            <td>
                                <select class="form-select form-select-sm status-change"
                                        data-id="{{ $datas->id }}">
                                    @foreach(config('const.status') as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ $datas->status == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>


                            <td>{{ $datas['id_no'] }}</td>

                            @php $tent = config('const.type'); @endphp
                            <td>{{ $tent[$datas->type] ?? 'Unknown' }}</td>
                            <td>{{ $datas['remarks'] }}</td>

                            <td class="action-btns">
                                <a href="{{ route('tnuwwb.edit', ['data' => $datas]) }}" class="btn btn-sm btn-info text-white" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger text-white" title="Delete"
                                        onclick="deleteDetails('{{ $datas->id }}')">
                                    <i class="fa fa-trash"></i>
                                </button>
                                <a href="{{ route('tnuwwb.pdf', $datas->id) }}" class="btn btn-sm btn-warning text-white" target="_blank" title="Download PDF">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
