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
<style>
  .text-danger {
    font-size: 0.875rem;
}
</style>
<style>
/* 🌟 NAVBAR BASE STYLE */
.navbar {
    background: linear-gradient(90deg, #004aad, #0078d7);
    padding: 0.8rem 1rem;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
}

/* Brand Logo & Text */
.navbar-brand {
    color: #fff !important;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
    letter-spacing: 0.5px;
}

.navbar-brand img {
    height: 42px;
    border-radius: 6px;
}

/* Nav Items */
.navbar-nav .nav-link {
    color: #e3e3e3 !important;
    font-weight: 500;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.navbar-nav .nav-link:hover,
.navbar-nav .nav-link.active {
    color: #ffffff !important;
    background-color: rgba(255, 255, 255, 0.1);
    text-decoration: none;
}

/* Dropdown Menu */
.dropdown-menu {
    border-radius: 10px;
    border: none;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    min-width: 180px;
}

.dropdown-item {
    padding: 8px 20px;
    transition: all 0.2s ease;
    color: #333;
}

.dropdown-item:hover {
    background-color: #0078d7;
    color: #fff;
}

/* Logout Button */
.logout-btn,
.navbar-Text {
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1.2rem;
    padding: 6px 10px;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.logout-btn:hover,
.navbar-Text:hover {
    background-color: rgba(255, 255, 255, 0.2);
    color: #ffb3b3;
    text-decoration: none;
}

/* Mobile Navbar Toggle Button */
.navbar-toggler {
    border-color: rgba(255, 255, 255, 0.2);
}

.navbar-toggler-icon {
    background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba%28255, 255, 255, 0.9%29' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/ %3E%3C/svg%3E");
}

/* Adjust spacing on navbar items */
.navbar-nav {
    gap: 10px;
}

/* Responsive adjustments */
@media (max-width: 991px) {
    .navbar-nav .nav-link {
        margin-bottom: 5px;
    }
    .logout-btn,
    .navbar-Text {
        margin-top: 10px;
    }
}

.flash-container {
    position: fixed;
    top: 10px;              /* adjust if you have a navbar */
    left: 50%;
    transform: translateX(-50%);
    width: 80%;
    z-index: 2000;          /* keep above everything */
    pointer-events: none;   /* so it doesn't block clicks */
}

.flash-message {
    pointer-events: auto;   /* restore click for close button if needed */
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    margin-bottom: 8px;
}
</style>


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

setTimeout(function() {
    document.querySelectorAll('.flash-message').forEach(function(el) {
        el.style.transition = 'opacity 1s ease';
        el.style.opacity = '0';
        setTimeout(() => el.remove(), 1000);
    });
}, 1000); // 10000 ms = 10 seconds

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
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 navbar-text">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('dashboard') }}">Home</a>
                    </li>
                    <!-- <li class="nav-item">
                      <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#aepsModal">AEPS</a>
                    </li> -->
                    <li class="nav-item">
                      <a href="{{ route('aepsindex') }}" class="nav-link">AEPS</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Services
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('index') }}">Employee</a></li>
                            <li><a class="dropdown-item" href="{{ route('atm.index') }}">Transaction</a></li>
                            <li><a class="dropdown-item" href="{{ route('tnuwwb.index') }}">TNUWWB</a></li>
                            <!-- <li><hr class="dropdown-divider"></li>
                            <li></li> -->
                        </ul>
                    </li>
                </ul>
                <a class="navbar-Text" href="{{ url('logout') }}"><i class="fas fa-sign-out-alt fa-2x"></i></a>
            </div>
        </div>
    </nav>

    {{-- Page Content --}}
    <div class="container-fluid">
      <div class="flash-container" style="width:300px;">
			@if (session('flash_success'))
          <div class="alert alert-success text-center flash-message" role="alert">
              <strong><i class="fa fa-check-circle"></i> {{ session('flash_success') }}</strong>
          </div>
      @endif

      @if (session('flash_error'))
          <div class="alert alert-danger text-center flash-message" role="alert">
              <strong><i class="fa fa-exclamation-circle"></i> {{ session('flash_error') }}</strong>
          </div>
      @endif

      @if ($errors->any())
          <div class="alert alert-danger text-center flash-message" role="alert">
              <strong><i class="fa fa-exclamation-circle"></i> Please fix the following errors:</strong>
              <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
</div>

      @yield(section: 'content')
    </div>

    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
