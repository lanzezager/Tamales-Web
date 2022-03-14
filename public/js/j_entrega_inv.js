	$(document).ready(function(){
		$('body #tabla_productos_entrega').on('click', 'button', function(){
	        //event.preventDefault();
	        var index=$(this).attr('id');
	        //console.log(index);
	        var precio_menos=$("#valor_total_" + index).html();
	        var gran_tot_ori=$("#gran_total").val();
	        //console.log((gran_tot_ori-precio_menos));

	        $('#gran_total').val((gran_tot_ori-precio_menos).toFixed(2));    	
	        $("#id_fila_" + index).remove();
	    })

		$("#cambio").select(function(){
			var gran_tot_ori=$("#gran_total").val();
			var cambio=$("#cambio").val();

			var suma=0;
			$('#tabla_productos_entrega tbody tr').each(function() {
				var valor = $(this).find('td').eq(4).text();				
				suma=Number(suma)+Number(valor);
			});

			//console.log((suma));
			//console.log((cambio));

			if(isNaN(cambio)){
				$('#gran_total').val(Number(suma)+Number(0));
			}else{
				$('#gran_total').val((Number(suma)+Number(cambio)).toFixed(2));
			}
			
		});

		$("#cambio").keyup(function(){
			var gran_tot_ori=$("#gran_total").val();
			var cambio=$("#cambio").val();

			var suma=0;
			$('#tabla_productos_entrega tbody tr').each(function() {
				var valor = $(this).find('td').eq(4).text();				
				suma=Number(suma)+Number(valor);
			});

			//console.log((suma));
			//console.log((cambio));

			if(isNaN(cambio)){
				$('#gran_total').val(Number(suma)+Number(0));
			}else{
				$('#gran_total').val((Number(suma)+Number(cambio)).toFixed(2));
			}
			
		});

		$("#mercado").change(function(){
			if(($("#tipo_form").val())<3){
				//var emple = @json($empleados_market);
				var emple= window.emple;
				var mark_id=this.value;
				$('#sel_empleados').val(0);				
				$("#sel_empleados").empty();
				
				var option = $('<option  selected hidden></option>').attr("value", "0").text("Selecciona Uno");
				$("#sel_empleados").append(option);
				console.log('Hola :D');
				//console.log(emple);
				var cuenta=Object.keys(emple).length;
				var i=0;
				var numero=0;
				var receptor=$("#receptor").val();

				while(i<cuenta){
					try{
						if((Object.keys(emple[i][""+mark_id+""]).length)!=null){
							//console.log('numero:'+i);
							numero=i;
						}		
					}catch{}
					i++;
				}			

				//console.log(numero);
				var sub_cuenta=Object.keys(emple[numero][""+mark_id+""]).length;
				
				i=0;		

				while(i<sub_cuenta){
					var ide=emple[numero][""+mark_id+""][i].id;
					var nombre=emple[numero][""+mark_id+""][i].nombre;

					if(($("#tipo_form").val())==2){
						if(receptor==ide){
							var option1 = $('<option selected></option>').attr("value", ide).text(nombre);
						}else{
							
							var option1 = $('<option></option>').attr("value", ide).text(nombre);
						}
					}else{
												
						var option1 = $('<option></option>').attr("value", ide).text(nombre);
					}

					$("#sel_empleados").append(option1);
					i++;
				}
			}
		});
		
		if(($("#tipo_form").val())==2){
			var $select = $('#mercado');
			$select.trigger('change');
		}
	});