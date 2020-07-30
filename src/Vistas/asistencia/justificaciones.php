<?php
    require_once "../Controladores/GrupoHorarioControl.php";
    require_once "../Controladores/HorarioControl.php";

?>
 
<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar Justificaciones
   
    </h1>

    <ol class="breadcrumb">
      
      <li class="active">Administrar Justificaciones Asistencias</li>
    
    </ol>

  </section>

  <section class="content">
   
    <div class="box">
      
    <div class="box-header with-border">
    
     <div class="col-md-4">
          <!-- Seleccion de periodo en asistencia -->
            <label>Periodo</label>
            <select class="form-control select2" style="width: 100%;" id="jPeriodo">
            <option value="0">Seleccione Periodo</option>
            <?php
          
            $objPeriodo = new ControladorGrupoHorario();
            $periodos = $objPeriodo->ctrMostrarPeriodos(null);
                    
              foreach ($periodos as $key => $value) {
                    
                echo '<option value="'.$value["id"].'">'.$value["periodo"].'</option>';
            }

            ?>
  
            </select>
            
     </div>
     
    </div>
    
    <div class="box-body">
    
     <div class="nav-tabs-custom">
     
      <ul class="nav nav-tabs">
        <li class="active"><a href="#inicial" data-toggle="tab">Inicial</a></li>
        <li><a href="#primaria" data-toggle="tab">Primaria</a></li>
        <li><a href="#secundaria" data-toggle="tab">Secundaria</a></li>
      </ul>
      
    <div class="tab-content">
             
      <div class="active tab-pane" id="inicial">
           
        <div class="row">
          
          <!-- Seleccion de grupo en asistencia -->
          <div class="col-md-3">
            <label>Grupo</label><small> Seleccione un periodo primero</small>
            <select class="form-control select2" style="width: 100%;" id="jiGrupo" >
            <option value="0" >Seleccione Grupo</option>
            </select>

          </div>
          <!-- Seleccion de condificon en asistencia -->
          <div class="col-md-3">
            <label>Condicion</label>
            <select class="form-control select2" id="condicioni">
                  
            <option value="0">Todos</option>
            <option value="P">Puntual</option>
            <option value="T">Tarde</option>
            <option value="F">Falta</option>
            <option value="TJ">Tarde Justificada</option>
            <option value="FJ">Falta Justificada</option>
  
            </select>

          </div>
          
          <!-- Seleccion una fecha asistencia -->
          <div class="col-md-3">
            <label>Fecha</label>
            <div class="form-group">
              <div class="input-group date">
                  
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 

                <input type="text" class="form-control " id="fechai" placeholder="Ingrese una fecha">

              </div>

            </div>
<!--
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" id="fechai" onchange="fechai();">
            </div>
-->

          </div>
          
          <div class="col-md-3">
          <!-- Seleccion de grupo en asistencia -->
            <label>Horario</label>
            <select class="form-control select2" style="width: 100%;" id="jiHorario" >
            <option value="0" >Seleccione Horario</option>
            </select>

          </div>
          

        </div>
        <br>        
        <div id="tablainicial" class="post clearfix">        
            <p class="alert alert-warning">No hay datos, por favor seleccione un periodo, un grupo y una fecha o condicion.</p>     
        </div>
        
      </div>
              <!-- /.tab-pane -->
      <div class="tab-pane" id="primaria">
        <div class="row">
          
          <div class="col-md-3">
          <!-- Seleccion de grupo en asistencia -->
            <label>Grupo</label>
            <select class="form-control select2" style="width: 100%;" id="jpGrupo" >
            <option value="0" >Seleccione Grupo</option>
            </select>

          </div>
          <div class="col-md-3">
          <!-- Seleccion de condificon en asistencia -->
            <label>Condicion</label>
            <select class="form-control select2" style="width: 100%;" id="condicionp" >
                  
            <option value="0" >Todos</option>
            <option value="P" >Puntual</option>
            <option value="T" >Tarde</option>
            <option value="F" >Falta</option>
            <option value="TJ">Tarde Justificada</option>
            <option value="FJ">Falta Justificada</option>
  
            </select>

          </div>
          
          <div class="col-md-3">
          <!-- Seleccion una fecha asistencia -->
            <label>Fecha</label>
            <div class="form-group">
              <div class="input-group date">
                  
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 

                <input type="text" class="form-control " id="fechap" placeholder="Ingrese una fecha">

              </div>

            </div>
<!--
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="date" class="form-control pull-right" id="fechap" onchange="fechap();">
            </div>
-->

          </div>
          
          <div class="col-md-3">
          <!-- Seleccion de grupo en asistencia -->
            <label>Horario</label>
            <select class="form-control select2" style="width: 100%;" id="jpHorario" >
            <option value="0" >Seleccione Horario</option>
            </select>

          </div>

        </div>
        <br>        
        <div id="tablaprimaria" class="post clearfix">        
            <p class="alert alert-warning">No hay datos, por favor seleccione un periodo, un grupo y una fecha o condicion.</p>   
        </div>
        
                  
      </div>
              <!-- /.tab-pane -->

      <div class="tab-pane" id="secundaria">
        <div class="row">
          
          <div class="col-md-3">
          <!-- Seleccion de grupo en asistencia -->
            <label>Grupo</label>
            <select class="form-control select2" style="width: 100%;" id="jsGrupo" >
            <option value="0" >Seleccione Grupo</option>
            </select>

          </div>
          <div class="col-md-3">
          <!-- Seleccion de condificon en asistencia -->
            <label>Condicion</label>
            <select class="form-control select2" style="width: 100%;" id="condicions">
                  
            <option value="0" >Todos</option>
            <option value="P" >Puntual</option>
            <option value="T" >Tarde</option>
            <option value="F" >Falta</option>
            <option value="TJ">Tarde Justificada</option>
            <option value="FJ">Falta Justificada</option>
  
            </select>

          </div>
          
          <div class="col-md-3">
          <!-- Seleccion una fecha asistencia -->
            <label>Fecha</label>
            <div class="form-group">
              <div class="input-group date">
                  
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 

                <input type="text" class="form-control " id="fechas" placeholder="Ingrese una fecha">

              </div>

            </div>
<!--
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="date" class="form-control pull-right" id="fechas" onchange="fechas();">
            </div>
-->

          </div>
          
          <div class="col-md-3">
          <!-- Seleccion de grupo en asistencia -->
            <label>Horario</label>
            <select class="form-control select2" style="width: 100%;" id="jsHorario" >
            <option value="0" >Seleccione Horario</option>
            </select>

          </div>

        </div>
        <br>        
        <div id="tablasecundaria" class="post clearfix">        
           <p class="alert alert-warning">No hay datos, por favor seleccione un periodo, un grupo y una fecha o condicion.</p>      
        </div>     
      </div>
    </div>
    </div>

    </div> 
    
    </div>
    
    

  </section>

</div>

