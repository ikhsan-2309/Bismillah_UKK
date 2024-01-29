@extends('admin.layouts.app')
@section('content')
  <section class="section">
    <div class="card">
      <div class="card-header">
        <h6 class="card-title">
          <table>
            <tr>
              <td>Supplier</td>
              <td>: {{ $supplier->nama }}</td>
            </tr>
            <tr>
              <td>Telepon</td>
              <td>: {{ $supplier->telepon }}</td>
            </tr>
            <tr>
              <td>Alamat</td>
              <td>: {{ $supplier->alamat }}</td>
            </tr>
          </table>
        </h6>
        <div>
          <div class="card-body">
            <div class="table-responsive">
              <form class="form-produk">
                @csrf
                <div class="row">
                  <div class="col-md-6 mb-1">
                    <div class="input-group mb-3">
                      <label for="code-product" class="ml-0 m-2">Code Product</label>
                      <input type="hidden" name="id_pembelian" id="id_pembelian" value="{{ $id_pembelian }}">
                      <input type="hidden" name="id_produk" id="id_produk">
                      <input type="text" class="form-control" id="code-product" placeholder="Code Product"
                        aria-label="Code Product" aria-describedby="button-addon2">
                      <button class="btn btn-outline-primary" onclick="tampilProduk()" type="button"
                        id="button-addon2"><i class="bi bi-search"></i></button>
                    </div>
                  </div>
                </div>
              </form>
              <table class="table-pembelian" id="table-pembelian">
                <thead>
                  <th width="5%">No</th>
                  <th>Kode</th>
                  <th>Nama</th>
                  <th>Harga</th>
                  <th width="15%">Jumlah</th>
                  <th>Subtotal</th>
                  <th width="5%" class="text-center"><i class="bi bi-gear"></i></th>
                </thead>
              </table>
            </div>
            <div class="row mt-3">
              <div class="col-lg-6">
                <div class="tampil-bayar bg-primary"></div>
                <div class="tampil-terbilang"></div>
              </div>
              <div class="col-lg-6">
                <form action="{{ route('pembelian.store') }}" class="form-pembelian" method="post">
                  @csrf
                  <input type="hidden" name="id_pembelian" value="{{ $id_pembelian }}">
                  <input type="hidden" name="total" id="total">
                  <input type="hidden" name="total_item" id="total_item">
                  <input type="hidden" name="bayar" id="bayar">
                  <div class="form-group row">
                    <label for="totalrp" class="col-lg-2 control-label">Total</label>
                    <div class="col-lg-8">
                      <input type="text" id="totalrp" class="form-control" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="diskon" class="col-lg-2 control-label">Diskon</label>
                    <div class="col-lg-8">
                      <input type="number" name="diskon" id="diskon" class="form-control"
                        value="{{ $diskon }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="bayar" class="col-lg-2 control-label">Bayar</label>
                    <div class="col-lg-8">
                      <input type="text" id="bayarrp" class="form-control">
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-primary btn-sm btn-flat pull-right btn-simpan float-end"><i
                class="fa fa-floppy-o"></i>
              Simpan Transaksi</button>
          </div>
        </div>
      </div>
  </section>
  <div class="modal modal-lg text-left" id="modal-produk" tabindex="-1" role="dialog" aria-labelledby="modal-form"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table-produk" id="table-produk">
              <thead>
                <th width="5%">No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Harga Beli</th>
                <th><i class="fa fa-cog"></i></th>
              </thead>
              <tbody>
                @foreach ($produk as $key => $item)
                  <tr>
                    <td width="5%">{{ $key + 1 }}</td>
                    <td><span class="badge bg-light-success">{{ $item->kode_produk }}</span></td>
                    <td>{{ $item->nama_produk }}</td>
                    <td>{{ $item->harga_beli }}</td>
                    <td>
                      <a href="#" class="btn btn-primary btn-xs btn-flat"
                        onclick="pilihProduk('{{ $item->id_produk }}', '{{ $item->kode_produk }}')">
                        <i class="fa fa-check-circle"></i>
                        Pilih
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    let table, table2;

    $(function() {
      $('body').addClass('sidebar-collapse');

      table = $('.table-pembelian').DataTable({
          responsive: true,
          processing: true,
          serverSide: true,
          autoWidth: true,
          ajax: {
            url: '{{ route('pembelian_detail.data', $id_pembelian) }}',
          },
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
              data: 'harga_beli'
            },
            {
              data: 'jumlah'
            },
            {
              data: 'subtotal'
            },
            {
              data: 'aksi',
              searchable: false,
              sortable: false
            },
          ],
          dom: 'Brt',
          bSort: false,
          paginate: false
        })
        .on('draw.dt', function() {
          loadForm($('#diskon').val());
          $('.table-pembelian tbody tr:last-child').hide();
        });
      table2 = $('.table-produk').DataTable();

      $(document).on('input', '.quantity', function() {
        let id = $(this).data('id');
        let jumlah = parseInt($(this).val());

        if (jumlah < 1) {
          $(this).val(1);
          alert('Jumlah tidak boleh kurang dari 1');
          return;
        }
        if (jumlah > 10000) {
          $(this).val(10000);
          alert('Jumlah tidak boleh lebih dari 10000');
          return;
        }

        $.post(`{{ url('/pembelian_detail') }}/${id}`, {
            '_token': $('[name=csrf-token]').attr('content'),
            '_method': 'put',
            'jumlah': jumlah
          })
          .done(response => {
            $(this).on('mouseout', function() {
              table.ajax.reload(() => loadForm($('#diskon').val()));
            });
          })
          .fail(errors => {
            alert('Tidak dapat menyimpan data');
            return;
          });
      });

      $(document).on('input', '#diskon', function() {
        if ($(this).val() == "") {
          $(this).val(0).select();
        }

        loadForm($(this).val());
      });

      $('.btn-simpan').on('click', function() {
        $('.form-pembelian').submit();
      });
    });

    function tampilProduk() {
      $('#modal-produk').modal('show');
    }

    function hideProduk() {
      $('#modal-produk').modal('hide');
    }

    function pilihProduk(id, kode) {
      $('#id_produk').val(id);
      $('#kode_produk').val(kode);
      hideProduk();
      tambahProduk();
    }

    function tambahProduk() {
      $.post('{{ route('pembelian_detail.store') }}', $('.form-produk').serialize())
        .done(response => {
          $('#kode_produk').focus();
          table.ajax.reload(() => loadForm($('#diskon').val()));
        })
        .fail(errors => {
          alert('Tidak dapat menyimpan data');
          return;
        });
    }

    function deleteData(url) {
      if (confirm('Yakin ingin menghapus data terpilih?')) {
        $.post(url, {
            '_token': $('[name=csrf-token]').attr('content'),
            '_method': 'delete'
          })
          .done((response) => {
            table.ajax.reload(() => loadForm($('#diskon').val()));
          })
          .fail((errors) => {
            alert('Tidak dapat menghapus data');
            return;
          });
      }
    }

    function loadForm(diskon = 0) {
      $('#total').val($('.total').text());
      $('#total_item').val($('.total_item').text());

      $.get(`{{ url('/pembelian_detail/loadform') }}/${diskon}/${$('.total').text()}`)
        .done(response => {
          $('#totalrp').val('Rp. ' + response.totalrp);
          $('#bayarrp').val('Rp. ' + response.bayarrp);
          $('#bayar').val(response.bayar);
          $('.tampil-bayar').text('Rp. ' + response.bayarrp);
          $('.tampil-terbilang').text(response.terbilang);
        })
        .fail(errors => {
          alert('Tidak dapat menampilkan data');
          return;
        })
    }
  </script>
@endpush
