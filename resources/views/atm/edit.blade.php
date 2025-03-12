@extends('layouts.header')

@section('title', 'Transaction Update')

@section('content')
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
            function toggleFields() {
                let selectedValue = $("input[name='method']:checked").val();
                if (selectedValue == "0") {
                    $("#mobile_field").show();
                    $("#account_fields").hide();
                } else {
                    $("#mobile_field").hide();
                    $("#account_fields").show();
                }
            }

            // Run on page load to set correct fields
            toggleFields();

            // Change event listener
            $("input[name='method']").on("change", function () {
                toggleFields();
            });
        });
    </script>

    <div class="wrapper">
        <div class="wrapper">
            <div class="wrapper-content">
                <div class="container-fluid">
                    <h1>Edit Transaction</h1>
                    <div class="col-sm-12 d-flex justify-content-between">
                        <a href="{{route('atm.index')}}" class="btn btn-primary"><i class="fa-solid fas fa-arrow-left"></i>Back</a>
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{route('atm.index')}}">List</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Edit</a>
                            </li>
                        </ol>
                    </div>
                    <form action="{{route('atm.update',$transaction)}}" method="POST" enctype="multipart/form-data">
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
                                                        <input type="date" name="date" class="form-control input-sm" placeholder="Date" value="{{ old('date', $transaction->date ? date('Y-m-d', strtotime($transaction->date)) : '') }}">
                                                    </div>
                                                    @if($errors->has('date'))
                                                        <span class="form-text form-danger fwb">
                                                            <i class="fas fa-info-circle"></i> {{$errors->first('date')}}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row mt-2">
                                                <label class="col-form-label col-sm-2">Method</label>
                                                <div class="col-sm-8">
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" name="method" id="phone" class="form-check-input" value="0" {{ old('method', $transaction->method ?? '') == '0' ? 'checked' : '' }}>
                                                        <label for="phone" class="form-check-label">Phone</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" name="method" id="acc_no" class="form-check-input" value="1" {{ old('method', $transaction->method ?? '') == '1' ? 'checked' : '' }}>
                                                        <label for="acc_no" class="form-check-label">Account Number</label>
                                                    </div>
                                                    @if($errors->has('method'))
                                                        <span class="form-text text-danger fwb">
                                                            <i class="fa-solid fa-info-circle"></i> {{ $errors->first('method') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Mobile Number Field -->
                                            <div class="form-group row mt-2" id="mobile_field">
                                                <label for="mobile_number" class="col-form-label col-sm-2">Mobile Number</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-secondary"><i class="fas fa-pencil-alt"></i></span>
                                                        </div>
                                                        <input type="text" name="mobile_number" class="form-control input-sm" placeholder="Mobile Number" value="{{old('mobile_number', $transaction->mobile_number)}}">
                                                    </div>
                                                    @if($errors->has('mobile_number'))
                                                        <span class="form-text text-danger fwb">
                                                            <i class="fas fa-info-circle"></i> {{$errors->first('mobile_number')}}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Account Number and IFSC Fields -->
                                            <div id="account_fields">
                                                <div class="form-group row mt-2">
                                                    <label for="acc_no" class="col-form-label col-sm-2">Account Number</label>
                                                    <div class="col-sm-8">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text bg-secondary"><i class="fas fa-pencil-alt"></i></span>
                                                            </div>
                                                            <input type="text" name="acc_no" class="form-control input-sm" placeholder="Account Number" value="{{old('acc_no', $transaction->acc_no)}}">
                                                        </div>
                                                        @if($errors->has('acc_no'))
                                                            <span class="form-text text-danger fwb">
                                                                <i class="fas fa-info-circle"></i> {{$errors->first('acc_no')}}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row mt-2">
                                                    <label for="ifsc" class="col-form-label col-sm-2">IFSC Code</label>
                                                    <div class="col-sm-8">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text bg-secondary"><i class="fas fa-pencil-alt"></i></span>
                                                            </div>
                                                            <input type="text" name="ifsc" class="form-control input-sm" placeholder="IFSC Code" value="{{old('ifsc', $transaction->ifsc)}}">
                                                        </div>
                                                        @if($errors->has('ifsc'))
                                                            <span class="form-text text-danger fwb">
                                                                <i class="fas fa-info-circle"></i> {{$errors->first('ifsc')}}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row mt-2">
                                                <label for="name" class="col-form-label col-sm-2">Name</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <div class="input-group-pretend">
                                                            <span class="input-group-text bg-secondary"><i class="fas fa-pencil-alt"></i></span>
                                                        </div>
                                                        <input type="text" name="name" class="form-control input-sm" placeholder="Name" value="{{old('name', $transaction->name)}}">
                                                    </div>
                                                    @if($errors->has('name'))
                                                        <span class="form-text form-danger fwb">
                                                            <i class="fas fa-info-circle"></i> {{$errors->first('name')}}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group row mt-2">
                                                <label for="amount" class="col-form-label col-sm-2">Amount</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <div class="input-group-pretend">
                                                            <span class="input-group-text bg-secondary"><i class="fas fa-pencil-alt"></i></span>
                                                        </div>
                                                        <input type="text" name="amount" class="form-control input-sm" placeholder="Amount" value="{{old('amount', $transaction->amount)}}">
                                                    </div>
                                                    @if($errors->has('amount'))
                                                        <span class="form-text form-danger fwb">
                                                            <i class="fas fa-info-circle"></i> {{$errors->first('amount')}}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            @php $app = config('const.via_app'); @endphp
                                            <div class="form-group row mt-2">
                                                <label for="via_app" class="col-form-label col-sm-2">Via App</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <div class="input-group-pretend">
                                                            <span class="input-group-text bg-secondary"><i class="fas fa-pencil-alt"></i></span>
                                                        </div>
                                                        <select name="via_app" id="via_app" class="form-control input-sm">
                                                            <option value="">Select a App</option>
                                                            @foreach($app as $key => $value)
                                                            <option value="{{$key}}" {{ old('via_app', $transaction->via_app ?? '') == $key ? 'selected' : '' }}>{{$value}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @if($errors->has('via_app'))
                                                        <span class="form-text form-danger fwb">
                                                            <i class="fas fa-info-circle"></i> {{$errors->first('via_app')}}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            @php $bank = config('const.via_bank'); @endphp
                                            <div class="form-group row mt-2">
                                                <label for="via_bank" class="col-form-label col-sm-2">Via Bank</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <div class="input-group-pretend">
                                                            <span class="input-group-text bg-secondary"><i class="fas fa-pencil-alt"></i></span>
                                                        </div>
                                                        <select name="via_bank" id="via_bank" class="form-control input-sm">
                                                            <option value="">Select a Bank</option>
                                                            @foreach($bank as $key => $value)
                                                            <option value="{{$key}}" {{ old('via_bank', $transaction->via_bank ?? '') == $key ? 'selected' : '' }}>{{$value}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @if($errors->has('via_bank'))
                                                        <span class="form-text form-danger fwb">
                                                            <i class="fas fa-info-circle"></i> {{$errors->first('via_bank')}}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row mt-2">
                                                <label for="sender_name" class="col-form-label col-sm-2">Sender Name</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <div class="input-group-pretend">
                                                            <span class="input-group-text bg-secondary"><i class="fas fa-pencil-alt"></i></span>
                                                        </div>
                                                        <input type="text" name="sender_name" class="form-control input-sm" placeholder="Sender Name" value="{{old('sender_name',$transaction->sender_name)}}">
                                                    </div>
                                                    @if($errors->has('sender_name'))
                                                        <span class="form-text form-danger fwb">
                                                            <i class="fas fa-info-circle"></i> {{$errors->first('sender_name')}}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row mt-2">
                                                <label for="sender_mobile" class="col-form-label col-sm-2">Sender Mobile Number</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <div class="input-group-pretend">
                                                            <span class="input-group-text bg-secondary"><i class="fas fa-pencil-alt"></i></span>
                                                        </div>
                                                        <input type="text" name="sender_mobile" class="form-control input-sm" placeholder="Sender Mobile Number" value="{{old('sender_mobile',$transaction->sender_mobile)}}">
                                                    </div>
                                                    @if($errors->has('sender_mobile'))
                                                        <span class="form-text form-danger fwb">
                                                            <i class="fas fa-info-circle"></i> {{$errors->first('sender_mobile')}}
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
                                                        <input type="text" name="remarks" class="form-control input-sm" placeholder="Remarks" value="{{old('remarks',$transaction->remarks)}}">
                                                    </div>
                                                    @if($errors->has('remarks'))
                                                        <span class="form-text form-danger fwb">
                                                            <i class="fas fa-info-circle"></i> {{$errors->first('remarks')}}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row mt-2">
                                                <label for="images" class="col-form-label col-sm-2">Image</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <div class="input-group-pretend">
                                                            <span class="input-group-text bg-secondary"><i class="fas fa-pencil-alt"></i></span>
                                                        </div>
                                                        <input type="file" name="images" class="form-control input-sm" placeholder="Image">
                                                    </div>
                                                    <div>
                                                        <img src="{{ asset('images/transaction/' . $transaction->images) }}" alt="image" style="height: 80px; width: 80px; object-fit:contain;">
                                                    </div>
                                                    @if($errors->has('images'))
                                                        <span class="form-text form-danger fwb">
                                                            <i class="fas fa-info-circle"></i> {{$errors->first('images')}}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="card-footer mt-2">
                                                <div class="col-sm-12 mt-3 text-center">
                                                    <div class="btn-group">
                                                        <input type="submit" class="btn btn-success" value="Submit">
                                                    </div>
                                                    <div class="btn-group">
                                                        <input type="reset" class="btn btn-danger" value="Reset">
                                                    </div>
                                                </div>
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