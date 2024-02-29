@extends('admin.layouts.app')

@section('content')
  <div class="card">
    <div class="card-body">
      <div class="card-title mb-3 d-flex justify-content-between align-items-center">
        <h4 class="card-title me-auto">List Categories</h4>
        <div class="d-flex">
          <button type="button" class="btn btn-primary btn-icon-text btn-sm mt-2 mb-2"
            onclick="addForm('{{ route('kategori.store') }}')">
            <i class="fa-solid fa-plus btn-icon-prepend"></i>
            Category
          </button>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="table-responsive">
            <table id="table" class="table">
              <thead>
                <tr>
                  <th class="text-center" width="5%">No</th>
                  <th>Category Name</th>
                  <th class="text-center" width="5%">Actions</th>
                </tr>
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
          <h5 class="modal-title" id="modal-formLabel"></h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body pt-1">
          <form action="" method="POST" class="form form-horizontal">
            @csrf
            @method('post')
            <div class="form-body">
              <div class="row">
                <div class="mt-2">
                  <label for="first-name-horizontal">Category Name</label>
                </div>
                <div class="mt-2">
                  <input type="text" id="nama_kategori" class="form-control has-valiadtion" name="nama_kategori"
                    placeholder="Category Name" required autofocus>
                  <div class="invalid-feedback">
                    Please choose a username.
                  </div>
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
@endsection

@push('scripts')
  <script>
    let table;

    $(function() {
      table = $('#table').DataTable({
        responsive: true,
        processing: true,
        processingMessage: "<div class='loader-demo-box'><div class='dot-opacity-loader'><span></span><span></span><span></span></div></div>",
        serverSide: true,
        autoWidth: false,
        ajax: {
          url: '{{ route('kategori.data') }}',
        },
        columns: [{
            data: 'DT_RowIndex',
            searchable: false,
            sortable: false,
            class: 'text-center'
          },
          {
            data: 'nama_kategori'
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
              showSwal('success');
            })
            .fail((errors) => {
              alert('Tidak dapat menyimpan data');
              return;
            });
        }
      });
    });

    function addForm(url) {
      $('#modal-form').modal('show');
      $('#modal-form .modal-title').text('Create Category');

      $('#modal-form form')[0].reset();
      $('#modal-form form').attr('action', url);
      $('#modal-form [name=_method]').val('post');
      $('#modal-form [name=nama_kategori]').focus();
    }

    function editForm(url) {
      $('#modal-form').modal('show');
      $('#modal-form .modal-title').text('Edit Category');

      $('#modal-form form')[0].reset();
      $('#modal-form form').attr('action', url);
      $('#modal-form [name=_method]').val('put');
      $('#modal-form [name=nama_kategori]').focus();

      $.get(url)
        .done((response) => {
          $('#modal-form [name=nama_kategori]').val(response.nama_kategori);
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
