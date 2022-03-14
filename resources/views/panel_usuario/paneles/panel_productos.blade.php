
@include('panel_usuario.common.success')
@include('panel_usuario.common.errors')
@include('panel_usuario.common.modal_borrar')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
	<h1 class="h2">Productos</h1>
	<div class="btn-toolbar mb-2 mb-md-0">
		<div class="btn-group mr-2">
			<a href="/panel_usuario/productos/create" class="btn btn-outline-primary"><strong>Nuevo</strong> <span data-feather="plus"></span></a>
		</div>
	</div>
</div>

<div class="table-responsive">
        <table class="table table-striped table-sm table-bordered table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre Producto</th>
              <th>Precio</th>
              <th>Categoría</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tbody>

            @foreach($productos as $producto)

              @if($producto->activo==0)
                <tr class="table-danger" data-toggle="tooltip" data-placement="top" title="Producto Desactivado">
              @else
                <tr>
              @endif
              <th scope="row">{{$producto->id}}</th>
                <td id="nom_{{$producto->id}}">{{$producto->nombre}}</td>
                <td>$ {{$producto->precio}} USD</td>
                <td><h5><span class="badge badge-primary">{{$catego_produ[($producto->id_categoria-1)]->descripcion}}</span></h5></td>                
                <td>
                  <a href="/panel_usuario/productos/{{$producto->id}}" class="btn btn-sm btn-outline-secondary" style="margin-right: 5px;"><span data-feather="eye" data-toggle="tooltip" data-placement="top" title="Detalle Producto"></span></a>
                  <a href="/panel_usuario/productos/{{$producto->id}}/edit" class="btn btn-sm btn-outline-secondary" style="margin-right: 5px;"><span data-feather="edit-2" data-toggle="tooltip" data-placement="top" title="Editar Producto"></span></a>
                  <button type="button" class="btn btn-sm btn-outline-danger borrar_prod" data-toggle="modal" data-target="#confirma_modal" id="{{$producto->id}}"><span data-feather="x" data-toggle="tooltip" data-placement="top" title="Eliminar Producto"></span></button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="d-flex justify-content-center">
          {!! $productos->onEachSide(1)->links('vendor.pagination.bootstrap-4'); !!}
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
            $("#form_borrar").attr('action','/panel_usuario/productos/'+ide);
            $("#titulo_modal").html('Eliminar Producto');
            $("#pregunta_modal").html('¿Confirma que desea borrar este producto?');
          });       
        });
      
      </script>
      @endsection