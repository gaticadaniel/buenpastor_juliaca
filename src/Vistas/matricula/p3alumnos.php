<div name="menu">
	<ul class="nav nav-tabs nav-justified">
		<li class='active'><a href='#' onclick='javascript:document.form_alumnos.submit()'>Lista de Alumnos<?php if(isset($_SESSION['p3llave'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_pagos.submit()'>Condiciones Económicas <?php if(isset($_SESSION['p3pagosConfirmados'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_compromiso.submit()'>Compromiso de Pago<?php if(isset($_SESSION['p3firmantes'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_finalizar.submit()'>Finalizar</a></li>
	</ul>
	
	
	<form method='POST' name='form_alumnos' id='form_alumnos' action='../Controladores/MatriculaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='p3alumnos.php'>
	</form>
	<form method='POST' name='form_pagos' id='form_Pagos' action='../Controladores/MatriculaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='p3pagos.php'>
	</form>
	<form method='POST' name='form_compromiso' id='form_compromiso' action='../Controladores/MatriculaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='p3compromiso.php'>
	</form>
	<form method='POST' name='form_finalizar' id='form_finalizar' action='../Controladores/MatriculaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='p3finalizar.php'>
	</form>
</div>
</br>
<?php 
//print_r($_SESSION['p3grupo_id']);
//print_r($_SESSION['p3periodos']);
?>

<table>
	<tr>
		<td>
			<form action='../Controladores/MatriculaControl.php' method="POST" name="form_periodo" id="form_periodo" class="form-inline" role="form" >
				<label>Periodo</label>
				<select class="form-control" name="periodo_id" id="periodo_id" onchange="this.form.submit()">
					<option value="" disabled="true" <?php if(!isset($_SESSION['p3periodo_id'])) echo "selected='true'"; ?> >Elija un periodo</option>
<?php
					if( isset($_SESSION['p3periodos']) ){
						$p3periodos=$_SESSION['p3periodos'];
						for ($i=0; $i < count($p3periodos); $i++) { 
							$value="";
							if(isset($_SESSION['p3periodo_id'])) {
								if($_SESSION['p3periodo_id']==$p3periodos[$i]['id']) {
									$value="selected='true'";
								}
							}
							echo "<option value='".$p3periodos[$i]['id']."' ".$value.">".$p3periodos[$i]['periodo']."</option>";
						}
					}
?>
				</select>
				<input type='hidden' name='control' id='control' value='ElegirGrupoP3'>
			</form>
		</td>
		<td>
			<form action='../Controladores/MatriculaControl.php' method="POST" name="form_grupo" id="form_grupo" class="form-inline" role="form" >
				<label>Grupo</label>
				<select class="form-control" name="grupo_id" id="grupo_id" onchange="this.form.submit()">
					<option value="" disabled="true" selected="true">Elija un grupo</option>
<?php
					if( isset($_SESSION['p3grupos']) ){
						$p3grupos=$_SESSION['p3grupos'];
						for ($i=0; $i < count($p3grupos); $i++) { 
							$value="";
							if(isset($_SESSION['p3grupo_id'])) {
								if($_SESSION['p3grupo_id']==$p3grupos[$i]['id']) {
									$value="selected='true'";
								}
							}
							echo "<option value='".$p3grupos[$i]['id']."' ".$value.">".$p3grupos[$i]['nivel']." - ".$p3grupos[$i]['grado']." - ".$p3grupos[$i]['seccion']."</option>";
						}
					}
?>
				</select>
				<input type='hidden' name='control' id='control' value='ListarAlumnosP3'>
			</form>
		</td>
	</tr>
</table>

<div class="table-responsive">
<?php
	if(isset($_SESSION['p3alumnos'])){
		$resultado = $_SESSION['p3alumnos'];
	
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
							echo "<td><a href='#' onclick='javascript:document.elegir".$i.".submit()'>Pagos</a>";
								echo "<form method='POST' name='elegir".$i."' id='elegir".$i."' action='../Controladores/MatriculaControl.php'>";
								echo "<input type='hidden' name='llave' id='llave' value='".$i."'>";
								echo "<input type='hidden' name='control' id='control' value='PagosP3'>";
								echo "</form> ";
							echo "</td>";
							echo "</tr>";
						}
				echo "</tbody>";
			echo "</table>";
		} else {
			echo "<h3>Resultados: <small>".count($resultado)." filas encontradas</small></h3>";
		}
	}	?>
</div>