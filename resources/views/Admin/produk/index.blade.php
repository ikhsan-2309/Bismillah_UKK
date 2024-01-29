@extends('admin.layouts.app')

@section('content')
  <section class="section">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">
          List kategori
          <button type="button" class="btn btn-outline-primary float-end" onclick="addForm('{{ route('produk.store') }}')">+
            Products</button>
          <button type="button" class="mr-3 btn btn-outline-danger float-end m-2 mt-0"
            onclick="deleteSelected('{{ route('produk.delete_selected') }}')">Hapus</button>
          <button type="button" class="mr-3 btn btn-outline-success float-end"
            onclick="cetakBarcode('{{ route('produk.cetak_barcode') }}')">Cetak</button>
        </h5>
        <div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table" id="table">
                <thead>
                  <form action="" method="post" class="form-produk">
                    @csrf
                    <th width="3%">
                      <input type="checkbox" name="select_all" id="select_all">
                    </th>
                    <th width="5%">No</th>
                    <th>Code</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Merk</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Diskon</th>
                    <th>Stok</th>
                  </form>
                  <th width="5%">Action</th>
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
          <h4 class="modal-title" id="myModalLabel6"></h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <i data-feather="x"></i>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="POST" class="form form-horizontal">
            @csrf
            @method('post')
            <div class="form-body">
              <div class="row">
                <div class="mt-2">
                  <label for="nama_produk">Product Name</label>
                </div>
                <div class="mt-2">
                  <input type="text" id="nama_produk" class="form-control" name="nama_produk"
                    placeholder="Product Name" required autofocus>
                  <span class="help-block with-errors"></span>
                </div>
                <div class="mt-2">
                  <label for="nama_kategori">Category Name</label>
                </div>
                <div class="mt-2">
                  <select name="id_kategori" id="id_kategori" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    @foreach ($kategori as $key => $item)
                      <option value="{{ $key }}">{{ $item }}</option>
                    @endforeach
                  </select>
                  <span class="help-block with-errors"></span>
                </div>
                <div class="mt-2">
                  <label for="merk">Merk</label>
                </div>
                <div class="mt-2">
                  <input type="text" id="merk" class="form-control" name="merk" placeholder="Product Name"
                    required autofocus>
                  <span class="help-block with-errors"></span>
                </div>
                <div class="mt-2">
                  <label for="harga_beli">Harga Beli</label>
                </div>
                <div class="mt-2">
                  <input type="number" id="harga_beli" class="form-control" name="harga_beli"
                    placeholder="Harga Beli"autofocus>
                  <span class="help-block with-errors"></span>
                </div>
                <div class="mt-2">
                  <label for="harga_jual">Harga Jual</label>
                </div>
                <div class="mt-2">
                  <input type="number" id="harga_jual" class="form-control" name="harga_jual" placeholder="Harga Jual"
                    required autofocus>
                  <span class="help-block with-errors"></span>
                </div>
                <div class="mt-2">
                  <label for="diskon">Discount</label>
                </div>
                <div class="mt-2">
                  <input type="number" id="diskon" class="form-control" name="diskon" placeholder="Discount"
                    required autofocus value="0">
                  <span class="help-block with-errors"></span>
                </div>
                <div class="mt-2">
                  <label for="stok">Stock</label>
                </div>
                <div class="mt-2">
                  <input type="number" id="stok" class="form-control" name="stok" placeholder="Stock"
                    required autofocus value="0">
                  <span class="help-block with-errors"></span>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                <i class="bx bx-x d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Close</span>
              </button>
              <button type="submit" class="btn btn-primary ms-1" data-bs-dismiss="modal">
                <i class="bx bx-check d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Save</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    let table;

    $(function() {
      table = $('.table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
          url: '{{ route('produk.data') }}',
        },
        columns: [{
            data: 'select_all',
            searchable: false,
            sortable: false
          },
          {
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
            data: 'nama_kategori'
          },
          {
            data: 'merk'
          },
          {
            data: 'harga_beli'
          },
          {
            data: 'harga_jual'
          },
          {
            data: 'diskon'
          },
          {
            data: 'stok'
          },
          {
            data: 'aksi',
            searchable: false,
            sortable: false
          },
        ]
      });

      $('#modal-form').validator().on('submit', function(e) {
        if (!e.preventDefault()) {
          $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
            .done((response) => {
              $('#modal-form').modal('hide');
              table.ajax.reload();
            })
            .fail((errors) => {
              alert('Tidak dapat menyimpan data');
              return;
            });
        }
      });

      $('[name=select_all]').on('click', function() {
        $(':checkbox').prop('checked', this.checked);
      });
    });

    function addForm(url) {
      $('#modal-form').modal('show');
      $('#modal-form .modal-title').text('Tambah Produk');

      $('#modal-form form')[0].reset();
      $('#modal-form form').attr('action', url);
      $('#modal-form [name=_method]').val('post');
      $('#modal-form [name=nama_produk]').focus();
    }

    function editForm(url) {
      $('#modal-form').modal('show');
      $('#modal-form .modal-title').text('Edit Produk');

      $('#modal-form form')[0].reset();
      $('#modal-form form').attr('action', url);
      $('#modal-form [name=_method]').val('put');
      $('#modal-form [name=nama_produk]').focus();

      $.get(url)
        .done((response) => {
          $('#modal-form [name=nama_produk]').val(response.nama_produk);
          $('#modal-form [name=id_kategori]').val(response.id_kategori);
          $('#modal-form [name=merk]').val(response.merk);
          $('#modal-form [name=harga_beli]').val(response.harga_beli);
          $('#modal-form [name=harga_jual]').val(response.harga_jual);
          $('#modal-form [name=diskon]').val(response.diskon);
          $('#modal-form [name=stok]').val(response.stok);
        })
        .fail((errors) => {
          alert('Tidak dapat menampilkan data');
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
            table.ajax.reload();
          })
          .fail((errors) => {
            alert('Tidak dapat menghapus data');
            return;
          });
      }
    }

    function deleteSelected(url) {
      if ($('input:checked').length > 0) {
        if (confirm('Yakin ingin menghapus data terpilih?')) {
          $.post(url, $('.form-produk').serialize())
            .done((response) => {
              table.ajax.reload();
            })
            .fail((errors) => {
              alert('Tidak dapat menghapus data');
              return;
            });
        }
      } else {
        alert('Pilih data yang akan dihapus');
        return;
      }
    }

    function cetakBarcode(url) {
      if ($('input:checked').length < 1) {
        alert('Pilih data yang akan dicetak');
        return;
      } else if ($('input:checked').length < 3) {
        alert('Pilih minimal 3 data untuk dicetak');
        return;
      } else {
        $('.form-produk')
          .attr('target', '_blank')
          .attr('action', url)
          .submit();
      }
    }
  </script>
@endpush
