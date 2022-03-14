<?php

namespace TamaleFiesta\Http\Controllers;

use TamaleFiesta\User;
use TamaleFiesta\Role_user;
use TamaleFiesta\Role;
use TamaleFiesta\Market_Vendedore;
use TamaleFiesta\Market;
use TamaleFiesta\Entrega;
use TamaleFiesta\Detalle_entrega;
use TamaleFiesta\Producto;
use TamaleFiesta\Categoria_producto;
use TamaleFiesta\Venta;
use TamaleFiesta\Detalle_venta;

use Illuminate\Http\Request;
use TamaleFiesta\Http\Requests\RequestPagar;

class PuntodeVentaController extends Controller
{
    //
    public function puntodeventa()
    {
    	if(!is_null(auth()->user())){
            $rol=auth()->user()->authorizedRoles(['administrador','gerente','supervisor']);
            $usuario=auth()->user();

            $id_sucursal=$this->verifica_error_duplicidad_user($usuario->id);

            //return $id_sucursal;

            if(($id_sucursal)>0){                
                $id_entrega=Entrega::where('id_market', $id_sucursal)->where('id_recibo', 0)->orderBy('id', 'asc')->get();

                //return $id_entrega;

                if(($id_entrega->count())>1){
                    return \Redirect::back()->withErrors('El punto de venta no se puede iniciar, se deben recibir primero todas las entregas pendientes');
                }else{
                    if(($id_entrega->count())<1){
                        return \Redirect::back()->withErrors('No hay inventario a cargar en el punto de venta');
                    }else{
                        $sucursal=Market::select('id','nombre')->where('id',$id_sucursal)->get();
                        $num_entrega=$id_entrega[0]->id;
                        $detalle_entregado=Detalle_entrega::where('id_entrega', $num_entrega)->orderBy('id', 'asc')->get();
                        $lista_productos=Producto::where('activo', 1)->orderBy('id_categoria','asc')->orderBy('id','asc')->get();
                       
                        $zona='pdv';
                        $productos=array();

                        //return $sucursal;

                        foreach ($lista_productos as $producto) {                            
                            foreach ($detalle_entregado as $detalle) {
                                if($detalle->id_producto==$producto->id){

                                    $productos_vendidos=Detalle_venta::where('id_entrega', $num_entrega)->where('id_producto', $producto->id)->orderBy('id','asc')->get();
                                    $i=0;
                                    $tot_vendidos=0;
                                    //return $productos_vendidos;
                                    while ($i<$productos_vendidos->count()) {
                                        $tot_vendidos=$tot_vendidos+$productos_vendidos[$i]->cantidad;
                                        $i++;
                                    }

                                    $fecha_actual = strtotime(date("d-m-Y",time()));
                                    $fecha_desde = strtotime($producto->vig_desde);
                                    $fecha_hasta = strtotime($producto->vig_hasta);

                                    if($producto->id_categoria==6){
                                        if(($fecha_actual>=$fecha_desde)&&($fecha_actual<=$fecha_hasta)){
                                            $productos[]=array('id_producto'=>$producto->id,
                                                               'nombre'=>$producto->nombre,
                                                               'descripcion'=>$producto->descripcion,
                                                               'precio_u'=>$producto->precio,
                                                               'imagen'=>$producto->imagen,                                                       
                                                               'id_categoria'=>$producto->id_categoria,
                                                               'existencias'=>(1),
                                                               'items'=>$producto->items_combo,
                                                               'vig_desde'=>$producto->vig_desde,
                                                               'vig_hasta'=>$producto->vig_hasta
                                                            );
                                        }
                                    }else{
                                        $productos[]=array('id_producto'=>$producto->id,
                                                           'nombre'=>$producto->nombre,
                                                           'descripcion'=>$producto->descripcion,
                                                           'precio_u'=>$producto->precio,
                                                           'imagen'=>$producto->imagen,                                                       
                                                           'id_categoria'=>$producto->id_categoria,
                                                           'existencias'=>(($detalle->cantidad)-($tot_vendidos)),
                                                           'items'=>'-',
                                                           'vig_desde'=>'0000-00-00',
                                                           'vig_hasta'=>'0000-00-00'
                                                        );
                                    }
                                }
                            }
                        }
                        
                        //return $productos;
                        return view('pdv/puntodeventa',compact('rol','zona','productos','sucursal','num_entrega','fecha_actual'));
                    }
                }

                //

        		
                //return $usuario->id;
            }else{
               return \Redirect::back()->withErrors('Hubo un error al acceder al punto de venta');
            }
	    }else{
	    	abort(403,'No puedes acceder a esta Seccion');
	    }
    }

