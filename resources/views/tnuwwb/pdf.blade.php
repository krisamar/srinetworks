<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TNUWWB Report - {{ $data->application_no }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Tamil:wght@100..900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            position: relative;
            color: #333;
        }

        /* Watermark Logo */
        .watermark {
            position: fixed;
            top: 10%;
            left: 12%;
            opacity: 0.1;
            width: 400px;
            z-index: -1;
        }

/* Header Section */
/* Header Section */
.header {
    border-bottom: 2px solid #333;
    padding: 8px 0;
    margin-bottom: 20px;
}

.header-inner {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: nowrap;

}

.header-left {
    display: flex;
    align-items: center;
    gap: 8px;
    float: left;
}

.header-left img {
    width: 130px;
    height: auto;
    object-fit: contain;

}

.header-left .company-name {
    font-size: 22px;
    font-weight: 700;
    color: #2a4d69;
}
.company-name{
    position: absolute;
    padding-top: 10px;
}

.company-info {
    text-align: right;
    font-size: 13px;
    line-height: 1.4;
}

.header h2 {
    text-align: center;
    margin: 0;
    color: #2a4d69;
}

        .header h2 {
            text-align: center;
            margin: 0;
            color: #2a4d69;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        table, th, td {
            border: 1px solid #777;
        }

        th, td {
            padding: 8px 10px;
        }

        th {
            /* background: #f0f0f0; */
            text-align: left;
        }

        .footer {
            position: fixed;
            bottom: 20px;
            width: 100%;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        
        @font-face {
            font-family: 'NotoSansTamil';
            src: url('{{ storage_path("fonts/NotoSansTamil-Regular.ttf") }}') format('truetype');
        }

        .tamil-text {
            font-family: 'Latha', 'NotoSansTamil', sans-serif !important;
        }



    </style>
</head>
<body>
    <!-- Watermark -->
    <img src="{{ public_path('images/srinetworks.jpg') }}" class="watermark" alt="Watermark">

<!-- Header -->
<!-- Header -->
<div class="header">
    <div class="header-inner">
        
        <!-- Left section -->
        <div class="header-left">
            <img src="{{ public_path('images/srinetworks.jpg') }}" alt="Logo">
            <span class="company-name">SRI NETWORKS</span>
        </div>
        
        <!-- Right section -->
        <div class="company-info">
            Main Bazaar, Veeravanallur.<br>
            <i class="fa fa-phone"></i> 8300456607<br>
            <i class="fa fa-envelope"></i> srinetvvr@gmail.com
        </div>

    </div>
</div>


<!-- <div class="tnuwwb-header" style="text-align:center; margin-bottom:20px;">
    <table style="width:100%; border:none;">
        <tr> -->
            <!-- <td style="width:15%; text-align:right;"> -->
                <!-- <img src="images/govt-logo.png" alt="Govt Logo" style="height:80px;"> -->
            <!-- <img src="{{ asset('images/govt-logo.png') }}" alt="Logo" style="width:100px;"> -->
 

            <!-- </td> -->
            <!-- <td style="width:70%; text-align:center; vertical-align:middle;"> -->
                <!-- <div style="font-size:18px; font-weight:bold;tamil-text">
                    தமிழ்நாடு அமைப்புசாரா தொழிலாளர்கள் நலவாரியம்
                </div> -->
                <!-- <div style="font-size:18px;font-weight:bold">
                   <h4> Tamil Nadu Unorganised Workers Welfare Board</h4>
                </div>
            </td> -->
            <!-- <td style="width:15%; text-align:left;"> -->
                <!-- <img src="images/statue.jpg" alt="Statue Logo" style="height:80px;"> -->
            <!-- <img src="{{ asset('images/statue.jpg') }}" alt="Logo" style="width:100px;"> -->

            <!-- </td> -->
        <!-- </tr>
    </table>
</div> -->



    <!-- Table Content -->
    <table>
        <tbody>
    @if(!empty($data->date))
        <tr>
            <th>Date</th>
            <td>{{ \Carbon\Carbon::parse($data->date)->format('d/m/Y') }}</td>
        </tr>
    @endif

    @if(!empty($data->name))
        <tr>
            <th>Name</th>
            <td>{{ $data->name }}</td>
        </tr>
    @endif

    @if(!empty($data->application_no))
        <tr>
            <th>Application Number</th>
            <td>{{ $data->application_no }}</td>
        </tr>
    @endif

    @if(!empty($data->mobile))
        <tr>
            <th>Mobile Number</th>
            <td>{{ $data->mobile }}</td>
        </tr>
    @endif

    <!-- @if(!empty($data->status))
        <tr>
            <th>Status</th>
            <td>{{ config('const.status')[$data->status] ?? 'Unknown' }}</td>
        </tr>
    @endif -->

    <!-- @if(!empty($data->others))
        <tr>
            <th>Others</th>
            <td>{{ $data->others }}</td>
        </tr>
    @endif -->

    @if(!empty($data->id_no))
        <tr>
            <th>ID Number</th>
            <td>{{ $data->id_no }}</td>
        </tr>
    @endif

    @if(!empty($data->type))
        <tr>
            <th>Type</th>
            <td>{{ config('const.type')[$data->type] ?? 'Unknown' }}</td>
        </tr>
    @endif

    @if(!empty($data->remarks))
        <tr>
            <th>Remarks</th>
            <td>{{ $data->remarks }}</td>
        </tr>
    @endif
</tbody>

    </table>

    <!-- Footer -->
    <!-- <div class="footer">
        Generated on {{ now()->format('d-m-Y H:i') }} | © {{ date('Y') }} Sri Networks
    </div> -->
</body>
</html>
