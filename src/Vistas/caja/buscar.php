<div name="menu">
	<ul class="nav nav-tabs nav-justified">
		<li><a href='#' onclick='javascript:document.form_fecha.submit()'>Definir Fecha<?php if(isset($_SESSION['p3fecha'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li class='active'><a href='#' onclick='javascript:document.form_alumnos.submit()'>Seleccionar Estudiante<?php if(isset($_SESSION['llave'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_estado_cuenta.submit()'>Estado de Cuenta<?php if(isset($_SESSION['boleta'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_emitir_boleta.submit()'>Emitir Comprobante</a></li>
	</ul>
	
	<form method='POST' name='form_fecha' id='form_fecha' action='../Controladores/CajaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='fecha.php'>
	</form>
	<form method='POST' name='form_alumnos' id='form_alumnos' action='../Controladores/CajaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='buscar.php'>
	</form>
	<form method='POST' name='form_estado_cuenta' id='form_estado_cuenta' action='../Controladores/CajaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='estado_de_cuenta.php'>
	</form>
	<form method='POST' name='form_emitir_boleta' id='form_emitir_boleta' action='../Controladores/CajaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='emitir_boleta.php'>
	</form>
</div>
</br>
<?php 
//echo "aqui";
//print_r($_SESSION['alumnosCaja']);
//print_r($_SESSION['p3periodos']);
?>

<div class="container">

	<form class="form-inline" role="form">
		<h3>Buscar Alumno
			<small> 
				<div class="radio">
				  <label>
				    <input type="radio" name="radio" value="dni" onclick="elegir()" <?php if($_SESSION['condicion']=="por_dni") echo "checked"; ?> > Por DNI
				  </label>
				</div>	
				<div class="radio">
				  <label>
				    <input type="radio" name="radio" value="apellidos" onclick="elegir()" <?php if($_SESSION['condicion']=="por_nombre") echo "checked"; ?> > Por Apellidos y Nombres
				  </label>
				</div>
				<div class="radio">
				  <label>
				    <input type="radio" name="radio" value="periodo" onclick="elegir()" <?php if($_SESSION['condicion']=="por_periodo") echo "checked"; ?> > Por Periodo y Grupo
				  </label>
				</div>
			</small>
		</h3>
	</form>
	</br>
	
	<script type="text/javascript">
	function elegir(){
		var resultado="ninguno";
		var porNombre=document.getElementsByName("radio");
			for(var i=0;i<porNombre.length;i++){
				if(porNombre[i].checked) resultado=porNombre[i].value;
			}
			if(resultado=='apellidos'){
				document.getElementById('por apellidos').style.display = 'block';
				document.getElementById('por dni').style.display = 'none';
				document.getElementById('por periodos').style.display = 'none';
			} 
			if(resultado=='dni'){
				document.getElementById('por apellidos').style.display = 'none';
				document.getElementById('por dni').style.display = 'block';
				document.getElementById('por periodos').style.display = 'none';
			}
			if(resultado=='periodo'){
				document.getElementById('por apellidos').style.display = 'none';
				document.getElementById('por dni').style.display = 'none';
				document.getElementById('por periodos').style.display = 'block';
			}
	}
	</script>

	<div id="por apellidos" <?php if($_SESSION['condicion']!="por_nombre") echo "style='display:none;'"; ?> >
		<form method="POST" class="form-inline" name="por_nombre" id="por_nombre" action="../../src/Controladores/CajaControl.php">
		  <div class="form-group">
		    <input type="text" class="form-control" name="apellido_paterno" id="apellido_paterno" placeholder="Apellido Paterno">
		  </div>
		  <div class="form-group">
		    <input type="text" class="form-control" name="apellido_materno" id="apellido_materno" placeholder="Apellido Materno">
		  </div>
		  <div class="form-group">
		    <input type="text" class="form-control" name="nombres" id="nombres" placeholder="Nombres">
		  </div>
		  <input type="hidden" name="control" id="control" value="Emitir" >
		  <input type="hidden" name="condicion" id="condicion" value="por_nombres" >
		  <button type="submit" class="btn btn-default">Buscar</button>
		</form>
	</div>
	
	<div id="por dni" <?php if($_SESSION['condicion']!="por_dni") echo "style='display:none;'"; ?> >
		<form method="POST" class="form-inline" name="por_dni" id="por_dni" action="../../src/Controladores/CajaControl.php">
		  <div class="form-group">
		    <input type="text" class="form-control" name="dni" id="dni" minlength="8" placeholder="DNI" required/>	
		  </div>
		  <input type="hidden" name="control" id="control" value="Emitir" >
		  <input type="hidden" name="condicion" id="condicion" value="por_dni" >
		  <button type="submit" class="btn btn-default">Buscar</button>
		</form>
	</div>

	<div id="por periodos" <?php if($_SESSION['condicion']!="por_periodo") echo "style='display:none;'"; ?> >
		<table>
			<tr>
				<td>
				<label>Periodo</label>
					<form action='../Controladores/CajaControl.php' method="POST" name="form_periodo" id="form_periodo" class="form-inline" role="form" >
						
						<select class="form-control select2" style="width: 100%;" name="periodo_id" id="periodo_id" onchange="this.form.submit()">
							<option value="" disabled="true" <?php if(!isset($_SESSION['periodo_id'])) echo "selected='true'"; ?> >Elija un periodo</option>
		<?php
							if( isset($_SESSION['periodos']) ){
								$periodos=$_SESSION['periodos'];
								for ($i=0; $i < count($periodos); $i++) { 
									if(isset($_SESSION['periodo_id'])) {
										$value="";
										if($_SESSION['periodo_id']==$periodos[$i]['id']) {
											$value="selected='true'";
										}
									}
									echo "<option value='".$periodos[$i]['id']."' ".$value.">".$periodos[$i]['periodo']."</option>";
								}
							}
		?>
						</select>
						<input type='hidden' name='control' id='control' value='Emitir'>
						<input type='hidden' name='condicion' id='condicion' value='por_periodo'>
					</form>
				</td>
				<td>
				<label>Grupo</label>
					<form action='../Controladores/CajaControl.php' method="POST" name="form_grupo" id="form_grupo" class="form-inline" role="form" >
						<select class="form-control select2" style="width: 100%;" name="grupo_id" id="grupo_id" onchange="this.form.submit()">
							<option value="" disabled="true" selected="true">Elija un grupo</option>
		<?php
							if( isset($_SESSION['grupos']) ){
								$grupos=$_SESSION['grupos'];
								for ($i=0; $i < count($grupos); $i++) { 
									if(isset($_SESSION['grupo_id'])) {
										$value="";
										if($_SESSION['grupo_id']==$grupos[$i]['id']) {
											$value="selected='true'";
										}
									}
									echo "<option value='".$grupos[$i]['id']."' ".$value.">".$grupos[$i]['nivel']." - ".$grupos[$i]['grado']." - ".$grupos[$i]['seccion']."</option>";
								}
							}
		?>
						</select>
						<input type='hidden' name='control' id='control' value='Emitir'>
						<input type='hidden' name='condicion' id='condicion' value='por_grupo'>
					</form>
				</td>
			</tr>
		</table>
	</div>


	<div class="table-responsive">
	<?php
		if(isset($_SESSION['alumnosCaja'])){
			$resultado = $_SESSION['alumnosCaja'];

			if(count($resultado)>0){		?>
				<h3>Resultados: <small><?=count($resultado)?> fila(s) encontrada(s). IMPORTANTE: La lista mostrada no tiene relación con los pasos de matrícula.</small></h3>
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
								echo "<td><a href='#' onclick='javascript:document.elegir".$i.".submit()'>Seleccionar</a>";
									echo "<form method='POST' name='elegir".$i."' id='elegir".$i."' action='../Controladores/CajaControl.php'>";
									echo "<input type='hidden' name='llave' id='llave' value='".$i."'>";
									echo "<input type='hidden' name='control' id='control' value='EstadoDeCuenta'>";
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

</div>