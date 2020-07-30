<div name="menu">
	<ul class="nav nav-tabs nav-justified">
		<li class='active'><a href=''>REPORTE DE ASISTENCIA GRUPAL</a></li>
	</ul>
</div>
</br>
<?php 
print_r("xx");
//print_r($_SESSION['rg_alumnos']);
print_r("oo");
?>

<table>
	<tr>
		<td>
            <label>Periodo</label>
			<form action='../Controladores/AsistenciaControl.php' method="POST" name="form_rg" id="form_rg" class="form-inline" role="form" >
				<select class="form-control" name="periodo_id" id="periodo_id" onchange="this.form.submit()">
					<option value="" disabled="true" <?php if(!isset($_SESSION['rg_periodo_id'])) echo "selected='true'"; ?> >Elija un periodo</option>
<?php
					if( isset($_SESSION['rg_periodos']) ){
						$rg_periodos=$_SESSION['rg_periodos'];
						for ($i=0; $i < count($rg_periodos); $i++) { 
							$value="";
							if(isset($_SESSION['rg_periodo_id'])) {
								if($_SESSION['rg_periodo_id']==$rg_periodos[$i]['id']) {
									$value="selected='true'";
								}
							}
							echo "<option value='".$rg_periodos[$i]['id']."' ".$value.">".$rg_periodos[$i]['periodo']."</option>";
						}
					}
?>
				</select>
				<input type='hidden' name='control' id='control' value='Reporte_grupal'>
				<input type='hidden' name='subcontrol' id='subcontrol' value='RG_ElegirGrupo'>
			</form>
		</td>
		<td>
		    <label>Grupo</label>
			<form action='../Controladores/AsistenciaControl.php' method="POST" name="form_grupo" id="form_grupo" class="form-inline" role="form" >
				<select class="form-control" name="grupo_id" id="grupo_id" onchange="this.form.submit()">
					<option value="" disabled="true" selected="true">Elija un grupo</option>
<?php
					if( isset($_SESSION['rg_grupos']) ){
						$rg_grupos=$_SESSION['rg_grupos'];
						for ($i=0; $i < count($rg_grupos); $i++) { 
							$value="";
							if(isset($_SESSION['rg_grupo_id'])) {
								if($_SESSION['rg_grupo_id']==$rg_grupos[$i]['id']) {
									$value="selected='true'";
								}
							}
							echo "<option value='".$rg_grupos[$i]['id']."' ".$value.">".$rg_grupos[$i]['nivel']." - ".$rg_grupos[$i]['grado']." - ".$rg_grupos[$i]['seccion']."</option>";
						}
					}
?>
				</select>
				<input type='hidden' name='control' id='control' value='Reporte_grupal'>
				<input type='hidden' name='subcontrol' id='subcontrol' value='RG_ElegirFecha'>
			</form>
		</td>
		<td>
		    <label>Fecha</label>
			<form action='../Controladores/AsistenciaControl.php' method="POST" name="form_fecha" id="form_fecha" class="form-inline" role="form" >
				
				<select class="form-control" name="fecha_id" id="fecha_id" onchange="this.form.submit()">
					<option value="" disabled="true" selected="true">Elija una Fecha</option>
<?php
					if( isset($_SESSION['rg_fechas']) ){
						$rg_fechas=$_SESSION['rg_fechas'];
						for ($i=0; $i < count($rg_fechas); $i++) { 
							$value="";
							if(isset($_SESSION['rg_fecha_id'])) {
								if($_SESSION['rg_fecha_id']==$rg_fechas[$i]['id']) {
									$value="selected='true'";
								}
							}
							echo "<option value='".$rg_fechas[$i]['id']."' ".$value.">".$rg_fechas[$i]['fecha']."</option>";
						}
					}
?>
				</select>
				<input type='hidden' name='control' id='control' value='Reporte_grupal'>
				<input type='hidden' name='subcontrol' id='subcontrol' value='RG_Lista'>
			</form>
		</td>
	</tr>
</table>

<div class="table-responsive">
<?php
	if(isset($_SESSION['rg_alumnos'])){
		$resultado = $_SESSION['rg_alumnos'];
	
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
						<td><strong>SEXO</strong></td>
						<td><strong>OPCIONES</strong></td>
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
							echo "<td>".$resultado[$i]['sexo']."</td>";
							echo "<td></td>";
							echo "</tr>";
						}
				echo "</tbody>";
			echo "</table>";
		} else {
			echo "<h3>Resultados: <small>".count($resultado)." filas encontradas</small></h3>";
		}
	}	?>
</div>