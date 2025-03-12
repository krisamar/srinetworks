@extends('layouts.header')

@section('title', 'Employee View')

@section('content')
	<div class="container-fluid">

		<h1>TNUWWB View</h1>
		<div class="col-sm-12 d-flex justify-content-between">
			<a href="{{route('tnuwwb.index')}}" class="btn btn-primary"><i class="fa-solid fas fa-arrow-left"></i> Back</a>
		</div>
		<div class="row mt-3">
			<div class="col-sm-12 d-flex justify-content-between">
				<table class="table table-bordered text-wrap table-striped">
					<tbody>
						<tr>
							<td>Date</td>
							<td>{{$data->date}}</td>
						</tr>
						<tr>
							<td>Name</td>
							<td>{{$data->name}}</td>
						</tr>
						<tr>
							<td>Application No</td>
							<td>{{$data->application_no}}</td>
						</tr>
						<tr>
							<td>Mobile</td>
							<td>{{$data->mobile}}</td>
						</tr>
						<tr>
							<td>Status</td>
							<td>{{ config('const.status')[$data->status]??'Unknown'}}</td>
						</tr>
						<tr>
							<td>Others</td>
							<td>{{$data->others}}</td>
						</tr>
						<tr>
							<td>ID No</td>
							<td>{{$data->id_no}}</td>
						</tr>
						<tr>
							<td>Type</td>
							<td>{{ config('const.type')[$data->type]??'Unknown'}}</td>
						</tr>
						<tr>
							<td>Remarks</td>
							<td>{{$data->remarks}}</td>
						</tr>
					</tbody>
				</table>
				<!-- <div class="row col-sm-4">
					<img src="{{asset('images/'.$data->image)}}" alt="image" style="height: 250px; width: 250px; object-fit:contain;margin-left: 20px;">
				</div> -->
			</div>
		</div>
	</div>

@endsection