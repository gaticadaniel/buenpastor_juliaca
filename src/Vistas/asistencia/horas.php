<?php
    require_once "../Controladores/GrupoHorarioControl.php";
    require_once "../Controladores/HorarioControl.php";

?>
 
<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar Reporte de Asistencias por Horas
   
    </h1>

    <ol class="breadcrumb">
      
      <li class="active">Administrar Reporte de Asistencias por Horas</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">
      
    <div class="box-header with-border">
  
    <label>
        <input type="radio" name="rh" id="rh" value="dni" class="flat-red" onclick="radioS()" checked>Dni
    </label>  
        
    <label>
        <input type="radio" name="rh" id="rh" value="apellidos" class="flat-red" onclick="radioS()" > Apellidos y Nombres
    </label>
    
    <div class="row">
      
      <div id="apellidosyNombre" style='display:none;'>
<!--		<form class="form-inline" name="por_nombre" id="por_nombre" >-->
		  <div  class="form-group col-md-2">
		    <input type="text" class="form-control" name="apellidosPH" id="apellidosPH" value="" placeholder="Apellido Paterno" >
		  </div>
		  <div class="form-group col-md-2">
		    <input type="text" class="form-control" name="apellidosMH" id="apellidosMH" value="" placeholder="Apellido Materno">
		  </div>
		  <div class="form-group col-md-2">
		    <input type="text" class="form-control" name="nombresH" id="nombresH" value="" placeholder="Nombres">
		  </div>
		  
		  <button onclick="buscarInfo()" class="btn btn-info">Buscar</button>
<!--		</form>-->
	  </div>
	
	  <div id="solo_dni">
<!--		<form class="form-inline" name="por_dni" id="por_dni" >-->
		  <div class="form-group col-md-2">
		    <input type="number" class="form-control" name="dnirh" id="dnirh" minlength="5" placeholder="DNI" required/>	
		  </div>
		  
		  <button onclick="buscarInfo()" class="btn btn-info">Buscar</button>
<!--		</form>-->
	  </div>
		
    </div>
    
    <div class="col-md-4">
     <div class="form-group">
        <label>Elija la fecha</label>

        <div class="input-group">
            <button type="button" class="btn btn-default pull-right" id="daterange-btn3">
             <span>
             <i class="fa fa-calendar"></i> Rango de fechas
             </span>
             <i class="fa fa-caret-down"></i>
            </button>
        </div>
      </div>
    </div>
    
    <div class="col-md-1 pull-right">
      <div class="box-tools pull-right">
       
    <button class="btn btn-success" onclick="descargareporteh()" style="margin-top:25px">Descargar Excel</button>
       
      </div>

    </div>
    
    
    
    </div>
    
    <div class="box-body">
     <div id="dataHoras">
	 <p id="advertencia" class="alert alert-warning">No hay datos. Ingrese un dni y rango de fechas para mostrar datos.</p>
     </div>

    </div>    

    
   
    </div>

  </section>

</div>

