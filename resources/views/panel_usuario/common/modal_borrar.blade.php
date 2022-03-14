
<div class="modal fade" id="confirma_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"  id="titulo_modal"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class ="" method="POST" action="" enctype="multipart/form-data" id="form_borrar">
        @method('DELETE')<!-- etiqueta importante -->
        @csrf
        <div class="modal-body">
          <p id="pregunta_modal"></p>
          <div class="alert alert-danger" role="alert">
           <div class="d-block" id="dato_borrar"></div>
          </div> 
            Esta acción no se puede deshacer.         
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
          <button type="submit" class="btn btn-primary">SÍ</button>
        </div>
      </form> 
    </div>
  </div>
</div>