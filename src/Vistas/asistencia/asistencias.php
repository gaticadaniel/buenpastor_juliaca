<?php
    require_once "../Controladores/GrupoHorarioControl.php";
    require_once "../Controladores/HorarioControl.php";

?>
 
<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar Asistencias
   
    </h1>

    <ol class="breadcrumb">
      
      <li class="active">Administrar Asistencias</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">

        <div class="row">
              
          <div class="col-md-4">
          <!-- Seleccion de periodo en asistencia -->
            <label>Periodo</label>
            <form action='../Controladores/AsistenciaControl.php' method="POST" name="form_periodo" id="form_periodo" class="form-inline" role="form" >
        <select class="form-control select2" style="width: 100%;" name="aperiodoId" id="aperiodoId" onchange="this.form.submit()">
					<option value="" disabled="true" <?php if(!isset($_SESSION['aPeriodo_id'])) echo "selected='true'"; ?> >Elija un periodo</option>
<?php
					if( isset($_SESSION['aPeriodos']) ){
						$p4periodos=$_SESSION['aPeriodos'];
						for ($i=0; $i < count($p4periodos); $i++) { 
							$value="";
							if(isset($_SESSION['aPeriodo_id'])) {
								if($_SESSION['aPeriodo_id']==$p4periodos[$i]['id']) {
									$value="selected='true'";
								}
							}
							echo "<option value='".$p4periodos[$i]['id']."' ".$value.">".$p4periodos[$i]['periodo']."</option>";
						}
					}
?>
				</select>
				<input type='hidden' name='control' id='control' value='ElegirGrupoAsistencia'>
			</form>
            
          </div>
          
          <div class="col-md-4">
          <!-- Seleccion de grupo en asistencia -->
            <label>Grupo</label>
            <form action='../Controladores/AsistenciaControl.php' method="POST" name="form_grupo" id="form_grupo" class="form-inline" role="form" >
            <select class="form-control select2" style="width: 100%;" name="agrupo_id" id="agrupo_id" onchange="this.form.submit()">
				<option value="" disabled="true" selected="true">Elija un grupo</option>
<?php
					if( isset($_SESSION['aGrupos']) ){
						$p4grupos=$_SESSION['aGrupos'];
						for ($i=0; $i < count($p4grupos); $i++) { 
							$value="";
							if(isset($_SESSION['aGrupo_id'])) {
								if($_SESSION['aGrupo_id']==$p4grupos[$i]['id']) {
									$value="selected='true'";
								}
							}
							echo "<option value='".$p4grupos[$i]['id']."' ".$value.">".$p4grupos[$i]['nivel']." - ".$p4grupos[$i]['grado']." - ".$p4grupos[$i]['seccion']."</option>";
						}
					}
?>
				</select>
				<input type='hidden' name='control' id='control' value='ElegirAsistencia'>
			</form>

          </div>
          <div class="col-md-4">
          <!-- Seleccion de condificon en asistencia -->
            <label>Condicion</label>
            <select class="form-control select2" id="condicion" name="condicion" required>
                  
            <option value="0" >Todos</option>
            <option value="1" >Puntual</option>
            <option value="2" >Tarde</option>
            <option value="3" >Falta</option>
  
            </select>

          </div>

        </div>

      </div>

      <div class="box-body">
