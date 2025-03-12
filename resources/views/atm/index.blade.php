@extends('layouts.header')

@section('title', 'Transaction Index')

@section('content')

    <script>
        function deleteUser(transactions){
            var btnText = 'Delete';
            var btnColor = '#f44336';
            var destroyUrl = "{{ route('atm.destroy',':transactions') }}".replace(':transactions', transactions);

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
    </script>

    <div class="container-fluid">
        <form action="{{ url('edit/{$transactions}')}}" method="post">
            @csrf
            @method('put')
        
                <h1>Transaction Details</h1>
          
        <div class="row">
            <div class="col-sm-12">
                <a href="{{ route('atm.create') }}" class="btn btn-success float-end">Add Transaction</a>

            </div>
        </div>
        
        <div class="col-sm-12 mt-3">
            <table class="table table-bordered text-wrap table-hover transaction-table" id="transaction-table">
                <thead>
                    <tr class="text-center">
                        <th>SNo</th>
                        <th>Date</th>
                        <th>Mobile / Accouont</th>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>App</th>
                        <th>Bank</th>
                        <th>Sender Name</th>
                        <th>Sender Mobile</th>
                        <th>Remarks</th>
                        <!-- <th>Image</th> -->
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach($transaction as $transactions)
                    <tr>
                        <td class="text-center">{{ $i++ }}</td>
                        <td class="text-center">{{ date('d-m-Y', strtotime($transactions->date)) }}</td>
                        <td class="text-center">
                            @if($transactions->method == 0)
                                {{ $transactions->mobile_number }}
                            @else
                                {{ $transactions->acc_no }} <br>
                                <small class="text-muted">( {{ $transactions->ifsc }} )</small>
                            @endif
                        </td>
                        <td>
                            <a href="{{route('atm.show',['transaction'=>$transactions])}}">{{$transactions->name}}</a>
                        </td>
                        <td>{{ $transactions->amount }}</td>
                        @php $app = config('const.via_app'); @endphp
                        <td>{{$app[$transactions->via_app] ?? 'Unknown'}}</td>
                        @php $bank = config('const.via_bank'); @endphp
                        <td>{{$bank[$transactions->via_bank] ?? 'Unknown'}}</td>
                        <td>{{ $transactions->sender_name }}</td>
                        <td class="text-center">{{ $transactions->sender_mobile }}</td>
                        <td>{{ $transactions->remarks }}</td>
                        <!-- <td>
                            <img src="{{ asset('images/transaction/' . $transactions->images) }}" alt="profile" style="height: 50px; width: 50px;object-fit:contain">
                        </td> -->
                        <td>
                            <a href="{{route('atm.edit',['transaction'=>$transactions])}}" class="bg-info p-2 text-white text-decoration-none">
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
@endsection