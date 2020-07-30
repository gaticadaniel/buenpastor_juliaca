<div name="menu">
	<ul class="nav nav-tabs nav-justified">
		<li><a href='#' onclick='javascript:document.form_fecha.submit()'>Definir Fecha<?php if(isset($_SESSION['p3fecha'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_alumnos.submit()'>Seleccionar Estudiante<?php if(isset($_SESSION['llave'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_estado_cuenta.submit()'>Estado de Cuenta<?php if(isset($_SESSION['boleta'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li class='active'><a href='#' onclick=''>Emitir Comprobante</a></li>
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

$emitir_comprobante = FALSE;
//PARA MOSTRAR LAS OPCIONES QUE PERMITAN REGISTRAR COMPROBANTES INTERNOS
if (count($_SESSION['comprobantesExternos'])>=1) {
	$comprobantesExternos=$_SESSION['comprobantesExternos'];
	$emitir_comprobante = TRUE; // la variable antiguo era $emitir_boleta
} else {
	$emitir_comprobante = FALSE;
}

//print_r($_SESSION['clientes']);
$hoy = $_SESSION['fechaSistema']; // FECHA PARA EL CALCULO DE TODAS LAS OPERACIONES

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

<?php 	if($emitir_comprobante) {
			$codigo_sunat = '00';
			if ( isset($_SESSION['indice_cliente'] )) {
				$indice_cliente = $_SESSION['indice_cliente'];
				$modo = "actualizar";
			} else {
				$indice_cliente = null;
				$modo = "nuevo";
			} 
?>
			<li><strong>
					SELECCIONE COMPROBANTE: 
				</strong>
				<form action='../Controladores/CajaControl.php' method="POST" name="form_cuenta" id="form_cuenta" class="form-inline" role="form" >
					<select class="form-control" name="indice_comprobante_externo" id="indice_comprobante_externo" onchange="this.form.submit()">
						<option value="" disabled="true" <?php if(!isset($_SESSION['indice_comprobante_externo'])) echo "selected='true'"; ?> >Seleccione</option>
<?php
							for ($i=0; $i < count($comprobantesExternos); $i++) {
								$value=""; 
								if(isset($_SESSION['indice_comprobante_externo'])) {
									if($i==$_SESSION['indice_comprobante_externo']) {
										$codigo_sunat = $comprobantesExternos[$i]['codigo_sunat'];
										$value="selected='true'";
									}
								}
								echo "<option value='".$i."' ".$value.">".$comprobantesExternos[$i]['comprobante']." - ".$comprobantesExternos[$i]['serie']."</option>";
							}
?>
					</select>
					<input type='hidden' name='accion' id='accion' value='ElegirComprobante'>
					<input type='hidden' name='control' id='control' value='PrepararComprobante'>
				</form>
			</li>
<?php			 				
			//Si el codigo_sunat=03	del Comprobante(BOLETA) 
			if ($codigo_sunat=='03' ) {
?>			
				<table class="table table-condensed table-striped" >
					<tr>
						<td <?=$estilo?> >
							<form action='../Controladores/CajaControl.php' method="POST" name="form_subcuenta" id="form_subcuenta" class="form-inline" role="form" >
								<label>Cliente:</label>
								<select class="form-control" name="indice_cliente" id="indice_cliente" onchange="this.form.submit()" <?php if(isset($_SESSION['indice_comprobante_externo'])) echo ""; else echo "disabled='true'"; ?> >
									<option value="" disabled="true" selected="true">Seleccione</option>
<?php
									if( isset($_SESSION['clientes']) ){
										$clientes=$_SESSION['clientes'];
										for ($i=0; $i < count($clientes); $i++) {
											$value=""; 
											if(isset($_SESSION['indice_cliente'])){
												if($i==$_SESSION['indice_cliente']) {
													$indice_cliente = $_SESSION['indice_cliente'];
													$value="selected='true'";
												}
											}
											echo "<option value='".$i."' ".$value.">".$clientes[$i]['role']." - ".$clientes[$i]['apellido_paterno']." ".$clientes[$i]['apellido_materno'].", ".$clientes[$i]['nombres']."</option>";
										}
									}
?>
								</select>
								<input type='hidden' name='accion' id='accion' value='ElegirCliente'>
								<input type='hidden' name='control' id='control' value='PrepararComprobante'>
							</form>
						</td>
						<td <?=$estilo?> >
							<table>
								<tr>
									<td align="right">DNI:&ensp;</td>
									<td align="center">
										<input type="number" class="form-control input-sm" name="dni" id="dni" value="<?php if (isset($indice_cliente)) echo $clientes[$indice_cliente]['dni']; else echo ""; ?>" disabled='true' >
									</td>
									<td></td>
								</tr>									
								<tr>
									<td align="right">Nombres:&ensp;</td>
									<td align="center">
										<input type="text" class="form-control input-sm" name="nombres" id="nombres" size="30" value="<?php if (isset($indice_cliente)) echo $clientes[$indice_cliente]['apellido_paterno']." ".$clientes[$indice_cliente]['apellido_materno'].", ".$clientes[$indice_cliente]['nombres']; else echo ""; ?> " disabled='true' >
									</td>
									<td></td>
								</tr>									
								<form action='../Controladores/CajaControl.php' method="POST" name="form_email" id="form_email" class="form-inline" role="form" >
									<tr>
										<td align="right">Dirección:&ensp;</td>
										<td align="center">
											<input type="text" class="form-control input-sm" name="direccion" id="direccion" value="<?php if (isset($indice_cliente)) echo $clientes[$indice_cliente]['direccion'] ; else echo '' ?>" required='true' >
										</td>
										<td></td>
									</tr>									
									<tr>
										<td align="right">Teléfono:&ensp;</td>
										<td align="center">
											<input type="text" class="form-control input-sm" name="telefono" id="telefono" value="<?php if (isset($indice_cliente)) echo $clientes[$indice_cliente]['movistar'] ; else echo '' ?>" required='true' >
										</td>
										<td></td>
									</tr>									
									<tr>
											<td align="right">E-mail:&ensp;</td>
											<td align="center">
												<input type='hidden' name='accion' id='accion' value='ActualizarDatos'>
												<input type='hidden' name='control' id='control' value='PrepararComprobante'>
												<input type="email" class="form-control input-sm" name="email" id="email" value="<?php if (isset($indice_cliente)) echo $clientes[$indice_cliente]['email']; else echo ""; ?>" required='true'>
											</td>
											<td>
												<button name="enviarEmail" id="enviarEmail" type="submit" class="btn btn-primary btn-sm" >GUARDAR EMAIL</button>
											</td>
									</tr>									
								</form>
							</table>
						</td>
						<td <?=$estilo?> >
							<label>Estado:</label><br>
<?php						if (isset($_SESSION['indice_comprobante_externo']) && isset($_SESSION['indice_cliente']) && $clientes[$indice_cliente]['email']!="" ) {
								echo "<span class='glyphicon glyphicon-ok'></span>";
							} else {
								echo "<span class='glyphicon glyphicon-remove'></span>";
							}
?>
						</td>
					</tr>
				</table>
<?php			 				
			}
?>
<?php			 				
			//Si el codigo_sunat=01 PARA FACTURA y el indice_cliente existe
			if ($codigo_sunat=='01' ) {
?>
				<table class="table table-condensed table-striped" >
					<tr>
						<td <?=$estilo?> >
							<table class="table table-condensed table-striped" >
								<tr>
									<td>
										<form action='../Controladores/CajaControl.php' method="POST" name="form_subcuenta" id="form_subcuenta" class="form-inline" role="form" >
											<label>Cliente:</label>
											<select class="form-control" name="indice_cliente" id="indice_cliente" onchange="this.form.submit()" <?php if(isset($_SESSION['indice_comprobante_externo'])) echo ""; else echo "disabled='true'"; ?> >
												<option value="" disabled="true" selected="true">Seleccione</option>
<?php
												if( isset($_SESSION['clientes']) ){
													$clientes=$_SESSION['clientes'];
													for ($i=0; $i < count($clientes); $i++) {
														$value=""; 
														if(isset($_SESSION['indice_cliente'])){
															if($i==$_SESSION['indice_cliente']) {
																$indice_cliente = $_SESSION['indice_cliente'];
																$value="selected='true'";
															}
														}
														echo "<option value='".$i."' ".$value.">".$clientes[$i]['ruc']."</option>";
													}
												}
?>
											</select>
											<input type='hidden' name='accion' id='accion' value='ElegirCliente'>
											<input type='hidden' name='control' id='control' value='PrepararComprobante'>
										</form>
									</td>
								</tr>
								<tr>
									<td><br><br>
										<form action='../Controladores/CajaControl.php' method="POST" name="buscar_pj" id="buscar_pj" class="form-inline" role="form" >
											<table>
												<tr>
													<td align="center" colspan="3">Ingrese número de RUC a buscar</td>
												</tr>									
												<tr>
													<td align="right">RUC:&ensp;</td>
													<td align="left">
														<input type="number" class="form-control input-sm" name="ruc" id="ruc" required="true">
													</td>
													<td>
														<input type='hidden' name='accion' id='accion' value='BuscarRuc'>
														<input type='hidden' name='control' id='control' value='PrepararComprobante'>
														<button name="enviarEmail" id="enviarEmail" type="submit" class="btn btn-primary btn-sm" >BUSCAR</button>
													</td>
												</tr>									
											</table>
										</form>
									</td>
								</tr>	
							</table>
						</td>
						<td <?=$estilo?> >
							<form action='../Controladores/CajaControl.php' method="POST" name="form_email" id="form_email" class="form-inline" role="form" >
								<table>
									<tr>
										<td align="right">RUC:&ensp;</td>
										<td align="left">
											<input type="number" <?php if($modo=="actualizar") echo "disabled='true'" ?> class="form-control input-sm" name="ruc" id="ruc" size="40" required="true" value="<?php if (isset($indice_cliente)) echo $clientes[$indice_cliente]['ruc']; else echo ""; ?>"  >
										</td>
										<td></td>
									</tr>									
									<tr>
										<td align="right">Razón Social:&ensp;</td>
										<td align="left">
											<input type="text" class="form-control input-sm" name="razon_social" id="razon_social" size="40" required="true" value="<?php if (isset($indice_cliente)) echo $clientes[$indice_cliente]['razon_social']; else echo ""; ?>" >
										</td>
										<td></td>
									</tr>									
									<tr>
										<td align="right">Dirección:&ensp;</td>
										<td align="left">
											<input type="text" class="form-control input-sm" name="direccion" id="direccion" size="40" required="true" value="<?php if (isset($indice_cliente)) echo $clientes[$indice_cliente]['direccion']; else echo ""; ?>" >
										</td>
										<td></td>
									</tr>									
									<tr>
										<td align="right">Teléfono:&ensp;</td>
										<td align="left">
											<input type="number" class="form-control input-sm" name="telefono" id="telefono" size="40" required="true" value="<?php if (isset($indice_cliente)) echo $clientes[$indice_cliente]['telefono']; else echo ""; ?>" >
										</td>
										<td></td>
									</tr>									
									<tr>
										<td align="right">Ubigeo:&ensp;</td>
										<td align="left">
											<input type="number" class="form-control input-sm" name="ubigeo" id="ubigeo" size="40" required="true" value="<?php if (isset($indice_cliente)) echo $clientes[$indice_cliente]['ubigeo']; else echo ""; ?>" >
										</td>
										<td></td>
									</tr>									
									<tr>
										<td align="right">E-mail:&ensp;</td>
										<td align="left">
											<input type="email" class="form-control input-sm" name="email" id="email" size="40" required="true" value="<?php if (isset($indice_cliente)) echo $clientes[$indice_cliente]['email']; else echo ""; ?>" >
										</td>
										<td>
											<input type='hidden' name='modo' id='modo' value='<?=$modo?>'>
											<input type='hidden' name='accion' id='accion' value='GuardarPersonaJuridica'>
											<input type='hidden' name='control' id='control' value='PrepararComprobante'>
											<button name="enviarEmail" id="enviarEmail" type="submit" class="btn btn-primary btn-sm" >GUARDAR</button>
										</td>
									</tr>									
								</table>
							</form>
							
						</td>
						<td <?=$estilo?> >
							<label>Estado:</label><br>
<?php						if (isset($_SESSION['indice_comprobante_externo']) && isset($_SESSION['indice_cliente']) && $clientes[$indice_cliente]['email']!="" ) {
								echo "<span class='glyphicon glyphicon-ok'></span>";
							} else {
								echo "<span class='glyphicon glyphicon-remove'></span>";
							}
?>
						</td>
					</tr>
				</table>

<?php			 				
					}
			}
?>
	
			<li><strong>DETALLE</strong></li>
				<table class="table table-condensed table-striped" >
					<tr>
						<td <?=$estilo?> ><strong>#</strong></td>
						<td <?=$estilo?> ><strong>CANTIDAD</strong></td>
						<td <?=$estilo?> ><strong>DETALLE</strong></td>
						<td <?=$estilo?> ><strong>PRECIO UNITARIO</strong></td>
						<td <?=$estilo?> ><strong>DESCUENTO</strong></td>
						<td <?=$estilo?> ><strong>SUBTOTAL</strong></td>
					</tr>
<?php
					if (isset($_SESSION['detalles']) ) {
						$detalles = $_SESSION['detalles'];
						$total_gravado = 0;
						$total_inafecto = 0;
						$total_exonerado = 0;
						$total_gratuito = 0;
						$total_exportacion = 0;
						$total_descuento = 0;
						$subtotal = 0;
						$por_igv = 0;
						$total_igv = 0;
						$total_isc = 0;
						$total_otr_imp = 0;
						$total = 0;
						
						for ($i=0; $i < count($detalles) ; $i++) {
							$total_inafecto+=$detalles[$i]['monto'];
							$total_descuento+=$detalles[$i]['descuento'];
?>
							<tr>
								<td <?=$estilo?> ><strong><?=$i+1?></strong></td>
								<td <?=$estilo?> align='center' ><strong>1</strong></td>
								<td <?=$estilo?> ><strong><?=$detalles[$i]['detalle'] ?></strong></td>
								<td <?=$estilo?> align="right" ><strong><?=$detalles[$i]['monto'] ?></strong></td>
								<td <?=$estilo?> align="right" ><strong><?=$detalles[$i]['descuento'] ?></strong></td>
								<td <?=$estilo?> align="right" ><strong><?=$detalles[$i]['total'] ?></strong></td>
							</tr>
<?php							
						}
						$subtotal = $total_gravado + $total_inafecto + $total_exonerado + $total_gratuito + $total_exportacion - $total_descuento;
						$total = $subtotal - $total_igv - $total_isc - $total_otr_imp;
					}
?>				
					<form action='../Controladores/CajaControl.php' method="POST" name="form_comprobante" id="form_comprobante" class="form-inline" role="form" >
						<tr>
							<td colspan="3" align="right" <?=$estilo ?> >
								<table>
									<tr>
										<td colspan="4" align="right" <?=$estilo ?> ><strong>Total Gravado:</strong></td>
										<td colspan="2" align="right" <?=$estilo?> >
											<input type="number" readonly class="form-control input-sm" name="total_gravado" id="total_gravado" value="<?=$total_gravado ?>" >
										</td>
									</tr>
									<tr>
										<td colspan="4" align="right" <?=$estilo ?> ><strong>Total Inafecto:</strong></td>
										<td colspan="2" align="right" <?=$estilo?> >
											<input type="number" readonly class="form-control input-sm" name="total_inafecto" id="total_inafecto" value="<?=$total_inafecto ?>" >
										</td>
									</tr>
									<tr>
										<td colspan="4" align="right" <?=$estilo ?> ><strong>Total Exonerado:</strong></td>
										<td colspan="2" align="right" <?=$estilo?> >
											<input type="number" readonly class="form-control input-sm" name="total_exonerado" id="total_exonerado" value="<?=$total_exonerado ?>" >
										</td>
									</tr>
									<tr>
										<td colspan="4" align="right" <?=$estilo ?> ><strong>Total Gratuito:</strong></td>
										<td colspan="2" align="right" <?=$estilo?> >
											<input type="number" readonly class="form-control input-sm" name="total_gratuito" id="total_gratuito" value="<?=$total_gratuito ?>" >
										</td>
									</tr>
									<tr>
										<td colspan="4" align="right" <?=$estilo ?> ><strong>Total Exportación:</strong></td>
										<td colspan="2" align="right" <?=$estilo?> >
											<input type="number" readonly class="form-control input-sm" name="total_exportacion" id="total_exportacion" value="<?=$total_exportacion ?>" >
										</td>
									</tr>
									<tr>
										<td colspan="4" align="right" <?=$estilo ?> ><strong>Descuentos:</strong></td>
										<td colspan="2" align="right" <?=$estilo?> >
											<input type="number" readonly class="form-control input-sm" name="total_descuento" id="total_descuento" value="<?=$total_descuento ?>" >
										</td>
									</tr>
								</table>		
							</td>
							<td colspan="2" align="right" <?=$estilo?> >
								<table>
									<tr>
										<td colspan="4" align="right" <?=$estilo ?> ><strong>SubTotal:</strong></td>
										<td colspan="2" align="right" <?=$estilo?> >
											<input type="number" readonly class="form-control input-sm" name="subtotal" id="subtotal" value="<?=$subtotal ?>" >
										</td>
									</tr>
									<tr>
										<td colspan="4" align="right" <?=$estilo ?> ><strong>Porcentaje IGV:</strong></td>
										<td colspan="2" align="right" <?=$estilo?> >
											<input type="number" readonly class="form-control input-sm" name="por_igv" id="por_igv" value="<?=$por_igv ?>" >
										</td>
									</tr>
									<tr>
										<td colspan="4" align="right" <?=$estilo ?> ><strong>IGV:</strong></td>
										<td colspan="2" align="right" <?=$estilo?> >
											<input type="number" readonly class="form-control input-sm" name="total_igv" id="total_igv" value="<?=$total_igv ?>" >
										</td>
									</tr>
									<tr>
										<td colspan="4" align="right" <?=$estilo ?> ><strong>ISC:</strong></td>
										<td colspan="2" align="right" <?=$estilo?> >
											<input type="number" readonly class="form-control input-sm" name="total_isc" id="total_isc" value="<?=$total_isc ?>" >
										</td>
									</tr>
									<tr>
										<td colspan="4" align="right" <?=$estilo ?> ><strong>Otros Impuestos:</strong></td>
										<td colspan="2" align="right" <?=$estilo?> >
											<input type="number" readonly class="form-control input-sm" name="total_otr_imp" id="total_otr_imp" value="<?=$total_otr_imp ?>" >
										</td>
									</tr>
									<tr>
										<td colspan="4" align="right" <?=$estilo ?> ><strong>Total:</strong></td>
										<td colspan="2" align="right" <?=$estilo?> >
											<input type="number" readonly class="form-control input-sm" name="total" id="total" value="<?=$total ?>" >
										</td>
									</tr>
								</table>		
							</td>
							<td><br><br><br><br><br><br><br>
								<input type='hidden' name='control' id='control' value='GuardarComprobante'>
								<button name="enviarEmail" id="enviarEmail" type="submit" class="btn btn-primary btn-sm" <?php if(isset($_SESSION['indice_comprobante_externo']) && isset($_SESSION['indice_cliente']) && $clientes[$indice_cliente]['email']!="" ) echo ""; else echo "disabled='true'" ?> >GUARDAR</button>
							</td>
						</tr>
					</form>	
				</table>
				</br>


		<li><strong>COMPROBANTES EMITIDOS: </strong><?="Impreso el: ".$hoy." - ".$hora?> </li>
			<ul class="list-unstyled">

				<table class="table table-condensed table-striped" >
					<tr>
						<td <?=$estilo?> ><strong>#</strong></td>
						<td <?=$estilo?> ><strong>Serie</strong></td>
						<td <?=$estilo?> ><strong>Correlativo</strong></td>
						<td <?=$estilo?> ><strong>Fecha y Hora</strong></td>
						<td <?=$estilo?> ><strong>DNI / RUC</strong></td>
						<td <?=$estilo?> ><strong>Nombres / Razón Social</strong></td>
						<td <?=$estilo?> ><strong>Subtotal</strong></td>
						<td <?=$estilo?> ><strong>Descuentos</strong></td>
						<td <?=$estilo?> ><strong>Impuestos</strong></td>
						<td <?=$estilo?> ><strong>Total</strong></td>
						<td <?=$estilo?> ><strong>XML</strong></td>
						<td <?=$estilo?> ><strong>PDF</strong></td>
						<td <?=$estilo?> ><strong>CDR</strong></td>
						<td <?=$estilo?> ><strong>Opciones</strong></td>
					</tr>
<?php
					$contador=0;
					if (isset($_SESSION['registrosDeVentas']) ) {
						$registrosDeVentas = $_SESSION['registrosDeVentas'];
//						print_r("<pre>");
//						print_r($registrosDeVentas);
//						print_r("</pre>");
						for ($i=0; $i < count($registrosDeVentas) ; $i++) {
								 
							$contador++;
							$serieYcorrelativoDeIngreso=str_pad($registrosDeVentas[$i]['serie'],4,"0",STR_PAD_LEFT)."-".str_pad($registrosDeVentas[$i]['correlativo'],8,"0",STR_PAD_LEFT);
							//BUSCAMOS SI EXISTEN LOS ARCHIVOS XML, PDF Y CDR DE LA BOLETA
							
							// XML EN LA CARPETA FIRMA, EL NOMBRE ES 20406231594-03-B001-00000021.XML
							$archivoXML='./../../sunat_archivos/sfs/FIRMA/20406231594-03-'.$serieYcorrelativoDeIngreso.'.XML';
							if (file_exists($archivoXML)) $vinculoXML="<a href='".$archivoXML."' target='_blank'> <img src='../../imagenes/XML.SVG' width='25'/></a>";
							else $vinculoXML='';				

							// CDR EN LA CARPETA RPTA, EL NOMBRE ES R20406231594-03-B001-00000026.ZIP
							$archivoCDR='./../../sunat_archivos/sfs/RPTA/R20406231594-03-'.$serieYcorrelativoDeIngreso.'.ZIP';
							if (file_exists($archivoCDR)) $vinculoCDR="<a href='".$archivoCDR."' target='_blank'> <img src='../../imagenes/CDR.SVG' width='25'/></a>";
							else $vinculoCDR='';				
							
							// PDF EN LA CARPETA REPO, EL NOMBRE ES 20406231594-03-B001-00000021.PDF
							$archivoPDF='./../../sunat_archivos/sfs/REPO/20406231594-03-'.$serieYcorrelativoDeIngreso.'.PDF';
							if (file_exists($archivoPDF)) $vinculoPDF="<a href='".$archivoPDF."' target='_blank'> <img src='../../imagenes/PDF.PNG' width='25'/></a>";
							else $vinculoPDF='';				
?>
							<tr>
								<td <?=$estilo?> ><?=$contador ?></strong></td>
								<td <?=$estilo?> ><?=str_pad($registrosDeVentas[$i]['serie'],4,"0",STR_PAD_LEFT) ?></td>
								<td <?=$estilo?> ><?=str_pad($registrosDeVentas[$i]['correlativo'],8,"0",STR_PAD_LEFT) ?></td>
								<td <?=$estilo?> ><?=$registrosDeVentas[$i]['fecha'] ?></td>
								<td <?=$estilo?> ><?php if ($registrosDeVentas[$i]['user_id']!='') echo $registrosDeVentas[$i]['cliente'][0]['dni']; if ($registrosDeVentas[$i]['personajuridica_id']!='') echo $registrosDeVentas[$i]['cliente'][0]['ruc']; ?></td>
								<td <?=$estilo?> ><?php if ($registrosDeVentas[$i]['user_id']!='') echo $registrosDeVentas[$i]['cliente'][0]['apellido_paterno']." ".$registrosDeVentas[$i]['cliente'][0]['apellido_materno'].", ".$registrosDeVentas[$i]['cliente'][0]['nombres']; 
														if ($registrosDeVentas[$i]['personajuridica_id']!='') echo $registrosDeVentas[$i]['cliente'][0]['razon_social']; ?></td>
								<td <?=$estilo?> align="right" ><?=$registrosDeVentas[$i]['total_gravado']+$registrosDeVentas[$i]['total_inafecto']+$registrosDeVentas[$i]['total_exonerado']+$registrosDeVentas[$i]['total_gratuito']+$registrosDeVentas[$i]['total_exportacion'] ?></td>
								<td <?=$estilo?> align="right" ><?=$registrosDeVentas[$i]['total_descuento'] ?></td>
								<td <?=$estilo?> align="right" ><?=$registrosDeVentas[$i]['total_igv']+$registrosDeVentas[$i]['total_isc']+$registrosDeVentas[$i]['total_otr_imp'] ?></td>
								<td <?=$estilo?> align="right" ><?=$registrosDeVentas[$i]['total'] ?></td>
								<td <?=$estilo?> align="right" ><?=$vinculoXML ?></td>
								<td <?=$estilo?> align="right" ><?=$vinculoPDF ?></td>
								<td <?=$estilo?> align="right" ><?=$vinculoCDR ?></td>
								<td <?=$estilo?> align="right" ></td>
							</tr>
<?php							
						}
					}
?>	
<?php
					if (isset($_SESSION['ingresos_antiguos']) ) {
						$ingresos_antiguos = $_SESSION['ingresos_antiguos'];
//						print_r("<pre>");
//						print_r($detalles);
//						print_r("</pre>");
						for ($i=0; $i < count($ingresos_antiguos) ; $i++) { 
							$contador++;
							$serieYcorrelativoDeIngreso=str_pad($ingresos_antiguos[$i]['serie'],4,"0",STR_PAD_LEFT)."-".str_pad($ingresos_antiguos[$i]['correlativo'],8,"0",STR_PAD_LEFT);
							//BUSCAMOS SI EXISTEN LOS ARCHIVOS XML, PDF Y CDR DE LA BOLETA
							
							// XML EN LA CARPETA FIRMA, EL NOMBRE ES 20406231594-03-B001-00000021.XML
							$archivoXML='./../../sunat_archivos/sfs/FIRMA/20406231594-03-'.$serieYcorrelativoDeIngreso.'.XML';
							if (file_exists($archivoXML)) $vinculoXML="<a href='".$archivoXML."' target='_blank'> <img src='../../imagenes/XML.SVG' width='25'/></a>";
							else $vinculoXML='';				

							// CDR EN LA CARPETA RPTA, EL NOMBRE ES R20406231594-03-B001-00000026.ZIP
							$archivoCDR='./../../sunat_archivos/sfs/RPTA/R20406231594-03-'.$serieYcorrelativoDeIngreso.'.ZIP';
							if (file_exists($archivoCDR)) $vinculoCDR="<a href='".$archivoCDR."' target='_blank'> <img src='../../imagenes/CDR.SVG' width='25'/></a>";
							else $vinculoCDR='';				
							
							// PDF EN LA CARPETA REPO, EL NOMBRE ES 20406231594-03-B001-00000021.PDF
							$archivoPDF='./../../sunat_archivos/sfs/REPO/20406231594-03-'.$serieYcorrelativoDeIngreso.'.PDF';
							if (file_exists($archivoPDF)) $vinculoPDF="<a href='".$archivoPDF."' target='_blank'> <img src='../../imagenes/PDF.PNG' width='25'/></a>";
							else $vinculoPDF='';				
?>
							<tr>
								<td <?=$estilo?> ><?=$contador ?></strong></td>
								<td <?=$estilo?> ><?=str_pad($ingresos_antiguos[$i]['serie'],4,"0",STR_PAD_LEFT) ?></td>
								<td <?=$estilo?> ><?=str_pad($ingresos_antiguos[$i]['correlativo'],8,"0",STR_PAD_LEFT) ?></td>
								<td <?=$estilo?> ><?=$ingresos_antiguos[$i]['fecha']." ".$ingresos_antiguos[$i]['hora'] ?></td>
								<td <?=$estilo?> ><?=$ingresos_antiguos[$i]['cliente'][0]['dni'] ?></td>
								<td <?=$estilo?> ><?=$ingresos_antiguos[$i]['cliente'][0]['apellido_paterno']." ".$ingresos_antiguos[$i]['cliente'][0]['apellido_materno'].", ".$ingresos_antiguos[$i]['cliente'][0]['nombres'] ?></td>
								<td <?=$estilo?> align="right" ><?=$ingresos_antiguos[$i]['monto'] ?></td>
								<td <?=$estilo?> align="right" ><?=$ingresos_antiguos[$i]['descuento'] ?></td>
								<td <?=$estilo?> align="right" >0</td>
								<td <?=$estilo?> align="right" ><?=$ingresos_antiguos[$i]['total'] ?></td>
								<td <?=$estilo?> align="right" ><?=$vinculoXML ?></td>
								<td <?=$estilo?> align="right" ><?=$vinculoPDF ?></td>
								<td <?=$estilo?> align="right" ><?=$vinculoCDR ?></td>
								<td <?=$estilo?> align="right" ></td>
							</tr>
<?php							
						}
					}
?>	
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

</script>
