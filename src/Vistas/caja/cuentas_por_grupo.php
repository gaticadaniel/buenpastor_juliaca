<div name="menu">
	<ul class="nav nav-tabs nav-justified">
		<li class='active'><a href=''>ESTADO DE CUENTA POR GRUPO</a></li>
	</ul>
</div>
</br>
<?php 
//print_r($_SESSION['vista']);
//print_r($_SESSION['subCuentas']);
?>

<div class="row">
    <div class="col-md-6">
    				<label>Periodo</label>
			<form action='../Controladores/CajaControl.php' method="POST" name="form_periodo" id="form_periodo" class="form-inline" role="form" >
				<select class="form-control select2" style="width: 100%;" name="periodo_id" id="periodo_id" onchange="this.form.submit()">
					<option value="" disabled="true" <?php if(!isset($_SESSION['periodo_id'])) echo "selected='true'"; ?> >Elija un periodo</option>
<?php
					if( isset($_SESSION['periodos']) ){
						$periodos=$_SESSION['periodos'];
						for ($i=0; $i < count($periodos); $i++) { 
							$value="";
							if(isset($_SESSION['periodo_id'])) {
								if($_SESSION['periodo_id']==$periodos[$i]['id']) {
									$value="selected='true'";
								}
							}
							echo "<option value='".$periodos[$i]['id']."' ".$value.">".$periodos[$i]['periodo']."</option>";
						}
					}
?>
				</select>
				<input type='hidden' name='control' id='control' value='Cuentas_por_grupo'>
				<input type='hidden' name='accion' id='accion' value='Grupos'>
			</form>
		</div>
		<div class="col-md-6">
        <label>Grupo</label>
			<form action='../Controladores/CajaControl.php' method="POST" name="form_grupo" id="form_grupo" class="form-inline" role="form" >
				<select class="form-control select2" style="width: 100%;" name="grupo_id" id="grupo_id" onchange="this.form.submit()">
					<option value="" disabled="true" <?php if(!isset($_SESSION['grupo_id'])) echo "selected='true'"; ?> >Elija un grupo</option>
<?php
					if( isset($_SESSION['grupos']) ){
						$grupos=$_SESSION['grupos'];
						for ($i=0; $i < count($grupos); $i++) { 
							$value="";
							if(isset($_SESSION['grupo_id'])) {
								if($_SESSION['grupo_id']==$grupos[$i]['id']) {
									$value="selected='true'";
								}
							}
							echo "<option value='".$grupos[$i]['id']."' ".$value.">".$grupos[$i]['nivel']." - ".$grupos[$i]['grado']." - ".$grupos[$i]['seccion']."</option>";
						}
					}
?>
				</select>
				<input type='hidden' name='control' id='control' value='Cuentas_por_grupo'>
				<input type='hidden' name='accion' id='accion' value='Listado'>
			</form>
    </div>
</div>

<div class="table-responsive">
<?php
	if(isset($_SESSION['alumnos']) AND isset($_SESSION['subCuentas']) ){
		$resultado = $_SESSION['alumnos'];
		$subCuentas = $_SESSION['subCuentas'];
	
		if(count($resultado)>0){		?>
			<h3>Resultados: <small><?=count($resultado)?> fila(s) encontrada(s)</small></h3>
			<table class='table table-hover'>
				<thead>
					<tr>
						<td><strong>#</strong></td>
						<td><strong>APELLIDO PATERNO</strong></td>
						<td><strong>APELLIDO MATERNO</strong></td>
						<td><strong>NOMBRES</strong></td>
						<td><strong>DNI</strong></td>
<?php				for ($i=0; $i < count($subCuentas); $i++) { ?>
						<td><strong><?=$subCuentas[$i]['detalle'] ?></strong></td>
<?php				}	?>

					</tr>
				</thead>
				<tbody>
					<tr>
<?php					for ($i=0; $i < count($resultado) ; $i++) {
							$j=$i+1;
							echo "<td>".$j."</td>"; 
							echo "<td>".$resultado[$i]['apellido_paterno']."</td>";
							echo "<td>".$resultado[$i]['apellido_materno']."</td>";
							echo "<td>".$resultado[$i]['nombres']."</td>";	
							echo "<td>".$resultado[$i]['dni']."</td>";
							
							for ($j=0; $j < count($subCuentas); $j++) { 
								for ($k=0; $k < count($resultado[$i]['deudas']); $k++) { 
									if ($resultado[$i]['deudas'][$k]['subcuenta_id']==$subCuentas[$j]['subcuenta_id']) {
										if($resultado[$i]['deudas'][$k]['activo']==0) {
											echo "<td> <span class='glyphicon glyphicon-minus'></span> </td>";
										}
										if($resultado[$i]['deudas'][$k]['activo']==1) {
											if($resultado[$i]['deudas'][$k]['cancelado']==0){
												echo "<td> <span class='glyphicon glyphicon-remove'></span> </td>";	
											}
											if($resultado[$i]['deudas'][$k]['cancelado']==1){
												echo "<td> <span class='glyphicon glyphicon-ok'></span> </td>";
											}
										}			
									}
								}
							}	

							echo "</tr>";
						}
				echo "</tbody>";
			echo "</table>";
		} else {
			echo "<h3>Resultados: <small>".count($resultado)." filas encontradas</small></h3>";
		}
	}	?>
</div>