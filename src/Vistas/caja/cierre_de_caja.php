<?php 
date_default_timezone_set('America/Lima');
setlocale(LC_TIME, "Spanish");		

$hora=strftime("%H:%M");

$series_de_vouchers_pendientes = $_SESSION['series_de_vouchers_pendientes'];
$series_de_rifs_pendientes = $_SESSION['series_de_rifs_pendientes'];
$series_de_ries_pendientes = $_SESSION['series_de_ries_pendientes'];

print_r($series_de_ries_pendientes);
?>

<div name="menu">
	<ul class="nav nav-tabs nav-justified">
		<li class='active'><a href='#' onclick='javascript:document.form_fecha.submit()'>Recibos Internos Electrónicos<span class="badge pull-right"><?=count($series_de_ries_pendientes) ?></span></a></li>
		<li><a href='#' onclick='javascript:document.form_alumnos.submit()'>Recibos Internos Físicos<span class="badge pull-right"><?=count($series_de_rifs_pendientes) ?></span></a></li>
		<li><a href='#' onclick='javascript:document.form_estado_cuenta.submit()'>Voucher's<span class="badge pull-right"><?=count($series_de_vouchers_pendientes) ?></span></a></li>
	</ul>
	
	<form method='POST' name='form_fecha' id='form_rie' action='../Controladores/CajaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='fecha.php'>
	</form>
	<form method='POST' name='form_alumnos' id='form_rif' action='../Controladores/CajaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='buscar.php'>
	</form>
	<form method='POST' name='form_estado_cuenta' id='form_vouchers' action='../Controladores/CajaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='estado_de_cuenta.php'>
	</form>
</div>
</br>

<?php 
$fechas_pendientes_ries = $_SESSION['fechas_pendientes_ries'];

?>

<div class="container">
	<hr/>
	<table>
		<tr>
			<td>
				<form action='../Controladores/CajaControl.php' method="POST" name="form_stands" id="form_stands" class="form-inline" role="form" >
					<label>Series:<span class="badge pull-right"><?=count($series_de_ries_pendientes) ?></span></label>
					<select class="form-control" name="indice_series_de_ries" id="indice_series_de_ries" onchange="this.form.submit()">
						<option value="" disabled="true" <?php if(!isset($_SESSION['indice_series_de_ries'])) echo "selected='true'"; ?> >Elija una Serie</option>
<?php
							for ($i=0; $i < count($series_de_ries_pendientes); $i++) { 
								$value="";
								if(isset($_SESSION['indice_series_de_ries'])) {
									if($_SESSION['indice_series_de_ries']==$i) {
										$value="selected='true'";
									}
								}
								echo "<option value='".$i."' ".$value.">".$series_de_ries_pendientes[$i]['serie']."</option>";
							}
?>
					</select>
					<input type='hidden' name='control' id='control' value='Cierre'>
					<input type='hidden' name='subcontrol' id='subcontrol' value='serie'>
				</form>
			</td>
			<td>
				<label>Usuario: </label>
				<select class="form-control" name="usuario" id="usuario" disabled="true">
					<option selected='true'><?php if(isset($_SESSION['indice_series_de_ries'])) echo $series_de_ries_pendientes[$_SESSION['indice_series_de_ries']]['username']; else echo "username"; ?></option>
				</select>
			</td>
			<td>
				<form action='../Controladores/CajaControl.php' method="POST" name="form_stands" id="form_stands" class="form-inline" role="form" >
					<label>Fechas: <span class="badge pull-right"><?=count($fechas_pendientes_ries) ?></span></label>
					<select class="form-control" name="indice_fecha_rie" id="indice_fecha_rie" onchange="this.form.submit()">
						<option value="" disabled="true" <?php if(!isset($_SESSION['indice_fecha_rie'])) echo "selected='true'"; ?> >Elija una Fecha</option>
<?php
            				if(isset($_SESSION['fechas_pendientes_ries'])){
            				    $fechas_ries = $_SESSION['fechas_pendientes_ries'];
                				for ($i=0; $i < count($fechas_ries); $i++) { 
                					$value="";
                					if(isset($_SESSION['indice_fecha_rie'])) {
                						if($_SESSION['indice_fecha_rie']==$i) {
                							$value="selected='true'";
                						}
                					}
                					echo "<option value='".$i."' ".$value.">".$fechas_ries[$i]['fecha']."</option>";
                				}
            				}
?>
					</select>
					<input type='hidden' name='control' id='control' value='Cierre'>
					<input type='hidden' name='subcontrol' id='subcontrol' value='fecha'>
				</form>
			</td>
		</tr>
		<tr>
		</tr>
	</table>

	<hr />
	
	<div class="table-responsive">
		
