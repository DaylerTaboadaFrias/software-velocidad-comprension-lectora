<form method="POST" action="{{route('category.store')}}" enctype="multipart/form-data">
        @csrf
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">New message</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Nombre</label>
            <input type="text" class="form-control" id="recipient-name" name="name">
          </div>
          
          <div class="mb-3">
            <input type="file" name="img" class="form-control" id="formFile">
          </div>

        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Send message</button>
      </div>
    </div>
  </div>
</div>
</form>