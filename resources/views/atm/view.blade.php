@extends('layouts.header')

@section('title', 'Transaction View')

@section('content')
<style>
    /* Background Image */
    .background-image {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('/images/srinetworks.jpg');
        background-size: cover;
        background-position: center;
        filter: blur(8px);
        z-index: -1;
    }

    /* Content Styling */
    .container-fluid {
        position: relative;
        z-index: 1;
        background: #fff; /* Ensures white background for PDF */
        /* padding: 20px; */
    }

    .contact-list {
        list-style: none; 
        /* padding: 0;
        margin: 0; */
    }

    .contact-list li {
        margin-bottom: 3px; 
    }

    .contact-list p {
        margin: 0;
    }

    /* Header Styling */
    h3.text-success {
        font-size: 30px;
        color: #28a745;
    }

    /* Image Styling */
    .content-image {
        height: 470px;
        width: 950px;
        display: block;
        margin: 20px auto;
    }

    /* Table Styling */
    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table td, .table th {
        border: 1px solid #000;
        padding: 6px;
    }

    /* Hide Buttons in PDF */
    @media print {
        #downloadPDF, #back-btn {
            display: none !important;
        }
    }
</style>

<div class="container-fluid" id="pdf-content">
<div class="row d-flex justify-content-between align-items-center">
    <div class="col-md-6 d-flex align-items-center">
        <img src="{{ asset('images/srinetworks.jpg') }}" alt="cmpy_logo" style="height: 60px; width: 90px; margin-right: 10px;">
        <h3 class="text-success mt-2">Sri Networks</h3>
    </div>
    <div class="col-md-6 text-end">
        <ul class="contact-list list-unstyled">
            <li><p class="text-end">Main Bazaar, Veeravanallur</p></li>
            <li><p class="text-end">Phone: +91 8300456607</p></li>
            <li><p class="text-end">Email: srinetvvr@gmail.com</p></li>
        </ul>
    </div>
</div>


    <!-- Buttons for Back and Download -->
    <div class="col-sm-12 d-flex justify-content-between mt-3">
        <a href="{{route('atm.index')}}" class="btn btn-primary" id="back-btn">
            <i class="fa-solid fas fa-arrow-left"></i> Back
        </a>
        <button id="downloadPDF" class="btn btn-success">
            <i class="fas fa-download"></i> Download PDF
        </button>
    </div>

    <!-- Transaction Table -->
    <div class="row mt-3">
        <div class="col-sm-12">
            <table class="table table-bordered text-wrap table-striped">
                <tbody>
                    <tr><td>Employee ID</td><td>{{ date('d-m-Y', strtotime($transaction->date)) }}</td></tr>
                    <tr><td>Name</td><td>{{$transaction->name}}</td></tr>
                    @if($transaction->method == 0)
                    <tr>
                        <td>Mobile Number</td><td>{{ $transaction->mobile_number }}</td>
                    </tr>
                    @else
                    <tr>
                        <td>Account Number</td>
                        <td>{{ $transaction->acc_no }}</td> <br>
                    </tr>
                    <tr>
                        <td>IFSC Code</td>
                        <td>{{ $transaction->ifsc }}</td>
                    </tr>       
                    @endif
                    <tr><td>Amount</td><td>{{$transaction->amount}}</td></tr>
                    <tr><td>App</td><td>{{ config('const.via_app')[$transaction->via_app]??'Unknown'}}</td></tr>
                    <tr><td>Bank</td><td>{{ config('const.via_bank')[$transaction->via_bank]??'Unknown'}}</td></tr>
                    <tr><td>Sender Name</td><td>{{$transaction->sender_name}}</td></tr>
                    <tr><td>Sender Mobile Number</td><td>{{$transaction->sender_mobile}}</td></tr>
                    <tr><td>Remarks</td><td>{{$transaction->remarks}}</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Transaction Image -->
    <div class="row col-sm-12 text-center">
        <img src="{{asset('images/transaction/'.$transaction->images)}}" alt="Transaction Image" class="content-image">
    </div>
</div>

<!-- Include html2pdf.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
    document.getElementById("downloadPDF").addEventListener("click", function () {
        let element = document.getElementById("pdf-content"); // Capture only the main content
        let downloadButton = document.getElementById("downloadPDF");
        let backButton = document.getElementById("back-btn");

        // Hide buttons before generating PDF
        downloadButton.style.display = "none";
        backButton.style.display = "none";

        setTimeout(() => {
            html2pdf()
                .from(element)
                .set({
                    margin: [10, 10, 10, 10], // Top, Right, Bottom, Left margins
                    filename: 'Transaction_Details.pdf',
                    image: { type: 'jpeg', quality: 0.98 },
                    html2canvas: { scale: 2 },
                    jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
                })
                .save()
                .then(() => {
                    // Restore buttons after PDF download
                    downloadButton.style.display = "inline-block";
                    backButton.style.display = "inline-block";
                });
        }, 500); // Small delay to prevent flickering
    });
</script>

@endsection