<!--        <div class="col-md-9">-->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li><a href="#inicial" data-toggle="tab">Inicial</a></li>
              <li><a href="#primaria" data-toggle="tab">Primaria</a></li>
              <li><a href="#secundaria" data-toggle="tab">Secundaria</a></li>
            </ul>
            <div class="tab-content">
             
              <div class="tab-pane" id="inicial">
                
                <table class="table table-bordered table-striped dt-responsive tablas" style="width: 100%;">
         
                <thead>
         
                <tr>
           
                 <th style="width:10px">#</th>
                 <th>Nombre</th>
                 <th>Dni</th>
                 <th>Apoderado</th>
                 <th>Movistar</th>
                 <th>Rpm</th>
                 <th>Claro</th>
                 <th>Otro</th>
                 <th>Fijo</th>
                 <th>Condicion</th>
           
                </tr> 

                </thead>

                <tbody>
                <?php
        if(isset($_SESSION['aGrupo_id']) and isset($_SESSION['aPeriodo_id'])) {
		$objAsistencia = new ControladorGrupoHorario();
        $asistenciaI = $objAsistencia->ctrMostrarAsistencias(1,$_SESSION['aPeriodo_id'],$_SESSION['aGrupo_id']);
            
         foreach ($asistenciaI as $key => $value){
         
          echo ' <tr>
                  <td>'.($key+1).'</td>
                  <td>'.$value["nombreal"].'</td>
                  <td>'.$value["dni"].'</td>             
                  <td>'.$value["nombreap"].'</td> 
                  <td>'.$value["movistar"].'</td> 
                  <td>'.$value["rpm"].'</td> 
                  <td>'.$value["claro"].'</td> 
                  <td>'.$value["otro"].'</td> 
                  <td>'.$value["fijo"].'</td> 
                  <td>'.$value["condicion"].'</td> 
                </tr>';
        }}
        ?> 

                </tbody>

               </table>
                
              </div>
               
               
               
               
              <div class="tab-pane" id="primaria">
               
                <table class="table table-bordered table-striped dt-responsive tablas" style="width: 100%;">
         
                <thead>
         
                <tr>
           
                 <th style="width:10px">#</th>
                 <th>Nombre</th>
                 <th>Dni</th>
                 <th>Apoderado</th>
                 <th>Movistar</th>
                 <th>Rpm</th>
                 <th>Claro</th>
                 <th>Otro</th>
                 <th>Fijo</th>
                 <th>Condicion</th>
           
                </tr> 

                </thead>

                <tbody>
                <?php
        if(isset($_SESSION['aGrupo_id']) and isset($_SESSION['aPeriodo_id'])) {
		$objAsistencia = new ControladorGrupoHorario();
        $asistenciaI = $objAsistencia->ctrMostrarAsistencias(2,$_SESSION['aPeriodo_id'],$_SESSION['aGrupo_id']);
            
         foreach ($asistenciaI as $key => $value){
         
          echo ' <tr>
                  <td>'.($key+1).'</td>
                  <td>'.$value["nombreal"].'</td>
                  <td>'.$value["dni"].'</td>             
                  <td>'.$value["nombreap"].'</td> 
                  <td>'.$value["movistar"].'</td> 
                  <td>'.$value["rpm"].'</td> 
                  <td>'.$value["claro"].'</td> 
                  <td>'.$value["otro"].'</td> 
                  <td>'.$value["fijo"].'</td> 
                  <td>'.$value["condicion"].'</td> 
                </tr>';
        }}
        ?> 

                </tbody>

               </table>
                
              </div>  

             
             
             
              <div class="tab-pane" id="secundaria">
               <table class="table table-bordered table-striped dt-responsive tablas" style="width: 100%;">
         
                <thead>
         
                <tr>
           
                 <th style="width:10px">#</th>
                 <th>Nombre</th>
                 <th>Dni</th>
                 <th>Apoderado</th>
                 <th>Movistar</th>
                 <th>Rpm</th>
                 <th>Claro</th>
                 <th>Otro</th>
                 <th>Fijo</th>
                 <th>Condicion</th>
           
                </tr> 

                </thead>

                <tbody>
                <?php
    if(isset($_SESSION['aGrupo_id']) and isset($_SESSION['aPeriodo_id'])) {
		$objAsistencia = new ControladorGrupoHorario();
        $asistenciaI = $objAsistencia->ctrMostrarAsistencias(3,$_SESSION['aPeriodo_id'],$_SESSION['aGrupo_id']);
            
         foreach ($asistenciaI as $key => $value){
         
          echo ' <tr>
                  <td>'.($key+1).'</td>
                  <td>'.$value["nombreal"].'</td>
                  <td>'.$value["dni"].'</td>             
                  <td>'.$value["nombreap"].'</td> 
                  <td>'.$value["movistar"].'</td> 
                  <td>'.$value["rpm"].'</td> 
                  <td>'.$value["claro"].'</td> 
                  <td>'.$value["otro"].'</td> 
                  <td>'.$value["fijo"].'</td> 
                  <td>'.$value["condicion"].'</td> 
                </tr>';
        } }
        ?> 

                </tbody>

               </table>
             
              </div>
            </div>
          </div>
<!--        </div>-->
      </div>

    </div>

  </section>

</div>

