@extends('admin.layouts.app')
@push('css')
  <link rel="stylesheet" href="{{ asset('assets/extensions/flatpickr/flatpickr.min.css') }}">
@endpush
@section('content')
  <div class="card">
    <div class="card-body">
      <div class="card-title mb-3 d-flex justify-content-between align-items-center">
        <h4 class="card-title me-auto">List Income</h4>
        <div class="d-flex">
          <a href="{{ route('laporan.export_pdf', [$tanggalAwal, $tanggalAkhir]) }}" target="_blank"
            class="btn btn-success btn-sm m-2 mt-0">
            <i class="fas fa-file-pdf mr-2"></i>
            Export PDF
          </a>
          <button class="btn btn-primary btn-sm m-2 mt-0 mr-0" onclick="updatePeriode()">
            <i class="fas fa-calendar-alt mr-2"></i>
            Ubah Periode
          </button>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="table-responsive">
            <table class="table" id="table">
              <thead>
                <th class="text-center" width="5%">No</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Penjualan (Rp)</th>
                <th class="text-center">Pembelian (Rp)</th>
                <th class="text-center">Pendapatan (Rp)</th>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-formLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal-formLabel">Periode Laporan</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pt-1 mt-2">
          <form action="{{ route('laporan.index') }}" method="get" data-toggle="validator" class="form form-horizontal">
            <div class="form-group row">
              <label for="tanggal_awal" class="col-lg-4 col-lg-offset-1 mt-3">Tanggal Awal</label>
              <div class="col-lg-8">
                <input type="text" name="tanggal_awal" id="tanggal_awal" class="form-control flatpickr" required
                  autofocus value="{{ request('tanggal_awal') }}" style="border-radius: 0 !important;">
                <span class="help-block with-errors"></span>
              </div>
            </div>
            <div class="form-group row">
              <label for="tanggal_akhir" class="col-lg-4 col-lg-offset-1 mt-3">Tanggal Akhir</label>
              <div class="col-lg-8">
                <input type="text" name="tanggal_akhir" id="tanggal_akhir" class="form-control flatpickr" required
                  value="{{ request('tanggal_akhir') ?? date('Y-m-d') }}" style="border-radius: 0 !important;">
                <span class="help-block with-errors"></span>
              </div>
            </div>
            <div class="mt-3 d-flex justify-content-end">
              <button type="submit" class="btn btn-primary">Submit</button>
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- @includeIf('admin.category.form') --}}
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
            sortable: false,
            class: 'text-center',
          },
          {
            data: 'tanggal',
            class: 'text-center',
          },
          {
            data: 'penjualan',
            class: 'text-center',
          },
          {
            data: 'pembelian',
            class: 'text-center',
          },
          {
            data: 'pendapatan',
            class: 'text-center',
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
