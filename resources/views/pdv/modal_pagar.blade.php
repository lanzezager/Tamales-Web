
<div class="modal fade" id="confirma_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"  id="titulo_modal">Confirmar Compra</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form  method="POST" action="/pdv/pagar" enctype="multipart/form-data" id="form_borrar">
        @csrf
        <div class="modal-body">
          <div style="max-height: 600px;">
            <table class="table table-sm table-hover" style="border: solid 1px; border-color: #dee2e6;" id="tabla_items_compra">
              <thead>
                <tr>
                  <th class="text-center" style="width: 5%;">#</th>
                  <th class="text-center" style="width: 44%;">Nombre</th>
                  <th class="text-center" style="width: 18%;">Precio Unitario</th>
                  <th class="text-center" style="width: 15%;">Cantidad</th>
                  <th class="text-center" style="width: 18%;">Importe</th>
                </tr>
              </thead>
              <tbody id="tabla_items">
                
              </tbody>
            </table>
          </div>
          <div class="form-group row">
            <div class="col-sm col_metodo">
              <label style="font-size: 1.2em; font-weight:600; margin-right: 10px;" for="metodo_pago">Método de Pago</label>
              <select name="metodo_pago" class="form-control" id="metodo_pago" style="max-width:200px; min-width:100px; font-size: 1em; display: inline;">
                <option value="0" disabled selected hidden>Selecciona Uno</option>
                <option value="1" style="font-size: 1em;">En Efectivo</option>
                <option value="2" style="font-size: 1em;">Tarjeta de Débito</option>
                <option value="3" style="font-size: 1em;">Tarjeta de Crédito</option>
              </select>
              <div class="form-group row" style="visibility: hidden; height: 0px; position: fixed; margin-top: 10px;" id="digitos_tarjeta_row">
            <div class="col-sm">
              <label style="margin-right: 10px; font-weight: 600; font-size: 1.2em" >Terminación Tarjeta</label>
              <div class="input-group" style="width:70px; display: inline-flex;">               
                <input type="text" class="form-control" id="digitos_tarjeta" value="" maxlength="4" name="digitos_tarjeta" placeholder="" onkeypress="return filterInteger(event,this);" onpaste="return false" style="font-size: 1rem;font-weight: 600; color: #3490dc; background-color: #ffffff;" data-toggle="tooltip" data-placement="top" title="Ingresar sólo los ultimos 4 dígitos">
              </div>  
            </div>
          </div>
            </div>
            <div class="col-sm-5 col_total" style="text-align: right;">
              <label style="margin-right: 10px; font-weight: 600; font-size: 1.5em">Total</label>
              <div class="input-group" style="width:145px; display: inline-flex;">
                <div class="input-group-prepend">
                  <span class="input-group-text"><span data-feather="dollar-sign"></span></span>
                </div>
                <input type="text" class="form-control" id="gran_total_modal" value="0.00" name="gran_total" placeholder="" onpaste="return false" readonly style="font-size: 1.2rem;font-weight: 600; color: #3490dc; background-color: #ffffff;">
              </div>    
            </div>   
          </div>
          
          <input type="text" name="lista_compra" style="visibility: hidden; height: 0px; position: fixed;" id="lista_compra">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Atrás</button>
          <button type="submit" class="btn btn-primary" style="font-weight: 600;" id="pagar">PAGAR</button>
        </div>
      </form> 
    </div>
  </div>
</div>