<div name="menu">
	<ul class="nav nav-tabs nav-justified">
		<li><a href='#' onclick='javascript:document.form_alumno.submit()'>Alumno <?php if(isset($_SESSION['alumnoMatri'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_padre.submit()'>Padre <?php if(isset($_SESSION['padreMatri'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_madre.submit()'>Madre <?php if(isset($_SESSION['madreMatri'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_apoderado.submit()'>Apoderado <?php if(isset($_SESSION['apoderadoMatri'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_periodo.submit()'>Periodo <?php if(isset($_SESSION['periodoMatri'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_grupo.submit()'>Grupo <?php if(isset($_SESSION['grupoMatri'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li class='active'><a href='#' onclick='javascript:document.form_finalizar.submit()'>Finalizar</a></li>
	</ul>
	
	
	<form method='POST' name='form_alumno' id='form_alumno' action='../Controladores/MatriculaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='alumno.php'>
	</form>
	<form method='POST' name='form_padre' id='form_padre' action='../Controladores/MatriculaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='padre.php'>
	</form>
	<form method='POST' name='form_madre' id='form_madre' action='../Controladores/MatriculaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='madre.php'>
	</form>
	<form method='POST' name='form_apoderado' id='form_apoderado' action='../Controladores/MatriculaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='apoderado.php'>
	</form>
	<form method='POST' name='form_periodo' id='form_periodo' action='../Controladores/MatriculaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='periodo.php'>
	</form>
	<form method='POST' name='form_grupo' id='form_grupo' action='../Controladores/MatriculaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='grupo.php'>
	</form>
	<form method='POST' name='form_finalizar' id='form_finalizar' action='../Controladores/MatriculaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='finalizar.php'>
	</form>
</div>

<?php
// CONFIGURA EL NUMERO DE COLUMNAS A MOSTRAR EN LA PRESENTACION
$COLUMNAS = 5;
$GUARDAR = "SI";
?>

<center>
	<h3>MATRICULA <small></small></h3>
	<h4>FICHA 1<small></small></h4>
</center>

<div class="panel panel-info">
	<div class="panel-heading">PERIODO</div>
	<div class="panel-body">
		<table class="table table-bordered">
<?php
			if( isset($_SESSION['periodoMatri']) ){
//				print_r($_SESSION['periodoMatri']);
				$i=1;
				foreach ($_SESSION['periodoMatri'] as $key => $value) {
					if ($i==1) echo "<tr>";
					if ($key=="id") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="periodo") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="inicia") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="termina") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if (fmod($i, $COLUMNAS)==0) echo "</tr><tr>";
					$i++;
				}
			} else {
				echo "<tr><td><center>NO SE HA DEFINIDO UN PERIODO DE MATRICULA</center></td></tr>";
				$GUARDAR = "NO";
			}
?>
		</table>
	</div>
</div>

<div class="panel panel-info">
  <div class="panel-heading">GRUPO</div>
  <div class="panel-body">
		<table class="table table-bordered">
<?php
			if( isset($_SESSION['grupoMatri']) ){
//				print_r($_SESSION['grupoMatri']);
				$i=1;
				foreach ($_SESSION['grupoMatri'] as $key => $value) {
					if ($i==1) echo "<tr>";
					if ($key=="id") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="nivel") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="grado") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="seccion") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="ambiente") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if (fmod($i, $COLUMNAS)==0) echo "</tr><tr>";
					$i++;
				}
			} else {
				echo "<tr><td><center>NO SE HA DEFINIDO NINGÚN GRUPO</center></td></tr>";
				$GUARDAR = "NO";
			}
?>
		</table>
  </div>
</div>

<div class="panel panel-info">
  <div class="panel-heading">ALUMNO</div>
  <div class="panel-body">
		<table class="table table-bordered">
<?php
			if( isset($_SESSION['alumnoMatri']) ){
//				print_r($_SESSION['alumnoMatri']);
				$i=1;
				foreach ($_SESSION['alumnoMatri'] as $key => $value) {
					if ($i==1) echo "<tr>";
					if ($key=="id") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="dni") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="apellido_paterno") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="apellido_materno") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="nombres") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="sexo") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="role") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="padre") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="madre") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="apoderado") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="estado") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="direccion") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="movistar") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="rpm") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="claro") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="otro") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="fijo") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="fecha_nacimiento") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="comentario") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="created") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="modified") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="username") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="password") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="accion") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if (fmod($i, $COLUMNAS)==0) echo "</tr><tr>";
					$i++;
				}
			} else {
				echo "<tr><td><center>NO SE HA CONFIRMADO LOS DATOS DEL ALUMNO</center></td></tr>";
				$GUARDAR = "NO";
			}
