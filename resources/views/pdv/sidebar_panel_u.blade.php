<nav id="barra_venta" class="col-md-3 d-none d-md-block bg-light fixed-right sidebar" style="right: 0; left: auto; border: solid; border-width: 0px 0px 0px 1px; border-color: rgb(223,224,225); width: 24%; z-index: 1001; min-width: 195px;">
  <div class="sidebar-sticky">
    <div style="position: fixed; background-color: #f8f9fa;  margin-top: -10px; width: 24%; z-index: 1002; border-bottom: 1px solid; border-color: #cdcdcd; height: 49px; min-width: 195px;">
      <div class="text-center" style="font-weight: 600; font-size: 2em; ">Caja</div>
    </div>
    
    <ul class="nav flex-column" style="margin-top: 35px; margin-bottom: 30vh; " id="accordion">
              
    </ul>
    <!-- *****CUADRO PAGO ****** -->
    <div style="position: fixed; background-color: #f8f9fa; width: 24%; top: auto; bottom: 0; height: 30vh; border-top: 2px solid; border-color: #cdcdcd; min-width: 195px;">
      <div class ="form-row total_pagar" style="margin-left: 1rem;  margin-top: 0.5rem;">
       <!-- <div class="form-group col-4" style="font-size: 1.5em; font-weight: 600;">
                 
        </div> -->
        <div class="form-group col-auto text-center" style="font-size: 1.5em; font-weight: 600; width: 100%; float: right; display: inline; padding-right: 2rem;">
          <label style="margin-right: 10px;">Total</label>
          <div class="input-group" style="width:145px; display: inline-flex;">
            <div class="input-group-prepend">
              <span class="input-group-text"><span data-feather="dollar-sign"></span></span>
            </div>
            <input type="text" class="form-control" id="gran_total" value="0.00" name="gran_total" placeholder="" onpaste="return false" readonly style="font-size: 1.2rem;font-weight: 600; color: #3490dc; background-color: #ffffff;">
          </div>
        </div>
      </div>
      <div class="text-center" style="font-weight: 600; font-size: 2em; height: 100px;">
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#confirma_modal" id="btn_pagar">Pagar</button>
      </div>
    </div>
    <!-- *****CUADRO PAGO ****** -->
  </div>  
</nav>
