<div name="menu">
	<ul class="nav nav-tabs nav-justified">
		<li class='active'><a href='#' >REGISTRO DE INGRESO</a></li>
	</ul>
	
</div>

<?php 
date_default_timezone_set('America/Lima');
setlocale(LC_TIME, "Spanish");		

$hora=strftime("%H:%M");
$hoy=strftime("%Y-%m-%d");

//$stands_pendientes = $_SESSION['stands_pendientes'];
//print_r($hora);
if(isset($_SESSION['asistencia']) AND isset($_SESSION['acumulado']) ){
	$asistencia = $_SESSION['asistencia'];
	$acumulado = $_SESSION['acumulado'];
//	print_r($acumulado);
}

?>

<div class="container">

	<form class="form-inline" action="../../src/Controladores/AsistenciaControl.php" method="post" onsubmit="return validacion()" name="buscar" >
		<div class="form-group">
			<h3>Ingrese Código <small> 
			<input type="text" class="form-control" name="dni" id="dni" placeholder="DNI" required/>

			<div class="radio">
				<label>
					<input type="radio" name="agenda" id="opciones_1" value="1" checked>
						Con Agenda
				</label>
			</div>
			<div class="radio">
				<label>
					<input type="radio" name="agenda" id="opciones_2" value="0">
					Sin agenda
				</label>
			</div>

			<input type="hidden" name="fecha" id="fecha" value="<?=$hoy?>" >
			<input type="hidden" name="hora" id="hora" value="<?=$hora?>" >
			<input type="hidden" name="tipo" id="tipo" value="INGRESO" >
				
			<input type="hidden" name="control" id="control" value="Ingreso" >
			<button type="submit" class="btn btn-default">Buscar</button>
			</small> 
			</h3>
		</div>
	</form>
	
<?php 
	if(isset($_SESSION['asistencia']) AND isset($_SESSION['acumulado']) ){
		$asistencia = $_SESSION['asistencia'];
		$acumulado = $_SESSION['acumulado'];
		if ($asistencia[0]['diferencia_ingreso']>0)
			$estado="PUNTUAL";
		else
			$estado="TARDE";
?>

	<table class="table">
		<tr>
			<td rowspan="2">
				<div class="thumbnail">
					<img src="../../imagenes/fotos/general_2.jpg" alt="...">
				</div>
			</td>
			<td colspan="4">
				<h2><?=$asistencia[0]['hora_ingreso_real']." - ".$estado ?> <small>&nbsp;&nbsp;Fecha: <?=$asistencia[0]['fecha']?>&nbsp;&nbsp;Horario: <?=$asistencia[0]['denominacion']?> &nbsp;&nbsp;Ingreso: <?=$asistencia[0]['hora_ingreso']?> &nbsp;&nbsp;Tolerancia: <?=$asistencia[0]['minutos_de_tolerancia']."'"?> </small></h2>
			</td>
		</tr>
		<tr>
			<td>
				<div class="panel panel-primary">
					<div class="panel-heading">DATOS PERSONALES</div>
					<div class="panel-body">
							<h3><?=$asistencia[0]['dni'] ?></h3>
							<p><?=$asistencia[0]['apellido_paterno']." ".$asistencia[0]['apellido_materno'] ?></p>
							<p><?=$asistencia[0]['nombres'] ?></p>
							<p><?=$asistencia[0]['comentario'] ?></p>
					</div>
				</div>
			</td>
			<td>
				<div class="panel panel-primary">
					<div class="panel-heading">FALTAS</div>
					<div class="panel-body">
							<h3>Acumuladas: <?=$acumulado['faltas_acumuladas'] ?></h3>
							<p>Justificadas: <?=$acumulado['faltas_justificadas'] ?></p>
							<p>Injustificadas: <?=$acumulado['faltas_injustificadas'] ?></p>
							<p>&nbsp;</p>
					</div>
				</div>
			</td>
			<td>
				<div class="panel panel-primary">
					<div class="panel-heading">TARDANZAS</div>
					<div class="panel-body">
							<h3>Acumuladas: <?=$acumulado['tardanzas_acumuladas'] ?></h3>
							<p>Justificadas: <?=$acumulado['tardanzas_justificadas'] ?></p>
							<p>Injustificadas: <?=$acumulado['tardanzas_injustificadas'] ?></p>
							<p>Minutos Perdidos: <?=-1*$acumulado['minutos_perdidos'] ?></p>
					</div>
				</div>
			</td>
			<td>
				<div class="panel panel-primary">
					<div class="panel-heading">USO DE LA AGENDA</div>
					<div class="panel-body">
							<h3>Registros: <?=$acumulado['asistencias_acumuladas'] ?></h3>
							<p>Sin Agenda: <?=$acumulado['sin_agenda'] ?></p>
							<p>Con Agenda: <?=$acumulado['con_agenda'] ?></p>
							<p>&nbsp;</p>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<table width="100%" class="table table-striped table-bordered">
				<tr class="warning">
					
<?php 		for ($i=0; $i < count($acumulado['deudas_pendientes']); $i++) { 
				if($asistencia[0]['fecha'] > $acumulado['deudas_pendientes'][$i]['fecha_vencimiento']) 
					$icono="<span class='glyphicon glyphicon-remove'></span>";
				else 
					$icono="<span class='glyphicon glyphicon-remove-circle'></span>";
?>
					<td align="center">
						<?=$icono ?>
						<br />
						<?=$acumulado['deudas_pendientes'][$i]['detalle'] ?>
					</td>
<?php 		}	?>
				</tr>
			</table>
		</tr>
	</table>

<?php 
	}
?>


</div>

<script type="text/javascript">
	function validacion() { 
	  var dni=document.getElementById("dni").value;
	  if (!(/^\d{8}$/.test(dni))) { 
	    alert('DNI no válido');
	    document.getElementById("dni").focus();
	    return false; 
	  } else {
	  	return true;
	  }
	}
	
	window.onload=function(){
		document.buscar.dni.focus()
	}
</script>