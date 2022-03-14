<?php

namespace TamaleFiesta\Http\Controllers;


use TamaleFiesta\Producto;
use TamaleFiesta\Categoria_producto;
use TamaleFiesta\User;

use Illuminate\Http\Request;
use TamaleFiesta\Http\Requests\RequestGuardaProducto;
use TamaleFiesta\Http\Requests\RequestActualizaProducto;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!is_null( $request->user())){
            $rol=$request->user()->authorizedRoles(['administrador','gerente','supervisor','vendedor']);
            $zona='productos';
            $usuario=$request->user();


            //$productos = Producto::all();
            $productos = Producto::paginate(10);

            $catego_produ= new Categoria_producto();
            $catego_produ= Categoria_producto::all();
            //return $productos->count();
            return view('panel_usuario/base',compact('rol','zona','usuario','productos','catego_produ'));
            
        }else{
            abort(403,'No puedes acceder a esta Seccion');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
       if(!is_null( $request->user())){
            $rol=$request->user()->authorizedRoles(['administrador','gerente']);
            $zona='add_productos';
            $usuario=$request->user();
            $modo_edit="on";
            $nvo="on";
            $msg="nvo";
            $produ = array (
                "nombre"  => "1 ",
                "descripcion" => "1 ",
                "precio"   => " 1",
                "existencias"   => "1 ",
                "id_categoria"   => "1 ",
                "activo"   => " 1",
                "imagen"   => "default.png"
            );

            $catego_produ= new Categoria_producto();
            $catego_produ= Categoria_producto::all();

            return view('panel_usuario/base',compact('rol','zona','usuario','modo_edit','nvo','produ','msg','catego_produ'));
            
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
    public function store(RequestGuardaProducto $request_save)
    {
        if(!is_null(auth()->user())){
            $rol=auth()->user()->authorizedRoles(['administrador','gerente']);
            $zona='add_productos';
            $usuario=auth()->user();

            //return $request_save;

            if($request_save ->hasFile('imagen')){
                $file =$request_save->file('imagen');
                $imagen = time().'_'.$file->getClientOriginalName();
                //$path = $request_save->file('imagen')->store('images/productos/'.$imagen);
                //$path = $request_save->file('imagen')->storeAs('images/productos', $imagen);
                //$file ->move(public_path().'/images/productos/',$imagen); 
                \Storage::disk('productos')->put($imagen,  \File::get($file));


                $producto = new Producto();
                $producto->nombre=$request_save -> input('nombre');
                $producto->descripcion=$request_save -> input('descripcion');
                $producto->precio=$request_save -> input('precio');
                $producto->existencias=0;
                $producto->imagen=$imagen;
                $producto->id_categoria=$request_save -> input('id_categoria');

                $fecha_actual=getdate();

                if(!is_null($request_save->input('items'))){
                    $producto->items_combo=$request_save->input('items');
                }else{
                     return \Redirect::back()->withErrors('El combo no puede contener 0 elementos');
                }

                if(!is_null($request_save->input('combo_desde'))){
                    $producto->vig_desde=$request_save->input('combo_desde');
                }else{                    
                    //return $fecha_actual['year'].'-01-01';
                    $producto->vig_desde=($fecha_actual['year'].'-01-01');
                }

                if(!is_null($request_save->input('combo_hasta'))){
                    $producto->vig_hasta=$request_save->input('combo_hasta');
                }else{                    
                    //return $fecha_actual['year'].'-12-31';
                    $producto->vig_hasta=($fecha_actual['year'].'-12-31');
                }

                if(!is_null($request_save->input('activo'))){
                    $activar= true;
                }else{
                    $activar= false;
                }

                $producto->activo=$activar;
                $producto->save();
                //return $imagen;
                return redirect()->action('ProductosController@index')->with('status','Producto Guardado Correctamente');
            }else{
                return \Redirect::back()->withErrors('No se cargó una imagen');
            }
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
    public function show(Producto $producto, Request $request)
    {
        if(!is_null( $request->user())){

            $rol=$request->user()->authorizedRoles(['administrador','gerente','supervisor','vendedor']);
            $zona='add_productos';
            $usuario=$request->user();
            $modo_edit="off";
            $nvo="off";
            $msg="show";

            if(empty($producto->imagen)){
                $producto->imagen="default.png";
            }

            $catego_produ= new Categoria_producto();
            $catego_produ= Categoria_producto::all();

            return view('panel_usuario/base',compact('rol','zona','usuario','producto','modo_edit','nvo','msg','catego_produ'));
            
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
    public function edit(Producto $producto,Request $request)
    {
       
        if(!is_null( $request->user())){
            $rol=$request->user()->authorizedRoles(['administrador','gerente']);
            $zona='add_productos';
            $usuario=$request->user();
            $modo_edit="on";
            $nvo="off";
            $msg="edit";

            if(empty($producto->imagen)){
                $producto->imagen="default.png";
            }

            $catego_produ= new Categoria_producto();
            $catego_produ= Categoria_producto::all();

            return view('panel_usuario/base',compact('rol','zona','usuario','producto','modo_edit','nvo','msg','catego_produ'));
            
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
    public function update(RequestActualizaProducto $request_save, Producto $producto)
    {
        if(!is_null( $request_save->user())){
            $rol=$request_save->user()->authorizedRoles(['administrador','gerente']);
            /*$produ ->fill(['nombre' => $request_save -> input('nombre')],
                ['descripcion' => $request_save -> input('descripcion')],
                ['precio' => $request_save -> input('precio')],
                ['existencias' => $request_save -> input('existencias')],
                ['id_categoria' => $request_save -> input('id_categoria')]);*/
            $producto->nombre=$request_save -> input('nombre');
            $producto->descripcion=$request_save -> input('descripcion');
            $producto->precio=$request_save -> input('precio');
            //$produ->existencias=$request_save -> input('existencias');
            $producto->id_categoria=$request_save -> input('id_categoria');

            if($request_save ->hasFile('imagen')){
                $file =$request_save->file('imagen');
                $imagen = time().'_'.$file->getClientOriginalName();
                \Storage::disk('productos')->put($imagen,  \File::get($file));
                $producto->imagen=$imagen;

            }else{
                if(empty($producto->imagen)){
                    return \Redirect::back()->withErrors('No se cargó una imagen');
                }           
            }

            $fecha_actual=getdate();

            if(!is_null($request_save->input('items'))){
                $producto->items_combo=$request_save->input('items');
            }else{
               return \Redirect::back()->withErrors('El combo no puede contener 0 elementos');
            }

            if(!is_null($request_save->input('combo_desde'))){
                $producto->vig_desde=$request_save->input('combo_desde');
            }else{                    
                //return $fecha_actual['year'].'-01-01';
                $producto->vig_desde=($fecha_actual['year'].'-01-01');
            }

            if(!is_null($request_save->input('combo_hasta'))){
                $producto->vig_hasta=$request_save->input('combo_hasta');
            }else{                    
                        //return $fecha_actual['year'].'-12-31';
                $producto->vig_hasta=($fecha_actual['year'].'-12-31');
            }           

            if(!is_null($request_save->input('activo'))){
                $activar= true;
            }else{
                $activar= false;
            }

            $producto->activo=$activar;
            $producto->save();

            return redirect()->action('ProductosController@index')->with('status','Producto Actualizado Correctamente');
            //return redirect()->action('Panel_usuario_controller@edit_productos',[$produ])->with('status','Producto Actualizado Correctamente');
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
    public function destroy(Producto $producto)
    {
        //return $producto;
        if(!is_null(auth()->user())){
            $rol=auth()->user()->authorizedRoles(['administrador','gerente']);
            
            $Productoo= new Producto();
            $Productoo= Producto::where('id',$producto->id)->delete();
            //return "Borraré este producto: ".$produ->id." ".$produ->nombre;
            return redirect()->action('ProductosController@index')->with('status','Producto Eliminado Correctamente');
        }else{
            abort(403,'No puedes acceder a esta Seccion');
        }   
    }
}
