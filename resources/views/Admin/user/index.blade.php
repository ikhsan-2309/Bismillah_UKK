@extends('admin.layouts.app')

@section('content')
  <div class="card">
    <div class="card-body">
      <div class="card-title mb-3 d-flex justify-content-between">
        <h4 class="card-title align-items-center mt-2">List Chasiers</h4>
        <button class="btn btn-primary btn-sm" onclick="addForm('{{ route('user.store') }}')">+
          Chasier</button>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="table-responsive">
            <table class="table" id="table">
              <thead>
                <th width="7%" class="text-center">No</th>
                <th>Nama</th>
                <th>Email</th>
                <th class="text-center" width="5%"><i class="fa fa-cog"></i></th>
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
                <div class="">
                  <label for="name">Name</label>
                </div>
                <div class="">
                  <input type="text" id="name" class="form-control" name="name" required autofocus>
                  <span class="help-block with-errors"></span>
                </div>
                <div class="mt-3">
                  <label for="email">Email</label>
                </div>
                <div class="">
                  <input type="email" id="email" class="form-control" name="email" required>
                  <span class="help-block with-errors"></span>
                </div>
                <div class="mt-3">
                  <label for="password">Password</label>
                </div>
                <div class="">
                  <input type="password" id="password" class="form-control" name="password" required>
                  <span class="help-block with-errors"></span>
                </div>
                <div class="mt-3">
                  <label for="password_confirmation">Konfirmasi Password</label>
                </div>
                <div class="">
                  <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                    required data-match="#password">
                  <span class="help-block with-errors"></span>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
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
      table = $('.table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
          url: '{{ route('user.data') }}',
        },
        columns: [{
            data: 'DT_RowIndex',
            searchable: false,
            sortable: false,
            class: 'text-center'
          },
          {
            data: 'name'
          },
          {
            data: 'email'
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
              showSwal('error');
              return;
            });
        }
      });
    });

    function addForm(url) {
      $('#modal-form').modal('show');
      $('#modal-form .modal-title').text('Tambah User');

      $('#modal-form form')[0].reset();
      $('#modal-form form').attr('action', url);
      $('#modal-form [name=_method]').val('post');
      $('#modal-form [name=name]').focus();

      $('#password, #password_confirmation').attr('required', true);
    }

    function editForm(url) {
      $('#modal-form').modal('show');
      $('#modal-form .modal-title').text('Edit User');

      $('#modal-form form')[0].reset();
      $('#modal-form form').attr('action', url);
      $('#modal-form [name=_method]').val('put');
      $('#modal-form [name=name]').focus();

      $('#password, #password_confirmation').attr('required', false);

      $.get(url)
        .done((response) => {
          $('#modal-form [name=name]').val(response.name);
          $('#modal-form [name=email]').val(response.email);
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
