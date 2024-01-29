@extends('admin.layouts.app')
@push('css')
  <link rel="stylesheet" href="{{ asset('assets/extensions/flatpickr/flatpickr.min.css') }}">
@endpush
@section('content')
  <section class="section">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">
          List Pembelian
          <button type="button" class="btn btn-outline-primary float-end " onclick="updatePeriode()">Ubah Periode</button>
          <a href="{{ route('laporan.export_pdf', [$tanggalAwal, $tanggalAkhir]) }}" target="_blank"
            class="btn btn-outline-success float-end m-2 mt-0"> Export PDF</a>

        </h5>
        <div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table" id="table">
                <thead>
                  <th width="5%">No</th>
                  <th>Tanggal</th>
                  <th>Penjualan</th>
                  <th>Pembelian</th>
                  <th>Pendapatan</th>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
  </section>
  <div class="modal text-left" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel6">Periode Laporan</h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <i data-feather="x"></i>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('laporan.index') }}" method="get" data-toggle="validator" class="form form-horizontal">
            <div class="form-group row">
              <label for="tanggal_awal" class="col-lg-4 col-lg-offset-1 control-label">Tanggal Awal</label>
              <div class="col-lg-8">
                <input type="text" name="tanggal_awal" id="tanggal_awal" class="form-control flatpickr" required
                  autofocus value="{{ request('tanggal_awal') }}" style="border-radius: 0 !important;">
                <span class="help-block with-errors"></span>
              </div>
            </div>
            <div class="form-group row">
              <label for="tanggal_akhir" class="col-lg-4 col-lg-offset-1 control-label">Tanggal Akhir</label>
              <div class="col-lg-8">
                <input type="text" name="tanggal_akhir" id="tanggal_akhir" class="form-control flatpickr" required
                  value="{{ request('tanggal_akhir') ?? date('Y-m-d') }}" style="border-radius: 0 !important;">
                <span class="help-block with-errors"></span>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                <i class="bx bx-x d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Close</span>
              </button>
              <button type="submit" class="btn btn-primary ms-1" data-bs-dismiss="modal">
                <i class="bx bx-check d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Accept</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('scripts')
  <script src="assets/extensions/flatpickr/flatpickr.min.js"></script>
  <script src="assets/static/js/pages/date-picker.js"></script>
  <script>
    let table;

    $(function() {
      table = $('.table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
          url: '{{ route('laporan.data', [$tanggalAwal, $tanggalAkhir]) }}',
        },
        columns: [{
            data: 'DT_RowIndex',
            searchable: false,
            sortable: false
          },
          {
            data: 'tanggal'
          },
          {
            data: 'penjualan'
          },
          {
            data: 'pembelian'
          },
          {
            data: 'pendapatan'
          }
        ],
        dom: 'Brt',
        bSort: false,
        bPaginate: false,
      });

      $('.flatpickr').flatpickr({
        dateFormat: "Y-m-d",
        autoclose: true
      });
    });

    function updatePeriode() {
      $('#modal-form').modal('show');
    }
  </script>
@endpush
