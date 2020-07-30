<?php
            require_once "../Controladores/HorarioControl.php";
?>
 
<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar Horarios
    
    </h1>

    <ol class="breadcrumb">
      
      <li class="active">Administrar Horarios</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarHorario">
          
          Agregar Horario

        </button>

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Denominación</th>
           <th>Nivel</th>
           <th>Hora Ingreso</th>
           <th>Minutos PreIngreso</th>
           <th>Tolerancia Ingreso</th>
           <th>Minutos PosIngreso</th>
           <th>Hora Salida</th>
           <th>Minutos PreSalida</th>
           <th>Tolerancia Salida</th>
           <th>Minutos PosSalida</th>
           <th>Opciones</th>
           
         </tr> 

        </thead>

        <tbody>
        <?php

		$objHorarios = new ControladorHorarios();
        $horarios = $objHorarios->ctrVerHorariosyNiveles(null);
            
         foreach ($horarios as $key => $value){
         
          echo ' <tr>
                  <td>'.($key+1).'</td>
                  <td>'.$value["denominacion"].'</td>
                  <td>'.$value["nivel"].'</td>             
                  <td>'.$value["hora_ingreso"].'</td> 
                  <td>'.$value["minutos_antes_ingreso"].'</td> 
                  <td>'.$value["minutos_de_tolerancia"].'</td> 
                  <td>'.$value["minutos_despues_ingreso"].'</td> 
                  <td>'.$value["hora_salida"].'</td> 
                  <td>'.$value["minutos_antes_salida"].'</td> 
                  <td>'.$value["minutos_de_tolerancia_2"].'</td> 
                  <td>'.$value["minutos_despues_salida"].'</td> 
                  <td>
                    <div class="btn-group">
                        
                      <button class="btn btn-warning btnEditarHorario" idHorario="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarHorario"><i class="fa fa-pencil"></i></button>

                      <button class="btn btn-danger btnEliminarHorario" idHorario="'.$value["id"].'" ><i class="fa fa-times"></i></button>

                    </div>  

                  </td>

                </tr>';
        }
        ?> 

        </tbody>

       </table>


      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL AGREGAR Horario
======================================-->

<div id="modalAgregarHorario" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" >

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar Horario</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">


            <!-- ENTRADA PARA SELECCIONAR NIVEL -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th-list"></i></span> 

                <select class="form-control input-lg" id="nuevoNivel" name="nuevoNivel" required>
                  
                  <option value="" >Seleccione Nivel</option>

                  <?php
                    $objNivels = new ControladorHorarios();
                    $niveles = $objNivels->ctrMostrarNiveles();
                    
                  foreach ($niveles as $key => $value) {
                    
                    echo '<option value="'.$value["id"].'">'.$value["nivel"].'</option>';
                  }

                  ?>
  
                </select>

              </div>

            </div>

            <!-- ENTRADA PARA LA DENOMINACION -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-align-left"></i></span> 

                <input type="text" class="form-control input-lg" name="denominacion" placeholder="Ingresar Denominacion" required>

              </div>

            </div>
            
            <!-- ENTRADA PARA HORA DE INGRESO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span> 

                <input type="time" class="form-control input-lg" name="horaIngreso" placeholder="Ingresar Hora Ingreso" required>

              </div>

            </div>
            
            <!-- ENTRADA PARA LOS MINUTOS ANTES DEL INGRESO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span> 

                <input type="number" min="0" class="form-control input-lg" name="mantesi" placeholder="Ingresar Minutos Antes del Ingreso" required>

              </div>

            </div>
            
            <!-- ENTRADA PARA MINUTOS DE TOLERANCIA AL INGRESO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span> 

                <input type="number" min="0" class="form-control input-lg" name="mtoleranciai" placeholder="Ingresar Minutos Tolerancia del Ingreso" required>

              </div>

            </div>
            
            <!-- ENTRADA MINUTOS DESPUES DEL INGRESO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span> 

                <input type="number" min="0" class="form-control input-lg" name="mdespuesi" placeholder="Ingresar Minutos Despues del Ingreso" required>

              </div>

            </div>
            
            <!-- ENTRADA PARA LA HORA DE SALIDA -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span> 

                <input type="time" class="form-control input-lg" name="horaSalida" placeholder="Ingresar Hora de Salida" required>

              </div>

            </div>
            
            <!-- ENTRADA PARA LOS MINUTOS ANTES DE LA SALIDA -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span> 

                <input type="number" min="0" class="form-control input-lg" name="mantess" placeholder="Ingresar Minutos Antes de la Salida" required>

              </div>

            </div>
            
            <!-- ENTRADA PARA MINUTOS DE TOLERANCIA A LA SALIDA -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span> 

                <input type="number" min="0" class="form-control input-lg" name="mtolerancias" placeholder="Ingresar Minutos Tolerancia de la Salida" required>

              </div>

            </div>
            
            <!-- ENTRADA MINUTOS DESPUES DE LA SALIDA -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span> 

                <input type="number" min="0" class="form-control input-lg" name="mdespuess" placeholder="Ingresar Minutos Despues de la Salida" required>

              </div>

            </div>
            
          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar Horario</button>

        </div>

      </form>

        <?php
        $objHorarios = new ControladorHorarios();
        $objHorarios->ctrCrearHorario();
        ?>  

    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR HORARIO
