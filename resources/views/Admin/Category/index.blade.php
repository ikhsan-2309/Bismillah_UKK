@extends('admin.layouts.app')

@section('content')
  <section class="section">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">
          List kategori
          <button type="button" class="btn btn-outline-primary float-end"
            onclick="addForm('{{ route('kategori.store') }}')">+ Category</button>
        </h5>
        <div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table" id="table">
                <thead>
                  <th width="5%">No</th>
                  <th>Category Name</th>
                  <th width="15%">Action</th>
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
                <div class="">
                  <label for="first-name-horizontal">Category Name</label>
                </div>
                <div class="mt-3">
                  <input type="text" id="nama_kategori" class="form-control" name="nama_kategori"
                    placeholder="Category Name" required autofocus>
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
                <span class="d-none d-sm-block">Accept</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- @includeIf('admin.category.form') --}}
@endsection

@push('scripts')
  <script>
    let table;

    $(function() {
      table = $('#table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
          url: '{{ route('kategori.data') }}',
        },
        columns: [{
            data: 'DT_RowIndex',
            searchable: false,
            sortable: false
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
