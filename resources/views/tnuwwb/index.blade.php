@extends('layouts.header')

@section('title', 'TNUWWB Index')

@section('content')
<script>
    $(document).ready(function() {
        initializeDataTable('#tnuwwb-table', {
            scrollY: '520px',
            order: [[1, 'desc']]  
        });
    });
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
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $datas)
                    @php $i = 1; @endphp
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
                            <span class="bg-danger p-2 mr-2" onclick="deleteDetails('{{$datas->id}}')">
                                <i class="fa fa-trash text-white"></i>
                            </span>
                            <a href="{{route('tnuwwb.edit',['data'=>$datas])}}" class="bg-info p-2  text-white">
                                <i class="fas fa-edit text-white"></i>
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