<?php
$subtotal=-1;
		if(isset($_SESSION['ries_pendientes'])){
			$ries_pendientes = $_SESSION['ries_pendientes'];
			$subtotal=$j=0;
?>
				<h4>REGISTROS PENDIENTES: <small><?=count($ries_pendientes) ?> encontradas. </small></h4>
				<table class='table table-hover'>
					<thead>
						<tr>
							<td align='center'><strong>#</strong></td>
							<td align='center'><strong>NRO. BOLETA</strong></td>
							<td align='center'><strong>FECHA</strong></td>
							<td align='center'><strong>DETALLE</strong></td>
							<td align='center'><strong>MONTO</strong></td>
							<td align='center'><strong>DESCUENTO</strong></td>
							<td align='center'><strong>TOTAL</strong></td>
							<td align='center' colspan="2"><strong>OPCIONES</strong></td>
						</tr>
					</thead>
					<tbody>
<?php					for ($i=0; $i < count($ries_pendientes) ; $i++) {
							$j++; 
							if ($ries_pendientes[$i]['anulado']==0) { //si el RIE no esta anulado
								$subtotal+=$ries_pendientes[$i]['total'];	?>
									<tr>
										<td><?=$j ?></td>
										<td><?=$ries_pendientes[$i]['serie']."-".$ries_pendientes[$i]['correlativo'] ?></td>
										<td><?=$ries_pendientes[$i]['fecha'] ?></td>
										<td><?=$ries_pendientes[$i]['detalle'] ?></td>
										<td align='right'><?=$ries_pendientes[$i]['monto'] ?></td>	
										<td align='right'><?=$ries_pendientes[$i]['descuento'] ?></td>
										<td align='right'><?=$ries_pendientes[$i]['total'] ?></td>
										<td align='center'><a href='./caja/reimprimir.php?orden=<?=$i ?>' target="_blank">Comprobante</a></td>
										<td align='center'><a href='#' onclick='javascript:document.elegir<?=$i?>.submit()'>Anular</a>
											<form method='POST' name='elegir<?=$i?>' id='elegir<?=$i?>' action='../Controladores/CajaControl.php'>
												<input type='hidden' name='idBoleta' id='idBoleta' value='<?=$boletas[$i]['id']?>'>
												<input type='hidden' name='idDeuda' id='idDeuda' value='<?=$boletas[$i]['deuda_id']?>'>
												<input type='hidden' name='control' id='control' value='Cierre'>
												<input type='hidden' name='subcontrol' id='subcontrol' value='AnularBoleta'>
											</form>
										</td>
										
									</tr>
<?php							} else { //si la boleta está anulada.	?>
									<tr>
										<td><s><?=$j ?></s></td>
										<td><s><?=$ries_pendientes[$i]['serie']."-".$ries_pendientes[$i]['correlativo']?></s></td>
										<td><s><?=$ries_pendientes[$i]['fecha']?></s></td>
										<td><s><?=$ries_pendientes[$i]['detalle']?></s></td>
										<td align='right'><s><?=$ries_pendientes[$i]['monto']?></s></td>
										<td align='right'><s><?=$ries_pendientes[$i]['descuento']?></s></td>
										<td align='right'><s><?=$ries_pendientes[$i]['total']?></s></td>
										<td align='center'><s><a href='./caja/reimprimir.php?orden=<?=$i ?>' target="_blank">Imprimir</a></s></td>
									</tr>
<?php							}

							}		?>
						<tr>
							<td colspan='6'></td>
							<td align='right'><?=$subtotal?></td>
							<td></td>
						</tr>
					</tbody>
				</table>
				

<?php	}  else {
				echo "<h5><b>RIES PENDIENTES: </b><small> 0 Boletas - Parámetros incompletos.</small></h5>";
		}	?>
	</div>

	<hr />

	<h5><b>DATOS DE CIERRE: </b>
		<small>
			<?php
			if(isset($_SESSION['indice_series_de_ries']) AND isset($_SESSION['indice_fecha_rie']) AND $subtotal>=0){
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;USUARIO: ".$series_de_ries_pendientes[$_SESSION['indice_series_de_ries']]['username']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FECHA DE EMISIÓN: ".$fechas_ries[$_SESSION['indice_fecha_rie']]['fecha']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EFECTIVO: ".$subtotal;
				$listo = FALSE;
			} else {
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;USUARIO: NO DEFINIDO  "."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FECHA DE EMISIÓN: NO DEFINIDO "."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EFECTIVO: NO DEFINIDO";
				$listo = TRUE;
			}
			?>
		</small>
	</h5>
	<form action='../Controladores/CajaControl.php' method="POST" class="form-inline" role="form" onsubmit="return validacion()" name="cierre">
		<div class="form-group">
	    	<label for="Monto">Efectivo Total</label>
	    	<input type="number" step="any" class="form-control" name="monto" id="monto" placeholder="Introduce total de efectivo">
		</div>
		<div class="form-group">
			<label for="comentario">Comentario Adicional</label>
			<input type="text" class="form-control" name="comentario" id="comentario" placeholder="Comentario adicional">
		</div>

		<input type='hidden' name='subtotal' id='subtotal' value='<?=$subtotal ?>'>
		<input type='hidden' name='username_cajero' id='username_cajero' value='<?=$_SESSION['usuario_id'] ?>'>
		<input type='hidden' name='stand_id' id='stand_id' value='<?=$_SESSION['stand_id'] ?>'>
		<input type='hidden' name='fecha' id='fecha' value='<?=$_SESSION['fecha_id'] ?>'>
		<input type='hidden' name='hora' id='hora' value='<?=$hora ?>'>
		<input type='hidden' name='subcontrol' id='subcontrol' value='Cerrar'>
		<input type='hidden' name='control' id='control' value='Cierre'>
		
		<button type="submit" class="btn btn-default" <?php if($listo) echo "disabled='true'" ?> >Guardar</button>
	</form>


</div>

<script type="text/javascript">
	function validacion() {
		subtotal = document.getElementById("subtotal").value;
		monto = document.getElementById("monto").value;
		if( monto<subtotal ) {
			alert("MONTO NO VÁLIDO");
			document.getElementById("monto").value='';
			document.getElementById("monto").focus();
			return false;
		}
		if (confirm('¿ESTA SEGURO DE REGISTRAR CIERRE DE CAJA?')){ 
			document.cierre.submit() 
		} else {
			document.getElementById("monto").focus();
			return false;
		}
	}
</script>