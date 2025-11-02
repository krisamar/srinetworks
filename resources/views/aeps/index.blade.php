@extends('layouts.header')

@section('title', 'Transaction Index')

@section('content')

    <script>
        function deleteUser(transactions){
            var btnText = 'Delete';
            var btnColor = '#f44336';
            var destroyUrl = "{{ route('aepsdestroy',':transactions') }}".replace(':transactions', transactions);

            Swal.fire({
                title : "Are you sure want to"+ btnText +"?",
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
                            Swal.fire('Deleted!', 'The Employee Details deleted successfully','success');
                            location.reload();
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
            url: `/aeps/${transactionId}/edit`,
            method: 'GET',
            success: function (data) {
                $('#aepsModal').modal('show');
                $('#aepsForm')[0].reset();
                $('#transaction_id').val(data.id);
                $('input[name="aadhar_no"]').val(data.aadhar_no);
                $('input[name="phone"]').val(data.phone);
                $('input[name="name"]').val(data.name);
                $('input[name="amount"]').val(data.amount);
                $('input[name="bank"]').val(data.bank);
                $('select[name="apps"]').val(data.apps);
                $('.modal-footer .btn-primary').hide();  // Hide submit
                $('.modal-footer .btn-success').show();  // Show update
            },
            error: function () {
                alert('Failed to load transaction data');
            }
        });
    });

    // FORM SUBMIT
    $('#aepsForm').on('submit', function (e) {
        e.preventDefault();
        $('#aepsForm .text-danger').remove();
        $('#aepsForm .form-control').removeClass('is-invalid');

        let isValid = true;
        const validations = [
            { name: 'aadhar_no', label: 'Aadhar Number', type: 'numeric' },
            // { name: 'phone', label: 'Phone Number', type: 'numeric' },
            // { name: 'name', label: 'Name' },
            { name: 'amount', label: 'Amount', type: 'numeric' },
            { name: 'bank', label: 'Bank' },
            { name: 'apps', label: 'App', isSelect: true }
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

        let Routeurl = "{{ route('aepsstore') }}";
        let method = "POST";

        if (isEdit && transactionId) {
            Routeurl = "{{ route('aepsupdate', ':id') }}".replace(':id', transactionId);
            method = "POST"; // Always POST, with _method=PUT for Laravel
        }

        let formData = {
            aadhar_no: $('input[name="aadhar_no"]').val(),
            phone: $('input[name="phone"]').val(),
            name: $('input[name="name"]').val(),
            amount: $('input[name="amount"]').val(),
            bank: $('input[name="bank"]').val(),
            apps: $('select[name="apps"]').val(),
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
                $('#aepsModal').modal('hide');
                $('#aepsForm')[0].reset();
                location.reload();
            },
            error: function () {
                alert('Something went wrong!');
            }
        });
    });

    // RESET MODAL ON OPEN FOR ADD
    $('[data-bs-target="#aepsModal"]').on('click', function () {
        isEdit = false;
        transactionId = null;
        $('#aepsForm')[0].reset();
        $('#aepsForm .text-danger').remove();
        $('#aepsForm .form-control').removeClass('is-invalid');
        $('.modal-footer .btn-success').hide();  // Hide update
        $('.modal-footer .btn-primary').show();  // Show submit
    });

    // RESET on modal close
    $('#aepsModal').on('hidden.bs.modal', function () {
        isEdit = false;
        transactionId = null;
        $('#aepsForm')[0].reset();
        $('#aepsForm .text-danger').remove();
        $('#aepsForm .form-control').removeClass('is-invalid');
        $('.modal-footer .btn-success').hide();
        $('.modal-footer .btn-primary').show();
    });
});

    </script>

    <div class="container-fluid">
        <form action="route('aepsedit', ['transaction' => $transaction->id])" method="post">
            @csrf
            @method('put')
            <input type="hidden" name="transaction_id" id="transaction_id">

                <h1>AEPS Details</h1>
          
        <div class="row">
            <div class="col-sm-12">
                <a class="btn btn-success float-end" href="#" data-bs-toggle="modal" data-bs-target="#aepsModal">Add AEPS</a>
                <!-- <a href="{{ route('download') }}" class="btn btn-success float-end">Download PDF</a> -->
            </div>
        </div>
        
        <div class="col-sm-12 mt-3">
            <table class="table table-bordered text-wrap table-hover transaction-table" id="transaction-table">
                <thead>
                    <tr class="text-center">
                        <th class="text-center">SNo</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Mobile</th>
                        <th class="text-center">Aadhar No</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Amount</th>
                        <th class="text-center">Bank</th>
                        <th class="text-center">Apps</th>
                        <!-- <th>Sender Name</th>
                        <th>Sender Mobile</th>
                        <th>Remarks</th> -->
                        <!-- <th>Image</th> -->
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1;  @endphp
                    @foreach($transaction as $transactions)
                    <tr>
                        <td class="text-center">{{ $i++ }}</td>
                        <td class="text-center">{{ date('d-m-Y', strtotime($transactions->date)) }}</td>
                        <td class="text-center">{{ $transactions->phone }}</td>
                        <td class="text-center">{{ $transactions->aadhar_no }}  </td>
                        <td>
                            {{$transactions->name}}
                            <!-- <a href="{{route('atm.show',['transaction'=>$transactions])}}">{{$transactions->name}}</a> -->
                        </td>
                        <td>{{ $transactions->amount }}</td>
                        
                        <td>{{$transactions->bank}}</td>
                        @php $bank = config('const.aeps'); @endphp
                        <td>{{$bank[$transactions->apps] ?? 'Unknown'}}</td>
                        <!-- <td>{{ $transactions->sender_name }}</td>
                        <td class="text-center">{{ $transactions->sender_mobile }}</td>
                        <td>{{ $transactions->remarks }}</td> -->
                        <!-- <td>
                            <img src="{{ asset('images/transaction/' . $transactions->images) }}" alt="profile" style="height: 50px; width: 50px;object-fit:contain">
                        </td> -->
                        <td>
                            <a href="#" class="edit-btn bg-info p-2 text-white text-decoration-none" data-id="{{ $transactions->id }}">
                                <i class="fas fa-edit text-white"></i>
                            </a>

                            <span class="bg-danger p-2" onclick="deleteUser('{{$transactions->id}}')">
                                <i class="fa fa-trash text-white"></i>
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </form>
    </div>
    <!-- AEPS Modal -->
<div class="modal fade" id="aepsModal" tabindex="-1" aria-labelledby="aepsModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="aepsForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">AEPS Transaction</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="text" name="aadhar_no" class="form-control mb-2" placeholder="Aadhar No" >
          <input type="text" name="phone" class="form-control mb-2" placeholder="Phone Number" >
          <input type="text" name="name" class="form-control mb-2" placeholder="Name" >
          <input type="text" name="amount" class="form-control mb-2" placeholder="Amount" >
          <input type="text" name="bank" class="form-control mb-2" placeholder="Bank" >

          <select name="apps" class="form-control mb-2" >
              <option value="">-- Select App --</option>
              @foreach(config('const.aeps') as $key => $app)
                  <option value="{{ $key }}">{{ $app }}</option>
              @endforeach
          </select>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit Transaction</button>
          <button type="submit" class="btn btn-success" style="display:none;">Update Transaction</button>

        </div>
      </div>
    </form>
  </div>
</div>

@endsection