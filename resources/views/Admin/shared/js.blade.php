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
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
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
      } else if (type === 'success') {
        return swal({
          title: 'Congratulations!',
          text: 'You entered the correct answer',
          icon: 'success',
          timer: 2000,
          button: false,
        }).then(
          function() {}, // No need for a success callback here
          function(dismiss) {
            if (dismiss === 'timer') {
              console.log('I was closed by the timer');
            }
          }
        );
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
