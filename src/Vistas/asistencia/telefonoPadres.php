<?php
    require_once "../Controladores/GrupoHorarioControl.php";
    require_once "../Controladores/HorarioControl.php";

?>
 
<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar Telefonos de Padres
   
    </h1>

    <ol class="breadcrumb">
      
      <li class="active">Administrar Telefonos de Padres</li>
    
    </ol>

  </section>

  <section class="content">
   
    <div class="box">
      
    <div class="box-header with-border">
    
     <div class="col-md-4">
          <!-- Seleccion de periodo en asistencia -->
            <label>Periodo</label>
            <select class="form-control select2" style="width: 100%;" name="tPeriodo" id="tPeriodo" >
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
          
          <div class="col-md-4">
          <!-- Seleccion de grupo en asistencia -->
            <label>Grupo</label><small> Seleccione un periodo primero</small>
            <select class="form-control select2" style="width: 100%;" name="tiGrupo" id="tiGrupo" >
            <option value="0" >Seleccione Grupo</option>
            </select>

          </div>
          <div class="col-md-4">
          <!-- Seleccion de condificon en asistencia -->
            <label>Condicion</label>
            <select class="form-control select2" id="condicioni" name="condicioni" >
                  
            <option value="0" >Todos</option>
            <option value="P" >Puntual</option>
            <option value="T" >Tarde</option>
            <option value="F" >Falta</option>
  
            </select>

          </div>
          
          <div class="col-md-4">
          <!-- Seleccion una fecha asistencia -->
            <label>Fecha</label>
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="date" class="form-control pull-right" id="fechai" onchange="fechai();">
            </div>

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
          
          <div class="col-md-4">
          <!-- Seleccion de grupo en asistencia -->
            <label>Grupo</label>
            <select class="form-control select2" style="width: 100%;" name="tpGrupo" id="tpGrupo" >
            <option value="0" >Seleccione Grupo</option>
            </select>

          </div>
          <div class="col-md-4">
          <!-- Seleccion de condificon en asistencia -->
            <label>Condicion</label>
            <select class="form-control select2" style="width: 100%;" id="condicionp" name="condicionp" >
                  
            <option value="0" >Todos</option>
            <option value="P" >Puntual</option>
            <option value="T" >Tarde</option>
            <option value="F" >Falta</option>
  
            </select>

          </div>
          
          <div class="col-md-4">
          <!-- Seleccion una fecha asistencia -->
            <label>Fecha</label>
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="date" class="form-control pull-right" id="fechap" onchange="fechap();">
            </div>

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
          
          <div class="col-md-4">
          <!-- Seleccion de grupo en asistencia -->
            <label>Grupo</label>
            <select class="form-control select2" style="width: 100%;" name="tsGrupo" id="tsGrupo" >
            <option value="0" >Seleccione Grupo</option>
            </select>

          </div>
          <div class="col-md-4">
          <!-- Seleccion de condificon en asistencia -->
            <label>Condicion</label>
            <select class="form-control select2" style="width: 100%;" id="condicions" name="condicions" >
                  
            <option value="0" >Todos</option>
            <option value="P" >Puntual</option>
            <option value="T" >Tarde</option>
            <option value="F" >Falta</option>
  
            </select>

          </div>
          
          <div class="col-md-4">
          <!-- Seleccion una fecha asistencia -->
            <label>Fecha</label>
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="date" class="form-control pull-right" id="fechas" onchange="fechas();">
            </div>

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