    public function verifica_error_duplicidad_user($id_user)
    {
        $jefes_markets=Market::where('id_encargado', $id_user)->get();

        $id_sucursal=0;
        $id_market=0;
        $id_pdv=0;

        if(($jefes_markets->count())<1){//sino es jefe
            $markets_users=Market_Vendedore::where('id_vendedor', $id_user)->get();

            if((($markets_users->count())>1)||(($markets_users->count())<1)){
                $id_sucursal=0;
            }else{
                $id_sucursal=$markets_users[0]->id_market;
            }
        }else{
            if(($jefes_markets->count())>1){//si esta duplicado
                $id_market=0;
            }else{
                if(($jefes_markets->count())==1){//si es valido
                    $id_market=$jefes_markets[0]->id;
                }   
            }
        }

        if($id_sucursal==$id_market){
            $id_pdv=$id_market;
        }else{
            if($id_market>0){
                $id_pdv=$id_market;
            }else{
                $id_pdv=$id_sucursal;
            }
        }       

        return $id_pdv;
    }

    public function pagar(RequestPagar $datos_venta){
        if(!is_null(auth()->user())){
            $rol=auth()->user()->authorizedRoles(['administrador','gerente','supervisor']);
            $usuario=auth()->user();

            $lista=json_decode($datos_venta->input('lista_compra'));

            $venta = new Venta();            

            if(count($lista)>0){
                if(!is_null($datos_venta->input('metodo_pago'))){
                    if(($datos_venta->input('metodo_pago'))>1){//si es tarjeta
                        if(!is_null($datos_venta->input('digitos_tarjeta'))){
                            if((strlen($datos_venta->input('digitos_tarjeta')))==4){//si es válida
                                
                                $id_sucursal=$this->verifica_error_duplicidad_user($usuario->id);
                                $id_entrega=Entrega::select('id')->where('id_market', $id_sucursal)->where('id_recibo', 0)->orderBy('id', 'asc')->get();
                                
                                $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                $slug='V_'.$id_sucursal.$id_entrega[0]->id.$usuario->id.'_'.substr(str_shuffle($permitted_chars), 0, 16).time();

                                $venta->id_market=$id_sucursal;
                                $venta->id_entrega=$id_entrega[0]->id;
                                $venta->vendedor=$usuario->id;
                                $venta->cliente=0;
                                $venta->tipo_venta='EN SUCURSAL';

                                if(($datos_venta->input('metodo_pago'))==2){
                                    $venta->metodo_pago='TD';
                                }else{
                                    $venta->metodo_pago='TC';
                                }

                                $venta->digitos_tarjeta=$datos_venta->input('digitos_tarjeta');
                                $venta->importe=0.00;
                                $venta->slug_venta=$slug;                                

                                if(($this->verifica_venta($lista,$id_entrega[0]->id))==true){

                                    $venta->save();

                                    $num_venta=Venta::where('slug_venta', $slug)->orderBy('id', 'asc')->get();

                                    $importe_total=0;

                                    foreach ($lista as $item) {
                                        $prod_info=Producto::where('id', $item->id)->orderBy('id', 'asc')->get();
                                        
                                        if($prod_info[0]->id_categoria!=6){
                                            $detalle_v = new Detalle_venta();
                                            $detalle_v->id_entrega=$id_entrega[0]->id;
                                            $detalle_v->id_venta=$num_venta[0]->id;
                                            $detalle_v->id_producto=$prod_info[0]->id;
                                            $detalle_v->cantidad=$item->cantidad;
                                            $detalle_v->precio=$prod_info[0]->precio;
                                            $importe_total=$importe_total+(($item->cantidad)*($prod_info[0]->precio));

                                            $detalle_v->save();
                                        }else{
                                            $items=explode(',',$prod_info[0]->items_combo);
                                            $precio_item_combo=($prod_info[0]->precio)/(count($items));

                                            foreach ($items as $ite) {
                                                $prod_info=Producto::where('id', $ite)->orderBy('id', 'asc')->get();

                                                $detalle_v = new Detalle_venta();
                                                $detalle_v->id_entrega=$id_entrega[0]->id;
                                                $detalle_v->id_venta=$num_venta[0]->id;
                                                $detalle_v->id_producto=$prod_info[0]->id;
                                                $detalle_v->cantidad=$item->cantidad;
                                                $detalle_v->precio=$precio_item_combo;
                                                $importe_total=$importe_total+(($item->cantidad)*($precio_item_combo));
                                                $detalle_v->save();
                                            }

                                        }  
                                    }

                                    Venta::where('slug_venta', $slug)->update(['importe' => $importe_total]);

                                    return redirect()->action('PuntodeVentaController@puntodeventa')->with('status','Venta Registrada Correctamente');

                                }else{
                                    return \Redirect::back()->withErrors('No se pudo completar la venta debido a falta de artículos en el Inventario');
                                }
                                
                            }else{
                                return \Redirect::back()->withErrors('Debe ingresar sólo los últimos 4 dígitos de la Tarjeta utilizada');
                            }
                        }else{
                             return \Redirect::back()->withErrors('Debe ingresar los últimos 4 dígitos de la Tarjeta utilizada');
                        }
                    }else{//si no es tarjeta

                        $id_sucursal=$this->verifica_error_duplicidad_user($usuario->id);
                        $id_entrega=Entrega::select('id')->where('id_market', $id_sucursal)->where('id_recibo', 0)->orderBy('id', 'asc')->get();

                        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        $slug='V_'.$id_sucursal.$id_entrega[0]->id.$usuario->id.'_'.substr(str_shuffle($permitted_chars), 0, 16).time();

                        $venta->id_market=$id_sucursal;
                        $venta->id_entrega=$id_entrega[0]->id;
                        $venta->vendedor=$usuario->id;
                        $venta->cliente=0;
                        $venta->tipo_venta='EN SUCURSAL';
                        $venta->metodo_pago='EFECTIVO';
                        $venta->digitos_tarjeta='0000';

                        $venta->importe=0.00;
                        $venta->slug_venta=$slug;

                        if(($this->verifica_venta($lista,$id_entrega[0]->id))==true){

                            $venta->save();

                            $num_venta=Venta::where('slug_venta', $slug)->orderBy('id', 'asc')->get();

                            $importe_total=0;

                            foreach ($lista as $item) {
                                        $prod_info=Producto::where('id', $item->id)->orderBy('id', 'asc')->get();
                                        
                                        if($prod_info[0]->id_categoria!=6){
                                            $detalle_v = new Detalle_venta();
                                            $detalle_v->id_entrega=$id_entrega[0]->id;
                                            $detalle_v->id_venta=$num_venta[0]->id;
                                            $detalle_v->id_producto=$prod_info[0]->id;
                                            $detalle_v->cantidad=$item->cantidad;
                                            $detalle_v->precio=$prod_info[0]->precio;
                                            $importe_total=$importe_total+(($item->cantidad)*($prod_info[0]->precio));
                                            $detalle_v->save();
                                        }else{
                                            $items=explode(',',$prod_info[0]->items_combo);
                                            $precio_item_combo=($prod_info[0]->precio)/(count($items));

                                            foreach ($items as $ite) {
                                                $prod_info=Producto::where('id', $ite)->orderBy('id', 'asc')->get();

                                                $detalle_v = new Detalle_venta();
                                                $detalle_v->id_entrega=$id_entrega[0]->id;
                                                $detalle_v->id_venta=$num_venta[0]->id;
                                                $detalle_v->id_producto=$prod_info[0]->id;
                                                $detalle_v->cantidad=$item->cantidad;
                                                $detalle_v->precio=$precio_item_combo;
                                                $importe_total=$importe_total+(($item->cantidad)*($precio_item_combo));
                                                $detalle_v->save();
                                            }

                                        }  
                                    }

                            Venta::where('slug_venta', $slug)->update(['importe' => $importe_total]);

                            return redirect()->action('PuntodeVentaController@puntodeventa')->with('status','Venta Registrada Correctamente');
                        }else{
                           return \Redirect::back()->withErrors('No se pudo completar la venta debido a falta de artículos en el Inventario');
                        }
                    }
                }else{
                    return \Redirect::back()->withErrors('Se tiene que elegir algún método de pago');
                }                
            }else{
                return \Redirect::back()->withErrors('No se puede procesar una lista vacía');
            }
        }else{
            abort(403,'No puedes acceder a esta Seccion');
        }

    }

