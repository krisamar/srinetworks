@extends('layouts.header')
@section('title', 'Transaction Details')
@section('content')

<div class="container-fluid">
    
        <form action="{{ route('income') }}" method="POST">
            @csrf
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Daily Income</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4 d-flex justify-content-between mb-3">
                            <input type="hidden" name="date" class="form-control input-sm" id="date" value="{{ old('date', date('Y-m-d')) }}" style="margin-right:10px;">
                            <input type="text" name="amount" class="form-control input-sm" id="amount" style="margin-right:10px;">
                            <input type="submit" class="btn btn-success ml-2" value="Submit">&nbsp;
                        </div>
                        <div class="col-sm-4">
                                @if($errors->has('amount'))
                                    <span class="form-text form-danger fwb text-danger">
                                        <i class="fas fa-info-circle"></i>&nbsp;{{ $errors->first('amount') }}
                                    </span>
                                @endif
                            </div>
                            <div class=" col-sm-12 text-right mb-2">
                                <span id="toggle-table-btn" class="btn btn-primary">
                                    <i id="toggle-icon" class="fas fa-minus"></i> Hide Income Table
                                </span>
                            </div>
                            <div class="show-incomeTable">
                                <table class="table table-bordered text-wrap mt-5" id="income-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">SNo</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center delete">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @php $i=1; @endphp
                                        @foreach ($income as $incomes)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ date('d-m-Y', strtotime($incomes->date)) }}</td>
                                            <td>{{ $incomes->amount }}</td>
                                            <td>
                                                <span class="btn btn-danger" onclick="amountDetails('{{ $incomes->id }}')">
                                                    <i class="fa fa-trash"></i>
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div>
            </div>
        </form>
    <!-- Income Chart Section -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between">
            <h3 class="card-title">Income Charts</h3>
            <div>
                <button id="showIncomeDaily" class="btn btn-primary">Daily Income</button>
                <button id="showIncomeMonthly" class="btn btn-secondary">Monthly Income</button>
            </div>
        </div>
        <div class="card-body">
            <div id="dailyIncomeChartContainer">
                <h2 class="text-center">This Month</h2>
                <div style="width: 800px; height: 400px; margin: auto;">
                    <canvas id="dailyIncomeChart"></canvas>
                </div>
            </div>
            <div id="monthlyIncomeChartContainer" style="display: none;">
                <h2 class="text-center">This Year</h2>
                <div style="width: 800px; height: 400px; margin: auto;">
                    <canvas id="monthlyIncomeChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Chart Section -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between">
            <h3 class="card-title">Transaction Charts</h3>
            <div>
                <button id="showDaily" class="btn btn-primary">Daily Transactions</button>
                <button id="showMonthly" class="btn btn-secondary">Monthly Transactions</button>
            </div>
        </div>
        <div class="card-body">
            <div id="dailyChartContainer">
                <h2 class="text-center">This Month</h2>
                <div style="width: 800px; height: 400px; margin: auto;">
                    <canvas id="dailyTransactionChart"></canvas>
                </div>
            </div>
            <div id="monthlyChartContainer" style="display: none;">
                <h2 class="text-center">This Year</h2>
                <div style="width: 800px; height: 400px; margin: auto;">
                    <canvas id="monthlyTransactionChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Chart.js and jQuery -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {

    // Toggle Between Daily and Monthly Transaction Graphs
    $("#showDaily").click(function () {
        $("#monthlyChartContainer").hide();
        $("#dailyChartContainer").show();
        $("#showDaily").addClass("btn-primary").removeClass("btn-secondary");
        $("#showMonthly").addClass("btn-secondary").removeClass("btn-primary");
    });
    
    $("#showMonthly").click(function () {
        $("#dailyChartContainer").hide();
        $("#monthlyChartContainer").show();
        $("#showMonthly").addClass("btn-primary").removeClass("btn-secondary");
        $("#showDaily").addClass("btn-secondary").removeClass("btn-primary");
    });

    // Fetch and Display Daily Transactions Chart
    fetch("{{ url('/daily-transactions') }}")
        .then(response => response.json())
        .then(data => {
            if (!data.labels.length || !data.totalTransactions.length) {
                alert("No daily transaction data available.");
                return;
            }
            const ctx = document.getElementById("dailyTransactionChart").getContext("2d");
            new Chart(ctx, {
                type: "line",
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: "Total Daily Transactions",
                        data: data.totalTransactions,
                        borderColor: "#36A2EB",
                        backgroundColor: "rgba(54, 162, 235, 0.2)",
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        });

    // Fetch and Display Monthly Transactions Chart
    fetch("{{ url('/monthly-transactions') }}")
        .then(response => response.json())
        .then(data => {
            if (!data.labels.length || !data.monthlyTransactions.length) {
                alert("No monthly transaction data available.");
                return;
            }
            const ctx = document.getElementById("monthlyTransactionChart").getContext("2d");
            new Chart(ctx, {
                type: "line",
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: "Total Monthly Transactions",
                        data: data.monthlyTransactions,
                        borderColor: "#FF6384",
                        backgroundColor: "rgba(255, 99, 132, 0.2)",
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        });

    // Toggle Between Daily and Monthly Income Graphs
    $("#showIncomeDaily").click(function () {
        $("#monthlyIncomeChartContainer").hide();
        $("#dailyIncomeChartContainer").show();
        $("#showIncomeDaily").addClass("btn-primary").removeClass("btn-secondary");
        $("#showIncomeMonthly").addClass("btn-secondary").removeClass("btn-primary");
    });

    $("#showIncomeMonthly").click(function () {
        $("#dailyIncomeChartContainer").hide();
        $("#monthlyIncomeChartContainer").show();
        $("#showIncomeMonthly").addClass("btn-primary").removeClass("btn-secondary");
        $("#showIncomeDaily").addClass("btn-secondary").removeClass("btn-primary");
    });

    // Fetch and Display Daily Income Chart
    fetch("{{ url('/daily-income') }}")
        .then(response => response.json())
        .then(data => {
            if (!data.labels.length || !data.totalIncome.length) {
                alert("No daily income data available.");
                return;
            }
            const ctx = document.getElementById("dailyIncomeChart").getContext("2d");
            new Chart(ctx, {
                type: "line",
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: "Total Daily Income",
                        data: data.totalIncome,
                        borderColor: "#36A2EB",
                        backgroundColor: "rgba(54, 162, 235, 0.2)",
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        });

    // Fetch and Display Monthly Income Chart
    fetch("{{ url('/monthly-income') }}")
        .then(response => response.json())
        .then(data => {
            if (!data.labels.length || !data.monthlyIncome.length) {
                alert("No monthly income data available.");
                return;
            }
            const ctx = document.getElementById("monthlyIncomeChart").getContext("2d");
            new Chart(ctx, {
                type: "line",
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: "Total Monthly Income",
                        data: data.monthlyIncome,
                        borderColor: "#FF6384",
                        backgroundColor: "rgba(255, 99, 132, 0.2)",
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        });

});

function amountDetails(income){
    var destroyIncome = "{{ route('destroyIncome', ':income') }}".replace(':income', income);
    $.ajax({
        url: destroyIncome,
        type: 'DELETE',
        data: {
            _method: 'DELETE',
            _token: '{{ csrf_token() }}'
        },
        success: function(response){
            location.reload();
        },
        error: function (response){
            Swal.fire('Error!', 'There was an something issue','error');
        }
    });
}

$(document).ready(function() {
        $("#toggle-table-btn").click(function() {
            $(".show-incomeTable").toggle(); // Show/hide table
            let icon = $("#toggle-icon");

            // Change icon and button text dynamically
            if (icon.hasClass("fa-plus")) {
                icon.removeClass("fa-plus").addClass("fa-minus");
                $(this).html('<i id="toggle-icon" class="fas fa-minus"></i> Hide Income Table');
                $(".delete").trigger("click");
            } else {
                icon.removeClass("fa-minus").addClass("fa-plus");
                $(this).html('<i id="toggle-icon" class="fas fa-plus"></i> Show Income Table');
            }
        });

        if ($("#toggle-icon").hasClass("fa-minus")) {
            $("#toggle-table-btn").trigger("click"); // Click the button if icon is minus
        }
});

$(document).ready(function() {
        initializeDataTable('#income-table', {
            scrollY: '520px',
            order: [[1, 'desc']]  
        });
    });

</script>

@endsection
