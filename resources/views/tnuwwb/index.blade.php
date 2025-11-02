@extends('layouts.header')

@section('title', 'TNUWWB Index')

@section('content')
<script>
    $(document).ready(function() {
        initializeDataTable('#tnuwwb-table', {
            scrollY: '520px',
            order: [] 
        });
    });

    function deleteDetails(data){
            var btnText = 'Delete';
            var btnColor = '#f44336';
            var destroyUrl = "{{ route('tnuwwb.destroy',':data') }}".replace(':data', data);

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
                            Swal.fire('Deleted!', 'The TNUWWB Details deleted successfully','success');
                            location.reload();
                        },
                        error: function(response){
                            Swal.fire('Error!', 'There was something issue', 'error');
                        }
                    });
                }
            });
        }

</script>

<div class="container-fluid">
    <h1>TNUWWB Details</h1>
    <div class="row mt-5">
        <div class="col-sm-2 col-md-4">
            <a href="{{ route('dashboard') }}" class="btn btn-primary text-white">Back</a>
        </div>
        <div class="col-sm-8">
            <a href="{{ route('tnuwwb.create') }}" class="btn btn-success float-end">Add Details</a>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-12">
            <table class="table table-bordered word-wrap table-hover tnuwwb-table" id="tnuwwb-table">
                <thead>
                    <tr>
                        <th>SNo</th>
                        <th>Date</th>
                        <th>Application No</th>
                        <th>Mobile</th>
                        <th>Name</th>
                        <th>Paid</th>
                        <th>Status</th>
                        <th>ID No</th>
                        <th>Type</th>
                        <th>Remarks</th>
                        <th class="col-sm-1"></th>
                    </tr>
                </thead>
                <tbody>
                @php $i = 1; @endphp
                    @foreach($data as $datas)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ \Carbon\Carbon::parse($datas['date'])->format('d-m-Y') }}</td>
                        <td>
                            <a href="{{route('tnuwwb.show',['data'=>$datas])}}">{{$datas->application_no}}</a>
                        </td>
                        <td>{{ $datas['mobile'] }}</td>
                        <td>{{ $datas['name'] }}</td>
                        @php $app = config('const.paid_details'); @endphp
                        <td>{{$app[$datas->paid] ?? 'Unknown'}}</td>
                        @php $apps = config('const.status'); @endphp
                        <td>
                            @if($datas->status == 4)
                                {{ $datas->others ?? 'N/A' }}
                            @else
                                {{ $apps[$datas->status] ?? 'Unknown' }}
                            @endif
                        </td>
                        <td>{{ $datas['id_no'] }}</td>
                        @php $tent = config('const.type'); @endphp
                        <td>{{$tent[$datas->type] ?? 'Unknown'}}</td>
                        <td>{{ $datas['remarks'] }}</td>
                        <td>
                            <!-- Edit Button -->
                            <a href="{{ route('tnuwwb.edit', ['data' => $datas]) }}" class="btn btn-sm btn-info text-white mr-2">
                                <i class="fas fa-edit"></i>
                            </a>

                            <!-- Delete Button -->
                            <button type="button" class="btn btn-sm btn-danger text-white mr-2" onclick="deleteDetails('{{ $datas->id }}')">
                                <i class="fa fa-trash"></i>
                            </button>

                            <!-- PDF Download Button -->
                            <a href="{{ route('tnuwwb.pdf', $datas->id) }}" class="btn btn-sm btn-warning text-white" target="_blank">
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