@extends('admin.layouts.app')

@section('content')
  <div class="card">
    <div class="card-body">
      <div class="card-title mb-3 d-flex justify-content-between align-items-center">
        <h4 class="card-title me-auto">List Transactions</h4>
        <div class="d-flex">
          {{-- @empty(!session('id_penjualan'))
            <a href="{{ route('transaksi.index') }}" class="btn btn-success btn-icon-text btn-sm m-2">
              <i class="fa-solid fa-history btn-icon-prepend"></i>
              Last Transaction
            </a>
          @endempty --}}
          <a href="{{ route('transaksi.baru') }}" class="btn btn-primary btn-icon-text btn-sm mt-2 mb-2">
            <i class="fa-solid fa-plus btn-icon-prepend"></i>
            Transaction
          </a>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="table-responsive">
            <table class="table" id="table-penjualan">
              <thead>
                <th class="text-center" width="5%">No</th>
                <th>Tanggal</th>
                <th>Kode Member</th>
                <th class="text-center">Total Item</th>
                <th class="text-center">Total Harga (Rp)</th>
                <th class="text-center">Diskon (%)</th>
                <th class="text-center">Total Bayar (Rp)</th>
                <th>Kasir</th>
                <th width="5%" class="text-center"><i class="fa fa-cog"></i></th>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="modal-formLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-body pt-1">
          <div class="table-responsive">
            <table class="table" id="table-detail">
              <thead>
                <th class="text-center" width="5%">No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Harga (Rp)</th>
                <th>Jumlah</th>
                <th>Subtotal (Rp)</th>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection


@push('scripts')
  <script>
    let table, table1;

    $(function() {
      table = $('#table-penjualan').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        autoWidth: true,
        ajax: {
          url: '{{ route('penjualan.data') }}',
        },
        columns: [{
            data: 'DT_RowIndex',
            searchable: false,
            sortable: false,
            class: 'text-center'
          },
          {
            data: 'tanggal'
          },
          {
            data: 'kode_member',
            class: 'text-center'
          },
          {
            data: 'total_item',
            class: 'text-center'
          },
          {
            data: 'total_harga',
            class: 'text-center'
          },
          {
            data: 'diskon',
            class: 'text-center'
          },
          {
            data: 'bayar',
            class: 'text-center'
          },
          {
            data: 'kasir'
          },
          {
            data: 'aksi',
            searchable: false,
            sortable: false
          },
        ]
      });

      table1 = $('#table-detail').DataTable({
        processing: true,
        bSort: false,
        dom: 'Brt',
        columns: [{
            data: 'DT_RowIndex',
            searchable: false,
            sortable: false,
            class: 'text-center'
          },
          {
            data: 'kode_produk'
          },
          {
            data: 'nama_produk'
          },
          {
            data: 'harga_jual',
            class: 'text-center'
          },
          {
            data: 'jumlah',
            class: 'text-center'
          },
          {
            data: 'subtotal',
            class: 'text-center'
          },
        ]
      })
    });

    function showDetail(url) {
      $('#modal-detail').modal('show');

      table1.ajax.url(url);
      table1.ajax.reload();
    }

    function deleteData(url) {
      showSwal('delete').then((result) => { // Call showSwal directly
        if (result) {
          $.post(url, {
              '_token': $('[name=csrf-token]').attr('content'),
              '_method': 'delete'
            })
            .done((response) => {
              table.ajax.reload();
              showSwal('s-delete');
            })
            .fail((errors) => {
              showSwal('error');
              return;
            });
        }
      });
    }
  </script>
@endpush
