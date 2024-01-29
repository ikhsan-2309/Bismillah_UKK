@extends('admin.layouts.app')

@section('content')
  <section class="section">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">
          List penjualan
        </h5>
        <div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table-penjualan" id="table-penjualan">
                <thead>
                  <th width="5%">No</th>
                  <th>Tanggal</th>
                  <th>Kode Member</th>
                  <th>Total Item</th>
                  <th>Total Harga</th>
                  <th>Diskon</th>
                  <th>Total Bayar</th>
                  <th>Kasir</th>
                  <th width="5%" class="text-center"><i class="bi bi-gear"></i></th>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
  </section>
  <div class="modal text-left" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="modal-form"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table-detail" id="table-detail">
              <thead>
                <th width="5%">No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
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
      table = $('.table-penjualan').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
          url: '{{ route('penjualan.data') }}',
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
            data: 'kode_member'
          },
          {
            data: 'total_item'
          },
          {
            data: 'total_harga'
          },
          {
            data: 'diskon'
          },
          {
            data: 'bayar'
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

      table1 = $('.table-detail').DataTable({
        processing: true,
        bSort: false,
        dom: 'Brt',
        columns: [{
            data: 'DT_RowIndex',
            searchable: false,
            sortable: false
          },
          {
            data: 'kode_produk'
          },
          {
            data: 'nama_produk'
          },
          {
            data: 'harga_jual'
          },
          {
            data: 'jumlah'
          },
          {
            data: 'subtotal'
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
      if (confirm('Yakin ingin menghapus data terpilih?')) {
        $.post(url, {
            '_token': $('[name=csrf-token]').attr('content'),
            '_method': 'delete'
          })
          .done((response) => {
            table.ajax.reload();
          })
          .fail((errors) => {
            alert('Tidak dapat menghapus data');
            return;
          });
      }
    }
  </script>
@endpush
