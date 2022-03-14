
@include('panel_usuario.common.success')
@include('panel_usuario.common.errors')
@include('panel_usuario.common.modal_borrar')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
	<h1 class="h2">Recibo de Inventario</h1>
	<div class="btn-toolbar mb-2 mb-md-0">
		<div class="btn-group mr-2">
			<a href="/panel_usuario/market/r_inventario/create" class="btn btn-outline-primary"><strong>Nuevo</strong> <span data-feather="plus"></span></a>
		</div>
	</div>
</div>

<div class="table-responsive">
        <table class="table table-striped table-sm table-bordered table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>Market</th>
              <th>Supervisor</th>
              <th>Valor Recibido</th>
              <th>Observación</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tbody>

            @foreach($recibos_inventario as $inventario)

              <tr>
              <th scope="row" id="nom_{{$inventario->id}}">{{$inventario->id}}</th>
               
                @foreach($markets as $market) 
                  @if($market->id==$inventario->id_market)
                    <td>{{$market->nombre}}</td>
                  @endif
                @endforeach

                @foreach($usurios as $user) 
                  @if($user->id==$inventario->id_supervisor)
                    <td>{{$user->nombre_s}} {{$user->apellido_s}}</td>
                  @endif
                @endforeach
                
                <td>$ {{($inventario->cambio_entregado + $inventario->valor_mercancia)}}</td>

                <td >{{$inventario->observacion}}</td>   
                            
                <td>
                  <a href="/panel_usuario/market/r_inventario/{{$inventario->id}}" class="btn btn-sm btn-outline-secondary" style="margin-right: 5px;"  ><span data-feather="eye" data-toggle="tooltip" data-placement="top" title="Detalle Entrega"></span></a>
                  <a href="/panel_usuario/market/r_inventario/{{$inventario->id}}/report" class="btn btn-sm btn-outline-secondary" style="margin-right: 5px;"><span data-feather="file-text" data-toggle="tooltip" data-placement="top" title="Generar Reporte"></span></a>
                  @if($rango_chido=='administrador'||$rango_chido=='gerente')
                    <a href="/panel_usuario/market/r_inventario/{{$inventario->id}}/edit" class="btn btn-sm btn-outline-secondary" style="margin-right: 5px;"><span data-feather="edit-2" data-toggle="tooltip" data-placement="top" title="Editar Entrega"></span></a>                  
                    <button type="button" class="btn btn-sm btn-outline-danger borrar_prod" data-toggle="modal" data-target="#confirma_modal" id="{{$inventario->id}}"><span data-feather="x" data-toggle="tooltip" data-placement="top" title="Eliminar Entrega"></span></button>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
</div>
      
      @section('script_opc_final')
      <script type="text/javascript">
        $(function () {
          $('[data-toggle="tooltip"]').tooltip()
        })
      </script>

      <script type="text/javascript">
        $(document).ready(function(){
          $(".borrar_prod").click(function(){
            var ide= $(this).attr('id');
            var nombre = $("#nom_"+ide).html();
            
            $("#dato_borrar").html("Recibo con el Id: "+nombre);
            $("#form_borrar").attr('action','/panel_usuario/market/r_inventario/'+ide);
            $("#titulo_modal").html('Eliminar Recibo');
            $("#pregunta_modal").html('¿Confirma que desea borrar este recibo?');
          });       
        });
      
      </script>
      @endsection