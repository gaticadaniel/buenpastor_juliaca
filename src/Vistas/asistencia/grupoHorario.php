<?php
        require_once "../Controladores/GrupoHorarioControl.php";
        require_once "../Controladores/HorarioControl.php";
?>
<div class="content-wrapper">

  <div class="box box-solid">
   
    <div class="box-header">
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
        </div>
    </div>
    
    <div class="box-body">
      <div class="row">
           
        <div class="col-md-6">
        <label>Periodo</label>
        <form action='../Controladores/AsistenciaControl.php' method="POST" name="form_periodo" id="form_periodo" class="form-inline" role="form" >
        <select class="form-control select2" style="width: 100%;" name="periodo_id" id="periodo_id" onchange="this.form.submit()">
					<option value="" disabled="true" <?php if(!isset($_SESSION['p4periodo_id'])) echo "selected='true'"; ?> >Elija un periodo</option>
<?php
					if( isset($_SESSION['p4periodos']) ){
						$p4periodos=$_SESSION['p4periodos'];
						for ($i=0; $i < count($p4periodos); $i++) { 
							$value="";
							if(isset($_SESSION['p4periodo_id'])) {
								if($_SESSION['p4periodo_id']==$p4periodos[$i]['id']) {
									$value="selected='true'";
								}
							}
							echo "<option value='".$p4periodos[$i]['id']."' ".$value.">".$p4periodos[$i]['periodo']."</option>";
						}
					}
?>
				</select>
				<input type='hidden' name='control' id='control' value='ElegirGrupoHorarios'>
			</form>    
        </div>
            
        <div class="col-md-6">       
        <label>Grupo</label> 
        <form action='../Controladores/AsistenciaControl.php' method="POST" name="form_grupo" id="form_grupo" class="form-inline" role="form" >
            <select class="form-control select2" style="width: 100%;" name="grupo_id" id="grupo_id" onchange="this.form.submit()">
				<option value="" disabled="true" selected="true">Elija un grupo</option>
<?php
					if( isset($_SESSION['p4grupos']) ){
						$p4grupos=$_SESSION['p4grupos'];
						for ($i=0; $i < count($p4grupos); $i++) { 
							$value="";
							if(isset($_SESSION['p4grupo_id'])) {
								if($_SESSION['p4grupo_id']==$p4grupos[$i]['id']) {
									$value="selected='true'";
								}
							}
							echo "<option value='".$p4grupos[$i]['id']."' ".$value.">".$p4grupos[$i]['nivel']." - ".$p4grupos[$i]['grado']." - ".$p4grupos[$i]['seccion']."</option>";
						}
					}
?>
				</select>
				<input type='hidden' name='control' id='control' value='ElegirGrupoH'>
			</form>
        </div>
            
      </div>
    </div>
        
  </div>
          
  <section class="content-header">
    
    <h1>
      
      Administrar Horarios de Grupos
    
    </h1>

    <ol class="breadcrumb">
      
      <li class="active">Administrar Horarios de Grupos</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarGrupoHorario">
          
          Agregar Grupo Horario

        </button>

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive ">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Grupo</th>
           <th>Horario</th>
           <th>Fecha </th>
           <th>Creación</th>
           <th>Ult. Modificacion</th>
           <th>Usuario</th>
           <th>Opciones</th>
           
         </tr> 

        </thead>

        <tbody>
        <?php
        if(isset($_SESSION['idGrupo'])){
            
		  $idGrupo = $_SESSION['idGrupo'];
          $objGruposHorarios = new ControladorGrupoHorario();
          $grupos = $objGruposHorarios->ctrMostrarGrupoHorariosPorGrupo($idGrupo);
            
           foreach ($grupos as $key => $value){
         
            echo ' <tr>
              <td>'.($key+1).'</td>
              <td>'.$value["comentario"].'</td>
              <td>'.$value["denominacion"].'</td>             
              <td>'.$value["fecha"].'</td> 
              <td>'.$value["created"].'</td> 
              <td>'.$value["modified"].'</td> 
              <td>'.$value["usuario"].'</td> 
              <td>
                  
                <div class="btn-group">
                 <button class="btn btn-danger btnEliminarGrupoHorario" idGrupoHorario="'.$value["id"].'" ><i class="fa fa-times"></i></button>
                </div>  

              </td>
            </tr>';
            }
        }
        ?> 

        </tbody>

       </table>

      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL AGREGAR GRUPO HORARIO
======================================-->

