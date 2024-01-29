@extends('admin.layouts.app')

@section('content')
  <section class="section">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">
          List Member
          <button type="button" class="btn btn-outline-primary float-end" onclick="addForm('{{ route('member.store') }}')">+
            Member</button>
          {{-- <button type="button" class="mr-3 btn btn-outline-success float-end" onclick="cetakMember('{{ route('member.cetak_member') }}')">Cetak</button> --}}
        </h5>
        <div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table" id="table">
                <thead>
                  <form action="{{ route('member.cetak_member') }}" method="post" class="form-member">
                    @csrf
                    <th width="3%">
                      <input type="checkbox" name="select_all" id="select_all">
                    </th>
                    <th width="5%">No</th>
                    <th>Code</th>
                    <th>Member Name</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
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
                  <label for="nama">Name</label>
                </div>
                <div class="mt-2">
                  <input type="text" id="nama" class="form-control" name="nama" placeholder="Name" required
                    autofocus>
                  <span class="help-block with-errors"></span>
                </div>
                <div class="mt-2">
                  <label for="telepon">Phone</label>
                </div>
                <div class="mt-2">
                  <input type="text" id="telepon" class="form-control" name="telepon" placeholder="Product Name"
                    required autofocus>
                  <span class="help-block with-errors"></span>
                </div>
                <div class="mt-2">
                  <label for="alamat">Alamat</label>
                </div>
                <div class="mt-2">
                  <textarea id="alamat" class="form-control" name="alamat" placeholder="Harga Beli"autofocus></textarea>
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
          url: '{{ route('member.data') }}',
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
            data: 'kode_member'
          },
          {
            data: 'nama'
          },
          {
            data: 'telepon'
          },
          {
            data: 'alamat'
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
      $('#modal-form .modal-title').text('Tambah Member');

      $('#modal-form form')[0].reset();
      $('#modal-form form').attr('action', url);
      $('#modal-form [name=_method]').val('post');
      $('#modal-form [name=nama]').focus();
    }

    function editForm(url) {
      $('#modal-form').modal('show');
      $('#modal-form .modal-title').text('Edit Member');

      $('#modal-form form')[0].reset();
      $('#modal-form form').attr('action', url);
      $('#modal-form [name=_method]').val('put');
      $('#modal-form [name=nama]').focus();

      $.get(url)
        .done((response) => {
          $('#modal-form [name=nama]').val(response.nama);
          $('#modal-form [name=telepon]').val(response.telepon);
          $('#modal-form [name=alamat]').val(response.alamat);
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

    function cetakMember(url) {
      if ($('input:checked').length < 1) {
        alert('Pilih data yang akan dicetak');
        return;
      } else {
        $('.form-member')
          .attr('target', '_blank')
          .attr('action', url)
          .submit();
      }
    }
  </script>
@endpush
