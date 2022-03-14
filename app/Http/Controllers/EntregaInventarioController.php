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

use Illuminate\Http\Request;
use TamaleFiesta\Http\Requests\RequestGuardaEntregaInv;

class EntregaInventarioController extends Controller
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
            $zona='entrega_inventario';
            $usuario=auth()->user();
            $entregas_inventario=Entrega::paginate(10);
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

            return view('panel_usuario/base',compact('rol','zona','usuario','entregas_inventario','usurios','markets','rango_chido'));
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
        if(!is_null(auth()->user())){
            $rol=auth()->user()->authorizedRoles(['administrador','gerente','supervisor']);           

            $zona='entrega_inventario_datos';
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

                //$empleados_market=json_encode($tot_users_market);                        
                //return $tot_users_market[0]["3"][0]["nombre"];

            return view('panel_usuario/base',compact('rol','zona','usuario','markets','editar','nvo','supervisores','productos','us_sup','empleados_market','sucursal','receptor'));

        }else{
            abort(403,'No puedes acceder a esta Seccion');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestGuardaEntregaInv $request)
    {
        //
        //$pdf = \PDF::loadView('reportes.reporte_entrega_inventario');        
        //return $pdf->stream('Prueba.pdf');
        //return $request;

        if(!is_null(auth()->user())){
            $rol=auth()->user()->authorizedRoles(['administrador','gerente','supervisor']);
            $productos=json_decode($request->input('lista_productos'));

            if(count($productos)>0){

                $validacion_entregas=Entrega::select('id','id_market','id_recibo')->where([ ['id_market',$request->input('sucursal')],['id_recibo', 0]])->orderBy('id','asc')->get();

                if(($validacion_entregas->count())<1){           

                    $tot=0;
                    foreach($productos as $producto){
                        $tot+= $producto->valor;
                    }

                    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $slug='E_'.$request->input('sucursal').$request->input('supervisor').$request->input('receptor').'_'.substr(str_shuffle($permitted_chars), 0, 16).time();

                    $entre= new Entrega();

                    $entre->id_market=$request->input('sucursal');
                    $entre->id_supervisor=$request->input('supervisor');
                    if($request->input('receptor')==0){
                        return \Redirect::back()->withErrors('Debe seleccionar al empleado que recibirá la Entrega');
                    }
                    $entre->id_receptor=$request->input('receptor');
                    $entre->cambio_entregado=$request->input('cambio');
                    if(strlen($request->input('observacion'))<1){
                        $entre->observacion='-';
                    }else{
                        $entre->observacion=$request->input('observacion');
                    }                
                    $entre->valor_mercancia=$tot;
                    $entre->slug_entrega=$slug;
                    $entre->save();

                     //return $tot;
                    //return $productos;

                    $entrega=Entrega::where('slug_entrega', $slug)->orderBy('id','asc')->get();
                    //return $entrega[0]->id;                

                    foreach ($productos as $producto){
                        $prod= new Detalle_entrega();                    
                        $prod->id_entrega=$entrega[0]->id;
                        $prod->id_producto=$producto->prod_id;
                        $prod->cantidad=$producto->cantidad;
                        $prod->precio_u=$producto->precio_u;
                        $prod->save();
                    }

                    //$this->reportes($entrega[0]->id);
                    //return redirect('/panel_usuario/market/e_inventario/'.$entrega[0]->id.'/report');
                    return redirect()->action('EntregaInventarioController@index')->with('status','Entrega Guardada Correctamente');
                    //return $productos;
                    /*$pdf = \PDF::loadView('reportes.reporte_entrega_inventario', compact('productos','sucursal','supervisor','receptor','cambio','gran_total','observacion'));        
                    return $pdf->stream('Factura.pdf');*/
                }else{
                    return \Redirect::back()->withErrors('No puede registrar una nueva entrega para la sucursal seleccionada si no ha hecho la recepción de la última entrega efectuada');
                }

            }else{
                return \Redirect::back()->withErrors('Debe registrar Productos en la entrega');
            }
        }else{
            abort(403,'No puedes acceder a esta Seccion');
        }
    }

    public function reportes($id_e_inv)
    {
        if(!is_null(auth()->user())){
            $rol=auth()->user()->authorizedRoles(['administrador','gerente','supervisor']);
            $entrega=Entrega::where('id', $id_e_inv)->orderBy('id','asc')->get();

            $producto=Detalle_entrega::where('id_entrega', $id_e_inv)->orderBy('id','asc')->get();

            $productos=array();

            foreach ($producto as $prod) {
                $produ=Producto::where('id', $prod->id_producto)->orderBy('id','asc')->get();
                $val_tot=$prod->precio_u*$prod->cantidad;
                $productos[]=array('id_producto'=>$prod->id_producto,
                                   'nombre'=>$produ[0]->nombre,
                                   'precio_u'=>$prod->precio_u,
                                   'cantidad'=>$prod->cantidad,
                                   'valor'=>bcdiv($val_tot, '1', 2));
            }
            
            //return $productos[0]['id_producto'];

            $marke=Market::where('id', $entrega[0]->id_market)->orderBy('id','asc')->get();
            $sucursal=$marke[0]->nombre;

            $users_super=User::where('id', $entrega[0]->id_supervisor)->orderBy('id','asc')->get();
            $supervisor=$users_super[0]->nombre_s.' '.$users_super[0]->apellido_s;

            $users_recep=User::where('id', $entrega[0]->id_receptor)->orderBy('id','asc')->get();
            $receptor=$users_recep[0]->nombre_s.' '.$users_recep[0]->apellido_s;

            $cambio=$entrega[0]->cambio_entregado;
            $gran_total=$entrega[0]->valor_mercancia;
            $observacion=$entrega[0]->observacion;

            $folio=$entrega[0]->id;
            $fecha=substr($entrega[0]->created_at, 0, 10);
            $val_tot_final=bcdiv($cambio+$gran_total, '1', 2);

            //return $productos;
            $pdf = \PDF::loadView('reportes.reporte_entrega_inventario', 
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
    public function show(Entrega $e_inventario, Request $request)
    {
        if(!is_null( $request->user())){
           $rol=auth()->user()->authorizedRoles(['administrador','gerente','supervisor']);
            $zona='entrega_inventario_vistazo';
            $usuario=auth()->user();
            $editar='';
            $nvo='';

            $sucursal=array();
            $supervisor=array();
            $receptor=array();

            $marke=Market::where('id', $e_inventario->id_market)->orderBy('id','asc')->get();
            $sucursal[0]=$e_inventario->id_market;
            $sucursal[1]=$marke[0]->nombre;

            $users_super=User::where('id', $e_inventario->id_supervisor)->orderBy('id','asc')->get();
            $supervisor[0]=$e_inventario->id_supervisor;
            $supervisor[1]=$users_super[0]->nombre_s.' '.$users_super[0]->apellido_s;

            $users_recep=User::where('id', $e_inventario->id_receptor)->orderBy('id','asc')->get();
            $receptor[0]=$e_inventario->id_receptor;
            $receptor[1]=$users_recep[0]->nombre_s.' '.$users_recep[0]->apellido_s;            

            $producto=Detalle_entrega::where('id_entrega', $e_inventario->id)->orderBy('id','asc')->get();
            $productos_e=array();

            $val_tot_prod=0;

            foreach ($producto as $prod) {
                $produ=Producto::where('id', $prod->id_producto)->orderBy('id','asc')->get();
                $val_tot=bcdiv(($prod->precio_u*$prod->cantidad), '1', 2);
                $val_tot_prod=($prod->precio_u*$prod->cantidad)+$val_tot_prod;
                $productos_e[]=array('id_producto'=>$prod->id_producto,
                 'nombre'=>$produ[0]->nombre,
                 'precio_u'=>$prod->precio_u,
                 'cantidad'=>$prod->cantidad,
                 'valor'=>$val_tot);
            }
            $cambio_entregado=$e_inventario->cambio_entregado;
            $val_tot_final=bcdiv($val_tot_prod+$e_inventario->cambio_entregado, '1', 2);
            $observacion=$e_inventario->observacion;

            $us_sup=0;
            $supervisores='nada';


            $empleados_market = array();
            $productos= array();

            //return 'Sucursal: '.$sucursal[1].'</br>Supervisor: '.$supervisor[1].'</br>Receptor: '.$receptor[1].'</br>Val_Tot_entre: '.$val_tot_final.' '.$observacion ;

            return view('panel_usuario/base',compact('rol','zona','usuario','sucursal','editar','nvo','supervisores','supervisor','receptor','val_tot_final','observacion','productos_e','us_sup','empleados_market','productos','cambio_entregado'));
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
    public function edit(Entrega $e_inventario, Request $request)
    {
       if(!is_null( $request->user())){
           $rol=auth()->user()->authorizedRoles(['administrador','gerente']);
            $zona='entrega_inventario_editar';
            $usuario=auth()->user();
            $mercados= Market::all();
            $productos=Producto::where('activo', 1)->orderBy('id_categoria','asc')->orderBy('id','asc')->get();
            $markets_users=Market_Vendedore::all();
            $usurios=User::all();
            
            $supervisores=$this->saca_usuarios(['supervisor'],true);
            $supervisores_2=$this->saca_usuarios(['supervisor'],false);
            $chidos=$this->saca_usuarios(['administrador','gerente'],false);
            $editar='editar';
            $nvo='';

            $sucursal=array();
            $supervisor=array();
            $receptor=array();

            $marke=Market::where('id', $e_inventario->id_market)->orderBy('id','asc')->get();
            $sucursal[0]=$e_inventario->id_market;
            $sucursal[1]=$marke[0]->nombre;

            $users_super=User::where('id', $e_inventario->id_supervisor)->orderBy('id','asc')->get();
            $supervisor[0]=$e_inventario->id_supervisor;
            $supervisor[1]=$users_super[0]->nombre_s.' '.$users_super[0]->apellido_s;

            $users_recep=User::where('id', $e_inventario->id_receptor)->orderBy('id','asc')->get();
            $receptor[0]=$e_inventario->id_receptor;
            $receptor[1]=$users_recep[0]->nombre_s.' '.$users_recep[0]->apellido_s;            

            $producto=Detalle_entrega::where('id_entrega', $e_inventario->id)->orderBy('id','asc')->get();
            $productos_e=array();

            $val_tot_prod=0;

            foreach ($producto as $prod){
                $produ=Producto::where('id', $prod->id_producto)->orderBy('id','asc')->get();
                $val_tot=bcdiv(($prod->precio_u*$prod->cantidad), '1', 2);
                $val_tot_prod=($prod->precio_u*$prod->cantidad)+$val_tot_prod;
                $productos_e[]=array('id_producto'=>$prod->id_producto,
                 'nombre'=>$produ[0]->nombre,
                 'precio_u'=>$prod->precio_u,
                 'cantidad'=>$prod->cantidad,
                 'valor'=>$val_tot);
            }

            $cambio_entregado=$e_inventario->cambio_entregado;
            $val_tot_final=bcdiv($val_tot_prod+$e_inventario->cambio_entregado, '1', 2);
            $observacion=$e_inventario->observacion;

            $us_sup=0;
            $supervisores='nada';

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
                        foreach ($mercados as $merca){
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

            //$productos= array();
            //return 'Sucursal: '.$sucursal[1].'</br>Supervisor: '.$supervisor[1].'</br>Receptor: '.$receptor[1].'</br>Val_Tot_entre: '.$val_tot_final.' '.$observacion ;

            return view('panel_usuario/base',compact('rol','zona','usuario','sucursal','editar','nvo','supervisores','supervisor','receptor','val_tot_final','observacion','productos_e','us_sup','empleados_market','productos','cambio_entregado','markets','e_inventario'));
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
    public function update(RequestGuardaEntregaInv $request, Entrega $e_inventario)
    {
        if(!is_null( $request->user())){
           $rol=auth()->user()->authorizedRoles(['administrador','gerente']);

            $productos=json_decode($request->input('lista_productos'));

            if(count($productos)>0){           

                $tot=0;
                foreach($productos as $producto){
                    $tot+= $producto->valor;
                }

                //return $request->input('receptor');

                $e_inventario->id_market=$request->input('sucursal');
                $e_inventario->id_supervisor=$request->input('supervisor');
                if($request->input('receptor')==0){
                    return \Redirect::back()->withErrors('Debe seleccionar al empleado que recibirá la Entrega');
                }
                $e_inventario->id_receptor=$request->input('receptor');
                $e_inventario->cambio_entregado=$request->input('cambio');
                if(strlen($request->input('observacion'))<1){
                    $e_inventario->observacion='-';
                }else{
                    $e_inventario->observacion=$request->input('observacion');
                }     
                $e_inventario->valor_mercancia=$tot;                
                $e_inventario->save();

                $products=Detalle_entrega::where('id_entrega',$e_inventario->id)->delete();

                foreach ($productos as $producto){
                    $prod= new Detalle_entrega();                    
                    $prod->id_entrega=$e_inventario->id;
                    $prod->id_producto=$producto->prod_id;
                    $prod->cantidad=$producto->cantidad;
                    $prod->precio_u=$producto->precio_u;
                    $prod->save();
                }
            }else{
                return \Redirect::back()->withErrors('Debe registrar Productos en la entrega');
            }

            return redirect()->action('EntregaInventarioController@index')->with('status','Entrega de Inventario Actualizada Correctamente');

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
    public function destroy(Request $request, Entrega $e_inventario)
    {
        if(!is_null( $request->user())){
           $rol=auth()->user()->authorizedRoles(['administrador','gerente']);
           
           $products=Detalle_entrega::where('id_entrega',$e_inventario->id)->delete();
           $products=Entrega::where('id',$e_inventario->id)->delete();

           return redirect()->action('EntregaInventarioController@index')->with('status','Entrega de Inventario Eliminada Correctamente');
        }else{
            abort(403,'No puedes acceder a esta Seccion');
        }
        //return $e_inventario;
    }
}