<div id="modalAgregarGrupoHorario" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" >

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar Grupo Horario</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">
        
           <!-- ENTRADA PARA LA FECHA -->          
            <div class="box-header">              
              <h3 class="box-title">Selecione una Fecha
                <small>para el horario</small>
              </h3>            
            </div>

            <div class="box-body pad">
              <div class="form-group">
                <label>Fecha:</label>
                <div class="input-group date">
                  <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                  <input type="date" class="form-control pull-right" id="fecha" name="fecha" required>
                </div>
              </div>
            </div>
            
          
          
           <!-- ENTRADA PARA LOS GRUPOS -->          
            <div class="box-header">
              <h3 class="box-title">Selecione Grupos 
                <small>Puede parametrizar su busqueda</small>
              </h3>
            </div>
            <div class="box-body pad">
            <!-- ENTRADA PARA SELECCIONAR PERIODO -->
            <div class="form-group">
              
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-th"></i></span>    
               
                <select class="form-control select2" id="nPeriodo" name="nPeriodo" style="width: 100%;" required>
                  
                  <option value="0" >Selecionar Periodo</option>

                  <?php 
                  $objPeriodos= new ControladorGrupoHorario();
                    $periodos = $objPeriodos->ctrMostrarPeriodos(null);
                   foreach ($periodos as $key => $value) {
                    echo '<option value="'.$value["id"].'">'.$value["periodo"].'</option>';
                  }

                  ?>
  
                </select>

              </div>

            </div>

            <!-- ENTRADA PARA SELECCIONAR NIVEL -->

            <div class="form-group">
              
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <select class="form-control input-lg select2" id="nNivel" name="nNivel" style="width: 100%;" required>
                  
                  <option value="0" >Selecionar Nivel</option>

                  <?php
                   $objNivel = new ControladorHorarios();
                   $niveles = $objNivel->ctrMostrarNiveles();
                   foreach ($niveles as $key => $value) {
                    echo '<option value="'.$value["id"].'">'.$value["nivel"].'</option>';
                  }
                  ?>
  
                </select>

              </div>

            </div>
            
            <!-- checkbox -->
            
            <div class="box-header">
              <h3 class="box-title">Grupos</h3>
            </div>
            
            <div class="box-body">
              <div class="form-group minimal" id="checkgrupo"></div>
            </div>
            
            <!-- horario -->
            <div class="box-header">
             <h3 class="box-title">Seleccione un Horario
             <small>seleccione un nivel primero</small></h3>
            </div>

            <div class="box-body">
            
            <div class="form-group minimal" id="listaHorario"> 
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <select class="form-control input-lg select2" id="ngHorario" name="ngHorario" style="width: 100%;" required>
                  <option value="" >Selecionar Horario</option>
                </select>

              </div>        
            </div>
            
            </div>
            
            </div>
            
          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar Grupo Horario</button>

        </div>

      </form>

       <?php
        $objAsistencias = new ControladorGrupoHorario();
        $objAsistencias->ctrCrearGrupoHorario();
       ?>  

    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR GRUPO HORARIO
======================================-->

<div id="modalEditarGrupoHorario" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar Grupo Horario</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">


        <!--  ENTRADA PARA SELECCIONAR GRUPO -->

            <div class="form-group">
              <h4 class="box-title">Grupo</h4>
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <select class="form-control input-lg " name="editGrupo" required>
                  
                  <option id="editGrupo"></option>
                  
                  <?php
//                    $objAsistencias = new ControladorGrupoHorario();
//                    $grupos = $objAsistencias->ctrSeleccionarGrupo();
//                    
//                  foreach ($grupos as $key => $value) { 
//                    echo '<option value="'.$value["id"].'">'.$value["comentario"].'</option>';
//                  }
                    
                  ?>
  
                </select>

              </div>

            </div> 
        
        <!--  ENTRADA PARA SELECCIONAR HORARIO -->

            <div class="form-group">
                    <h4 class="box-title">Horario</h4>
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <select class="form-control input-lg " name="editHorario" required>
                  
                  <option id="editHorario"></option>
                  
                  <?php
                    $objAsistencias = new ControladorHorarios();
                    $grupos = $objAsistencias->ctrMostrarhorarios(null);
                    
                  foreach ($grupos as $key => $value) { 
                    echo '<option value="'.$value["id"].'">'.$value["denominacion"].'</option>';
                  }
                    
                  ?>
  
                </select>

              </div>

            </div>

            <!-- ENTRADA PARA LA FECHA -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span> 

                <input type="date" class="form-control input-lg" id="editfecha" name="editfecha" value="" required>
                
                <input type="hidden" class="form-control input-lg" id="idghorario" name="idghorario" value="" required>
              </div>

            </div>

          </div>

        </div>
    

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar cambios</button>

        </div>

      </form>

        <?php

          $editarGrupoHorario = new ControladorGrupoHorario();
          $editarGrupoHorario -> ctrEditarGrupoHorario();

        ?>     

    </div>

  </div>

</div>

<?php
  $eliminarGrupoHorario = new ControladorGrupoHorario();
  $eliminarGrupoHorario -> ctrEliminarGrupoHorario();
?>  