@extends('layouts.header')

@section('title','TNUWWB Create')

@section('content')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
        .input-group-text {
            height: calc(1.5em + 0.75rem + 2px); /* Match input size */
            display: flex;
            align-items: center;
        }

        .breadcrumb-item a {
            text-decoration: none;
        }

        .breadcrumb-item .active {
            color: #6c757d; /* Bootstrap default breadcrumb active color */
            pointer-events: none;
        }
    </style>
<script>
    $(document).ready(function () {
        function toggleOthersField() {
            if ($('#status').val() == '4') {
                $('#othersField').show();
            } else {
                $('#othersField').hide();
            }
        }

        // Run on page load (if status is pre-selected)
        toggleOthersField();

        // Run on status change
        $('#status').on('change', function () {
            toggleOthersField();
        });
    });
</script>

<div class="wrapper">
		<div class="wrapper">
				<div class="wrapper-content">
						<div class="container-fluid">
								<h1>TNUWWB Create</h1>
								<div class="col-sm-12 d-flex justify-content-between">
										<a href="{{route('tnuwwb.index')}}" class="btn btn-primary"><i class="fa-solid fas fa-arrow-left"></i>Back</a>
										<ol class="breadcrumb float-sm-right">
												<li class="breadcrumb-item">
														<a href="{{ route('tnuwwb.index') }}">List</a>
												</li>
												<li class="breadcrumb-item active">
														<a href="#">Register</a>
												</li>
										</ol>
								</div>
								<form action="{{ route('tnuwwb.store') }}" method="POST">
										@csrf
										<div class="col-md-12 mt-2">
												<div class="row">
														<div class="card">
																<div class="card-body">
																		<div class="fields-group">
																			<div class="form-group row mt-2">
																				<label for="date" class="col-form-label col-sm-2">Date</label>
																				<div class="col-sm-8">
																					<div class="input-group">
																						<div class="input-group-pretend">
																							<span class="input-group-text bg-secondary"><i class="fas fa-pencil-alt"></i></span>
																						</div>
																						<input type="date" name="date" id="date" class="form-control input-sm" placeholder="Name" value="{{ old('date', date('Y-m-d')) }}">
																					</div>
																					@if($errors->has('date'))
																						<span class="form-text form-danger fwb">
																							<i class="fa-solid fa-info-circle">{{ $errors->first('date') }}</i>
																						</span>
																					@endif
																				</div>
																			</div>

																			<div class="form-group row mt-2">
																				<label for="application_no" class="col-form-label col-sm-2">Application No</label>
																				<div class="col-sm-8">
																					<div class="input-group">
																						<div class="input-group-pretend">
																							<span class="input-group-text bg-secondary"><i class="fas fa-pencil-alt"></i></span>
																						</div>
																						<input type="text" name="application_no" class="input-sm form-control" placeholder="Application No">
																					</div>
																					@if($errors->has('application_no'))
																						<span class="form-danger form-text fwb">
																							<i class="fa-solid fa-info-circle">{{ $errors->first('application_no') }}</i>
																						</span>
																					@endif
																				</div>
																			</div>

																			<div class="form-group row mt-2">
																				<label for="mobile" class="col-form-label col-sm-2">Mobile</label>
																				<div class="col-sm-8">
																					<div class="input-group">
																						<div class="input-group-pretend">
																							<span class="input-group-text bg-secondary"><i class="fas fa-pencil-alt"></i></span>
																						</div>
																						<input type="text" name="mobile" class="form-control input-sm" placeholder="Mobile Number">
																					</div>
																					@if($errors->has('mobile'))
																						<span class="form-text form-danger fwb">
																							<i class="fa-solid fa-info-circle">{{ $errors->first('mobile') }}</i>
																						</span>
																					@endif
																				</div>
																			</div>

																			<div class="form-group row mt-2">
																				<label for="name" class="col-form-label col-sm-2">Name</label>
																				<div class="col-sm-8">
																					<div class="input-group">
																						<div class="input-group-pretend">
																							<span class="input-group-text bg-secondary"><i class="fas fa-pencil-alt"></i></span>
																						</div>
																						<input type="text" name="name" class="form-control input-sm" placeholder="Name">
																					</div>
																					@if($errors->has('name'))
																						<span class="form-text form-danger fwb">
																							<i class="fa-solid fa-info-circle">{{ $errors->first('name') }}</i>
																						</span>
																					@endif
																				</div>
																			</div>

																			<div class="form-group row mt-2">
																				<label class="col-form-label col-sm-2">Fees</label>
																				<div class="col-sm-8">
																						<div class="form-check form-check-inline">
																								<input type="radio" name="paid" id="paid" class="form-check-input" value="0" {{ old('paid', $data->paid ?? '') == '0' ? 'checked' : '' }}>
																								<label for="paid" class="form-check-label">Paid</label>
																						</div>
																						<div class="form-check form-check-inline">
																								<input type="radio" name="paid" id="not_paid" class="form-check-input" value="1" {{ old('paid', $data->paid ?? '') == '1' ? 'checked' : '' }}>
																								<label for="not_paid" class="form-check-label">Not Paid</label>
																						</div>
																						@if($errors->has('paid'))
																								<span class="form-text text-danger fwb">
																										<i class="fa-solid fa-info-circle"></i> {{ $errors->first('paid') }}
																								</span>
																						@endif
																				</div>
																			</div>


																			@php $statuss = config('const.status'); @endphp
																			<div class="form-group row mt-2">
																				<label for="status" class="col-form-label col-sm-2">Status</label>
																				<div class="col-sm-8">
																					<div class="input-group">
																						<div class="input-group-pretend">
																							<span class="bg-secondary input-group-text"><i class="fas fa-pencil-alt"></i></span>
																						</div>
																						<select name="status" id="status" class="form-control input-sm">
                                              <option value="">Select a Status</option>
                                                @foreach($statuss as $key => $value)
                                                  <option value="{{$key}}" {{ old('status', $data->status ?? '') == $key ? 'selected' : '' }}>{{$value}}</option>
                                                @endforeach
                                            </select>
																					</div>
																				</div>
																			</div>

																			<div class="form-group row mt-2" id="othersField" style="display: none;">
																					<label for="others" class="col-form-label col-sm-2">Others</label>
																					<div class="col-sm-8">
																							<div class="input-group">
																									<div class="input-group-prepend">
																											<span class="input-group-text bg-secondary"><i class="fas fa-pencil-alt"></i></span>
																									</div>
																									<input type="text" name="others" class="form-control input-sm" placeholder="Others">
																							</div>
																							@if($errors->has('others'))
																									<span class="form-text text-danger fwb">
																											<i class="fa-solid fa-info-circle"></i> {{ $errors->first('others') }}
																									</span>
																							@endif
																					</div>
																			</div>

																			<div class="form-group row mt-2">
																				<label for="id_no" class="col-form-label col-sm-2">ID No</label>
																				<div class="col-sm-8">
																					<div class="input-group">
																						<div class="input-group-pretend">
																							<span class="input-group-text bg-secondary"><i class="fas fa-pencil-alt"></i></span>
																						</div>
																						<input type="text" name="id_no" class="form-control input-sm" placeholder="ID No">
																					</div>
																					@if($errors->has('id_no'))
																						<span class="form-text form-danger fwb">
																							<i class="fa-solid fa-info-circle">{{ $errors->first('id_no') }}</i>
																						</span>
																					@endif
																				</div>
																			</div>

																			@php $types = config('const.type'); @endphp
																			<div class="form-group row mt-2">
																				<label for="type" class="col-form-label col-sm-2">Type</label>
																				<div class="col-sm-8">
																					<div class="input-group">
																						<div class="input-group-pretend">
																							<span class="bg-secondary input-group-text"><i class="fas fa-pencil-alt"></i></span>
																						</div>
																						<select name="type" id="type" class="form-control input-sm">
                                              <option value="">Select a Type</option>
                                                @foreach($types as $key => $value)
                                                  <option value="{{$key}}" {{ old('type', $data->type ?? '') == $key ? 'selected' : '' }}>{{$value}}</option>
                                                @endforeach
                                            </select>
																					</div>
																					@if($errors->has('type'))
																						<span class="form-text form-danger fwb">
																							<i class="fa-solid fa-info-circle">{{ $errors->first('type') }}</i>
																						</span>
																					@endif
																				</div>
																			</div>

																			<div class="form-group row mt-2">
																				<label for="remarks" class="col-form-label col-sm-2">Remarks</label>
																				<div class="col-sm-8">
																					<div class="input-group">
																						<div class="input-group-pretend">
																							<span class="input-group-text bg-secondary"><i class="fas fa-pencil-alt"></i></span>
																						</div>
																						<input type="text" name="remarks" class="form-control input-sm" placeholder="Remarks">
																					</div>
																					@if($errors->has('remarks'))
																						<span class="form-text form-danger fwb">
																							<i class="fa-solid fa-info-circle">{{ $errors->first('remarks') }}</i>
																						</span>
																					@endif
																				</div>
																			</div>
																		</div>  
																</div>
																<div class="card-footer mt-3">
																	<div class="sol-sm-12 text-center mt-3 mb-2">
																		<div class="btn-group">
																			<button type="submit" class="btn btn-success">Register</button>
																		</div>
																		<div class="btn-group">
																			<button type="reset" class="btn btn-danger">Reset</button>
																		</div>
																	</div>
																</div>
														</div>
												</div>
										</div>
								</form>
						</div>
				</div>
		</div>
</div>
@endsection