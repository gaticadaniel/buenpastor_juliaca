<div name="menu">
	<ul class="nav nav-tabs nav-justified">
		<li><a href='#' onclick='javascript:document.form_alumno.submit()'>Alumno <?php if(isset($_SESSION['alumnoMatri'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_padre.submit()'>Padre <?php if(isset($_SESSION['padreMatri'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_madre.submit()'>Madre <?php if(isset($_SESSION['madreMatri'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_apoderado.submit()'>Apoderado <?php if(isset($_SESSION['apoderadoMatri'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_periodo.submit()'>Periodo <?php if(isset($_SESSION['periodoMatri'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li class='active'><a href='#' onclick='javascript:document.form_grupo.submit()'>Grupo <?php if(isset($_SESSION['grupoMatri'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_finalizar.submit()'>Finalizar</a></li>
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

if( isset($_SESSION['grupoMatri']) ){
	print_r($_SESSION['grupoMatri']);
}

?>

<form method='POST' name='form_periodo' id='form_periodo' action='../Controladores/MatriculaControl.php' onsubmit="return validate()">

<?php
	if(isset($_SESSION['gruposMatricula'])){
		$array = $_SESSION['gruposMatricula'];
		
		echo "<h3>Grupos activos: <small>".count($array)." encontrado(s)</small></h3>";
		if (count($array) > 0) {
			$COLUMNAS = 5;
			$i=0;
	
			echo "<table class='table table-hover'>";
			echo "<tr>";
			foreach ($array as $key => $value) {
				foreach ($value as $titulo => $contenido) {
					if ($i < $COLUMNAS) echo "<td><strong>".$titulo."</strong></td>";
					else break;
					$i++;
				}
				break;
			}
			echo "<td><strong>Seleccionar</strong></td>";
			echo "</tr>";
	
			foreach ($array as $key => $value) {
				$i=0;
				echo "<tr>";
				foreach ($value as $titulo => $contenido) {
					if ($titulo=='id') $grupo_id = $contenido;
					if ($i < $COLUMNAS) echo "<td>".$contenido."</td>";
					else break;
					$i++;
				}
				if( isset($_SESSION['grupoMatri']) ){
					if($_SESSION['grupoMatri']['id']==$grupo_id){
						echo "<td><label><input type='radio' name='grupo_id' value='".$grupo_id."' checked></label></td>";
					} else {
						echo "<td><label><input type='radio' name='grupo_id' value='".$grupo_id."'></label></td>";
					}
				} else {
					echo "<td><label><input type='radio' name='grupo_id' value='".$grupo_id."'></label></td>";
				}
				echo "</tr>";
			}
	
			echo "</table>";
		}	
	}
?>
	<input type='hidden' name='control' id='control' value='ConfirmarGrupo'>
	<button type="submit" class="btn btn-default" <?php if(!isset($_SESSION['periodoMatri'])) echo "disabled='true'"?> >Confirmar</button>
</form>


	
<script type="text/javascript">

function validate() {
	var a = 0, rdbtn=document.getElementsByName("grupo_id")
	for(i=0;i<rdbtn.length;i++) {
		if(rdbtn.item(i).checked == false) {
			a++;
		}
	}
	if(a == rdbtn.length) {
		alert("Por favor, seleccione un grupo");
//		document.getElementById("pais").style.border = "2px solid red";
		return false;
	} else {
//		document.getElementById("pais").style.border = "";
	}
}
</script>
