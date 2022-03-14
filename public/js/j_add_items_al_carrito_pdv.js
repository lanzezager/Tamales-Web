jQuery(document).ready(function() {
	/*------------AÑADIR A LISTA ------------*/
	$('.ficha_item').on('click', function(){
		var index=$(this).attr('id');		
		var produ =window.products;
		var count = Object.keys(produ).length;
		var i=0,j=0,k=0,precio_u=0,existencias=0,id_catego=0,venta_valida=0,tope_exis=0;
		var nombre='',pre_tope='';		

		var gran_tot=$('#gran_total').val();
		var howMany = $('#accordion li').length;

		//console.log(produ);
		if($('#item_'+index).length){		
			//console.log(exis);
			while(i<count){
				if(produ[i].id_producto==index){
					if((produ[i].id_categoria)!=6){
						var exis =$('#item_existencias_'+index).val();
						exis=(Number(exis)+Number(1));

						precio_u=produ[i].precio_u;
						//tope_exis=produ[i].existencias;
						pre_tope=$('#tope_existencias_'+index).html();
						tope_exis=Number(pre_tope.substring(1,pre_tope.length));

						if(tope_exis>0){
							$('#item_existencias_'+index).val(exis);
							$('#precio_subtotal_'+index).html('$'+(Number(exis)*Number(precio_u)).toFixed(2));
							$('#tope_existencias_'+index).html('X'+(Number(tope_exis)-Number(1)));
							$('#item_existencias_'+index).attr('prevalue',exis);
						}

					}else{//Si es combo

						var exis =$('#item_existencias_'+index).val();
						exis=(Number(exis)+Number(1));

						precio_u=produ[i].precio_u;
						var items=(produ[i].items).split(',');
						k=0;

						while(k<items.length){
							j=0;
							while(j<count){
								if(produ[j].id_producto==items[k]){									
									//tope_exis=produ[j].existencias;
									pre_tope=$('#tope_existencias_'+items[k]).html();
									tope_exis=Number(pre_tope.substring(1,pre_tope.length));									
									//console.log(tope_exis);
									if(tope_exis>0){													
										venta_valida=1;
									}else{
										venta_valida=0;
										k=items.length+1;
									}
								}
								j++;
							}
							k++;
						}
						
						if(venta_valida==1){
							$('#item_existencias_'+index).val(exis);
							$('#item_existencias_'+index).attr('prevalue',exis);
							$('#precio_subtotal_'+index).html('$'+(Number(exis)*Number(precio_u)).toFixed(2));
							
							k=0;
							while(k<items.length){
								j=0;
								while(j<count){
									if(produ[j].id_producto==items[k]){									
										//tope_exis=produ[j].existencias;
										pre_tope=$('#tope_existencias_'+items[k]).html();
										tope_exis=Number(pre_tope.substring(1,pre_tope.length));										
										$('#tope_existencias_'+items[k]).html('X'+(Number(tope_exis)-Number(1)));
									}
									j++;
								}
								k++;
							}

						}
						
					}//fin combo
					//console.log((Number(exis)*Number(precio_u)));
					i=count+1;
				}
				i++;
			}
		}else{
			while(i<count){
				if(produ[i].id_producto==index){
					nombre=produ[i].nombre;
					precio_u=produ[i].precio_u;
					//existencias=produ[i].existencias;
					pre_tope=$('#tope_existencias_'+index).html();
					//console.log(pre_tope);
					existencias=Number(pre_tope.substring(1,pre_tope.length));

					if((produ[i].id_categoria)==6){
						existencias=999;
						var items=(produ[i].items).split(',');
						k=0;

						while(k<items.length){
							j=0;
							while(j<count){
								if(produ[j].id_producto==items[k]){									
									//tope_exis=produ[j].existencias;
									pre_tope=$('#tope_existencias_'+items[k]).html();
									tope_exis=Number(pre_tope.substring(1,pre_tope.length));
									
									if(tope_exis>0){													
										venta_valida=1;

										if(existencias>produ[j].existencias){
											existencias=produ[j].existencias;									
										}
									}else{
										venta_valida=0;
										k=items.length+1;
									}
								}
								j++;
							}
							k++;
						}
					}

					/*
					<!-- BLOQUE ITEM -->
				      <!--
				      <li class="nav-item item_compra" style="border-bottom: 2px dotted; border-color: #cdcdcd; position: relative; height: 90px;">
				        <div class="text-center quita_elemento" style="width: 1rem; font-weight: 600; float:left; height: 100%; position: relative;"><span data-feather="x" style="position: absolute; top: 42%; right: 0%;"></span></div>
				        <div class ="form-row item_detalle" style="margin-left:5%; margin-top: 0.5rem; margin-bottom: 0.5rem; width:60%; display: inline-block;">
				          <div class="form-group col" style="margin-bottom:0px;">
				            <div class ="form-row text-center" style="font-size: 1em;">
				              Tamal de Puerco Con Salsa Verde
				            </div>
				            <div class ="form-row" >
				              <div class="form-group col text-center" style="margin-bottom:0px; font-size: 1.1em; font-weight: 600;">
				                $2.25
				              </div>
				              <div class="form-group col text-center" style="margin-bottom:0px; font-size: 1.1em">
				                <div style="width:80px; ">
				                  <input type="number" value="0" min="0" max="99" step="1" name="cantidad" placeholder="0" class="form-control-sm text-center" id="cantidad">
				                </div> 
				              </div>              
				            </div>
				          </div>          
				        </div>
				        <div class="text-center item_contenedor_precio" style="font-size: 1.2em; font-weight: 600; float:right; height: 100%; width:25%;  position: relative;">
				              <span class="item_precio" style="position: absolute; top: 35%; left: 5%;">$4.85</span>
				        </div>      
				      </li>
				      -->
				    <!-- BLOQUE ITEM -->  
					*/

					var linea='<li class="nav-item item_compra" style="border-bottom: 2px dotted; border-color: #cdcdcd; position: relative; height:90px;" id="item_'+index+'">'+
	        					'<div class="text-center quita_elemento" style="width: 1rem; font-weight: 600; float:left; height: 100%; position: relative;" id="quita_'+index+'"><span data-feather="x" style="position: absolute; top: 38%; right: 20%;">X</span></div>'+
	        						'<div class ="form-row item_detalle" style="margin-left:5%; margin-top: 0.5rem; margin-bottom: 0.5rem; width:60%; display: inline-block;">'+
	          							'<div class="form-group col" style="margin-bottom:0px;">'+
	            							'<div class ="form-row text-center nombre_item" style="font-size: 1em;">'+
	              								nombre+
	            							'</div>'+
	            						'<div class ="form-row" >'+
	              							'<div class="form-group col text-center precio_item" style="margin-bottom:0px; font-size: 1.1em; font-weight: 600;">'+
	                							'$'+precio_u+
	              							'</div>'+
	              							'<div class="form-group col text-center" style="margin-bottom:0px; font-size: 1.1em">'+
	                							'<div style="width:80px; ">'+
	                  								'<input type="number" prevalue="1" value="1" min="0" max="'+existencias+'" step="1" name="cantidad" placeholder="0" class="form-control-sm text-center item_existencias" id="item_existencias_'+index+'" style="width: 60px; font-size: .8em; font-weight: bold;">'+
	                							'</div>'+
	              							'</div>'+              
	            						'</div>'+
	          						'</div>'+          
	        					'</div>'+
	        					'<div class="text-center item_contenedor_precio" style="font-size: 1.2em; font-weight: 600; float:right; height: 100%; width:25%;  position: relative;">'+
	              					'<span class="item_precio" style="position: absolute; top: 35%; left: 5%;" id="precio_subtotal_'+index+'">$'+precio_u+'</span>'+
	        					'</div>'+     
	      					'</li>';
	      			if(existencias>0){
	      				if((produ[i].id_categoria)!=6){		
		      				$('#accordion').append(linea);
		      				$('#tope_existencias_'+index).html('X'+(Number(existencias)-Number(1)));
		      			}else{
		      				if (venta_valida==1) {
		      					$('#accordion').append(linea);
		      					k=0;
								while(k<items.length){
									j=0;
									while(j<count){
										if(produ[j].id_producto==items[k]){									
											//tope_exis=produ[j].existencias;	
											pre_tope=$('#tope_existencias_'+items[k]).html();
											tope_exis=Number(pre_tope.substring(1,pre_tope.length));
											//console.log(tope_exis);								
											$('#tope_existencias_'+items[k]).html('X'+(Number(tope_exis)-Number(1)));
										}
										j++;
									}
									k++;
								}		      					
		      				}
		      			}
	      			}
	      			//$('#gran_total').val(parseFloat(Number(gran_tot)+Number(precio_u)).toFixed(2));
	      			i=count+1;
				}
				i++;
			}
		}
		//console.log(index+' '+nombre+' '+precio_u+' '+existencias);
		var total=0;
		$(".item_compra").each(function(){
    		var id=$(this).attr('id');
    		id=id.substring(5,id.length);    		
    		var sub_tot=$('#precio_subtotal_'+id).html();
    		//console.log(sub_tot);
    		sub_tot=sub_tot.substring(1,sub_tot.length);
    		total=(Number(total)+Number(sub_tot)).toFixed(2);
   		});
		$('#gran_total').val(total);

	});

	/*------------QUITAR DE LISTA ------------*/
	$(document).on("click",".quita_elemento",function(){
		var id=$(this).attr('id');
		var produ =window.products;
		var count = Object.keys(produ).length;	
		var i=0,j=0,k=0,precio_u=0,existencias=0,id_catego=0,venta_valida=0,tope_exis=0;
		//console.log(id.length);
		id=id.substring(6,id.length);
		while(i<count){
			if(produ[i].id_producto==id){
				if((produ[i].id_categoria)!=6){
					//var tope_exis=produ[i].existencias;
					pre_tope=$('#tope_existencias_'+id).html();
					tope_exis=Number(pre_tope.substring(1,pre_tope.length));
					act_exis=Number($('#item_existencias_'+id).val());
					tope_exis=Number(tope_exis)+Number(act_exis);
					$('#tope_existencias_'+id).html('X'+(tope_exis));
				}else{
					var items=(produ[i].items).split(',');
					k=0;

					while(k<items.length){
						j=0;
						while(j<count){
							if(produ[j].id_producto==items[k]){									
								tope_exis=Number(0);
								pre_tope=$('#tope_existencias_'+items[k]).html();
								tope_exis=Number(pre_tope.substring(1,pre_tope.length));
								act_exis=Number($('#item_existencias_'+id).val());
								tope_exis=Number(tope_exis)+Number(act_exis);
								$('#tope_existencias_'+items[k]).html('X'+(tope_exis));
							}
							j++;
						}
						k++;
					}
				}

				i=count+1;

			}
			i++;
		}
		//console.log(id);
		$("#item_"+id).remove();
		
		var total=0;
		$(".item_compra").each(function(){
    		var id=$(this).attr('id');
    		id=id.substring(5,id.length);    		
    		var sub_tot=$('#precio_subtotal_'+id).html();
    		//console.log(sub_tot);
    		sub_tot=sub_tot.substring(1,sub_tot.length);
    		total=(Number(total)+Number(sub_tot)).toFixed(2);
   		});
		$('#gran_total').val(total);

	});

	/*------------MODIFICAR EXISTENCIA LISTA ------------*/
	$(document).on("change",".item_existencias",function(){
		var index=$(this).attr('id');
		index=index.substring(17,index.length);
		var produ =window.products;
		var count = Object.keys(produ).length;	
		var i=0,prevalue=0,diff=0,venta_valida=0,k=0,j=0,tope_exis=0;
		//console.log('cambio '+index);

		var exis =$('#item_existencias_'+index).val();
		//$('#item_existencias_'+index).attr('prevalue',exis);
		//console.log(exis);

		while(i<count){
			if(produ[i].id_producto==index){
				if((produ[i].id_categoria)!=6){
					precio_u=produ[i].precio_u;
					pre_tope=$('#tope_existencias_'+index).html();
					tope_exis=Number(pre_tope.substring(1,pre_tope.length));
					tope_exis=Number(tope_exis)
					prevalue=$('#item_existencias_'+index).attr('prevalue');

					if(Number(prevalue)<Number(exis)){
						diff=Number(exis)-Number(prevalue);

						if(Number(diff)>0){
							$('#precio_subtotal_'+index).html('$'+(Number(exis)*Number(precio_u)).toFixed(2));
							$('#tope_existencias_'+index).html('X'+(Number(tope_exis)-Number(diff)));
							$('#item_existencias_'+index).attr('prevalue',exis);
						}

					}else{
						if(Number(prevalue)>Number(exis)){
							diff=Number(prevalue)-Number(exis);

							if(Number(diff)>0){
								$('#precio_subtotal_'+index).html('$'+(Number(exis)*Number(precio_u)).toFixed(2));
								$('#tope_existencias_'+index).html('X'+(Number(tope_exis)+Number(diff)));
								$('#item_existencias_'+index).attr('prevalue',exis);
							}
						}else{
							$('#item_existencias_'+index).attr('prevalue',exis);
						}
					}
					//tope_exis=produ[i].existencias;
					
					//console.log((Number(exis)*Number(precio_u)));
				}else{

					precio_u=produ[i].precio_u;
					var items=(produ[i].items).split(',');
					k=0;

					while(k<items.length){
						j=0;
						while(j<count){
							if(produ[j].id_producto==items[k]){									
								//tope_exis=produ[j].existencias;									
								pre_tope=$('#tope_existencias_'+items[k]).html();
								tope_exis=Number(pre_tope.substring(1,pre_tope.length));
								prevalue=$('#item_existencias_'+index).attr('prevalue');
								//console.log(tope_exis);
									if(Number(prevalue)<Number(exis)){
										diff=Number(exis)-Number(prevalue);

										if(Number(diff)>0){
											if(tope_exis>0){
												venta_valida=1;
											}else{
												venta_valida=0;
												k=items.length+1;
											}
										}else{
											venta_valida=0;
											k=items.length+1;
										}
									}else{
										if(Number(prevalue)>Number(exis)){
											diff=Number(prevalue)-Number(exis);

											if(Number(diff)>0){
												//if(tope_exis>0){
													venta_valida=1;
												/*}else{
													venta_valida=0;
													k=items.length+1;
												}*/
											}else{
												venta_valida=0;
												k=items.length+1;
											}
										}else{
											//$('#item_existencias_'+index).attr('prevalue',exis);
										}
									}
								
								/*
								if(exis<=tope_exis){													
									venta_valida=1;
								}else{
									venta_valida=0;
									k=items.length+1;
								}
								*/
							}
							j++;
						}
						k++;
					}

					if(venta_valida==1){
						$('#precio_subtotal_'+index).html('$'+(Number(exis)*Number(precio_u)).toFixed(2));
						//$('#item_existencias_'+index).attr('prevalue',exis);
						k=0;
						while(k<items.length){
							j=0;
							while(j<count){
								if(produ[j].id_producto==items[k]){									
									//tope_exis=produ[j].existencias;
									pre_tope=$('#tope_existencias_'+items[k]).html();
									tope_exis=Number(pre_tope.substring(1,pre_tope.length));
									prevalue=$('#item_existencias_'+index).attr('prevalue');

									if(Number(prevalue)<Number(exis)){
										diff=Number(exis)-Number(prevalue);

										if(Number(diff)>0){
											$('#tope_existencias_'+items[k]).html('X'+(Number(tope_exis)-Number(diff)));
										}
									}else{
										if(Number(prevalue)>Number(exis)){
											diff=Number(prevalue)-Number(exis);

											if(Number(diff)>0){
												$('#tope_existencias_'+items[k]).html('X'+(Number(tope_exis)+Number(diff)));
											}
										}else{
											//$('#item_existencias_'+index).attr('prevalue',exis);
										}
									}
									//$('#tope_existencias_'+items[k]).html('X'+(Number(tope_exis)-Number(exis)));
								}
								j++;
							}
							k++;
						}
						$('#item_existencias_'+index).attr('prevalue',exis);
					}
				}

				i=count+1;
			}
			i++;
		}

		var total=0;
		$(".item_compra").each(function(){
    		var id=$(this).attr('id');
    		id=id.substring(5,id.length);    		
    		var sub_tot=$('#precio_subtotal_'+id).html();
    		//console.log(sub_tot);
    		sub_tot=sub_tot.substring(1,sub_tot.length);
    		total=(Number(total)+Number(sub_tot)).toFixed(2);
   		});
		$('#gran_total').val(total);
	});

	//------------MODIFICAR EXISTENCIA LISTA DIGITANDO------------
	$(document).on("keyup",".item_existencias",function(){
		var index=$(this).attr('id');
		index=index.substring(17,index.length);
		var produ =window.products;
		var count = Object.keys(produ).length;	
		var i=0,prevalue=0,diff=0,venta_valida=0,k=0,j=0,tope_exis=0;
		//console.log('cambio '+index);

		var exis =$('#item_existencias_'+index).val();
		//var prevalue=$('#item_existencias_'+index).attr('prevalue');
		//console.log(exis);

		while(i<count){
			if(produ[i].id_producto==index){
				if((produ[i].id_categoria)!=6){
					precio_u=produ[i].precio_u;					
					//tope_exis=produ[i].existencias;
					pre_tope=$('#tope_existencias_'+index).html();
					tope_exis=Number(pre_tope.substring(1,pre_tope.length));
					prevalue=$('#item_existencias_'+index).attr('prevalue');

					if(Number(prevalue)<Number(exis)){
						diff=Number(exis)-Number(prevalue);

						if((Number(tope_exis)-Number(diff))<0){
							$('#item_existencias_'+index).val(prevalue);
						}else{
							$('#precio_subtotal_'+index).html('$'+(Number(exis)*Number(precio_u)).toFixed(2));
							$('#tope_existencias_'+index).html('X'+(Number(tope_exis)-Number(diff)));
							$('#item_existencias_'+index).attr('prevalue',exis);
						}
					}else{
						if(Number(prevalue)>Number(exis)){
							diff=Number(prevalue)-Number(exis);

							if((Number(tope_exis)+Number(diff))<0){
								//$('#item_existencias_'+index).val(prevalue);
								$('#precio_subtotal_'+index).html('$'+(Number(exis)*Number(precio_u)).toFixed(2));
								$('#tope_existencias_'+index).html('X'+(Number(tope_exis)+Number(diff)));
								$('#item_existencias_'+index).attr('prevalue',exis);
							}else{
								//$('#precio_subtotal_'+index).html('$'+(Number(exis)*Number(precio_u)).toFixed(2));
								//$('#tope_existencias_'+index).html('X'+(Number(tope_exis)-Number(diff)));
							}
						}
					}
					/*
					if(exis<=tope_exis){
						$('#precio_subtotal_'+index).html('$'+(Number(exis)*Number(precio_u)).toFixed(2));
						$('#tope_existencias_'+index).html('X'+(Number(tope_exis)-Number(exis)));
					}else{
						$('#item_existencias_'+index).val(tope_exis);
						$('#tope_existencias_'+index).html('X'+(Number(tope_exis)-Number(tope_exis)));
					}*/
					//console.log((Number(exis)*Number(precio_u)));
					i=count+1;					
				}else{
					precio_u=produ[i].precio_u;
					var items=(produ[i].items).split(',');
					k=0;

					while(k<items.length){
						j=0;
						while(j<count){
							if(produ[j].id_producto==items[k]){									
								//tope_exis=produ[j].existencias;									
								pre_tope=$('#tope_existencias_'+items[k]).html();
								tope_exis=Number(pre_tope.substring(1,pre_tope.length));
								prevalue=$('#item_existencias_'+index).attr('prevalue');
								//console.log(tope_exis);
									if(Number(prevalue)<Number(exis)){
										diff=Number(exis)-Number(prevalue);

										if(Number(diff)>0){
											if(tope_exis>0){
												venta_valida=1;
											}else{
												venta_valida=0;
												k=items.length+1;
											}
										}else{
											venta_valida=0;
											k=items.length+1;
										}
									}else{
										if(Number(prevalue)>Number(exis)){
											diff=Number(prevalue)-Number(exis);

											if(Number(diff)>0){
												//if(tope_exis>0){
													venta_valida=1;
												/*}else{
													venta_valida=0;
													k=items.length+1;
												}*/
											}else{
												venta_valida=0;
												k=items.length+1;
											}
										}else{
											//$('#item_existencias_'+index).attr('prevalue',exis);
										}
									}
								
								/*
								if(exis<=tope_exis){													
									venta_valida=1;
								}else{
									venta_valida=0;
									k=items.length+1;
								}
								*/
							}
							j++;
						}
						k++;
					}

					if(venta_valida==1){
						$('#precio_subtotal_'+index).html('$'+(Number(exis)*Number(precio_u)).toFixed(2));
						//$('#item_existencias_'+index).attr('prevalue',exis);
						k=0;
						while(k<items.length){
							j=0;
							while(j<count){
								if(produ[j].id_producto==items[k]){									
									//tope_exis=produ[j].existencias;
									pre_tope=$('#tope_existencias_'+items[k]).html();
									tope_exis=Number(pre_tope.substring(1,pre_tope.length));
									prevalue=$('#item_existencias_'+index).attr('prevalue');

									if(Number(prevalue)<Number(exis)){
										diff=Number(exis)-Number(prevalue);

										if(Number(diff)>0){
											$('#tope_existencias_'+items[k]).html('X'+(Number(tope_exis)-Number(diff)));
										}
									}else{
										if(Number(prevalue)>Number(exis)){
											diff=Number(prevalue)-Number(exis);

											if(Number(diff)>0){
												$('#tope_existencias_'+items[k]).html('X'+(Number(tope_exis)+Number(diff)));
											}
										}else{
											//$('#item_existencias_'+index).attr('prevalue',exis);
										}
									}
									//$('#tope_existencias_'+items[k]).html('X'+(Number(tope_exis)-Number(exis)));
								}
								j++;
							}
							k++;
						}
						$('#item_existencias_'+index).attr('prevalue',exis);
					}

					max=$('#item_existencias_'+index).attr('max');

					//console.log('max '+max+','+'prevalue '+prevalue+','+'exis '+exis);
					if(Number(exis)>Number(max)){
						$('#item_existencias_'+index).val(prevalue);
						$('#item_existencias_'+index).attr('prevalue',prevalue);
						$('#precio_subtotal_'+index).html('$'+(Number(prevalue)*Number(precio_u)).toFixed(2));
						diff=Number(exis)-Number(prevalue);

						k=0;
						while(k<items.length){
							j=0;
							while(j<count){
								if(produ[j].id_producto==items[k]){									
									//tope_exis=produ[j].existencias;
									pre_tope=$('#tope_existencias_'+items[k]).html();
									tope_exis=Number(pre_tope.substring(1,pre_tope.length));
									$('#tope_existencias_'+items[k]).html('X'+(Number(tope_exis)+Number(diff)));
								}
								j++
							}
							k++;
						}
					}				

				}

			}
			i++;
		}

		var total=0;
		$(".item_compra").each(function(){
    		var id=$(this).attr('id');
    		id=id.substring(5,id.length);    		
    		var sub_tot=$('#precio_subtotal_'+id).html();
    		//console.log(sub_tot);
    		sub_tot=sub_tot.substring(1,sub_tot.length);
    		total=(Number(total)+Number(sub_tot)).toFixed(2);
   		});
		$('#gran_total').val(total);
	});	
});