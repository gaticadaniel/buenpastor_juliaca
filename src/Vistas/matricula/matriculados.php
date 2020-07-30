<div name="menu">
	<ul class="nav nav-tabs nav-justified">
		<li class='active'><a href=''>Lista de Alumnos Matriculados</a></li>
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
				<select class="form-control select2" style="width: 100%;" name="periodo_id" id="periodo_id" onchange="this.form.submit()">
					<option value="" disabled="true" <?php if(!isset($_SESSION['p5periodo_id'])) echo "selected='true'"; ?> >Elija un periodo</option>
<?php
					if( isset($_SESSION['p5periodos']) ){
						$p5periodos=$_SESSION['p5periodos'];
						for ($i=0; $i < count($p5periodos); $i++) { 
							$value="";
							if(isset($_SESSION['p5periodo_id'])) {
								if($_SESSION['p5periodo_id']==$p5periodos[$i]['id']) {
									$value="selected='true'";
								}
							}
							echo "<option value='".$p5periodos[$i]['id']."' ".$value.">".$p5periodos[$i]['periodo']."</option>";
						}
					}
?>
				</select>
				<input type='hidden' name='control' id='control' value='ElegirGrupoP5'>
			</form>
		</div>
		<div class="col-md-6">
			<label>Grupo</label>

			<form action='../Controladores/MatriculaControl.php' method="POST" name="form_grupo" id="form_grupo" class="form-inline" role="form" >
				<select class="form-control select2" style="width: 100%;"  name="grupo_id" id="grupo_id" onchange="this.form.submit()">
					<option value="" disabled="true" selected="true">Elija un grupo</option>
<?php
					if( isset($_SESSION['p5grupos']) ){
						$p5grupos=$_SESSION['p5grupos'];
						for ($i=0; $i < count($p5grupos); $i++) { 
							$value="";
							if(isset($_SESSION['p5grupo_id'])) {
								if($_SESSION['p5grupo_id']==$p5grupos[$i]['id']) {
									$value="selected='true'";
								}
							}
							echo "<option value='".$p5grupos[$i]['id']."' ".$value.">".$p5grupos[$i]['nivel']." - ".$p5grupos[$i]['grado']." - ".$p5grupos[$i]['seccion']."</option>";
						}
					}
?>
				</select>
				<input type='hidden' name='control' id='control' value='ListarAlumnosP5'>
			</form>
		</div>
	</div>

<div class="table-responsive">
<?php
	if(isset($_SESSION['p5alumnos'])){
		$resultado = $_SESSION['p5alumnos'];
	
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