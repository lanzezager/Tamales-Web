@extends('layouts.app')

@section('encabezado_opc')
	<link rel="stylesheet" type="text/css" href="{{ asset('/css/dashboard.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/dash_responsive.css') }}">
	 <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

       #data_mas_boton {
            line-height: 0.6;
            font-size: 22px ;
            font-weight: 700 ;
        }

        #data_menos_boton {
            line-height: 0.6 ;
            font-size: 30px ;
            font-weight: 700 ;
        }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>    
@endsection

@section('titulo','Panel de Usuario')

@section('activa1','')

@section('activa2','')

@section('contenido')  
  <div class="container-fluid">
    <div class="row">    
      @include('panel_usuario.common.highlight_sidebar')

      @include('panel_usuario.sidebar_panel_u_responsive')
      <div id="botones_menu">
          <a href="#" class="btn btn btn-outline-secondary movil_boton" id="movil_boton_derecha" ><span data-feather="arrow-right-circle" style="height: 24px; width: 24px;"></a>
          <a href="#" class="btn btn btn-outline-secondary movil_boton" id="movil_boton_izquierda" ><span data-feather="arrow-left-circle" style="height: 24px; width: 24px;"></a>
      </div>
      
    	@include('panel_usuario.sidebar_panel_u')
    	<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4" id="panel">
    		@include('panel_usuario.common.panel_selector')
      </main>
    </div>
  </div> 	
@endsection