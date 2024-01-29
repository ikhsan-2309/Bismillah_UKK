@extends('admin.layouts.app')
@section('content')
  <section class="section">
    <div class="card">
      <div class="card-header">
        <h6 class="card-title">
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
                      <input type="hidden" name="id_penjualan" id="id_penjualan" value="{{ $id_penjualan }}">
                      <input type="hidden" name="id_produk" id="id_produk">
                      <input type="text" class="form-control" id="code-product" placeholder="Code Product"
                        aria-label="Code Product" aria-describedby="button-addon2">
                      <button class="btn btn-outline-primary" onclick="tampilProduk()" type="button"
                        id="button-addon2"><i class="bi bi-search"></i></button>
                    </div>
                  </div>
                </div>
              </form>
              <table class="table-penjualan" id="table-penjualan">
                <thead>
                  <th width="5%">No</th>
                  <th>Kode</th>
                  <th>Nama</th>
                  <th>Harga</th>
                  <th width="15%">Jumlah</th>
                  <th>Diskon</th>
                  <th>Subtotal</th>
                  <th class="text-center" width="5%"><i class="bi bi-gear"></i></th>
                </thead>
              </table>
            </div>
            <div class="row mt-3">
              <div class="col-lg-8">
                <div class="tampil-bayar bg-primary"></div>
                <div class="tampil-terbilang"></div>
              </div>
              <div class="col-lg-4">
                <form action="{{ route('transaksi.simpan') }}" class="form-penjualan" method="post">
                  @csrf
                  <input type="hidden" name="id_penjualan" value="{{ $id_penjualan }}">
                  <input type="hidden" name="total" id="total">
                  <input type="hidden" name="total_item" id="total_item">
                  <input type="hidden" name="bayar" id="bayar">
                  <input type="hidden" name="id_member" id="id_member" value="{{ $memberSelected->id_member }}">

                  <div class="form-group row">
                    <label for="totalrp" class="col-lg-4 control-label">Total</label>
                    <div class="col-lg-8">
                      <input type="text" id="totalrp" class="form-control" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="kode_member" class="col-lg-4 control-label">Member</label>
                    <div class="col-lg-8">
                      <div class="input-group">
                        <input type="text" class="form-control" id="kode_member"
                          value="{{ $memberSelected->kode_member }}">
                        <button class="btn btn-outline-primary" onclick="tampilMember()" type="button"
                          id="button-addon2"><i class="bi bi-search"></i></button>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="diskon" class="col-lg-4 control-label">Diskon</label>
                    <div class="col-lg-8">
                      <input type="number" name="diskon" id="diskon" class="form-control"
                        value="{{ !empty($memberSelected->id_member) ? $diskon : 0 }}" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="bayar" class="col-lg-4 control-label">Bayar</label>
                    <div class="col-lg-8">
                      <input type="text" id="bayarrp" class="form-control" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="diterima" class="col-lg-4 control-label">Diterima</label>
                    <div class="col-lg-8">
                      <input type="number" id="diterima" class="form-control" name="diterima"
                        value="{{ $penjualan->diterima ?? 0 }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="kembali" class="col-lg-4 control-label">Kembali</label>
                    <div class="col-lg-8">
                      <input type="text" id="kembali" name="kembali" class="form-control" value="0"
                        readonly>
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
  <div class="modal text-left" id="modal-member" tabindex="-1" role="dialog" aria-labelledby="modal-form"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table-member" id="table-member">
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
      table = $('.table-penjualan').DataTable({
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
              data: 'jumlah'
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
              sortable: false
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
        $('.form-penjualan').submit();
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
          $('.tampil-bayar').text('Bayar: Rp. ' + response.bayarrp);
          $('.tampil-terbilang').text(response.terbilang);
          $('.table-penjualan tbody tr:last-child').hide();
          $('#kembali').val('Rp.' + response.kembalirp);
          if ($('#diterima').val() != 0) {
            $('.tampil-bayar').text('Kembali: Rp. ' + response.kembalirp);
            $('.tampil-terbilang').text(response.kembali_terbilang);
          }
        })
        .fail(errors => {
          alert('Tidak dapat menampilkan data');
          $('.table-penjualan tbody tr:last-child').hide();
          return;
        })
    }
  </script>
@endpush
