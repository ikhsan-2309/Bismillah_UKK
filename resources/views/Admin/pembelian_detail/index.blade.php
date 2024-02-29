@extends('admin.layouts.app')
@push('css')
  <style>
    .tampil-bayar {
      font-size: 5em;
      text-align: center;
      height: 120px;
    }

    .tampil-terbilang {
      padding: 10px;
      background: #f0f0f0;
    }


    @media(max-width: 768px) {
      .tampil-bayar {
        font-size: 3em;
        height: 70px;
        padding-top: 5px;
      }
    }

    @media(max-width: 425px) {
      .tampil-bayar {
        font-size: 2em;
        height: 60px;
        padding-top: 5px;
      }
    }
  </style>
@endpush
@section('content')
  <div class="card">
    <div class="card-body">
      <div class="card-title">
        <form class="form-produk">
          @csrf
          <div class="row">
            <div class="col-12 mb-1">
              <div class="row">
                <div class="col-6">
                  <h6>Supplier&nbsp; :&nbsp;&nbsp;{{ $supplier->nama }}</h6>
                  <h6>Telepon&nbsp;&nbsp; :&nbsp;&nbsp;{{ $supplier->telepon }}</h6>
                  <h6>Alamat&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;{{ $supplier->alamat }}</h6>
                </div>
                <div class="col-6">
                  <div class="input-group mb-3">
                    <label for="code-product">
                      <h6 class="ml-0 m-3">Code Product</h6>
                    </label>
                    <input type="hidden" name="id_pembelian" id="id_pembelian" value="{{ $id_pembelian }}">
                    <input type="hidden" name="id_produk" id="id_produk">
                    <input type="text" class="form-control" id="code-product" placeholder="Code Product"
                      aria-label="Code Product" aria-describedby="button-addon2">
                    <button class="btn btn-primary" onclick="tampilProduk()" type="button" id="button-addon2"><i
                        class="fa-solid fa-magnifying-glass"></i></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="table-responsive">
            <table class="table" id="table-pembelian">
              <thead>
                <th class="text-center" width="5%">No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th class="text-center">Harga (Rp)</th>
                <th class="text-center" width="10%">Jumlah</th>
                <th class="text-center">Subtotal (Rp)</th>
                <th width="5%" class="text-center"><i class="fa fa-cog"></i></th>
              </thead>
            </table>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-lg-6">
            <div class="tampil-bayar bg-primary text-white"></div>
            <div class="tampil-terbilang text-center"></div>
          </div>
          <div class="col-lg-6">
            <form action="{{ route('pembelian.store') }}" class="form-pembelian" method="post">
              @csrf
              <input type="hidden" name="id_pembelian" value="{{ $id_pembelian }}">
              <input type="hidden" name="total" id="total">
              <input type="hidden" name="total_item" id="total_item">
              <input type="hidden" name="bayar" id="bayar">
              <div class="form-group row">
                <label for="totalrp" class="col-lg-3 control-label mt-3 ">Total</label>
                <div class="col-lg-9">
                  <input type="text" id="totalrp" class="form-control" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="diskon" class="col-lg-3 control-label mt-3">Diskon</label>
                <div class="col-lg-9">
                  <input type="number" name="diskon" id="diskon" class="form-control" value="{{ $diskon }}">
                </div>
              </div>
              <div class="form-group row">
                <label for="bayar" class="col-lg-3 control-label mt-3">Bayar</label>
                <div class="col-lg-9">
                  <input type="text" id="bayarrp" class="form-control">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary btn-sm btn-flat pull-right btn-simpan float-end"><i
            class="fa fa-floppy-disk"></i> Simpan Transaksi</button>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modal-produk" tabindex="-1" role="dialog" aria-labelledby="modal-formLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal-formLabel">Pilih Product</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pt-1">
          <div class="table-responsive">
            <table class="table" id="table-produk">
              <thead>
                <th width="5%" class="text-center">No</th>
                <th width="10%">Kode</th>
                <th>Nama</th>
                <th class="text-center">Harga Beli (Rp)</th>
                <th width="5%" class="text-center"><i class="fa fa-cog"></i></th>
              </thead>
              <tbody>
                @foreach ($produk as $key => $item)
                  <tr>
                    <td width="5%" class="text-center">{{ $key + 1 }}</td>
                    <td width="10%"><span class="badge badge-success">{{ $item->kode_produk }}</span></td>
                    <td>{{ $item->nama_produk }}</td>
                    <td class="text-center">{{ $item->harga_beli }}</td>
                    <td width="5%" class="text-center">
                      <a href="#" class="btn btn-primary"
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
      $('body').addClass('sidebar-icon-only');

      table = $('#table-pembelian').DataTable({
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
              data: 'harga_beli',
              class: 'text-center',
            },
            {
              data: 'jumlah',
              class: 'text-center'
            },
            {
              data: 'subtotal',
              class: 'text-center',
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
          $('#table-pembelian tbody tr:last-child').hide();
          $('#table-pembelian tbody tr td').css('padding', '5px');
        });
      table2 = $('#table-produk').DataTable();

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
