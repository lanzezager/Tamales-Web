function add_productos() {
		var nvo_nom=document.getElementById("usr").value;
		//var cant=document.getElementById("cantidad").value;
		var cant = $("#cantidad").val();
		var gran_tot=document.getElementById("gran_total").value;
		var tabla = document.getElementById("tabla_productos").innerHTML;
		//var prod = @json($productos);
		var prod =window.products;
		var count = Object.keys(prod).length;		

		var i=0;
		var id="",nom="";
		var costo=0,precio=0,id_catego=0;

		//console.log(prod);

		if(nvo_nom!='0'){
			while(i<count){
				if(prod[i].id==nvo_nom){
					id=prod[i].id;
					nom=prod[i].nombre;
					precio=prod[i].precio;
					id_catego=prod[i].id_categoria;
					costo=parseFloat(cant*prod[i].precio).toFixed(2);

					if(id_catego==6){
						costo=(0.00).toFixed(2);						
					}
					i=count+1;
				}
				i++;
			}

			if (isNaN(gran_tot)){
				gran_tot=parseFloat(0.00);
			}

			if(document.getElementById("id_fila_"+id)==null){
				
				var linea='<tr id="id_fila_'+id+'">'+
									'<td scope="row" >'+id+'</td>'+
									'<td class="nombre_producto">'+nom+'</td>'+
									'<td class="precio_producto">'+precio+'</td>'+
									'<td class="cantidad_producto">'+cant+'</td>'+
									'<td id="valor_total_'+id+'">'+costo+'</td>'+
									'<td class="accion"><button type="button" class="btn btn-sm btn-outline-secondary borrar_emple" id="'+id+'"><span data-feather="x" data-toggle="tooltip" data-placement="top" title="Eliminar de la Lista">X</span></button></td>'+
							   '</tr>';
				document.getElementById("tabla_productos").innerHTML=tabla+linea;
				//document.getElementById("cantidad").value=0;
				$('#cantidad').val(0);
				document.getElementById("gran_total").value=parseFloat(Number(gran_tot)+Number(costo)).toFixed(2);
				document.getElementById("usr").value=0;
			
			}else{
				console.log('Ya existe id');
			}
		}
	}