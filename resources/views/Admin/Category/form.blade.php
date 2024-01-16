<div class="card-content">
  <div class="card-body">
    <div class="modal text-left" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="modal-title"></h4>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <i data-feather="x"></i>
            </button>
          </div>
        </div>
      </div>
      <div class="modal-body">
        <form action="" method="POST" class="form form-horizontal">
          @csrf
          @method('post')
          <div class="form-body">
            <div class="row">
              <div class="col-md-4">
                <label for="first-name-horizontal">Category Name</label>
              </div>
              <div class="col-md-8 form-group">
                <input type="text" id="nama_kategori" class="form-control" name="nama_kategori"
                  placeholder="Category Name" required autofocus>
                <span class="help-block with-errors"></span>
              </div>
              <div class="col-sm-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                <button type="button" class="btn btn-light-secondary me-1 mb-1" data-bs-dismiss="modal">Cancel</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

