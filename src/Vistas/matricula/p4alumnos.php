<div name="menu">
	<ul class="nav nav-tabs nav-justified">
		<li class='active'><a href=''>Lista de Alumnos - Pendientes de Pago</a></li>
	</ul>
</div>
</br>
<?php 
//print_r($_SESSION['vista']);
//print_r($_SESSION['p3periodos']);
?>

<div class="row">   
        <div class="col-md-6">
			<label>Periodo</label>
			<form action='../Controladores/MatriculaControl.php' method="POST" name="form_periodo" id="form_periodo" class="form-inline" role="form" >
				<select class="form-control" name="periodo_id" id="periodo_id" onchange="this.form.submit()">
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
				<input type='hidden' name='control' id='control' value='ElegirGrupoP4'>
			</form>
		</div>
		<div class="col-md-6">
			<label>Grupo</label>
			<form action='../Controladores/MatriculaControl.php' method="POST" name="form_grupo" id="form_grupo" class="form-inline" role="form" >
				<select class="form-control" name="grupo_id" id="grupo_id" onchange="this.form.submit()">
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
				<input type='hidden' name='control' id='control' value='ListarAlumnosP4'>
			</form>
		</div>
</div>

<div class="table-responsive">
<?php
	if(isset($_SESSION['p4alumnos'])){
		$resultado = $_SESSION['p4alumnos'];
	
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