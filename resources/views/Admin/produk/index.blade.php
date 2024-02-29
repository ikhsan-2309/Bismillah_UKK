@extends('admin.layouts.app')
@push('css')
  <link rel="stylesheet" href="{{ asset('vendors/dropify/dropify.min.css') }}">
@endpush
@section('content')
  <div class="card">
    <div class="card-body">
      <div class="card-title mb-3 d-flex justify-content-between align-items-center">
        <h4 class="card-title me-auto">List Products</h4>
        <div class="d-flex">
          <button type="button" class="btn btn-danger btn-icon-text btn-sm mt-2 mb-2"
            onclick="deleteSelected('{{ route('produk.delete_selected') }}')">
            <i class="fa-solid fa-trash btn-icon-prepend"></i>
            Delete
          </button>
          <button type="button" class="btn btn-success btn-icon-text btn-sm m-2"
            onclick="cetakBarcode('{{ route('produk.cetak_barcode') }}')">
            <i class="fa-solid fa-print btn-icon-prepend"></i>
            Print
          </button>
          <button type="button" class="btn btn-primary btn-icon-text btn-sm mt-2 mb-2"
            onclick="addForm('{{ route('produk.store') }}')">
            <i class="fa-solid fa-plus btn-icon-prepend"></i>
            Product
          </button>
          <button type="button" class="btn btn-primary btn-icon-text btn-sm m-2 tippy">
            Tooltip
          </button>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="table-responsive">
            <form action="" method="post" class="form-produk">
              @csrf
              <table class="table" id="table">
                <thead>
                  <th width="3%">
                    <input type="checkbox" class="text-start" name="select_all" id="select_all">
                  </th>
                  <th width="5%">No</th>
                  <th>Code</th>
                  <th>Product</th>
                  <th>Merk</th>
                  <th>Harga Beli (Rp)</th>
                  <th>Harga Jual (Rp)</th>
                  <th>Diskon (%)</th>
                  <th>Stok</th>
                  <th class="text-center" width="5%"><i class="fa fa-cog"></i></th>
                </thead>
              </table>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-formLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal-formLabel"></h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body pt-1">
            <form action="{{ route('produk.store') }}" method="POST" class="form form-horizontal"
              enctype="multipart/form-data">
              @csrf
              @method('post')
              <div class="form-body">
                <div class="row">
                  <div class="mt-2">
                    <label for="nama_produk">Product Name</label>
                    <input type="text" id="nama_produk" class="form-control mt-2" name="nama_produk"
                      placeholder="Product Name" required autofocus>
                    <span class="help-block with-errors"></span>
                  </div>
                  <div class="mt-2">
                    <label for="id_kategori">Category Name</label>
                    <select name="id_kategori" id="id_kategori" class="form-control mt-2" required>
                      <option value="">--Pilih Kategori--</option>
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
                    <label for="gambar_produk">Gambar Produk</label>
                  </div>
                  <div class="mt-2">
                    <input type="file" id="gambar_produk" name="gambar_produk" class="dropify">
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
                    <input type="number" id="harga_jual" class="form-control" name="harga_jual"
                      placeholder="Harga Jual" required autofocus>
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
              <div class="mt-3 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('scripts')
  <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
  <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>
  <script src="{{ asset('vendors/dropify/dropify.min.js') }}"></script>
  <script>
    (function($) {
      'use strict';
      $('.dropify').dropify(
        // defaultFile: '../../../../storage/images/produk/1707985178_coba.jpeg',
      );
    })(jQuery);
  </script>
  <script>
    tippy('.tippy', {
      // ...
      onShow(instance) {
        fetch('../../../../storage/images/produk/1708050090_face8.jpg')
          .then((response) => response.blob())
          .then((blob) => {
            // Convert the blob into a URL
            const url = URL.createObjectURL(blob);
            // Create an image
            const image = new Image();
            image.width = 200;
            image.height = 200;
            image.style.display = 'block';
            image.src = url;
            // Update the tippy content with the image
            instance.setContent(image);
          })
          .catch((error) => {
            // Fallback if the network request failed
            instance.setContent(`Request failed. ${error}`);
          });
      },
    });
  </script>
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
            sortable: false,
            class: 'text-center'
          },
          {
            data: 'DT_RowIndex',
            searchable: false,
            sortable: false,
            class: 'text-center'
          },
          {
            data: 'kode_produk'
          },
          {
            data: 'nama_produk',
            class: 'tippy'
          },
          {
            data: 'merk',
            class: 'tippy'
          },
          {
            data: 'harga_beli',
            class: 'text-center'
          },
          {
            data: 'harga_jual',
            class: 'text-center'
          },
          {
            data: 'diskon',
            class: 'text-center'
          },
          {
            data: 'stok',
            class: 'text-center'
          },
          {
            data: 'aksi',
            searchable: false,
            sortable: false
          },
        ]
      });

      $('#modal-form form').on('submit', function(e) {
        e.preventDefault(); // Menghentikan form submission default
        let formData = new FormData(
          this); // Menggunakan 'this' untuk merujuk ke elemen form yang sedang di-submit

        $.ajax({
          url: $(this).attr('action'),
          method: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function(response) {
            $('#modal-form').modal('hide');
            table.ajax.reload();
            showSwal('success');
          },
          error: function(xhr, status, error) {
            showSwal('error');
            console.error(xhr.responseText);
          }
        });
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
          if (response.gambar_produk) {
            const imgPath = `../../../../storage/images/produk/${response.gambar_produk}`;
            $('#gambar_produk').attr('data-default-file', imgPath);
          }

        })
        .fail((errors) => {
          alert('Tidak dapat menampilkan data');
          return;
        });
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
              showSwal('success');
            })
            .fail((errors) => {
              showSwal('error');
              return;
            });
        }
      });
    }

    function deleteSelected(url) {
      if ($('input:checked').length > 0) {
        showSwal('delete').then((result) => { // Call showSwal directly
          if (result) {
            $.post(url, $('.form-produk').serialize())
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