    public function verifica_venta($lista,$id_entrega)
    {
        $venta_aprobada=false;

        foreach ($lista as $item) {
            $prod_info=Producto::where('id', $item->id)->orderBy('id', 'asc')->get();

            if($prod_info[0]->id_categoria!=6){
                $vendidos = Detalle_venta::where('id_producto',$prod_info[0]->id)->sum('cantidad');
                $originales= Detalle_entrega::where('id_producto',$prod_info[0]->id)->where('id_entrega',$id_entrega)->sum('cantidad');
                $por_vender=$item->cantidad;
                
                if(($vendidos+$por_vender)<=$originales){
                    $venta_aprobada=true;
                }else{
                    $venta_aprobada=false;
                    break;
                }
            }else{
                $items=explode(',',$prod_info[0]->items_combo);

                foreach ($items as $ite) {
                    $prod_info=Producto::where('id', $ite)->orderBy('id', 'asc')->get();

                    $vendidos = Detalle_venta::where('id_producto',$prod_info[0]->id)->sum('cantidad');
                    $originales= Detalle_entrega::where('id_producto',$prod_info[0]->id)->where('id_entrega',$id_entrega)->sum('cantidad');
                    $por_vender=$item->cantidad;

                    if(($vendidos+$por_vender)<=$originales){
                        $venta_aprobada=true;
                    }else{
                        $venta_aprobada=false;
                        break 2;
                    }
                }

            }  
        }

        return $venta_aprobada;
    }




}
