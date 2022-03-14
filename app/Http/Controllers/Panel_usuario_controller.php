<?php

namespace TamaleFiesta\Http\Controllers;

use TamaleFiesta\Categoria_producto;
use TamaleFiesta\Detalle_venta;
use TamaleFiesta\Producto;
use TamaleFiesta\User;
use TamaleFiesta\Venta;
use TamaleFiesta\Role_user;
use TamaleFiesta\Role;


use Illuminate\Http\Request;
use TamaleFiesta\Http\Requests\RequestGuardaProducto;
use TamaleFiesta\Http\Requests\RequestActualizaProducto;
use TamaleFiesta\Http\Requests\RequestGuardaUsuario;

class Panel_usuario_controller extends Controller
{
    //

	public function index(Request $request){
        if(!is_null( $request->user())){
            $rol=$request->user()->authorizedRoles(['administrador','gerente','supervisor','vendedor','empleado','cliente','usuario']);
            $zona='inicio';
            /*
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        	$hash='U_'.substr(str_shuffle($permitted_chars), 0, 16).time();
        	return $hash;*/

            return view('panel_usuario/base',compact('rol','zona'));
            
        }else{
            abort(403,'No puedes acceder a esta Seccion');
        }
    }

    public function datos(User $userio, Request $request){
    	 if(!is_null( $request->user())){
            $rol=$request->user()->authorizedRoles(['administrador','gerente','supervisor','vendedor','empleado','cliente','usuario']);
            $zona='datos';
            $usuario=$request->user();

            if(is_null($userio->name)){
            	$usuario_query=$request->user();
            	$zona_2='datos';
            }else{
            	$zona_2='usuario';
            	$usuario_query=User::where('name',$userio->name)->first();
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

            return view('panel_usuario/base',compact('rol','zona','usuario','usuario_query','zona_2','editar','editar_file','usuario_puesto'));
            //return $usuario_query;
        }else{
            abort(403,'No puedes acceder a esta Seccion');
        }

    }

    public function pdv(Request $request){

    }

    public function pedidos(Request $request){
    	if(!is_null(auth()->user())){
            $rol=auth()->user()->authorizedRoles(['administrador','gerente','supervisor','vendedor','empleado','cliente','usuario']);
            $zona='pedidos';
            $usuario=auth()->user();
            
            return view('panel_usuario/base',compact('rol','zona','usuario'));
        }else{
            abort(403,'No puedes acceder a esta Seccion');
            
        }
    }

    public function estadisticas(Request $request){
    	if(!is_null(auth()->user())){
            $rol=auth()->user()->authorizedRoles(['administrador','gerente','supervisor','vendedor','empleado','cliente','usuario']);
            $zona='estadisticas';
            $usuario=auth()->user();
            
            return view('panel_usuario/base',compact('rol','zona','usuario'));
        }else{
            abort(403,'No puedes acceder a esta Seccion');
        }
    }

    public function ajustes(Request $request){
    	if(!is_null(auth()->user())){
            $rol=auth()->user()->authorizedRoles(['administrador','gerente','supervisor','vendedor','empleado','cliente','usuario']);
            $zona='ajustes';
            $usuario=auth()->user();
            
            return view('panel_usuario/base',compact('rol','zona','usuario'));
        }else{
            abort(403,'No puedes acceder a esta Seccion');
        }
    }
}
