<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- DataTables CSS -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css"> -->
<!-- DataTables CSS -->
<link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">

<!-- DataTables JS -->
<script src="{{ asset('js/datatables.js') }}"></script>
<script src="{{ asset('js/datatables.mark.min.js') }}"></script>


<script>
    // Common function to initialize DataTable
function initializeDataTable(tableId, customOptions = {}) {
  // Default options for DataTable
  const defaultDataTable = {
    scrollY: "380px",
    scrollX: true,
    bAutoWidth: false,
    pageLength: 50,
    mark: true, //For datatable search highlight
    stripeClasses: [],
    language: {
      paginate: {
        first: "<<",
        last: ">>",
        next: ">",
        previous: "<",
      },
    },
    columnDefs: [
      {
        orderable: false,
        targets: "no-sort",
      },
    ],
    order: [[1, "asc"]],
    pagingType: "full_numbers",
    drawCallback: function () {
      var api = this.api();
      var pagination = $(this)
        .closest(".dataTables_wrapper")
        .find(".dataTables_paginate");
      var info = $(this)
        .closest(".dataTables_wrapper")
        .find(".dataTables_info");
      var lengthSelector = $(this)
        .closest(".dataTables_wrapper")
        .find(".dataTables_length");
      pagination.toggle(this.api().page.info().pages > 1);

      // Hide DataTable info and length selector
      if (api.rows().count() === 0 || api.page.info().recordsDisplay === 0) {
        info.hide();
        lengthSelector.hide();
      } else {
        info.show();
        lengthSelector.show();
      }

      // for ScrollTop
      api.on("page.dt", function () {
        $(".dataTables_scrollBody").scrollTop(0);
      });
    },
  };

  // Adding default options with custom options
  const options = $.extend({}, defaultDataTable, customOptions);

  // DataTable initialization
  const dataTable = new DataTable(tableId, options);

  // Search and order process
  if (customOptions.enableSerialNumber !== false) {
    dataTable
      .on("order.dt search.dt", function () {
        let i = 1;
        dataTable
          .cells(null, 0, {
            search: "applied",
            order: "applied",
          })
          .every(function (cell) {
            this.data(i++);
          });
      })
      .draw();
  }
}
</script>

</head>
<body>
    <!-- jQuery and DataTables JS -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script> -->


    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/images/srinetworks.jpg" alt="logo" style="height: 40px;"> Sri Networks
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('dashboard') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Services
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('index') }}">Employee</a></li>
                            <li><a class="dropdown-item" href="{{ route('atm.index') }}">Transaction</a></li>
                            <li><a class="dropdown-item" href="{{ route('tnuwwb.index') }}">TNUWWB</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ url('logout') }}">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Page Content --}}
    <div class="container-fluid mt-4">
			@if (session('flash_success'))
					<div class="alert alert-success alert-dismissible fade show text-center">
							{!! session('flash_success') !!}
							<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
					</div>
			@endif

			@if (session('flash_error'))
					<div class="alert alert-danger alert-dismissible fade show text-center">
							{!! session('flash_error') !!}
							<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
					</div>
			@endif

      @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