?>
		</table>
  </div>
</div>

<div class="panel panel-info">
	<div class="panel-heading">PADRE</div>
	<div class="panel-body">
		<table class="table table-bordered">
<?php
			if( isset($_SESSION['padreMatri']) ){
//				print_r($_SESSION['alumnoMatri']);
				$i=1;
				foreach ($_SESSION['padreMatri'] as $key => $value) {
					if ($i==1) echo "<tr>";
					if ($key=="id") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="dni") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="apellido_paterno") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="apellido_materno") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="nombres") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="sexo") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="role") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="padre") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="madre") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="apoderado") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="estado") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="direccion") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="movistar") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="rpm") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="claro") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="otro") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="fijo") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="fecha_nacimiento") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="comentario") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="created") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="modified") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="username") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="password") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="accion") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if (fmod($i, $COLUMNAS)==0) echo "</tr><tr>";
					$i++;
				}
			} else {
				echo "<tr><td><center>NO SE HA CONFIRMADO LOS DATOS DEL PADRE</center></td></tr>";
				$GUARDAR = "NO";
			}
?>
		</table>
	</div>
</div>

<div class="panel panel-info">
	<div class="panel-heading">MADRE</div>
	<div class="panel-body">
		<table class="table table-bordered">
<?php
			if( isset($_SESSION['madreMatri']) ){
//				print_r($_SESSION['alumnoMatri']);
				$i=1;
				foreach ($_SESSION['madreMatri'] as $key => $value) {
					if ($i==1) echo "<tr>";
					if ($key=="id") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="dni") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="apellido_paterno") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="apellido_materno") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="nombres") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="sexo") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="role") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="padre") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="madre") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="apoderado") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="estado") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="direccion") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="movistar") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="rpm") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="claro") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="otro") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="fijo") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="fecha_nacimiento") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="comentario") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="created") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="modified") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="username") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="password") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="accion") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if (fmod($i, $COLUMNAS)==0) echo "</tr><tr>";
					$i++;
				}
			} else {
				echo "<tr><td><center>NO SE HA CONFIRMADO LOS DATOS DE LA MADRE</center></td></tr>";
				$GUARDAR = "NO";
			}
?>
		</table>
	</div>
</div>

<div class="panel panel-info">
	<div class="panel-heading">APODERADO</div>
	<div class="panel-body">
		<table class="table table-bordered">
<?php
			if( isset($_SESSION['apoderadoMatri']) ){
//				print_r($_SESSION['alumnoMatri']);
				$i=1;
				foreach ($_SESSION['apoderadoMatri'] as $key => $value) {
					if ($i==1) echo "<tr>";
					if ($key=="id") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="dni") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="apellido_paterno") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="apellido_materno") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="nombres") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="sexo") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="role") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="padre") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="madre") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="apoderado") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="estado") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="direccion") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="movistar") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="rpm") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="claro") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="otro") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="fijo") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="fecha_nacimiento") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="comentario") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="created") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="modified") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="username") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="password") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if ($key=="accion") echo "<td><font style='text-transform: uppercase;'>".$key."</font>: <strong>".$value."</strong></td>";
					if (fmod($i, $COLUMNAS)==0) echo "</tr><tr>";
					$i++;
				}
			} else {
				echo "<tr><td><center>NO SE HA CONFIRMADO LOS DATOS DEL APODERADO</center></td></tr>";
				$GUARDAR = "NO";
			}
?>
		</table>
	</div>
</div>

<?php
// CONFIGURA EL NUMERO DE COLUMNAS A MOSTRAR EN LA PRESENTACION
// echo $GUARDAR;
?>

<form method='POST' name='form_finalizar' id='form_finalizar' action='../Controladores/MatriculaControl.php' >
	<input type='hidden' name='control' id='control' value='Finalizar'>
	<button type="submit" class="btn btn-default" <?php if($GUARDAR=="NO") echo "disabled='true'"?> >Confirmar</button>
</form>
