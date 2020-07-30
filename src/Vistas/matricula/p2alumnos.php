<div name="menu">
	<ul class="nav nav-tabs nav-justified">
		<li class='active'><a href='#' onclick='javascript:document.form_p2alumnos.submit()'>Lista de Alumnos<?php if(isset($_SESSION['p2llave'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_p2compromiso.submit()'>Compromiso <?php if(isset($_SESSION['p2firmantes'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_p2finalizar.submit()'>Finalizar</a></li>
	</ul>
	
	
	<form method='POST' name='form_p2alumnos' id='form_p2alumnos' action='../Controladores/MatriculaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='p2alumnos.php'>
	</form>
	<form method='POST' name='form_p2compromiso' id='form_p2compromiso' action='../Controladores/MatriculaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='p2compromiso.php'>
	</form>
	<form method='POST' name='form_p2finalizar' id='form_p2finalizar' action='../Controladores/MatriculaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='p2finalizar.php'>
	</form>
</div>
</br>
<?php 

?>
<div class="row">   
        <div class="col-md-6">
			<label>Periodo</label>

			<form action='../Controladores/MatriculaControl.php' method="POST" name="form_periodo" id="form_periodo" class="form-inline" role="form" >
				<select class="form-control select2" style="width: 100%;"  name="periodo_id" id="periodo_id" onchange="this.form.submit()">
					<option value="" disabled="true" <?php if(!isset($_SESSION['p2periodo_id'])) echo "selected='true'"; ?> >Elija un periodo</option>
<?php
					if( isset($_SESSION['p2periodos']) ){
						$p2periodos=$_SESSION['p2periodos'];
						for ($i=0; $i < count($p2periodos); $i++) {
							$value=""; 
							if(isset($_SESSION['p2periodo_id'])) {
								
								if($_SESSION['p2periodo_id']==$p2periodos[$i]['id']) {
									$value="selected='true'";
								}
							}
							echo "<option value='".$p2periodos[$i]['id']."' ".$value.">".$p2periodos[$i]['periodo']."</option>";
						}
					}
?>
				</select>
				<input type='hidden' name='control' id='control' value='ElegirGrupo'>
			</form>
		</div>
        <div class="col-md-6">
			<label>Grupo</label>

			<form action='../Controladores/MatriculaControl.php' method="POST" name="form_grupo" id="form_grupo" class="form-inline" role="form" >
				<select class="form-control select2" style="width: 100%;"  name="grupo_id" id="grupo_id" onchange="this.form.submit()">
					<option value="" disabled="true" selected="true">Elija un grupo</option>
<?php
					if( isset($_SESSION['p2grupos']) ){
						$p2grupos=$_SESSION['p2grupos'];
						for ($i=0; $i < count($p2grupos); $i++) { 
							$value="";
							if(isset($_SESSION['p2grupo_id'])) {
								if($_SESSION['p2grupo_id']==$p2grupos[$i]['id']) {
									$value="selected='true'";
								}
							}
							echo "<option value='".$p2grupos[$i]['id']."' ".$value.">".$p2grupos[$i]['nivel']." - ".$p2grupos[$i]['grado']." - ".$p2grupos[$i]['seccion']."</option>";
						}
					}
?>
				</select>
				<input type='hidden' name='control' id='control' value='ListarAlumnosP2'>
			</form>
		</div>
</div>

<div class="table-responsive">
<?php
	if(isset($_SESSION['p2alumnos'])){
		$resultado = $_SESSION['p2alumnos'];
	
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
							echo "<td><a href='#' onclick='javascript:document.elegir".$i.".submit()'>Compromiso</a>";
								echo "<form method='POST' name='elegir".$i."' id='elegir".$i."' action='../Controladores/MatriculaControl.php'>";
								echo "<input type='hidden' name='llave' id='llave' value='".$i."'>";
								echo "<input type='hidden' name='control' id='control' value='CompromisoP2'>";
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