<div name="menu">
	<ul class="nav nav-tabs nav-justified">
		<li class='active'><a href='#' onclick='javascript:document.form_fecha.submit()'>Definir Fecha<?php if(isset($_SESSION['p3fecha'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_alumnos.submit()'>Seleccionar Estudiante<?php if(isset($_SESSION['llave'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
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
$estado = FALSE;
if (isset($_SESSION['comprobantesInternos'])) {
	$estado=TRUE;
}
?>
</br>
</br>



<div class="container" align="center">

	<form class='form-horizontal' method="POST"  name="form_fecha_boleta" id="form_fecha_boleta" action="../Controladores/CajaControl.php" onSubmit="return validando()">

		<div class="form-group">
			<h3>Configuración de Fecha del Sistema</h3>
			<h5>Válido solo para boletas manuales</h5>
		</div>
		</br></br>
		<div class="form-group">
			<label class="col-lg-3 control-label">Fecha Actual</label>
			<div class="col-lg-3">
				<?=" ".$_SESSION['fechaSistema'] ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-lg-3 control-label">Nueva fecha</label>
			<div class="col-lg-3">
				<input type="text" class="form-control" name="fecha_boleta" id="fecha_boleta" placeholder="AAAA-MM-DD" required>
			</div>
		</div>
		<div class="form-group">
			<div class="col-lg-offset-2 col-lg-10">
				<input type="hidden" name="control" id="control" value="FijarFecha" >
				<button type="submit" class="btn btn-default" <?php if(!$estado) echo "disabled='disabled'"?>>Confirmar</button>
			</div>
		</div>

	</form>

	<script language="javascript" type="text/javascript"> 
	
		function validando(){
			fecha = document.getElementById("fecha_boleta").value;
			foco = document.getElementById("fecha_boleta");
			var validformat=/^\d{4}\-\d{2}\-\d{2}$/ //Basic check for format validity
			var returnval=false
			if (!validformat.test(fecha)){
				alert("Formato incorrecto: use YYYY-MM-DD");
				foco.select()
				return false;
			}
			var yearfield=fecha.split("-")[0]
			var monthfield=fecha.split("-")[1]
			var dayfield=fecha.split("-")[2]
			var dayobj = new Date(yearfield, monthfield-1, dayfield)
			if ((dayobj.getMonth()+1!=monthfield)||(dayobj.getDate()!=dayfield)||(dayobj.getFullYear()!=yearfield)){
				alert("La fecha no existe.")
				foco.select()
				return false;
			}
			return true;
		}
	</script>
	
</div>