======================================-->

<div id="modalEditarHorario" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar Horario</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">


        <!--  ENTRADA PARA SELECCIONAR NIVEL -->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <select class="form-control input-lg" name="editnuevoNivel" required>
                  
                  <option id="editnuevoNivel"></option>
                  
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

            <!-- ENTRADA PARA LA DENOMINACION -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span> 

                <input type="text" class="form-control input-lg" id="editdenominacion" name="editdenominacion" value="" placeholder="Ingresar Denominacion" required>
                <input type="hidden" class="form-control input-lg" id="idhorario" name="idhorario" value="" required>

              </div>

            </div>
            
            <!-- ENTRADA PARA HORA DE INGRESO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span> 

                <input type="time" class="form-control input-lg" id="edithoraIngreso" name="edithoraIngreso" value="" required>

              </div>

            </div>
            
            <!-- ENTRADA PARA LOS MINUTOS ANTES DEL INGRESO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span> 

                <input type="number" min="0" class="form-control input-lg" id="editmantesi" name="editmantesi" placeholder="Ingresar Minutos Antes del Ingreso"  value="" required>

              </div>

            </div>
            
            <!-- ENTRADA PARA MINUTOS DE TOLERANCIA AL INGRESO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span> 

                <input type="number" min="0" class="form-control input-lg" placeholder="Ingresar Minutos Tolerancia del Ingreso" id="editmtoleranciai" name="editmtoleranciai" value="" required>

              </div>

            </div>
            
            <!-- ENTRADA MINUTOS DESPUES DEL INGRESO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span> 

                <input type="number" min="0" class="form-control input-lg" placeholder="Ingresar Minutos Despues del Ingreso" id="editmdespuesi" name="editmdespuesi" value="" required>

              </div>

            </div>
            
            <!-- ENTRADA PARA LA HORA DE SALIDA -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span> 

                <input type="time" class="form-control input-lg" id="edithoraSalida" name="edithoraSalida" value="" required>

              </div>

            </div>
            
            <!-- ENTRADA PARA LOS MINUTOS ANTES DE LA SALIDA -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span> 

                <input type="number" min="0" class="form-control input-lg" id="editmantess" name="editmantess" placeholder="Ingresar Minutos Antes de la Salida" value="" required>

              </div>

            </div>
            
            <!-- ENTRADA PARA MINUTOS DE TOLERANCIA A LA SALIDA -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span> 

                <input type="number" min="0" class="form-control input-lg" id="editmtolerancias" name="editmtolerancias" placeholder="Ingresar Minutos Tolerancia de la Salida" value="" required>

              </div>

            </div>
            
            <!-- ENTRADA MINUTOS DESPUES DE LA SALIDA -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span> 

                <input type="number" min="0" class="form-control input-lg" id="editmdespuess" name="editmdespuess" name="mdespuess" placeholder="Ingresar Minutos Despues de la Salida"  value="" required>

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

          $editarHorario = new ControladorHorarios();
          $editarHorario -> ctrEditarHorario();

        ?>     

    </div>

  </div>

</div>

<?php
  $eliminarHorario = new ControladorHorarios();
  $eliminarHorario -> ctrEliminarHorario();
?>      



