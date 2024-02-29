<link rel="stylesheet" href="{{ asset('vendors/typicons/typicons.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
  integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
  crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
<!-- endinject -->
<!-- plugin css for this page -->
<link rel="stylesheet" href="{{ asset('vendors/datatables/dataTables.bootstrap4.css') }}">
<!-- End plugin css for this page -->
<!-- inject:css -->
<link rel="stylesheet" href="{{ asset('css/vertical-layout-light/style.css') }}">
<!-- endinject -->
<link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />
<style>
  table.dataTable td {
    padding: 10px;
  }

  table.table-sup td {
    padding: 10px;
  }

  .page-item.active .page-link {
    color: #fff !important;
  }

  .datatable-minimal div.dataTables_wrapper div.dataTables_paginate ul.pagination {
    justify-content: flex-end !important;
  }

  .datatable-minimal div.dataTables_wrapper div.dataTables_filter {
    text-align: right;
  }

  div.dataTables_wrapper div.dataTables_info {
    padding-top: 0.4em;
  }

  .loader {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1000;
    display: none;
  }

  .dataTables_processing.loader {
    display: block;
  }

  .loader .dot-opacity-loader {
    display: inline-block;
    position: relative;
    width: 80px;
    height: 80px;
  }

  .loader .dot-opacity-loader span {
    position: absolute;
    top: 0;
    left: 0;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background-color: #333;
    opacity: 0;
    animation: dot-opacity 1.5s infinite ease-in-out;
  }

  .loader .dot-opacity-loader span:nth-child(1) {
    animation-delay: 0s;
  }

  .loader .dot-opacity-loader span:nth-child(2) {
    animation-delay: 0.5s;
  }

  .loader .dot-opacity-loader span:nth-child(3) {
    animation-delay: 1s;
  }

  @keyframes dot-opacity {
    0% {
      opacity: 0;
    }

    50% {
      opacity: 1;
    }

    100% {
      opacity: 0;
    }
  }
</style>
