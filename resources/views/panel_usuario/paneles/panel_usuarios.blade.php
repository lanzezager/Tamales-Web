
@include('panel_usuario.common.success')
@include('panel_usuario.common.errors')
@include('panel_usuario.common.modal_borrar')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
	<h1 class="h2">Usuarios</h1>
	<div class="btn-toolbar mb-2 mb-md-0">
		<div class="btn-group mr-2">
			
		</div>
	</div>
</div>

<div class="table-responsive">
        <table class="table table-striped table-sm table-bordered table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre(s)</th>
              <th>Apellido(s)</th>
              <th>Puesto(s)</th>
              <th>Email</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tbody>
            @foreach($query_usuarios as $usuario)

              @if(in_array('Inactivo', $puestos_query[$usuario->id]))
                <tr class="table-danger" data-toggle="tooltip" data-placement="top" title="Usuario Desactivado">
              @else
                <tr>
              @endif

                  <th scope="row" id="idd_{{$usuario->hash_user}}">{{$usuario->id}}</th>
                  <td id="nom_{{$usuario->id}}">{{$usuario->nombre_s}}</td>
                  <td id="ape_{{$usuario->id}}">{{$usuario->apellido_s}}</td>
                  <td>

                  @foreach($puestos_query[$usuario->id] as $puesto)
                    @if($puesto=='Empleado')

                    @else
                      <span class="badge badge-secondary">{{$puesto}}</span>
                    @endif
                  @endforeach

                  </td>
                  <td>{{$usuario->email}}</td>
                  <td>
                    <a href="/panel_usuario/usuarios/{{$usuario->hash_user}}" class="btn btn-sm btn-outline-secondary" style="margin-right: 5px;"><span data-feather="eye" data-toggle="tooltip" data-placement="top" title="Detalle Usuario"></span></a>
                    <a href="/panel_usuario/usuarios/{{$usuario->hash_user}}/edit" class="btn btn-sm btn-outline-secondary" style="margin-right: 5px;"><span data-feather="edit-2" data-toggle="tooltip" data-placement="top" title="Editar Usuario"></span></a>
                    <button type="button" class="btn btn-sm btn-outline-danger borrar_usr" data-toggle="modal" data-target="#confirma_modal" id="{{$usuario->hash_user}}"><span data-feather="x" data-toggle="tooltip" data-placement="top" title="Eliminar Usuario"></span></button>
                  </td>
              </tr>

            @endforeach
            
          </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-center">
          {!! $query_usuarios->onEachSide(1)->links('vendor.pagination.bootstrap-4'); !!}
      </div>

      @section('script_opc_final')
      <script type="text/javascript">
        $(function () {
          $('[data-toggle="tooltip"]').tooltip()
        })
      </script>

      <script type="text/javascript">
        $(document).ready(function(){
          $(".borrar_usr").click(function(){
            var clave= $(this).attr('id');
            var ide= $("#idd_"+clave).html();
            var nombre = $("#nom_"+ide).html();
            var apellido = $("#ape_"+ide).html();
            
            $("#dato_borrar").html(nombre+" "+apellido);
            $("#form_borrar").attr('action','/panel_usuario/usuarios/'+clave);
            $("#titulo_modal").html('Eliminar Usuario');
            $("#pregunta_modal").html('¿Confirma que desea borrar este usuario?');
          });       
        });
      </script>
      @endsection