<?php
    require_once "../Controladores/GrupoHorarioControl.php";
    require_once "../Controladores/HorarioControl.php";

?>
 
<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
     Reporte de Asistencias por fechas
   
    </h1>

    <ol class="breadcrumb">
      
      <li class="active">Reporte de Asistencias por fechas</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">
      
    <div class="box-header with-border">
  
    <div class="row"> 
        
    <div class="col-md-3">
     <label>Periodo</label>
      <select class="form-control select2" style="width: 100%;" name="fPeriodo" id="fPeriodo" >
        <option value="0" >Seleccione Periodo</option>
          <?php
          
            $objPeriodo = new ControladorGrupoHorario();
            $periodos = $objPeriodo->ctrMostrarPeriodos(null);
                    
              foreach ($periodos as $key => $value) {
                    
                echo '<option value="'.$value["id"].'">'.$value["periodo"].'</option>';
            }

          ?>
  
      </select>

    </div>
    
    <div class="col-md-3">
     <label>Grupo</label><small> Seleccione un periodo primero</small>
      <select class="form-control select2" style="width: 100%;" name="fGrupo" id="fGrupo" >
        <option value="0" >Seleccione Grupo</option> 
      </select>

    </div>
    
    <div class="col-md-3">
     <div class="form-group">
        <label>Eliga la fecha </label>

        <div class="input-group">
            <button type="button" class="btn btn-default pull-right" id="daterange-btn2">
             <span>
             <i class="fa fa-calendar"></i> Rango de fechas
             </span>
             <i class="fa fa-caret-down"></i>
            </button>
        </div>
      </div>
    </div>
    
    </div>
    <div class="box-tools pull-right">
       
         <button class="btn btn-success" onclick="descargar()" style="margin-top:25px">Descargar Excel</button>
      
    </div>
    </div>
    
    <div class="box-body">
    <div id="datafechas">
	 <p class="alert alert-warning">No hay datos, por favor selecciona un periodo un grupo y una fecha.</p>
    </div>

    </div>    

    
   
    </div>

  </section>

</div>
