<?php

namespace TamaleFiesta\Http\Controllers;

use TamaleFiesta\User;
use TamaleFiesta\Role_user;
use TamaleFiesta\Role;

use Illuminate\Http\Request;
use TamaleFiesta\Http\Requests\RequestGuardaUsuario;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       if(!is_null(auth()->user())){
            $rol=auth()->user()->authorizedRoles(['administrador','gerente','supervisor']);
            $zona='usuarios';
            $usuario=auth()->user();
            //$query_usuarios= User::all();
            $query_usuarios= User::paginate(10);

            $puestos_query =array();
            $usuario_puesto =array();

            foreach ($query_usuarios as $usurio) {
                $puestos = Role_user::where('user_id',$usurio->id)->orderBy('role_id', 'asc')->get();

                foreach ($puestos as $valor) {
                    $nombre_puesto=Role::where('id',$valor->role_id)->first();
                    $usuario_puesto[]=$nombre_puesto->descripcion;
                }

                if($puestos->count()<1){
                    $usuario_puesto[]='inexistente';
                }
                 
                $puestos_query[$usurio->id]=$usuario_puesto;
                unset($usuario_puesto);
                
            }

            return view('panel_usuario/base',compact('rol','zona','usuario','query_usuarios','puestos_query'));
        }else{
            abort(403,'No puedes acceder a esta Seccion');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $usuario, Request $request)
    {
        
        if(!is_null( $request->user())){
            $rol=$request->user()->authorizedRoles(['administrador','gerente','supervisor']);
            $zona='datos';
            $usuarioo=$request->user();

            if(is_null($usuario->name)){
                $usuario_query=$request->user();
                $zona_2='datos';
            }else{
                $zona_2='usuario';
                $usuario_query=User::where('name',$usuario->name)->first();
            }

            $editar='readonly';
            $editar_file='disabled';

            //------
            $puestos_query =array();
            $usuario_puesto =array();
        
            $puestos = Role_user::where('user_id',$usuario_query->id)->orderBy('role_id', 'asc')->get();

            foreach ($puestos as $valor) {
                $nombre_puesto=Role::where('id',$valor->role_id)->first();
                $usuario_puesto[]=$nombre_puesto->descripcion;
            }
                        
            //return $puestos_query;            
            //------

            return view('panel_usuario/base',compact('rol','zona','usuarioo','usuario_query','zona_2','editar','editar_file','usuario_puesto'));
            //return $usuario_query;
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
    public function edit(User $usuario, Request $request)
    {
        if(!is_null( $request->user())){
            $rol=$request->user()->authorizedRoles(['administrador','gerente']);
            $zona='datos';
            $usuarioo=$request->user();

            $usuario_query=User::where('name',$usuario->name)->first();
            $zona_2='usuario';
            $editar='';
            $editar_file='';

            //------
            $puestos_query =array();
            $usuario_puesto =array();
        
            $puestos = Role_user::where('user_id',$usuario_query->id)->orderBy('role_id', 'asc')->get();

            foreach ($puestos as $valor) {
                $nombre_puesto=Role::where('id',$valor->role_id)->first();
                $usuario_puesto[]=$nombre_puesto->descripcion;
            }
            
            //return $usuario_puesto;           
            //------

            return view('panel_usuario/base',compact('rol','zona','usuarioo','usuario_query','zona_2','editar','editar_file','usuario_puesto'));
            //return $usuario_query;
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
    public function update(RequestGuardaUsuario $request_usurio, User $usuario)
    {
        if(!is_null(auth()->user())){
            $rol=auth()->user()->authorizedRoles(['administrador','gerente']);
            //return $usuario;
            if(auth()->user()->id!=$usuario->id){

                $usuario->nombre_s=$request_usurio -> input('nombre_s');
                $usuario->apellido_s=$request_usurio -> input('apellido_s');
                $usuario->domicilio=$request_usurio -> input('domicilio');
                $usuario->telefono=$request_usurio -> input('telefono');

                $roul= new Role_user();
                $roul= Role_user::where('user_id',$usuario->id)->delete();

                $roul= new Role_user();

                if($request_usurio -> input('tipo_usuario')==7){
                    $id_roule=Role::where('nombre','Cliente')->first();

                    $roul->user_id=$usuario->id;
                    $roul->role_id=$id_roule->id;
                    $roul->save();

                }else{
                    $id_roule=Role::where('nombre','Empleado')->first();


                    $roul->user_id=$usuario->id;
                    $roul->role_id=$id_roule->id;
                    $roul->save();

                    if(!is_null($request_usurio->input('gerente'))){
                        $id_roule=Role::where('nombre','Gerente')->first();
                        $roul= new Role_user();
                        $roul->user_id=$usuario->id;
                        $roul->role_id=$id_roule->id;
                        $roul->save();
                    }

                    if(!is_null($request_usurio->input('supervisor'))){
                        $id_roule=Role::where('nombre','Supervisor')->first();
                        $roul= new Role_user();
                        $roul->user_id=$usuario->id;
                        $roul->role_id=$id_roule->id;
                        $roul->save();
                    }

                    if(!is_null($request_usurio->input('vendedor'))){
                        $id_roule=Role::where('nombre','Vendedor')->first();
                        $roul= new Role_user();
                        $roul->user_id=$usuario->id;
                        $roul->role_id=$id_roule->id;
                        $roul->save();
                    }

                    if(!is_null($request_usurio->input('operativo'))){
                        $id_roule=Role::where('nombre','Operativo')->first();
                        $roul= new Role_user();
                        $roul->user_id=$usuario->id;
                        $roul->role_id=$id_roule->id;
                        $roul->save();
                    }

                }
                
                if(is_null($request_usurio->input('activo'))){
                    $id_roule=Role::where('nombre','Inactivo')->first();
                    $roul= new Role_user();
                    $roul->user_id=$usuario->id;
                    $roul->role_id=$id_roule->id;
                    $roul->save();
                }



                if($request_usurio ->hasFile('foto')){

                    $exists = \Storage::disk('usuarios')->exists($usuario->foto);

                    if($exists){
                        \Storage::disk('usuarios')->delete($usuario->foto);
                    }

                    $file =$request_usurio->file('foto');
                    $imagen = time().'_'.$file->getClientOriginalName(); 
                    \Storage::disk('usuarios')->put($imagen,  \File::get($file));

                    $usuario->foto=$imagen;
                }

                $usuario->save();

                return redirect()->action('UsuariosController@index')->with('status','Usuario Actualizado Correctamente');

            }else{
                return \Redirect::back()->withErrors('No puedes Editar tu Propio Usuario');
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
    public function destroy(User $usuario)
    {
        if(!is_null(auth()->user())){
            $rol=auth()->user()->authorizedRoles(['administrador','gerente']);
            if(auth()->user()->id!=$usuario->id){
                $usuarioo= new User();
                $usuarioo= User::where('id',$usuario->id)->delete();

                $roul= new Role_user();
                $roul= Role_user::where('user_id',$usuario->id)->delete();

                return redirect()->action('UsuariosController@index')->with('status','Usuario Eliminado Correctamente');               
            }else{
                return \Redirect::back()->withErrors('No puedes Eliminar tu Propio Usuario');
                //return redirect()->action('Panel_usuario_controller@usuarios')->withErrors('status','No puedes Eliminar tu Propio Usuario');
                //return 'No puedes Eliminar tu Propio Usuario';
            }
        }else{
            abort(403,'No puedes acceder a esta Seccion');
        }   
    }
}
