@extends('admin.layouts.app')
@push('css')
  <style>
    .tampil-bayar {
      font-size: 3em;
      text-align: center;
      height: 70px;
    }

    .tampil-terbilang {
      padding: 10px;
      background: #f0f0f0;
    }


    @media(max-width: 768px) {
      .tampil-bayar {
        font-size: 2em;
        height: 70px;
        padding-top: 5px;
      }
    }

    @media(max-width: 425px) {
      .tampil-bayar {
        font-size: 1em;
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
        <div class="row">
          <div class="col-12 mb-1">
            <div class="row">
              <div class="col-6">
                <form class="form-produk">
                  @csrf
                  <div class="input-group mb-3">
                    <label for="code-product">
                      <h6 class="ml-0 m-3">Code Product</h6>
                    </label>
                    <input type="hidden" name="id_penjualan" id="id_penjualan" value="{{ $id_penjualan }}">
                    <input type="hidden" name="id_produk" id="id_produk">
                    <input type="text" class="form-control" id="code-product" placeholder="Code Product"
                      aria-label="Code Product" aria-describedby="button-addon2">
                    <button class="btn btn-primary" onclick="tampilProduk()" type="button" id="button-addon2"><i
                        class="fa-solid fa-magnifying-glass"></i></button>
                  </div>
                </form>
              </div>
              <div class="col-6">
                <form action="{{ route('transaksi.simpan') }}" class="form-penjualan" method="post">
                  @csrf
                  <div class="input-group mb-3">
                    <label for="kode-member">
                      <h6 class="ml-0 m-3">Code Member</h6>
                    </label>
                    <input type="text" class="form-control" id="kode_member"
                      value="{{ $memberSelected->kode_member }}">
                    <button class="btn btn-primary" onclick="tampilMember()" type="button" id="button-addon2"><i
                        class="fa-solid fa-magnifying-glass"></i></button>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="table-responsive">
            <table class="table" id="table-penjualan">
              <thead>
                <th width="5%">No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Harga</th>
                <th width="10%">Jumlah</th>
                <th>Diskon</th>
                <th>Subtotal</th>
                <th class="text-center" width="5%"><i class="fa fa-cog"></i></th>
              </thead>
            </table>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-lg-8">
            <div class="tampil-bayar bg-primary text-white"></div>
            <div class="tampil-terbilang text-center"></div>
          </div>
          <div class="col-lg-4">
            <input type="hidden" name="id_penjualan" value="{{ $id_penjualan }}">
            <input type="hidden" name="total" id="total">
            <input type="hidden" name="total_item" id="total_item">
            <input type="hidden" name="bayar" id="bayar">
            <input type="hidden" name="id_member" id="id_member" value="{{ $memberSelected->id_member }}">

            <div class="form-group row">
              <label for="totalrp" class="col-lg-4 control-label mt-3">Total</label>
              <div class="col-lg-8">
                <input type="text" id="totalrp" class="form-control" readonly>
              </div>
            </div>
            <div class="form-group row">
              <label for="diskon" class="col-lg-4 control-label mt-3">Diskon</label>
              <div class="col-lg-8">
                <input type="number" name="diskon" id="diskon" class="form-control"
                  value="{{ !empty($memberSelected->id_member) ? $diskon : 0 }}" readonly>
              </div>
            </div>
            <div class="form-group row">
              <label for="bayar" class="col-lg-4 control-label mt-3">Bayar</label>
              <div class="col-lg-8">
                <input type="text" id="bayarrp" class="form-control" readonly>
              </div>
            </div>
            <div class="form-group row">
              <label for="diterima" class="col-lg-4 control-label mt-3">Diterima</label>
              <div class="col-lg-8">
                <input type="number" id="diterima" class="form-control" name="diterima"
                  value="{{ $penjualan->diterima ?? 0 }}">
              </div>
            </div>
            <div class="form-group row">
              <label for="kembali" class="col-lg-4 control-label mt-3">Kembali</label>
              <div class="col-lg-8">
                <input type="text" id="kembali" name="kembali" class="form-control" value="0" readonly>
              </div>
            </div>
            </form>
            <div>
              <button class="btn btn-primary btn-simpan pull-right float-end"><i class="fa fa-floppy-disk"></i>
                Simpan Transaksi</button>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-transaksi" tabindex="-1" role="dialog" aria-labelledby="modal-formLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-body pt-1">
          <div class="swal-modal" role="dialog" aria-modal="true">
            <div class="swal-icon swal-icon--warning">
              <span class="swal-icon--warning__body">
                <span class="swal-icon--warning__dot"></span>
              </span>
            </div>
            <div class="swal-title" style="">Confirm Deletion</div>
            <div class="swal-text" style="">Are you sure you want to delete this item?</div>
            <div class="swal-footer">
              <div class="swal-button-container">

                <button class="swal-button swal-button--cancel btn btn-danger" fdprocessedid="mpq3e">Cancel</button>

                <div class="swal-button__loader">
                  <div></div>
                  <div></div>
                  <div></div>
                </div>

              </div>
              <div class="swal-button-container">

                <button class="swal-button swal-button--confirm btn btn-primary btn-simpan"
                  fdprocessedid="tx07v4">OK</button>

                <div class="swal-button__loader">
                  <div></div>
                  <div></div>
                  <div></div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modal-member" tabindex="-1" role="dialog" aria-labelledby="modal-formLabel"
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
            <table class="table table-sup" id="table-member">
              <thead>
                <th width="5%">No</th>
                <th>Nama</th>
                <th>Telepon</th>
                <th>Alamat</th>
                <th><i class="fa fa-cog"></i></th>
              </thead>
              <tbody>
                @foreach ($member as $key => $item)
                  <tr>
                    <td width="5%">{{ $key + 1 }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->telepon }}</td>
                    <td>{{ $item->alamat }}</td>
                    <td>
                      <a href="#" class="btn btn-primary btn-xs btn-flat"
                        onclick="pilihMember('{{ $item->id_member }}', '{{ $item->kode_member }}')">
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
      table = $('#table-penjualan').DataTable({
          responsive: true,
          processing: true,
          serverSide: true,
          autoWidth: false,
          ajax: {
            url: '{{ route('transaksi.data', $id_penjualan) }}',
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
              data: 'harga_jual'
            },
            {
              data: 'jumlah',
              class: 'text-center'
            },
            {
              data: 'diskon'
            },
            {
              data: 'subtotal'
            },
            {
              data: 'aksi',
              searchable: false,
              sortable: false,
              class: 'text-center'
            },
          ],
          dom: 'Brt',
          bSort: false,
          paginate: false
        })
        .on('draw.dt', function() {
          loadForm($('#diskon').val());
          setTimeout(() => {
            $('#diterima').trigger('input');
          }, 300);
        });
      table2 = $('#table-produk').DataTable();
      $(document).on('input', '.quantity', function() {
        let id = $(this).data('id');
        let jumlah = parseInt($(this).val());
        let stok = parseInt($(this).data('stok'));

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
        if (jumlah > stok) {
          $(this).val(stok); // Set quantity to available stock
          alert('Stock produk tidak mencukupi!');
          return;
        }

        $.post(`{{ url('/transaksi') }}/${id}`, {
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
      $('#diterima').on('input', function() {
        if ($(this).val() == "") {
          $(this).val(0).select();
        }

        loadForm($('#diskon').val(), $(this).val());
      }).focus(function() {
        $(this).select();
      });

      $('.btn-simpan').on('click', function() {
        const total = parseFloat($('#total').val());
        const diterima = parseFloat($('#diterima').val());
        if (diterima >= total) {
          $('.form-penjualan').submit();
        } else {
          alert('Uang yang diterima kurang');
        }
      });
    });

    function tampilProduk() {
      $('#modal-produk').modal('show');
    }

    function transaksi() {
      $('#modal-transaksi').modal('show');
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
      $.post('{{ route('transaksi.store') }}', $('.form-produk').serialize())
        .done(response => {
          $('#kode_produk').focus();
          table.ajax.reload(() => loadForm($('#diskon').val()));
        })
        .fail(errors => {
          alert('Tidak dapat menyimpan data');
          return;
        });
    }

    function tampilMember() {
      $('#modal-member').modal('show');
    }

    function pilihMember(id, kode) {
      $('#id_member').val(id);
      $('#kode_member').val(kode);
      $('#diskon').val('{{ $diskon }}');
      loadForm($('#diskon').val());
      $('#diterima').val(0).focus().select();
      hideMember();
    }

    function hideMember() {
      $('#modal-member').modal('hide');
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

    function loadForm(diskon = 0, diterima = 0) {
      $('#total').val($('.total').text());
      $('#total_item').val($('.total_item').text());

      $.get(`{{ url('/transaksi/loadform') }}/${diskon}/${$('.total').text()}/${diterima}`)
        .done(response => {
          $('#totalrp').val('Rp. ' + response.totalrp);
          $('#bayarrp').val('Rp. ' + response.bayarrp);
          $('#bayar').val(response.bayar);
          $('.tampil-bayar').text('Bayar : Rp. ' + response.bayarrp);
          $('.tampil-terbilang').text(response.terbilang);
          $('#table-penjualan tbody tr:last-child').hide();
          $('.quantity').css('width', '120px');
          $('#kembali').val('Rp.' + response.kembalirp);
          if ($('#diterima').val() != 0) {
            $('.tampil-bayar').text('Kembali : Rp. ' + response.kembalirp);
            $('.tampil-terbilang').text(response.kembali_terbilang);
          }
        })
        .fail(errors => {
          $('#table-penjualan tbody tr:last-child').hide();
          return;
        })
    }
  </script>
@endpush
