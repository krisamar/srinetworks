@extends('layouts.header')

@section('title', 'Transaction Index')

@section('content')

    <script>
        function deleteUser(transactions){
            var btnText = 'Delete';
            var btnColor = '#f44336';
            var destroyUrl = "{{ route('certificatedestroy',':transactions') }}".replace(':transactions', transactions);

            Swal.fire({
                title : "Are you sure want to "+ btnText +"?",
                text : "",
                showCancelButton : true,
                icon : "warning",
                confirmButtonText : btnText,
                confirmButtonColor : btnColor,
                cancelButtonText : "Cancel"
            }).then((result) => {
                if(result.isConfirmed){
                    $.ajax({
                        url : destroyUrl,
                        type : 'DELETE',
                        data : {
                            _method : 'DELETE',
                            _token : '{{csrf_token()}}'
                        },
                        success: function(response){
                            Swal.fire({
                            icon: 'success',
                            title: 'The Employee Details deleted successfully',
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            timer: 1500,
                            timerProgressBar: true
                        }).then(() => {
                            location.reload();
                        });

                        },
                        error: function(response){
                            Swal.fire('Error!', 'There was something issue', 'error');
                        }
                    });
                }
            });
        }

        $(document).ready(function() {
            initializeDataTable('#transaction-table', {
                scrollY: '520px',
                order: [[1, 'desc']]  
            });
        });



    $(document).ready(function () {
    let isEdit = false;
    let transactionId = null;

    // OPEN EDIT MODAL WITH DATA
    $('.edit-btn').on('click', function () {
        transactionId = $(this).data('id');
        isEdit = true;

        $.ajax({
            url: `/certificate/${transactionId}/edit`,
            method: 'GET',
            success: function (data) {
                $('#certificateModal').modal('show');
                $('#certificateForm')[0].reset();
                $('#transaction_id').val(data.id);
                $('input[name="date"]').val(data.date);
                $('input[name="name"]').val(data.name);
                $('input[name="certificate"]').val(data.certificate);
                $('input[name="certificate_number"]').val(data.certificate_number);
                $('select[name="status"]').val(data.status);
                $('.modal-footer .btn-primary').hide();  // Hide submit
                $('.modal-footer .btn-success').show();  // Show update
            },
            error: function () {
                alert('Failed to load transaction data');
            }
        });
    });

    // FORM SUBMIT
    $('#certificateForm').on('submit', function (e) {
        e.preventDefault();
        $('#certificateForm .text-danger').remove();
        $('#certificateForm .form-control').removeClass('is-invalid');

        let isValid = true;
        const validations = [
            { name: 'certificate', label: 'Certificate Name'},
            { name: 'certificate_number', label: 'Certificate Number', type: 'numeric' },
        ];

        validations.forEach((field) => {
            const input = $(`[name="${field.name}"]`);
            const value = input.val().trim();

            if (!value) {
                isValid = false;
                input.addClass('is-invalid');
                input.after(`<div class="text-danger">Please enter ${field.label}</div>`);
            } else if (field.type === 'numeric' && !/^\d+$/.test(value)) {
                isValid = false;
                input.addClass('is-invalid');
                input.after(`<div class="text-danger">${field.label} must be numeric</div>`);
            } else if (field.isSelect && value === '') {
                isValid = false;
                input.addClass('is-invalid');
                input.after(`<div class="text-danger">Please select an ${field.label}</div>`);
            }
        });

        if (!isValid) return;

        let Routeurl = "{{ route('certificatestore') }}";
        let method = "POST";

        if (isEdit && transactionId) {
            Routeurl = "{{ route('certificateupdate', ':id') }}".replace(':id', transactionId);
            method = "POST"; // Always POST, with _method=PUT for Laravel
        }

        let formData = {
            date: $('input[name="date"]').val(),
            name: $('input[name="name"]').val(),
            certificate: $('input[name="certificate"]').val(),
            certificate_number: $('input[name="certificate_number"]').val(),
            status: $('select[name="status"]').val(),
            is_application: 1,
            _token: '{{ csrf_token() }}'
        };

        if (isEdit) {
            formData._method = 'PUT';
        }

        $.ajax({
            url: Routeurl,
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            success: function (response) {
                $('#certificateModal').modal('hide');
                $('#certificateForm')[0].reset();
                location.reload();
            },
            error: function () {
                alert('Something went wrong!');
            }
        });
    });

    // RESET MODAL ON OPEN FOR ADD
    $('[data-bs-target="#certificateModal"]').on('click', function () {
        isEdit = false;
        transactionId = null;
        $('#certificateForm')[0].reset();
        let today = new Date().toISOString().split('T')[0];
        $('input[name="date"]').val(today);

        // Default status = Pending (1)
        $('select[name="status"]').val(1);

        $('#certificateForm .text-danger').remove();
        $('#certificateForm .form-control').removeClass('is-invalid');

        $('.modal-footer .btn-success').hide();
        $('.modal-footer .btn-primary').show();
    });

    // RESET on modal close
    $('#certificateModal').on('hidden.bs.modal', function () {
        isEdit = false;
        transactionId = null;
        $('#certificateForm')[0].reset();
        $('#certificateForm .text-danger').remove();
        $('#certificateForm .form-control').removeClass('is-invalid');
        $('.modal-footer .btn-success').hide();
        $('.modal-footer .btn-primary').show();
    });
});

    </script>

    <div class="container-fluid">
        <form action="route('certificateedit', ['transaction' => $transaction->id])" method="post">
            @csrf
            @method('put')
            <input type="hidden" name="transaction_id" id="transaction_id">

                <h1>Certificate Details</h1>
          
        <div class="row">
            <div class="col-sm-12">
                <a class="btn btn-success float-end" href="#" data-bs-toggle="modal" data-bs-target="#certificateModal">Add Certificate</a>
                <!-- <a href="{{ route('download') }}" class="btn btn-success float-end">Download PDF</a> -->
            </div>
        </div>
        
        <div class="col-sm-12 mt-3">
            <table class="table table-bordered text-wrap table-hover transaction-table" id="transaction-table">
                <thead>
                    <tr class="text-center">
                        <th class="text-center">SNo</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Customer Name</th>
                        <th class="text-center">Certificate Name</th>
                        <th class="text-center">Certificate Number</th>
                        <th class="text-center">Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1;  @endphp
                    @foreach($transaction as $transactions)
                    <tr>
                        <td class="text-center">{{ $i++ }}</td>
                        <td class="text-center">{{ date('d-m-Y', strtotime($transactions->date)) }}</td>
                        <td class="text-center">{{ $transactions->name }}</td>
                        <td class="text-center">{{ $transactions->certificate }}  </td>
                        <td>
                            {{$transactions->certificate_number}}
                            <!-- <a href="{{route('atm.show',['transaction'=>$transactions])}}">{{$transactions->name}}</a> -->
                        </td>
                        <td class="text-center">
                            @if($transactions->status == 1)
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($transactions->status == 2)
                                <span class="badge bg-success">Approved</span>
                            @elseif($transactions->status == 3)
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>

                        <td>
    <a href="#" 
       class="edit-btn bg-info p-2 text-white text-decoration-none me-2" 
       data-id="{{ $transactions->id }}">
        <i class="fas fa-edit text-white"></i>
    </a>

    <span class="bg-danger p-2">
        <i class="fa fa-trash text-white" onclick="deleteUser('{{ $transactions->id }}')"></i>
    </span>
</td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </form>
    </div>
    <!-- Certificate Modal -->
<div class="modal fade" id="certificateModal" tabindex="-1" aria-labelledby="certificateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="certificateForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Certificate Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="date" name="date" class="form-control mb-2" placeholder="Date" >
          <input type="text" name="name" class="form-control mb-2" placeholder="Customer Name" >
          <input type="text" name="certificate" class="form-control mb-2" placeholder="Certificate Name" >
          <input type="text" name="certificate_number" class="form-control mb-2" placeholder="Certificate Number" >
            <select name="status" class="form-control mb-2">
                <option value="1">Pending</option>
                <option value="2">Approved</option>
                <option value="3">Rejected</option>
            </select>
        </div>
        <div class="modal-footer text-center">
          <button type="submit" class="btn btn-primary text-center">Submit</button>
          <button type="submit" class="btn btn-success text-center" style="display:none;">Update</button>

        </div>
      </div>
    </form>
  </div>
</div>

@endsection