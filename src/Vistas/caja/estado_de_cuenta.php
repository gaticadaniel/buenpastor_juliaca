<div name="menu">
	<ul class="nav nav-tabs nav-justified">
		<li><a href='#' onclick='javascript:document.form_fecha.submit()'>Definir Fecha<?php if(isset($_SESSION['p3fecha'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_alumnos.submit()'>Seleccionar Estudiante<?php if(isset($_SESSION['llave'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li class='active'><a href='#' onclick=''>Estado de Cuenta<?php if(isset($_SESSION['boleta'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
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
date_default_timezone_set('America/Lima');
setlocale(LC_TIME, "Spanish");		

$hora=strftime("%H:%M:%S");
$estilo = "style='color:#456789;font-size:80%;FONT-FAMILY:Arial,Helvetica,sans-serif'";

if ( isset($_SESSION['alumnosCaja']) and isset($_SESSION['llave']) ){
	$llave = $_SESSION['llave'];
	$alumno = $_SESSION['alumnosCaja'][$llave];
} else $alumno = "NO DEFINIDO";

$registrar_ingresos = FALSE;
//PARA MOSTRAR LAS OPCIONES QUE PERMITAN REGISTRAR COMPROBANTES INTERNOS
if (count($_SESSION['comprobantesInternos'])>=1) {
	$comprobantesInternos=$_SESSION['comprobantesInternos'];
	$registrar_ingresos = TRUE; // la variable antiguo era $emitir_boleta
	
	//PARA EL REGISTRO DE PAGOS VARIOS
	if (isset($_SESSION['registrarPagosVarios'])) $registrarPagosVarios = $_SESSION['registrarPagosVarios'];
	else $registrarPagosVarios = FALSE; 
	
	//PARA EL REGISTRO DE PAGOS PROGRAMADOS
	if (isset($_SESSION['registrarPagoProgramado'])) $registrarPagoProgramado = $_SESSION['registrarPagoProgramado'];
	else $registrarPagoProgramado = FALSE; 	
	
	
} else {
	$registrar_ingresos = FALSE;
	$registrarPagosVarios = FALSE;
	$registrarPagoProgramado = FALSE;
}


//print_r($registrar_ingresos);
$hoy = $_SESSION['fechaSistema']; // FECHA PARA EL CALCULO DE TODAS LAS OPERACIONES
$monto=0; //PARA CONDICIONAR EL ENVIÓ DE BOLETA POR PAGOS VARIOS

?>
<div class="container">

	<ol>
		<li><strong>DATOS DEL ESTUDIANTE</strong></li>
			<ul class="list-unstyled">
				<table class="table table-hover table-condensed">
					<tr>
						<td <?=$estilo?> >APELLIDOS Y NOMBRES</td>
						<td <?=$estilo?> ><?php if ($alumno!="NO DEFINIDO") echo $alumno['apellido_paterno']." ".$alumno['apellido_materno'].", ".$alumno['nombres']; ?></td>
					</tr>
					<tr>
						<td <?=$estilo?> >DNI</td>
						<td <?=$estilo?> ><?php if ($alumno!="NO DEFINIDO") echo $alumno['dni']; ?></td>
					</tr>
					<tr>
						<td <?=$estilo?> >DIRECCIÓN</td>
						<td <?=$estilo?> ><?php if ($alumno!="NO DEFINIDO") echo $alumno['direccion']; ?></td>
					</tr>
					<tr>
						<td <?=$estilo?> >TELÉFONO(S)</td>
						<td <?=$estilo?> ><?php if ($alumno!="NO DEFINIDO") echo $alumno['movistar']."  ".$alumno['rpm']."  ".$alumno['claro']."  ".$alumno['otro']."  ".$alumno['fijo']; ?></td>
					</tr>
				</table>
			</ul>

<?php 	if($registrar_ingresos) {
			$comprobanteInternoTipo2=null;
?>
			<li><strong>PAGOS VARIOS</strong></li>
				<table class="table table-condensed table-striped" >
					<tr>
	
						<td <?=$estilo?> >
							<form action='../Controladores/CajaControl.php' method="POST" name="form_cuenta" id="form_cuenta" class="form-inline" role="form" >
								<label>Cuenta</label>
								<select class="form-control" name="indice_cuenta_libre" id="indice_cuenta_libre" onchange="this.form.submit()">
									<option value="" disabled="true" <?php if(!isset($_SESSION['indice_cuenta_libre'])) echo "selected='true'"; ?> >Seleccione</option>
<?php
									if( isset($_SESSION['cuentasLibres']) ){
										$cuentasLibres=$_SESSION['cuentasLibres'];
										for ($i=0; $i < count($cuentasLibres); $i++) {
											$value=""; 
											if(isset($_SESSION['indice_cuenta_libre'])) {
												if($i==$_SESSION['indice_cuenta_libre']) {
													$value="selected='true'";
												}
											}
											echo "<option value='".$i."' ".$value.">".$cuentasLibres[$i]['cuenta']."</option>";
										}
									}
?>
								</select>
								<input type='hidden' name='accion' id='accion' value='Cuentas'>
								<input type='hidden' name='control' id='control' value='PagosVarios'>
							</form>
						</td>
						<td <?=$estilo?> >
							<form action='../Controladores/CajaControl.php' method="POST" name="form_subcuenta" id="form_subcuenta" class="form-inline" role="form" >
								<label>Sub Cuenta</label>
								<select class="form-control" name="indice_subcuenta_libre" id="indice_subcuenta_libre" onchange="this.form.submit()" <?php if(isset($_SESSION['indice_cuenta_libre'])) echo ""; else echo "disabled='true'"; ?> >
									<option value="" disabled="true" selected="true">Seleccione</option>
<?php
									if( isset($_SESSION['subCuentasLibres']) ){
										$subCuentasLibres=$_SESSION['subCuentasLibres'];
										for ($i=0; $i < count($subCuentasLibres); $i++) {
											$value=""; 
											if(isset($_SESSION['indice_subcuenta_libre'])){
												if($i==$_SESSION['indice_subcuenta_libre']) {
													$value="selected='true'";
													$monto=$subCuentasLibres[$i]['monto'];
												}
											}
											echo "<option value='".$i."' ".$value.">".$subCuentasLibres[$i]['subcuenta']."</option>";
										}
									}
?>
								</select>
								<input type='hidden' name='accion' id='accion' value='subCuenta'>
								<input type='hidden' name='control' id='control' value='PagosVarios'>
							</form>
						</td>
						<td <?=$estilo?> >
							<form action='../Controladores/CajaControl.php' method="POST" name="form_comprobante_ingreso" id="form_comprobante_ingreso" class="form-inline" role="form" >
								<label>Comprobante de Ingreso</label>
								<select class="form-control" name="indice_comprobante_interno" id="indice_comprobante_interno" <?php if(isset($_SESSION['indice_subcuenta_libre'])) echo ""; else echo "disabled='true'";?> onchange="this.form.submit()">
									<option value="" disabled="true" selected="true">Seleccione</option>
<?php
									for ($i=0; $i < count($comprobantesInternos); $i++) {
										$value=""; 
										if(isset($_SESSION['indice_comprobante_interno'])){
											if($i==$_SESSION['indice_comprobante_interno']) {
												$value="selected='true'";
												$comprobanteInternoTipo2=$comprobantesInternos[$i]['tipo2'];
											}
										}
										echo "<option value='".$i."' ".$value.">".$comprobantesInternos[$i]['comprobante']."</option>";
									}
?>
								</select>
								<input type='hidden' name='accion' id='accion' value='comprobante_interno'>
								<input type='hidden' name='control' id='control' value='PagosVarios'>
							</form>
						</td>
<?php			//Si el comprobante interno es fisico
				if ($comprobanteInternoTipo2=="fisico") {
?>
						<td <?=$estilo?> >
							<label>
								<?php if(isset($_SESSION['indice_subcuenta_libre'])) echo "Monto a Pagar: S/. ".$monto.".00"; else echo "Monto a Pagar: NO DEFINIDO"; ?>
							</label>
							<form action='../Controladores/CajaControl.php' method="POST" name="form_rif" id="form_rif" class="form-inline" role="form" >
									<select class="form-control" name="indice_rif" id="indice_rif" onchange="this.form.submit()">
										<option value="" disabled="true" selected="true">Seleccione</option>
<?php
											$rifs = $_SESSION['rifs'];
											for ($i=0; $i < count($rifs); $i++) {
												$value=""; 
												if(isset($_SESSION['indice_rif'])){
													if($i==$_SESSION['indice_rif']) {
														$value="selected='true'";
													}
												}
												echo "<option value='".$i."' ".$value.">".$rifs[$i]['serie']."-".$rifs[$i]['correlativo']."-".$rifs[$i]['fecha']."-".$rifs[$i]['hora']."- S/".$rifs[$i]['saldo']." - ".$rifs[$i]['comentario']."</option>";
											}
?>
									</select>
									<input type='hidden' name='accion' id='accion' value='rif'>
									<input type='hidden' name='control' id='control' value='PagosVarios'>
							</form>
						</td>
						<td <?=$estilo?> >
							<form method="POST" action="../../src/Controladores/CajaControl.php" class="form-inline" role="form" name="form_fisico">
								<label>
									Verifique los datos
								</label>
								<div class="col-xs-9">
									<button name="registrar" id="registrar" type="submit" class="btn btn-primary btn-sm" <?php if($registrarPagosVarios) echo ""; else echo "disabled='true'";?>  > REGISTRAR </button>
									<input type='hidden' name='fecha' id='fecha' value='<?=$hoy ?>'>
									<input type='hidden' name='hora' id='hora' value='<?=$hora ?>'>
									<input type='hidden' name='accion' id='accion' value='rif'>
									<input type='hidden' name='control' id='control' value='RegistrarIngresoLibre'>
								</div>
							</form>
						</td>
<?php		} 				
		
				//Si el comprobante interno es bancarizado
				if ($comprobanteInternoTipo2=="bancarizado") {
?>
						<td <?=$estilo?> >
							<label>
								<?php if(isset($_SESSION['indice_subcuenta_libre'])) echo "Monto a Pagar: S/. ".$monto.".00"; else echo "Monto a Pagar: NO DEFINIDO"; ?>
							</label>
							<form action='../Controladores/CajaControl.php' method="POST" name="form_voucher" id="form_voucher" class="form-inline" role="form" >
									<select class="form-control" name="indice_voucher" id="indice_voucher" onchange="this.form.submit()">
										<option value="" disabled="true" selected="true">Seleccione</option>
<?php
											$vouchers = $_SESSION['vouchers'];
											for ($i=0; $i < count($vouchers); $i++) {
												$value=""; 
												if(isset($_SESSION['indice_voucher'])){
													if($i==$_SESSION['indice_voucher']) {
														$value="selected='true'";
													}
												}
												echo "<option value='".$i."' ".$value.">".$vouchers[$i]['serie']."-".$vouchers[$i]['operacion']."/".$vouchers[$i]['fecha']."/".$vouchers[$i]['hora']."/".$vouchers[$i]['concepto']."/".$vouchers[$i]['depositante']." S/ ".$vouchers[$i]['saldo']."</option>";
											}
?>
									</select>
									<input type='hidden' name='accion' id='accion' value='voucher'>
									<input type='hidden' name='control' id='control' value='PagosVarios'>
							</form>
						</td>
						<td <?=$estilo?> >
							<form method="POST" action="../../src/Controladores/CajaControl.php" class="form-inline" role="form" name="form_bancarizado">
								<label>
									Verifique los datos
								</label>
								<div class="col-xs-9">
									<button name="registrar" id="registrar" type="submit" class="btn btn-primary btn-sm" <?php if($registrarPagosVarios) echo ""; else echo "disabled='true'";?>  > REGISTRAR </button>
									<input type='hidden' name='fecha' id='fecha' value='<?=$hoy ?>'>
									<input type='hidden' name='hora' id='hora' value='<?=$hora ?>'>
									<input type='hidden' name='accion' id='accion' value='voucher'>
									<input type='hidden' name='control' id='control' value='RegistrarIngresoLibre'>
								</div>
							</form>
						</td>
<?php			} 				
				//Si el comprobante interno es electronico
				if ($comprobanteInternoTipo2=="electronico") {
?>
					<form method="POST" action="../../src/Controladores/CajaControl.php" class="form-inline" role="form" onsubmit="return validarOtroPago()" name="boleta">
						<td <?=$estilo?> >
							<label>
								<?php if(isset($_SESSION['indice_subcuenta_libre'])) echo "Monto a Pagar: S/. ".$monto.".00"; else echo "Monto a Pagar: NO DEFINIDO"; ?>
							</label>
							<div class="col-xs-9">
								<input type="number" step="0.01" class="form-control input-sm" name="efectivo_otro_pago" id="efectivo_otro_pago" placeholder="Efectivo" required="true" >
							</div>
						</td>
						<td <?=$estilo?> >
								<label>
									Verifique los datos
								</label>
								<div class="col-xs-9">
									<input type='hidden' name='fecha' id='fecha' value='<?=$hoy ?>'>
									<input type='hidden' name='hora' id='hora' value='<?=$hora ?>'>
									<input type='hidden' name='accion' id='accion' value='rie'>
									<input type='hidden' name='control' id='control' value='RegistrarIngresoLibre'>
									<button type="submit" class="btn btn-primary btn-sm" <?php if($monto == 0) echo "disabled='disabled'";?> >REGISTRAR</button>
								</div>
						</td>
					</form>
<?php			} 				
				//Si todavía no se ha definido un comprobante interno entonces solo imprimimos para completar la pantalla del usuario
				if ($comprobanteInternoTipo2=="") {
?>
						<td <?=$estilo?> >
							<label>
								<?php if(isset($_SESSION['indice_subcuenta_libre'])) echo "Monto a Pagar: S/. ".$monto.".00"; else echo "Monto a Pagar: NO DEFINIDO"; ?>
							</label>
							<div class="col-xs-9">
								<input type="number" class="form-control input-sm" name="niguno" id="ninguno" placeholder="efectivo" disabled='true' >
							</div>
						</td>
						<td <?=$estilo?> >
							<label>
								Verifique los datos
							</label>
							<div class="col-xs-9">
								<button name="registrar" id="registrar" type="submit" class="btn btn-primary btn-sm" disabled='true' > REGISTRAR </button>
							</div>
						</td>
	
<?php			} 				
?>
					</tr>
				</table>
				</br>
	
			<li><strong>PAGOS PROGRAMADOS</strong></li>
				<table class="table table-condensed table-striped" >
					<tr>
<?php 		if(isset($_SESSION['deudas']) ) {
				$deudas = $_SESSION['deudas'];
				$indice_deuda= array_search(0, array_column($deudas, 'cancelado'));
				$fechaVencimiento = $deudas[$indice_deuda]['fecha_vencimiento'];
				
				$vencido = TRUE;
				$descuento = 0;
				
				if ($fechaVencimiento == "") {
					$descuento = $deudas[$indice_deuda]['descuento_pago_oportuno'];
					$vencido = FALSE;
				} else {
					if($hoy > $fechaVencimiento) {
						$descuento = 0;
						$vencido = TRUE; 
					} 
					else {
						$descuento = $deudas[$indice_deuda]['descuento_pago_oportuno']; 
						$vencido = FALSE; 
					} 
				}
				
				$adelanto = 0;
				if (count($deudas[$indice_deuda]['ingresos'])>0 ) {
					for ($j=0; $j < count($deudas[$indice_deuda]['ingresos']); $j++) { 
						$adelanto+=$deudas[$indice_deuda]['ingresos'][$j]['total'];
					}
				}

				$montoPagoProgramado = $deudas[$indice_deuda]['monto'] - $descuento - $adelanto;
				$comprobanteInterno2Tipo2=null;
?>
						<td <?=$estilo?> >
							<label>Cuenta</label>
							<input type="text" class="form-control input-sm" name="cuenta2" id="cuenta2" placeholder="<?=$deudas[$indice_deuda]['cuenta']?>" disabled='true' >
						</td>
						<td <?=$estilo?> >
							<label>Sub Cuenta</label>
							<input type="text" class="form-control input-sm" name="subcuenta2" id="subcuenta2" placeholder="<?=$deudas[$indice_deuda]['detalle']?>" disabled='true' >
						</td>
						<td <?=$estilo?> >
							<label>Monto</label>
							<input type="text" class="form-control input-sm" name="monto2" id="monto2" placeholder="<?="S/ ".$deudas[$indice_deuda]['monto'].".00" ?>" disabled='true' >
						</td>
						<td <?=$estilo?> >
							<label>
								Descuento: <?php if($vencido) echo "<span class='glyphicon glyphicon-remove'></span>"; else echo "<span class='glyphicon glyphicon-ok'></span>"; ?>
							</label>
							<input type="text" class="form-control input-sm" name="descuento2" id="descuento2" placeholder="<?="S/ ".$descuento.".00" ?>" disabled='true' >
						</td>
						<td <?=$estilo?> >
							<label>Pago Adelantado</label>
							<input type="text" class="form-control input-sm" name="monto2" id="monto2" placeholder="<?="S/ ".$adelanto.".00" ?>" disabled='true' >
						</td>
	
						<td <?=$estilo?> >
							<form action='../Controladores/CajaControl.php' method="POST" name="form_comprobante_ingreso2" id="form_comprobante_ingreso2" class="form-inline" role="form" >
								<label>Comprobante de Ingreso</label>
								<select class="form-control" name="indice_comprobante_interno2" id="indice_comprobante_interno2" onchange="this.form.submit()">
									<option value="" disabled="true" selected="true">Seleccione</option>
	<?php
									for ($i=0; $i < count($comprobantesInternos); $i++) {
										$value=""; 
										if(isset($_SESSION['indice_comprobante_interno2'])){
											if($i==$_SESSION['indice_comprobante_interno2']) {
												$value="selected='true'";
												$comprobanteInterno2Tipo2=$comprobantesInternos[$i]['tipo2'];
											}
										}
										echo "<option value='".$i."' ".$value.">".$comprobantesInternos[$i]['comprobante']."</option>";
									}
	?>
								</select>
								<input type='hidden' name='accion' id='accion' value='comprobante_interno'>
								<input type='hidden' name='control' id='control' value='ElegirIngreso'>
							</form>
						</td>
	<?php	//Si el comprobante interno es fisico
				if ($comprobanteInterno2Tipo2=="fisico") {
	?>
						<td <?=$estilo?> >
							<label>
								<?php echo "Monto a Pagar: S/. ".$montoPagoProgramado.".00"; ?>
							</label>
							<form action='../Controladores/CajaControl.php' method="POST" name="form_rif" id="form_rif" class="form-inline" role="form" >
									<select class="form-control" name="indice_rif2" id="indice_rif2" onchange="this.form.submit()">
										<option value="" disabled="true" selected="true">Seleccione</option>
	<?php
											$rifs = $_SESSION['rifs'];
											for ($i=0; $i < count($rifs); $i++) {
												$value=""; 
												if(isset($_SESSION['indice_rif2'])){
													if($i==$_SESSION['indice_rif2']) {
														$value="selected='true'";
													}
												}
												echo "<option value='".$i."' ".$value.">".$rifs[$i]['serie']."-".$rifs[$i]['correlativo']."-".$rifs[$i]['fecha']."-".$rifs[$i]['hora']."- S/".$rifs[$i]['saldo']." - ".$rifs[$i]['comentario']."</option>";
											}
	?>
									</select>
									<input type='hidden' name='montoPagoProgramado' id='montoPagoProgramado' value='<?=$montoPagoProgramado ?>'>
									<input type='hidden' name='accion' id='accion' value='rif'>
									<input type='hidden' name='control' id='control' value='ElegirIngreso'>
							</form>
						</td>
						<td <?=$estilo?> >
							<form method="POST" action="../../src/Controladores/CajaControl.php" class="form-inline" role="form" name="form_fisico">
								<label>
									Verifique los datos
								</label>
								<div class="col-xs-9">
									<button name="registrar" id="registrar" type="submit" class="btn btn-primary btn-sm" <?php if($registrarPagoProgramado) echo ""; else echo "disabled='true'";?>  > REGISTRAR </button>
									
									<input type='hidden' name='indice_deuda' id='indice_deuda' value='<?=$indice_deuda ?>' >
									<input type='hidden' name='montoPagoProgramado' id='montoPagoProgramado' value='<?=$montoPagoProgramado ?>' >
									<input type='hidden' name='descuento' id='descuento' value='<?=$descuento ?>'>
									<input type='hidden' name='adelanto' id='adelanto' value='<?=$adelanto ?>'>
									
									<input type='hidden' name='fecha' id='fecha' value='<?=$hoy ?>'>
									<input type='hidden' name='hora' id='hora' value='<?=$hora ?>'>
									<input type='hidden' name='accion' id='accion' value='rif'>
									<input type='hidden' name='control' id='control' value='RegistrarIngreso'>
								</div>
							</form>
						</td>
	<?php		} 				
	?>
	<?php	//Si el comprobante interno es bancarizado
				if ($comprobanteInterno2Tipo2=="bancarizado") {
	?>
						<td <?=$estilo?> >
							<label>
								<?php echo "Monto a Pagar: S/. ".$montoPagoProgramado.".00"; ?>
							</label>
							<form action='../Controladores/CajaControl.php' method="POST" name="form_voucher2" id="form_voucher2" class="form-inline" role="form" >
									<select class="form-control" name="indice_voucher2" id="indice_voucher2" onchange="this.form.submit()">
										<option value="" disabled="true" selected="true">Seleccione</option>
	<?php
											$vouchers = $_SESSION['vouchers'];
											for ($i=0; $i < count($vouchers); $i++) {
												$value=""; 
												if(isset($_SESSION['indice_voucher2'])){
													if($i==$_SESSION['indice_voucher2']) {
														$value="selected='true'";
													}
												}
												echo "<option value='".$i."' ".$value.">".$vouchers[$i]['serie']."-".$vouchers[$i]['operacion']."/".$vouchers[$i]['fecha']."/".$vouchers[$i]['hora']."/".$vouchers[$i]['concepto']."/".$vouchers[$i]['depositante']." S/ ".$vouchers[$i]['saldo']."</option>";
											}
	?>
									</select>
									<input type='hidden' name='montoPagoProgramado' id='montoPagoProgramado' value='<?=$montoPagoProgramado ?>'>
									<input type='hidden' name='accion' id='accion' value='voucher'>
									<input type='hidden' name='control' id='control' value='ElegirIngreso'>
							</form>
						</td>
						<td <?=$estilo?> >
							<form method="POST" action="../../src/Controladores/CajaControl.php" class="form-inline" role="form" name="form_bancarizado">
								<label>
									Verifique los datos
								</label>
								<div class="col-xs-9">
									<button name="registrar" id="registrar" type="submit" class="btn btn-primary btn-sm" <?php if($registrarPagoProgramado) echo ""; else echo "disabled='true'";?>  > REGISTRAR </button>

									<input type='hidden' name='indice_deuda' id='indice_deuda' value='<?=$indice_deuda ?>' >
									<input type='hidden' name='montoPagoProgramado' id='montoPagoProgramado' value='<?=$montoPagoProgramado ?>' >
									<input type='hidden' name='descuento' id='descuento' value='<?=$descuento ?>'>
									<input type='hidden' name='adelanto' id='adelanto' value='<?=$adelanto ?>'>

									<input type='hidden' name='fecha' id='fecha' value='<?=$hoy ?>'>
									<input type='hidden' name='hora' id='hora' value='<?=$hora ?>'>
									<input type='hidden' name='accion' id='accion' value='voucher'>
									<input type='hidden' name='control' id='control' value='RegistrarIngreso'>
								</div>
							</form>
						</td>
	<?php		} 				
	?>
	<?php	//Si el comprobante interno es electronico
				if ($comprobanteInterno2Tipo2=="electronico") {
	?>
					<form method="POST" id="RIE" name="RIE" action="../../src/Controladores/CajaControl.php" class="form-inline" role="form" onsubmit="return validarFormulario()">
						<td <?=$estilo?> >
							<label>
								<?php echo "Monto a Pagar: S/. ".$montoPagoProgramado.".00"; ?>
							</label>
							<div class="col-xs-9">
								<input type="number" step="0.01" class="form-control input-sm" name="efectivo2" id="efectivo2" placeholder="Efectivo" required="true" >
							</div>
						</td>
						<td <?=$estilo?> >
								<label>
									Verifique los datos
								</label>
								<div class="col-xs-9">
									<button name="registrar2" id="registrar2" type="submit" class="btn btn-primary btn-sm" > REGISTRAR </button>

									<input type='hidden' name='indice_deuda' id='indice_deuda' value='<?=$indice_deuda ?>' >
									<input type='hidden' name='montoPagoProgramado' id='montoPagoProgramado' value='<?=$montoPagoProgramado ?>' >
									<input type='hidden' name='descuento' id='descuento' value='<?=$descuento ?>'>
									<input type='hidden' name='adelanto' id='adelanto' value='<?=$adelanto ?>'>

									<input type='hidden' name='fecha' id='fecha' value='<?=$hoy ?>'>
									<input type='hidden' name='hora' id='hora' value='<?=$hora ?>'>
									<input type='hidden' name='accion' id='accion' value='rie'>
									<input type='hidden' name='control' id='control' value='RegistrarIngreso'>
								</div>
						</td>
					</form>
	<?php		} 				
	?>
	
	<?php	//Si todavía no se ha definido un comprobante interno entonces solo imprimimos para completar la pantalla del usuario
				if ($comprobanteInterno2Tipo2=="") {
	?>
						<td <?=$estilo?> >
							<label>
								<?php echo "Monto a Pagar: S/. ".$montoPagoProgramado.".00"; ?>
							</label>
							<div class="col-xs-9">
								<input type="number" class="form-control input-sm" name="niguno" id="ninguno" placeholder="efectivo" disabled='true' >
							</div>
						</td>
						<td <?=$estilo?> >
							<label>
								Verifique los datos
							</label>
							<div class="col-xs-9">
								<button name="registrar" id="registrar" type="submit" class="btn btn-primary btn-sm" disabled='true' > REGISTRAR </button>
							</div>
						</td>
	
	<?php		} 				
	?>
	
	
	<?php 	}
	 ?>
					</tr>
				</table>
				</br>
<?php 	}  // FIN DE REGISTRAR INGRESOS
 ?>			
			
		<li><strong>ESTADO DE CUENTA: <?="Calculado el: ".$hoy." - ".$hora?> </strong></li>
			<ul class="list-unstyled">
				<table class="table table-condensed table-striped" >
					<form method="POST" id="form_detalles" name="form_detalles" action="../../src/Controladores/CajaControl.php" class="form-inline" role="form" onsubmit="return validarDetalle()">
						<tr>
							<td rowspan="2" <?=$estilo?> ><strong>#</strong></td>
							<td colspan="5" <?=$estilo?> ><strong>COBROS</strong></td>
							<td colspan="5" <?=$estilo?> ><strong>DEPOSITOS</strong></td>
							<td colspan="2" <?=$estilo?> ><strong>COMPROBANTE</strong></td>
							<td rowspan="2" <?=$estilo?> ><strong>SALDO</strong></td>
						</tr>
						<tr>
							<td <?=$estilo?> ><strong>Detalle</strong></td>
							<td <?=$estilo?> ><strong>Cobro</strong></td>
							<td <?=$estilo?> ><strong>Vencimiento</strong></td>
							<td <?=$estilo?> ><strong>Monto</strong></td>
							<td <?=$estilo?> ><strong>Descuento</strong></td>
							<td <?=$estilo?> ><strong>Registro de Ingreso</strong></td>
							<td <?=$estilo?> ><strong>Fecha</strong></td>
							<td <?=$estilo?> ><strong>Monto</strong></td>
							<td <?=$estilo?> ><strong>Descuento</strong></td>
							<td <?=$estilo?> ><strong>Total</strong></td>
							<td <?=$estilo?> ><strong>Seleccionar</strong></td>
							<td <?=$estilo?> ><strong>Emitido</strong></td>
						</tr>
<?php
		 			if (isset($_SESSION['deudas'])) {
						$deudas = $_SESSION['deudas'];
						$formulario = TRUE; //para ver que se imprima un solo formulario de pago
						
						for ($i=0; $i < count($deudas); $i++) {
							
							//PARA SABER CUANTAS BOLETAS YA SE HAN EMITIDO POR ESA DEUDA
							$nroIngresos = count($deudas[$i]['ingresos']); 
							$rowspan=0; $totalIngresos=0; $totalDescuentosIngresos=0;
							if ($nroIngresos==0){
								$rowspan=1;
								$totalIngresos=0;
								$repeticiones=1;
								$totalDescuentosIngresos=0;
							} elseif ($nroIngresos>0){
								$repeticiones = $nroIngresos;
								for ($j=0; $j < $nroIngresos; $j++) { 
									$rowspan++; // calculo del numero de filas a juntar
									$totalDescuentosIngresos+=$deudas[$i]['ingresos'][$j]['descuento'];
									$totalIngresos+=$deudas[$i]['ingresos'][$j]['total']; // suma de los totales de las boletas por una deuda
								}
							}
							// si se paso la fecha de vencimiento entonces descuento 0 sino no se venció descuento = descuento_pago_oportuno
							$vencimiento = $deudas[$i]['fecha_vencimiento'];
							$cobro = $deudas[$i]['monto'];
							
							if($hoy > $vencimiento) { $descuento = 0; $vencido=true; } 
							else { $descuento = $deudas[$i]['descuento_pago_oportuno']; $vencido=false; } 
	
							if ($deudas[$i]['cancelado']==1) $saldo=$cobro-$totalIngresos-$totalDescuentosIngresos;	
							else $saldo=$cobro-$descuento-$totalIngresos-$totalDescuentosIngresos;
							
							$repeticion=0;
							while ($repeticion < $repeticiones) {
?>
								<tr <?php if($i == $indice_deuda) echo "class='success'"; else echo "";?> >
<?php
									if ($repeticion==0){		?>
		 								<td rowspan="<?=$rowspan ?>" <?=$estilo?> ><?=$i+1 ?></td>
										<td rowspan="<?=$rowspan ?>" <?=$estilo?> ><?=$deudas[$i]['detalle'] ?></td>
										<td rowspan="<?=$rowspan ?>" <?=$estilo?> ><?=$deudas[$i]['fecha_de_cobro'] ?></td>
										<td rowspan="<?=$rowspan ?>" <?=$estilo?> ><?=$deudas[$i]['fecha_vencimiento'] ?></td>
										<td rowspan="<?=$rowspan ?>" <?=$estilo?> ><?="S/. ".$deudas[$i]['monto'] ?></td>
										<td rowspan="<?=$rowspan ?>" <?=$estilo?> ><?php if($vencido) echo "<span class='glyphicon glyphicon-remove'></span>"; else echo "<span class='glyphicon glyphicon-ok'></span>"; ?>	<?="S/. ".$deudas[$i]['descuento_pago_oportuno'] ?></td>
<?php
									}
									if ($nroIngresos==0){	
?>
										<td <?=$estilo?> ></td>
										<td <?=$estilo?> ></td>
										<td <?=$estilo?> ></td>
										<td <?=$estilo?> ></td>
										<td <?=$estilo?> ></td>
										<td <?=$estilo?> ></td>
										<td <?=$estilo?> ></td>
<?php
									} //echo "// deuda:".$i." a:".$repeticion." pasada:".$repeticiones."//";
									if($nroIngresos>0) {
										$serieYcorrelativoDeIngreso=str_pad($deudas[$i]['ingresos'][$repeticion]['serie'],4,"0",STR_PAD_LEFT)."-".str_pad($deudas[$i]['ingresos'][$repeticion]['correlativo'],8,"0",STR_PAD_LEFT);
?>
										<td <?=$estilo?> ><?=$serieYcorrelativoDeIngreso ?></td>
										<td <?=$estilo?> ><?=$deudas[$i]['ingresos'][$repeticion]['fecha'] ?></td>
										<td <?=$estilo?> align='right'><?=$deudas[$i]['ingresos'][$repeticion]['monto'] ?></td>
										<td <?=$estilo?> align='right'><?=$deudas[$i]['ingresos'][$repeticion]['descuento'] ?></td>
										<td <?=$estilo?> align='right'><?=$deudas[$i]['ingresos'][$repeticion]['total'] ?></td>
										<td <?=$estilo?> align='center'>
<?php
		 									if ($deudas[$i]['ingresos'][$repeticion]['registrodeventa_id']=="" && $deudas[$i]['ingresos'][$repeticion]['tipo1']=="interno") { 
?>
												<input type="checkbox" name="item[]" id="item" value="<?=$deudas[$i]['ingresos'][$repeticion]['id'] ?>">
<?php
											}
?>
										</td>
										<td <?=$estilo?> >
<?php
		 									if ($deudas[$i]['ingresos'][$repeticion]['registrodeventa_id']=="" && $deudas[$i]['ingresos'][$repeticion]['tipo1']=="externo") {
												echo $serieYcorrelativoDeIngreso; 
											} 
											if ($deudas[$i]['ingresos'][$repeticion]['registrodeventa_id']!="") {
												echo $deudas[$i]['ingresos'][$repeticion]['registrodeventa'][0]['serie']."-".str_pad($deudas[$i]['ingresos'][$repeticion]['registrodeventa'][0]['correlativo'],8,"0",STR_PAD_LEFT);
											}
?>
										</td>
<?php
									}	
									if($repeticion==0){	
?>
										<td  rowspan="<?=$rowspan ?>" <?=$estilo?> ><?="S/ ".$saldo?></td>
<?php
										}	
	
?>
								</tr>
<?php
							$repeticion++;
							}
						}		
					}
?>
						<tr>
							<td colspan="11" <?=$estilo?> ></td>
							<td colspan="3" <?=$estilo?> >
								<input type='hidden' name='accion' id='accion' value='ingresos'>
								<input type='hidden' name='control' id='control' value='PrepararComprobante'>
								<input type="checkbox" name="item[]" id="item" value="" disabled="true"> <!-- Este checkbox solo se puso para lograr validar a traves de javascript-->
								<button name="emitir" id="emitir" type="submit" class="btn btn-primary btn-sm" > EMITIR COMPROBANTE </button>							
							</td>
						</tr>
					</form>
				</table>
			</ul>
	</ol>
</div>

<script type="text/javascript">

	function validarOtroPago() {
		efectivo = document.getElementById("efectivo_otro_pago").value;
		monto = <?=$monto?>;
		if( efectivo<monto) {
			alert("Monto ingresado menor al requerido");
			document.getElementById("efectivo_otro_pago").value='';
			document.getElementById("efectivo_otro_pago").focus();
			return false;
		}
		if (confirm('¿ESTA SEGURO DE EMITIR BOLETA?')){ 
			document.boleta.submit() 
		} else {
			document.getElementById("efectivo_otro_pago").focus();
			return false;
		}
	}
	
	function validarPagoProgramado() {
		efectivo = document.getElementById("efectivo_2").value;
		monto = <?=$montoPagoProgramado?>;
		if( efectivo<monto) {
			alert("Monto ingresado menor al requerido");
			document.getElementById("efectivo_2").value='';
			document.getElementById("efectivo_2").focus();
			return false;
		}
		if (confirm('¿ESTA SEGURO DE EMITIR BOLETA?')){ 
			document.form_electronico2.submit() 
		} else {
			document.getElementById("efectivo_2").focus();
			return false;
		}
	}

	function validarFormulario() {
		valor = document.getElementById("efectivo2").value;
		if( valor<0  ) {
			alert("MONTO NO VÁLIDO");
			document.getElementById("efectivo2").value='';
			document.getElementById("efectivo2").focus();
			return false;
		}
		if (confirm('¿ESTA SEGURO DE EMITIR BOLETA?')){ 
			document.RIE.submit() 
		} else {
			document.getElementById("efectivo_2").focus();
			return false;
		}
	}

	function validarDetalle() {
		var detalle = document.form_detalles['item'];
		
		var contador = 0;
		for (var x=0; x<detalle.length; x++ ){
			if (detalle[x].checked ) {
				contador++;
			}
		}
		if( contador<1  ) {
			alert("Seleccione al menos un Registro Interno");
			return false;
		} else {
			if (confirm('¿ESTA SEGURO DE EMITIR COMPROBANTE?')) {
				document.detalle.submit()
			} else {
				return false;
			}
		}
	}

</script>