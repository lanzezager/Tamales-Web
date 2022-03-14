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
use TamaleFiesta\Recibo;
use TamaleFiesta\Detalle_recibo;
use TamaleFiesta\Detalle_venta;
use TamaleFiesta\Venta;


use Illuminate\Http\Request;
use TamaleFiesta\Http\Requests\RequestGuardaRecibo;

class RecibeInventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!is_null(auth()->user())){
            $rol=auth()->user()->authorizedRoles(['administrador','gerente','supervisor']);
            $zona='recibe_inventario';
            $usuario=auth()->user();            
            $recibos_inventario=Recibo::paginate(10);
            $usurios=User::all();
            $markets=Market::all();

            $rango_chido="";
            $j=0;
            foreach ($rol as $ro) {
                if($ro=='supervisor' && $j<1 ){
                    $rango_chido="supervisor";
                }

                if($ro=='gerente'&& $j<2){
                    $rango_chido="gerente";
                     $j=1;
                }

                if($ro=='administrador'){
                    $rango_chido="administrador";
                    $j=2;
                }
            }   

            return view('panel_usuario/base',compact('rol','zona','usuario','recibos_inventario','usurios','markets','rango_chido'));
        
        }else{
            abort(403,'No puedes acceder a esta Seccion');
        }
    }

    public function saca_usuarios($puestos,$limite)
    {
        $usuarios_q=User::all();
        $roles=Role::whereIn('nombre', $puestos)->orderBy('id','asc')->get();

        $markets_users=Market::all();
        $ids_usados=array();

        foreach ($markets_users as $m_u){
            $ids_usados[]=$m_u->id_supervisor;
        }

        foreach ($roles as $rol) {
            $roles_elegidos[]=$rol->id;
        }

        //return $ids_usados;
        $roles_user=Role_user::whereIn('role_id', $roles_elegidos)->orderBy('role_id', 'asc')->get();

        $users_autoriz=array();
        $nom=array();

        foreach ($roles_user as $role) {
            $i=0;
            unset($nom);
            while($i<$usuarios_q->count()){
                if($usuarios_q[$i]->id==$role->user_id){
                    $nom[]=[$role->user_id,$usuarios_q[$i]->nombre_s.' '.$usuarios_q[$i]->apellido_s];
                    $i=$usuarios_q->count()+1;
                }
                $i++;
            }

            if($limite==false){
                if(!in_array($nom[0], $users_autoriz)){
                    $users_autoriz[]=$nom[0];    
                }
            }else{
                if(in_array($nom[0][0],$ids_usados)){
                    if(!in_array($nom[0], $users_autoriz)){
                        $users_autoriz[]=$nom[0];
                    }
                }
            }
        }
        
        return $users_autoriz;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(!is_null(auth()->user())){
            $rol=auth()->user()->authorizedRoles(['administrador','gerente','supervisor']);
            $zona='recibe_inventario_datos';
            $lista_entregas=Entrega::where('id_recibo', 0)->orderBy('id','asc')->get();            
            $usuario=auth()->user();
            $mercados= Market::all();
            $productos=Producto::where('activo', 1)->orderBy('id_categoria','asc')->orderBy('id','asc')->get();
            $markets_users=Market_Vendedore::all();
            $usurios=User::all();
            $editar='';
            $nvo='nvo';

            $supervisores=$this->saca_usuarios(['supervisor'],true);
            $supervisores_2=$this->saca_usuarios(['supervisor'],false);
            $chidos=$this->saca_usuarios(['administrador','gerente'],false);
                //$empleados=$this->saca_usuarios(['administrador','gerente','supervisor','vendedor'],false);

            $usro=array();
            $markets=array();
            $usro[]=[$usuario->id, $usuario->nombre_s.' '.$usuario->apellido_s];

            if(in_array($usro[0],$chidos)){
                foreach ($mercados as $merca) {
                    $markets[]=[$merca->id,$merca->nombre,$merca->id_encargado,$merca->id_supervisor];
                }
                    //$us_sup=0;
                $us_sup=1;
                $supervisores='nada';
            }else{
                    if(in_array($usro[0],$supervisores_2)){//es supervisor?
                        if(in_array($usro[0],$supervisores)){//si es supervisor, tiene sucursales asignadas?
                            foreach ($mercados as $merca) {
                                if($merca->id_supervisor==$usuario->id){
                                    $markets[]=[$merca->id,$merca->nombre,$merca->id_encargado,$merca->id_supervisor];
                                }
                            }
                            $us_sup=1;
                            $supervisores='nada';
                        }else{
                            $us_sup=0;
                            $supervisores='nada';
                        }
                    }else{
                        $us_sup=0;
                        $supervisores='nada';
                    }                
                }

                $empleados_market=array();
                $users_market=array();

                foreach ($mercados as $mercad){
                    unset($users_market);
                    foreach ($usurios as $use) {
                       if($use->id==$mercad->id_encargado){
                           $users_market[]=array('id'=>$mercad->id_encargado,'nombre' =>$use->nombre_s.' '.$use->apellido_s);
                       }
                    }

                    foreach($markets_users as $mer){
                        if($mercad->id==$mer->id_market){
                            foreach ($usurios as $use) {
                                if($use->id==$mer->id_vendedor){
                                    $users_market[]=array('id'=>$mer->id_vendedor,'nombre'=>$use->nombre_s.' '.$use->apellido_s);
                                }
                            }
                        }
                    }

                    $empleados_market[]=array($mercad->id =>$users_market);
                }

            $sucursal=array();           
            $sucursal[0]=0;
            $sucursal[1]='vacia';

            $receptor=array();
            $receptor[0]=0;
            $receptor[1]='vacia';
            $parte_sel_dis="";
            $parte_dat_vis="";
            $editable="si";
            $nom_mark="";
           /* 
           foreach ($lista_entregas as $entrega) {
                foreach ($mercados as $mkt) {
                    if($mkt['id']==$entrega['id_market']){
                        $entrega['id_market']=$mkt['nombre'];
                    }
                }
            }
            */

            //return $markets;

            return view('panel_usuario/base',compact('rol','zona','usuario','markets','editar','nvo','supervisores','productos','us_sup','empleados_market','sucursal','receptor','lista_entregas','parte_sel_dis','parte_dat_vis','editable','nom_mark'));

        }else{
            abort(403,'No puedes acceder a esta Seccion');
        }
    }

    
    public function Busca_Detalle_Entrega(Request $id)
    {
        if(!is_null(auth()->user())){
            $rol=auth()->user()->authorizedRoles(['administrador','gerente','supervisor']);            
            if(strlen($id)>0){
                //return 'si jaló, esto envió:|'.$id->id_entrega.'|';
                $id_entrega=$id->data;
                $detalles_entre=Detalle_entrega::where('id_entrega', $id_entrega)->orderBy('id_producto','asc')->get();
                $por_recibir=array();
                $datos_ventas=Venta::where('id_entrega',$id_entrega)->where('metodo_pago','EFECTIVO')->sum('importe');
                $cambio=Entrega::where('id',$id_entrega)->get();
                $cambio_entre=$cambio[0]->cambio_entregado;
                //return $cambio_entre;
                
                foreach ($detalles_entre as $prod) {
                    $prod_id=$prod->id_producto;
                    $revisa_venta=Detalle_venta::where('id_entrega', $id_entrega)->where('id_producto',$prod_id)->orderBy('id_producto','asc')->get();
                    $tot_vendidos=0;
                    $tot_venta=0;

                    foreach ($revisa_venta as $venta) {
                        $vendidos=strval($venta->cantidad);
                        $precios=strval($venta->precio);
                        $tot_vendidos=bcadd($vendidos,strval($tot_vendidos));
                        $tot_venta=bcadd((bcmul(($precios),($vendidos),2)),strval($tot_venta),2);
                    }

                    $nombre_prod=Producto::where('id', $prod->id_producto)->orderBy('id','asc')->get();
                    $por_recibir[]=array('id' =>$prod->id_producto,
                                            'nombre' =>$nombre_prod[0]->nombre,
                                            'precio_u' => $prod->precio_u,
                                            'cantidad' => $prod->cantidad,
                                            'valor_tot' =>bcmul(strval($prod->precio_u),strval($prod->cantidad),2),
                                            'restante_virtual' =>bcsub(strval($prod->cantidad),strval($tot_vendidos)),
                                            //'total_virtual' =>$tot_venta
                                        );                   
                }

                $por_recibir[]=array('id' =>'99999999',
                                            'nombre' =>'info',
                                            'suma_venta' => $datos_ventas,
                                            'cambio' => $cambio_entre
                                        );

                $tabla=json_encode($por_recibir);
                return response($tabla,200)->header('Content-type','application/json');
            }

        }else{
            //return 'no jaló';
            abort(403,'No puedes acceder a esta Seccion');
        }        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestGuardaRecibo $request)
    {
        if(!is_null(auth()->user())){
            $rol=auth()->user()->authorizedRoles(['administrador','gerente','supervisor']);
            $productos=json_decode($request->input('lista_productos'));
           
           //return $productos;

            if(count($productos)>0){
                $id_market=Market::select('id')->where('nombre',$request->input('sucursal'))->orderBy('id','asc')->get();
                
                $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $slug='E_'.$id_market[0]->id.$request->input('supervisor').$request->input('emisor').'_'.substr(str_shuffle($permitted_chars), 0, 16).time();

                $recibo=new Recibo();
                $recibo->id_market=$id_market[0]->id;
                $recibo->id_entrega=$request->input('id_entrega');
                $recibo->monto_recibido=$request->input('cambio');
                $recibo->valor_mercancia=0.00;
                $recibo->id_supervisor=$request->input('supervisor');
                $recibo->id_empleado_entrega=$request->input('emisor');
                $recibo->slug_recibo=$slug;

                if($request->input('observacion')!= null){
                    $recibo->observacion=$request->input('observacion');
                }else{
                    $recibo->observacion="-";
                }

                $recibo->save();

                $last_recibo=Recibo::select('id')->where('slug_recibo',$slug)->orderBy('id','asc')->get();

                $valor_merca=0;

                foreach ($productos as $produ_reci) {
                    $detalle_recibo=new Detalle_recibo();
                    $detalle_recibo->id_recibo=$last_recibo[0]->id;
                    $detalle_recibo->id_producto=$produ_reci->id;
                    $detalle_recibo->precio_u=$produ_reci->precio_u;
                    $detalle_recibo->cantidad_real=$produ_reci->sobrante_real;
                    $detalle_recibo->cantidad_virtual=$produ_reci->sobrante_virtual;

                    if(strlen($produ_reci->justificacion)>0){
                        $detalle_recibo->justificacion=$produ_reci->justificacion;
                    }else{
                        $detalle_recibo->justificacion="-";
                    }

                    $valor_merca=$valor_merca+($produ_reci->precio_u*$produ_reci->sobrante_real);

                    $detalle_recibo->save();
                }

                Recibo::where('slug_recibo', $slug)->update(['valor_mercancia' => $valor_merca]);
                Entrega::where('id',$request->input('id_entrega'))->update(['id_recibo' => $last_recibo[0]->id]);
              //return $request;
                return redirect()->action('RecibeInventarioController@index')->with('status','Recibo Guardado Correctamente');
                //return redirect('/panel_usuario/market/r_inventario/'.$last_recibo[0]->id.'/report');
            }

            
        }else{
            abort(403,'No puedes acceder a esta Seccion');
        }
    }

    public function reportes($id_r_inv)
    {
        if(!is_null(auth()->user())){
            $rol=auth()->user()->authorizedRoles(['administrador','gerente','supervisor']);
            //return $id_r_inv;
            $recibo=Recibo::where('id', $id_r_inv)->orderBy('id','asc')->get();

            $producto=Detalle_recibo::where('id_recibo', $id_r_inv)->orderBy('id','asc')->get();

            $productos=array();

            foreach ($producto as $prod) {
                $produ=Producto::where('id', $prod->id_producto)->orderBy('id','asc')->get();
                $val_tot=$prod->precio_u*$prod->cantidad_real;
                $productos[]=array('id_producto'=>$prod->id_producto,
                                   'nombre'=>$produ[0]->nombre,
                                   'precio_u'=>$prod->precio_u,
                                   'cantidad'=>$prod->cantidad_real,
                                   'valor'=>bcdiv($val_tot, '1', 2));
            }
            
            //return $productos[0]['id_producto'];

            $marke=Market::where('id', $recibo[0]->id_market)->orderBy('id','asc')->get();
            $sucursal=$marke[0]->nombre;

            $users_super=User::where('id', $recibo[0]->id_supervisor)->orderBy('id','asc')->get();
            $supervisor=$users_super[0]->nombre_s.' '.$users_super[0]->apellido_s;

            $users_recep=User::where('id', $recibo[0]->id_empleado_entrega)->orderBy('id','asc')->get();
            $receptor=$users_recep[0]->nombre_s.' '.$users_recep[0]->apellido_s;

            $cambio=$recibo[0]->monto_recibido;
            $gran_total=$recibo[0]->valor_mercancia;
            $observacion=$recibo[0]->observacion;

            $folio=$recibo[0]->id;
            $fecha=substr($recibo[0]->created_at, 0, 10);
            $val_tot_final=bcdiv($cambio+$gran_total, '1', 2);

            //return $productos;
            $pdf = \PDF::loadView('reportes.reporte_recibo_inventario', 
                compact('folio','fecha','productos','sucursal','supervisor','receptor','cambio','gran_total','val_tot_final','observacion'));        
            return $pdf->stream('Factura.pdf');
        }else{
            abort(403,'No puedes acceder a esta Seccion');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Recibo $r_inventario)
    {
        //
        if(!is_null(auth()->user())){
            $rol=auth()->user()->authorizedRoles(['administrador','gerente','supervisor']);
            
            
            $zona='recibe_inventario_datos';
            $lista_entregas=Entrega::where('id_recibo', 0)->orderBy('id','asc')->get();            
            $usuario=auth()->user();
            $mercados= Market::all();
            $nom_marke=Market::select('nombre')->where('id',$r_inventario->id_market)->orderBy('id','asc')->get();
            $productos_ori=Producto::where('activo', 1)->orderBy('id_categoria','asc')->orderBy('id','asc')->get();
            $markets_users=Market_Vendedore::all();
            $usurios=User::all();
            $editar='';
            $nvo='no';

            $supervisores=$this->saca_usuarios(['supervisor'],true);
            $supervisores_2=$this->saca_usuarios(['supervisor'],false);
            $chidos=$this->saca_usuarios(['administrador','gerente'],false);
                //$empleados=$this->saca_usuarios(['administrador','gerente','supervisor','vendedor'],false);

            $usro=array();
            $markets=array();
            $usro[]=[$usuario->id, $usuario->nombre_s.' '.$usuario->apellido_s];

            if(in_array($usro[0],$chidos)){
                foreach ($mercados as $merca) {
                    $markets[]=[$merca->id,$merca->nombre,$merca->id_encargado,$merca->id_supervisor];
                }
                    //$us_sup=0;
                $us_sup=1;
                $supervisores='nada';
            }else{
                    if(in_array($usro[0],$supervisores_2)){//es supervisor?
                        if(in_array($usro[0],$supervisores)){//si es supervisor, tiene sucursales asignadas?
                            foreach ($mercados as $merca) {
                                if($merca->id_supervisor==$usuario->id){
                                    $markets[]=[$merca->id,$merca->nombre,$merca->id_encargado,$merca->id_supervisor];
                                }
                            }
                            $us_sup=1;
                            $supervisores='nada';
                        }else{
                            $us_sup=0;
                            $supervisores='nada';
                        }
                    }else{
                        $us_sup=0;
                        $supervisores='nada';
                    }                
                }

                $empleados_market=array();
                $users_market=array();

                foreach ($mercados as $mercad){
                    unset($users_market);
                    foreach ($usurios as $use) {
                       if($use->id==$mercad->id_encargado){
                           $users_market[]=array('id'=>$mercad->id_encargado,'nombre' =>$use->nombre_s.' '.$use->apellido_s);
                       }
                    }

                    foreach($markets_users as $mer){
                        if($mercad->id==$mer->id_market){
                            foreach ($usurios as $use) {
                                if($use->id==$mer->id_vendedor){
                                    $users_market[]=array('id'=>$mer->id_vendedor,'nombre'=>$use->nombre_s.' '.$use->apellido_s);
                                }
                            }
                        }
                    }

                    $empleados_market[]=array($mercad->id =>$users_market);
                }

            $sucursal=array();           
            $sucursal[0]=0;
            $sucursal[1]='vacia';

            $receptor=array();
            $receptor[0]=$r_inventario->id_empleado_entrega;
            for ($i=0; $i < count($usurios) ; $i++) { 
                if($usurios[$i]->id==$r_inventario->id_empleado_entrega){
                    $receptor[1]=$usurios[$i]->nombre_s.' '.$usurios[$i]->apellido_s;
                }
            }
            
            $parte_sel_dis='style=display:none';
            $parte_dat_vis='style=visibility:visible';
            $editable="no";
            $monto_recibido=$r_inventario->monto_recibido;
            $observacion=$r_inventario->observacion;
            $nom_mark=$nom_marke[0]->nombre;

            $detalles_recibo=Detalle_recibo::where('id_recibo', $r_inventario->id)->orderBy('id_producto','asc')->get();

            $id_entrega=$r_inventario->id_entrega;
            $detalles_entre=Detalle_entrega::where('id_entrega', $id_entrega)->orderBy('id_producto','asc')->get();
            $productos=array();
            $datos_ventas=Venta::where('id_entrega',$id_entrega)->where('metodo_pago','EFECTIVO')->sum('importe');
            $cambio=Entrega::where('id',$id_entrega)->get();

            if (count($cambio)>0) {
               $cambio_entre=$cambio[0]->cambio_entregado;
            }else{
                $cambio_entre=0.00;
            }
            
            foreach ($detalles_entre as $prod) {
                $prod_id=$prod->id_producto;
                $revisa_venta=Detalle_venta::where('id_entrega', $id_entrega)->where('id_producto',$prod_id)->orderBy('id_producto','asc')->get();
                $tot_vendidos=0;
                $tot_venta=0;

                foreach ($revisa_venta as $venta) {
                    $vendidos=strval($venta->cantidad);
                    $precios=strval($venta->precio);
                    $tot_vendidos=bcadd($vendidos,strval($tot_vendidos));
                    $tot_venta=bcadd((bcmul(($precios),($vendidos),2)),strval($tot_venta),2);
                }

                $nombre_prod=Producto::where('id', $prod->id_producto)->orderBy('id','asc')->get();

                for ($indi=0; $indi < count($detalles_recibo) ; $indi++) { 
                    if ($detalles_recibo[$indi]->id_producto==$prod->id_producto) {
                        $cantidad_real=$detalles_recibo[$indi]->cantidad_real;
                        $justificacion=$detalles_recibo[$indi]->justificacion;
                    }
                }

                $productos[]=array('id' =>$prod->id_producto,
                    'nombre' =>$nombre_prod[0]->nombre,
                    'precio_u' => $prod->precio_u,
                    'cantidad' => $prod->cantidad,
                    'valor_tot' =>bcmul(strval($prod->precio_u),strval($prod->cantidad),2),
                    'restante_virtual' =>bcsub(strval($prod->cantidad),strval($tot_vendidos)),
                    'sobrante_real'=>$cantidad_real,
                    'justificacion'=>$justificacion
                                            //'total_virtual' =>$tot_venta
                );                   
            }

            //return $id_entrega;

            return view('panel_usuario/base',compact('rol','zona','usuario','markets','editar','nvo','supervisores','productos','us_sup','empleados_market','sucursal','receptor','lista_entregas','parte_sel_dis','parte_dat_vis','nom_mark','monto_recibido','observacion'));

        }else{
            abort(403,'No puedes acceder a esta Seccion');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Recibo $r_inventario)
    {
        //return $r_inventario->id;
        if(!is_null(auth()->user())){
            $rol=auth()->user()->authorizedRoles(['administrador','gerente','supervisor']);
            
            
            $zona='recibe_inventario_datos';
            $lista_entregas=Entrega::where('id_recibo', 0)->orderBy('id','asc')->get();            
            $usuario=auth()->user();
            $mercados= Market::all();
            $nom_marke=Market::select('nombre')->where('id',$r_inventario->id_market)->orderBy('id','asc')->get();
            $productos_ori=Producto::where('activo', 1)->orderBy('id_categoria','asc')->orderBy('id','asc')->get();
            $markets_users=Market_Vendedore::all();
            $usurios=User::all();
            $editar='editar';
            $nvo='no';

            $supervisores=$this->saca_usuarios(['supervisor'],true);
            $supervisores_2=$this->saca_usuarios(['supervisor'],false);
            $chidos=$this->saca_usuarios(['administrador','gerente'],false);
                //$empleados=$this->saca_usuarios(['administrador','gerente','supervisor','vendedor'],false);

            $usro=array();
            $markets=array();
            $usro[]=[$usuario->id, $usuario->nombre_s.' '.$usuario->apellido_s];
            $cont_prod=0;
            if(in_array($usro[0],$chidos)){
                foreach ($mercados as $merca) {
                    $markets[]=[$merca->id,$merca->nombre,$merca->id_encargado,$merca->id_supervisor];
                }
                    //$us_sup=0;
                $us_sup=1;
                $supervisores='nada';
            }else{
                    if(in_array($usro[0],$supervisores_2)){//es supervisor?
                        if(in_array($usro[0],$supervisores)){//si es supervisor, tiene sucursales asignadas?
                            foreach ($mercados as $merca) {
                                if($merca->id_supervisor==$usuario->id){
                                    $markets[]=[$merca->id,$merca->nombre,$merca->id_encargado,$merca->id_supervisor];
                                }
                            }
                            $us_sup=1;
                            $supervisores='nada';
                        }else{
                            $us_sup=0;
                            $supervisores='nada';
                        }
                    }else{
                        $us_sup=0;
                        $supervisores='nada';
                    }                
                }

                $empleados_market=array();
                $users_market=array();

                foreach ($mercados as $mercad){
                    unset($users_market);
                    foreach ($usurios as $use) {
                       if($use->id==$mercad->id_encargado){
                           $users_market[]=array('id'=>$mercad->id_encargado,'nombre' =>$use->nombre_s.' '.$use->apellido_s);
                       }
                    }

                    foreach($markets_users as $mer){
                        if($mercad->id==$mer->id_market){
                            foreach ($usurios as $use) {
                                if($use->id==$mer->id_vendedor){
                                    $users_market[]=array('id'=>$mer->id_vendedor,'nombre'=>$use->nombre_s.' '.$use->apellido_s);
                                }
                            }
                        }
                    }

                    $empleados_market[]=array($mercad->id =>$users_market);
                }

            $sucursal=array();           
            $sucursal[0]=0;
            $sucursal[1]='vacia';

            $receptor=array();
            $receptor[0]=$r_inventario->id_empleado_entrega;
            for ($i=0; $i < count($usurios) ; $i++) { 
                if($usurios[$i]->id==$r_inventario->id_empleado_entrega){
                    $receptor[1]=$usurios[$i]->nombre_s.' '.$usurios[$i]->apellido_s;
                }
            }
            
            $parte_sel_dis='style=display:none';
            $parte_dat_vis='style=visibility:visible';
            $editable="no";
            $monto_recibido=$r_inventario->monto_recibido;
            $observacion=$r_inventario->observacion;
            $nom_mark=$nom_marke[0]->nombre;

            $detalles_recibo=Detalle_recibo::where('id_recibo', $r_inventario->id)->orderBy('id_producto','asc')->get();

            $id_entrega=$r_inventario->id_entrega;
            $detalles_entre=Detalle_entrega::where('id_entrega', $id_entrega)->orderBy('id_producto','asc')->get();
            $productos=array();
            $datos_ventas=Venta::where('id_entrega',$id_entrega)->where('metodo_pago','EFECTIVO')->sum('importe');
            $cambio=Entrega::where('id',$id_entrega)->get();

            if (count($cambio)>0) {
               $cambio_entre=$cambio[0]->cambio_entregado;
            }else{
                $cambio_entre=0.00;
            }
            
            foreach ($detalles_entre as $prod) {
                $prod_id=$prod->id_producto;
                $revisa_venta=Detalle_venta::where('id_entrega', $id_entrega)->where('id_producto',$prod_id)->orderBy('id_producto','asc')->get();
                $tot_vendidos=0;
                $tot_venta=0;

                foreach ($revisa_venta as $venta) {
                    $vendidos=strval($venta->cantidad);
                    $precios=strval($venta->precio);
                    $tot_vendidos=bcadd($vendidos,strval($tot_vendidos));
                    $tot_venta=bcadd((bcmul(($precios),($vendidos),2)),strval($tot_venta),2);
                }

                $nombre_prod=Producto::where('id', $prod->id_producto)->orderBy('id','asc')->get();

                for ($indi=0; $indi < count($detalles_recibo) ; $indi++) { 
                    if ($detalles_recibo[$indi]->id_producto==$prod->id_producto) {
                        $cantidad_real=$detalles_recibo[$indi]->cantidad_real;
                        $justificacion=$detalles_recibo[$indi]->justificacion;
                    }
                }
                $cont_prod++;
                $productos[]=array('id' =>$prod->id_producto,
                    'nombre' =>$nombre_prod[0]->nombre,
                    'precio_u' => $prod->precio_u,
                    'cantidad' => $prod->cantidad,
                    'valor_tot' =>bcmul(strval($prod->precio_u),strval($prod->cantidad),2),
                    'restante_virtual' =>bcsub(strval($prod->cantidad),strval($tot_vendidos)),
                    'sobrante_real'=>$cantidad_real,
                    'justificacion'=>$justificacion,
                    'contador'=>$cont_prod
                                            //'total_virtual' =>$tot_venta
                );                   
            }

            //return $r_inventario;
           
            $i=0;
            foreach ($empleados_market as $emp__p1) {
                if(key($emp__p1)==$r_inventario->id_market){
                    //return $emp__p1;
                    foreach ($emp__p1 as $emp__p2){                        
                        foreach ($emp__p2 as $emp__p3){
                            if($r_inventario->id_empleado_entrega==$emp__p3['id']){
                                $i=1;
                            }else{
                                $i=0;
                            }

                            $users_valido[]=array('id'=>$emp__p3['id'],
                                                  'nombre'=>$emp__p3['nombre'],
                                                  'emp_entr'=>$i);
                        }
                    }
                    
                    //return $emp__p1;
                }
                
            }
            $users_valid = json_decode(json_encode($users_valido), FALSE);
            //$users_valid=(object) $users_valido;
            //foreach ($users_valid as $usu) {
            //    return $usu['id'].' '.$usu['nombre'];
            //}
            //return $users_valid[1]['id'];
            return view('panel_usuario/base',compact('rol','zona','usuario','markets','editar','nvo','supervisores','productos','us_sup','empleados_market','sucursal','receptor','lista_entregas','parte_sel_dis','parte_dat_vis','nom_mark','monto_recibido','observacion','r_inventario','users_valid','cont_prod','id_entrega'));

        }else{
            abort(403,'No puedes acceder a esta Seccion');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequestGuardaRecibo $request, Recibo $r_inventario)
    {
        //return $request;
        //
        if(!is_null(auth()->user())){
            $rol=auth()->user()->authorizedRoles(['administrador','gerente']);
            $productos=json_decode($request->input('lista_productos'));
            //return $productos;

            $r_inventario->id_empleado_entrega=$request->input('emisor');
            $r_inventario->monto_recibido=$request->input('cambio');
            $r_inventario->observacion=$request->input('observacion');
            $r_inventario->save();

            $detalles_recibos=Detalle_recibo::where('id_recibo',$r_inventario->id)->delete();
            
            foreach ($productos as $produ) {
                $prod= new Detalle_recibo();                    
                $prod->id_recibo=$r_inventario->id;
                $prod->id_producto=$produ->id;
                $prod->precio_u=$produ->precio_u;
                $prod->cantidad_virtual=$produ->sobrante_virtual;
                $prod->cantidad_real=$produ->sobrante_real;
                $prod->justificacion=$produ->justificacion;                
                $prod->save();
            }
            
            return redirect()->action('RecibeInventarioController@index')->with('status','Recibo de Inventario Actualizado Correctamente');

        }else{
            abort(403,'No puedes acceder a esta Seccion');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Recibo $r_inventario)
    {
        if(!is_null(auth()->user())){
            $rol=auth()->user()->authorizedRoles(['administrador','gerente']);

            $detalles_recibos=Detalle_recibo::where('id_recibo',$r_inventario->id)->delete();
            $recibos=Recibo::where('id',$r_inventario->id)->delete();

            return redirect()->action('RecibeInventarioController@index')->with('status','Recibo de Inventario Eliminado Correctamente');
            //return $r_inventario;
        }else{
            abort(403,'No puedes acceder a esta Seccion');
        }
        
    }
}
