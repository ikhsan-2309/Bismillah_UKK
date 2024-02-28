<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="{{ asset('vendors/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('vendors/datatables/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('assets/compiled/js/validator.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
{{-- <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script> --}}
<script src="{{ asset('vendors/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/off-canvas.js') }}"></script>
<script src="{{ asset('js/jquery-cookie.js') }}"></script>
<script src="{{ asset('js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('js/template.js') }}"></script>
<script src="{{ asset('js/settings.js') }}"></script>
<script src="{{ asset('js/todolist.js') }}"></script>
<script>
  (function($) {
    showSwal = function(type) {
      if (type === 'delete') {
        return swal({ // Return the Promise
          title: 'Confirm Deletion',
          text: "Are you sure you want to delete this item?",
          icon: 'warning',
          buttons: {
            cancel: {
              text: "Cancel",
              value: null,
              visible: true,
              className: "btn btn-danger",
              closeModal: true
            },
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "btn btn-primary",
              closeModal: true
            }
          }
        });
      } else if (type === 'transaction') {
        return swal({ // Return the Promise
          title: 'Confirm Deletion',
          text: "Are you sure you want to delete this item?",
          icon: 'warning',
          buttons: {
            cancel: {
              text: "Cancel",
              value: null,
              visible: true,
              className: "btn btn-danger",
              closeModal: true
            },
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "btn btn-primary btn-simpan",
              closeModal: true
            }
          }
        });
      } else if (type === 'success') {
        return swal({
          title: 'Successfully',
          text: 'The item has been saved successfully.',
          icon: 'success',
          timer: 2000,
          button: false,
        });
      } else if (type === 's-delete') {
        return swal({
          title: 'Item Deleted Successfully',
          text: 'The item has been deleted.',
          icon: 'success',
          timer: 2000,
          button: false,
        });
      } else if (type === 'error') {
        return swal({
          title: 'Error',
          text: 'Terdapat Kesalahan',
          icon: 'error',
          timer: 2000,
          button: false,
        });
      }
    }
  })(jQuery);
</script>
