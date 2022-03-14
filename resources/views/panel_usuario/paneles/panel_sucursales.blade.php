
@include('panel_usuario.common.success')
@include('panel_usuario.common.errors')
@include('panel_usuario.common.modal_borrar')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
	<h1 class="h2">Sucursales</h1>
	<div class="btn-toolbar mb-2 mb-md-0">
		<div class="btn-group mr-2">
			<a href="/panel_usuario/market/sucursales/create" class="btn btn-outline-primary"><strong>Nuevo</strong> <span data-feather="plus"></span></a>
		</div>
	</div>
</div>

<div class="table-responsive">
        <table class="table table-striped table-sm table-bordered table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre Surcusal</th>
              <th>Dirección</th>
              <th>Encargado</th>
              <th>Supervisor</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tbody>

            @foreach($sucursales as $market)

              <tr>
              <th scope="row">{{$market->id}}</th>
                <td id="nom_{{$market->id}}">{{$market->nombre}}</td>
                <td>{{$market->direccion}}</td>
                <td>{{$nombre_usuarios[$market->id_encargado]}}</td>   
                <td>{{$nombre_usuarios[$market->id_supervisor]}}</td>             
                <td>
                  <a href="/panel_usuario/market/sucursales/{{$market->id}}" class="btn btn-sm btn-outline-secondary" style="margin-right: 5px;"  ><span data-feather="eye" data-toggle="tooltip" data-placement="top" title="Detalle Sucursal"></span></a>
                  <a href="/panel_usuario/market/sucursales/{{$market->id}}/edit" class="btn btn-sm btn-outline-secondary" style="margin-right: 5px;"><span data-feather="edit-2" data-toggle="tooltip" data-placement="top" title="Editar Sucursal"></span></a>
                  <button type="button" class="btn btn-sm btn-outline-danger borrar_prod" data-toggle="modal" data-target="#confirma_modal" id="{{$market->id}}"><span data-feather="x" data-toggle="tooltip" data-placement="top" title="Eliminar Surcusal"></span></button>
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
            
            $("#dato_borrar").html(nombre);
            $("#form_borrar").attr('action','/panel_usuario/market/sucursales/'+ide);
            $("#titulo_modal").html('Eliminar Sucursal');
            $("#pregunta_modal").html('¿Confirma que desea borrar esta sucursal?');
          });       
        });      
      </script>
      @endsection