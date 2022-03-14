<?php

namespace TamaleFiesta\Http\Controllers;

use TamaleFiesta\User;
use TamaleFiesta\Role_user;
use TamaleFiesta\Role;
use TamaleFiesta\Market_Vendedore;
use TamaleFiesta\Market;

use Illuminate\Http\Request;
use TamaleFiesta\Http\Requests\RequestGuardaSucursal;
use TamaleFiesta\Http\Requests\RequestActualizaSucursal;

class SucursalesController extends Controller
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
            $zona='sucursales';
            $usuario=auth()->user();
            $sucursales= Market::paginate(10);
            $users=User::all();

            $nombre_usuarios =array();
            $nombre_usuarios[]='inexistente';

            foreach ($users as $user) {
                $nombre_usuarios[]=$user->nombre_s.' '.$user->apellido_s;
            }

            return view('panel_usuario/base',compact('rol','zona','usuario','sucursales','nombre_usuarios'));
        }else{
            abort(403,'No puedes acceder a esta Seccion');
        }
    }

    public function saca_usuarios($puestos,$limite)
    {
        $usuarios_q=User::all();
        $roles=Role::whereIn('nombre', $puestos)->orderBy('id','asc')->get();

        $markets_users=Market_Vendedore::all();
        $ids_usados=array();

        $jefes_markets=Market::all();

        if($limite=='vendedores'){            
            foreach ($markets_users as $m_u){
                $ids_usados[]=$m_u->id_vendedor;
            }
        }

        if($limite=='supervisores'){
            foreach ($jefes_markets as $jefes) {
                $ids_usados[]=$jefes->id_supervisor;
            }
        }

        if($limite=='encargados'){
            foreach ($jefes_markets as $jefes) {
                $ids_usados[]=$jefes->id_encargado;
            }
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

            if($limite=='todos'){
                if(!in_array($nom, $users_autoriz)){
                    $users_autoriz[]=$nom[0];    
                }
            }else{                
                if(!in_array($nom[0][0],$ids_usados)){
                    if(!in_array($nom, $users_autoriz)){
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
            $rol=auth()->user()->authorizedRoles(['administrador','gerente']);
            $zona='sucursales_datos';
            $usuario=auth()->user();
            $markets= Market::all();
            $editar='';
            $nvo='nvo';

            //vendedores - ignora a los usuarios ya registrados en markets_vendedores
            //supervisores - ignora a los usuarios supervisores ya registrados en alguna sucursal (tabla markets)
            //encargados - ignora a los usuarios encargados ya registrados en alguna sucursal (tabla markets)
            //todos - no ignora a ningún usuario

            $supervisores=$this->saca_usuarios(['supervisor'],'todos');
            $encargados=$this->saca_usuarios(['gerente','vendedor','operativo'],'encargados');
            $empleados=$this->saca_usuarios(['vendedor','operativo'],'vendedores');

            //return $empleados;

            return view('panel_usuario/base',compact('rol','zona','usuario','markets','editar','nvo','supervisores','encargados','empleados'));
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
    public function store(RequestGuardaSucursal $request)
    {
        /*
        if($request->ajax()){
            return response()->json(['mensaje'=>'magia :D']);
        }
        */

        if(!is_null(auth()->user())){
            $rol=auth()->user()->authorizedRoles(['administrador','gerente']);

            //return $request;

            if(($request->input('encargado'))==($request->input('supervisor'))){
                return \Redirect::back()->withErrors('El Encargado no puede ser también el Supervisor');
            }else{

                $array=json_decode($request->input('lista_empleados'));

                if(count($array)>0){
                    $sucursal= new Market();

                    $sucursal->nombre=$request->input('nombre');
                    $sucursal->direccion=$request->input('domicilio');
                    $sucursal->telefono=$request->input('telefono');

                    $ubi=$request->input('ubicacion');
                    $primer_comi=strpos($ubi, 'src=');

                    if($primer_comi !== false){
                        
                        $largo=strpos(substr($ubi,$primer_comi+5,(strlen($ubi)-$primer_comi)), '"');
                        $segunda_comi=$largo+$primer_comi;
                        $ubi_final=substr($ubi,$primer_comi+5,$largo);

                        //return $ubi_final;
                        $sucursal->ubicacion=$ubi_final;
                        $sucursal->id_encargado=$request->input('encargado');
                        $sucursal->id_supervisor=$request->input('supervisor');

                        $sucursal->save();
                    }else{
                        return \Redirect::back()->withErrors('No se reconoce el enlace de Google Maps');
                    }

                    
                    $sucursal_emp= Market::where('nombre',$request->input('nombre'))->orderBy('id', 'desc')->first();

                    if(!is_null($sucursal_emp)){
                        $sig_market=($sucursal_emp->id);
                        
                    //return $sig_market;
                        
                        foreach($array as $empleado){                    

                            $sucursal_emp= new Market_Vendedore();
                            $sucursal_emp->id_market=$sig_market;
                            $sucursal_emp->id_vendedor=$empleado->emp_id;
                            $sucursal_emp->save();
                        }
                        
                        return redirect()->action('SucursalesController@index')->with('status','Sucursal Almacenada Correctamente');
                    }

                }else{
                    return \Redirect::back()->withErrors('Debe Asignar Empleados a la Sucursal');
                }
            }

        }else{
            abort(403,'No puedes acceder a esta Seccion');
        }
      
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Market $sucursale, Request $request)
    {
        if(!is_null( $request->user())){
            $rol=$request->user()->authorizedRoles(['administrador','gerente','supervisor']);
            $zona='sucursales_datos';
            $usuario=auth()->user();
            $editar='';
            $nvo='';

            //return $sucursale;
            $markets=Market::where('id',$sucursale->id)->first();
            $usuarios_q=User::all();
            $markets_users=Market_Vendedore::where('id_market',$sucursale->id)->get();
            $emplead=array();

            foreach ($usuarios_q as $usr) {
                if($usr->id==$markets->id_supervisor){
                   $superv=$usr->nombre_s.' '.$usr->apellido_s;
                   $superv_id=$markets->id_supervisor;
                }

                if($usr->id==$markets->id_encargado){
                   $encarg=$usr->nombre_s.' '.$usr->apellido_s;
                   $encarg_id=$markets->id_encargado;
                }
            }
            
            foreach ($markets_users as $mu) {
                $id_b=$mu->id_vendedor;
                foreach ($usuarios_q as $usr) {

                    if($id_b==$usr->id){
                        $emplead[]=[$usr->id,$usr->nombre_s.' '.$usr->apellido_s];
                    }
                }
            }

            //return  $emplead;

            $supervisores=$this->saca_usuarios(['supervisor'],false);
            $encargados=$this->saca_usuarios(['gerente','vendedor','operativo'],false);
            $empleados=$this->saca_usuarios(['vendedor','operativo'],true);

            return view('panel_usuario/base',compact('rol','zona','usuario','markets','editar','nvo','supervisores','encargados','empleados','superv','superv_id','encarg','encarg_id','emplead'));
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
    public function edit(Market $sucursale, Request $request)
    {
        //
        if(!is_null( $request->user())){
            $rol=$request->user()->authorizedRoles(['administrador','gerente']);
            $zona='sucursales_datos';
            $usuario=auth()->user();
            $editar='editar';
            $nvo='';

            //return $sucursale;

            $markets=Market::where('id',$sucursale->id)->first();
            $usuarios_q=User::all();
            $markets_users=Market_Vendedore::where('id_market',$sucursale->id)->get();
            $emplead=array();

            foreach ($usuarios_q as $usr) {
                if($usr->id==$markets->id_supervisor){
                   $superv=$usr->nombre_s.' '.$usr->apellido_s;
                   $superv_id=$markets->id_supervisor;
                }

                if($usr->id==$markets->id_encargado){
                   $encarg=$usr->nombre_s.' '.$usr->apellido_s;
                   $encarg_id=$markets->id_encargado;
                }
            }
            
            foreach ($markets_users as $mu) {
                $id_b=$mu->id_vendedor;
                foreach ($usuarios_q as $usr) {

                    if($id_b==$usr->id){
                        $emplead[]=[$usr->id,$usr->nombre_s.' '.$usr->apellido_s];
                    }
                }
            }

            //return  $emplead;

            //vendedores - ignora a los usuarios ya registrados en markets_vendedores
            //supervisores - ignora a los usuarios supervisores ya registrados en alguna sucursal (tabla markets)
            //encargados - ignora a los usuarios encargados ya registrados en alguna sucursal (tabla markets)
            //todos - no ignora a ningún usuario

            $supervisores=$this->saca_usuarios(['supervisor'],'todos');
            $encargados=$this->saca_usuarios(['gerente','vendedor','operativo'],'encargados');
            $empleados=$this->saca_usuarios(['vendedor','operativo'],'vendedores');

            return view('panel_usuario/base',compact('rol','zona','usuario','markets','editar','nvo','supervisores','encargados','empleados','superv','superv_id','encarg','encarg_id','emplead'));

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
    public function update(Market $sucursale, RequestActualizaSucursal $request)
    {
        if(!is_null( $request->user())){
            $rol=$request->user()->authorizedRoles(['administrador','gerente']);
            $zona='sucursales_datos';
            $usuario=auth()->user();
            $editar='editar';
            $nvo='';

            if(($request->input('encargado'))==($request->input('supervisor'))){
                return \Redirect::back()->withErrors('El Encargado no puede ser también el Supervisor');
            }else{
                $entra=0;

                $sucursal_emp= Market::where('nombre',$request->input('nombre'))->orderBy('id', 'desc')->get();
                //return $sucursal_emp->count();

                if($sucursal_emp->count()>0){
                    //return $sucursal_emp;
                    if($sucursal_emp[0]->id!=$sucursale->id){                        
                         $entra=0;
                    }else{
                        $entra=1;
                    }
                }else{
                    $entra=1;
                }

                if($entra==0){
                    return \Redirect::back()->withErrors('El Nombre de Sucursal Elegido Ya existe');
                }else{

                    //$sucursal= new Market();
                    $array=json_decode($request->input('lista_empleados'));
                    if(count($array)>0){
                        
                        $sucursale->nombre=$request->input('nombre');
                        $sucursale->direccion=$request->input('domicilio');
                        $sucursale->telefono=$request->input('telefono');

                        $ubi=$request->input('ubicacion');
                        $primer_comi=strpos($ubi, 'src=');

                        if($primer_comi !== false){
                            $largo=strpos(substr($ubi,$primer_comi+5,(strlen($ubi)-$primer_comi)), '"');
                            $segunda_comi=$largo+$primer_comi;
                            $ubi_final=substr($ubi,$primer_comi+5,$largo);

                            //return $ubi_final;
                            $sucursale->ubicacion=$ubi_final;
                            $sucursale->id_encargado=$request->input('encargado');
                            $sucursale->id_supervisor=$request->input('supervisor');
                            $id_mark=$sucursale->id;

                            $sucursale->save();
                        }else{
                            return \Redirect::back()->withErrors('No se reconoce el enlace de Google Maps');
                        }

                        
                       // $sucursal_emp= Market::where('nombre',$request->input('nombre'))->orderBy('id', 'desc')->first();

                       // if(!is_null($sucursal_emp)){
                        //   $sig_market=($sucursal_emp->id);
                            
                        //return $sig_market;

                        $mark_us= new Market_Vendedore();
                        $mark_us= Market_Vendedore::where('id_market',$id_mark)->delete();
                            
                            foreach($array as $empleado){                    

                                $sucursal_emp= new Market_Vendedore();
                                $sucursal_emp->id_market=$id_mark;
                                $sucursal_emp->id_vendedor=$empleado->emp_id;
                                $sucursal_emp->save();
                            }
                            
                            return redirect()->action('SucursalesController@index')->with('status','Sucursal Actualizada Correctamente');
                       // }
                    }else{
                        return \Redirect::back()->withErrors('Debe Asignar Empleados a la Sucursal');
                    }

                }
            }
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
    public function destroy(Market $sucursale,Request $request)
    {
         if(!is_null( $request->user())){
            $rol=$request->user()->authorizedRoles(['administrador','gerente']);

            $mark_us= new Market_Vendedore();
            $mark_us= Market_Vendedore::where('id_market',$sucursale->id)->delete();

            $marketa= new Market();
            $marketa= Market::where('id',$sucursale->id)->delete();

            return redirect()->action('SucursalesController@index')->with('status','Sucursal Eliminada Correctamente');
        }else{
             abort(403,'No puedes acceder a esta Seccion');
        }
        
    }
}
