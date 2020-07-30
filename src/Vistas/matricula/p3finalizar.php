<div name="menu">
	<ul class="nav nav-tabs nav-justified">
		<li><a href='#' onclick='javascript:document.form_alumnos.submit()'>Lista de Alumnos<?php if(isset($_SESSION['p3llave'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_pagos.submit()'>Condiciones Económicas <?php if(isset($_SESSION['p3pagosConfirmados'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_compromiso.submit()'>Compromiso de Pago<?php if(isset($_SESSION['p3firmantes'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li class='active'><a href='#' onclick='javascript:document.form_finalizar.submit()'>Finalizar</a></li>
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
date_default_timezone_set('America/Lima');
setlocale(LC_TIME, "Spanish");		
$fecha=strftime("Juliaca, %A %d de %B del %Y");
$hora=strftime("%H:%M");
$estilo = "style='color:#000000;font-size:60%;FONT-FAMILY:Arial,Helvetica,sans-serif'";

if ( isset($_SESSION['p3periodos']) and isset($_SESSION['p3periodo_id']) ){
	for ($i=0; $i < count($_SESSION['p3periodos']) ; $i++) { 
		if ($_SESSION['p3periodos'][$i]['id']==$_SESSION['p3periodo_id']) $periodo = $_SESSION['p3periodos'][$i]['periodo'];
	}
} else $periodo = "NO DEFINIDO";

if ( isset($_SESSION['p3alumnos']) and isset($_SESSION['p3llave']) ) $alumno = $_SESSION['p3alumnos'][$_SESSION['p3llave']];
else $alumno = "NO DEFINIDO";

if ( isset($_SESSION['p3grupos']) and isset($_SESSION['p3grupo_id']) ){
	for ($i=0; $i < count($_SESSION['p3grupos']) ; $i++) { 
		if ($_SESSION['p3grupos'][$i]['id']==$_SESSION['p3grupo_id']) $grupo = $_SESSION['p3grupos'][$i];
	}
} else $grupo = "NO DEFINIDO";


$imprimirPadre="No";
$imprimirMadre="No";
$imprimirApoderado="No";

if(isset($_SESSION['p3firmantes'])){
	$firmantes = $_SESSION['p3firmantes'];
	for ($i=0; $i < count($firmantes); $i++) { 
		if ($firmantes[$i]=="Padre") $imprimirPadre="Si";
		if ($firmantes[$i]=="Madre") $imprimirMadre="Si";
		if ($firmantes[$i]=="Apoderado") $imprimirApoderado="Si";
	}
}
//echo "Padre: ".$imprimirPadre." Madre: ".$imprimirMadre." Apoderado: ".$imprimirApoderado." Alumno: ".$imprimirAlumno;
?>

<div class="container">
	<br>	
	<div id="ImprimirCompromiso" name="ImprimirCompromiso" style="border : solid 2px #000000;
            background : #F0F8FF;
            color : #696969;
            padding : 4px;
            width : auto;
            height : 310px;
            overflow : auto; ">
		<div class="col-md-12">
			<FONT FACE="tahoma" size="1">
			<h5 style="FONT-SIZE:9px; COLOR:#000000; LINE-HEIGHT:1px; FONT-FAMILY:Arial,Helvetica,sans-serif"><center><strong>ASOCIACIÓN EDUCATIVA DE GESTION NO ESTATAL</strong></center></h5>
			<h5 style="FONT-SIZE:9px; COLOR:#000000; LINE-HEIGHT:1px; FONT-FAMILY:Arial,Helvetica,sans-serif"><center><strong>“COLEGIO DE CIENCIAS BUEN PASTOR”</strong></center></h5>
			<h5 style="FONT-SIZE:9px; COLOR:#000000; LINE-HEIGHT:1px; FONT-FAMILY:Arial,Helvetica,sans-serif"><center><strong>R.D.N°2506-DREP / R.D.N°0795-2005-DUGE-SR</strong></center></h5>
			<h5 style="FONT-SIZE:15px; COLOR:#000000; LINE-HEIGHT:10px; FONT-FAMILY:Arial,Helvetica,sans-serif"><center><strong>CONVENIO EDUCATIVO</strong></center></h5>
			<h5 style="FONT-SIZE:9px; COLOR:#000000; LINE-HEIGHT:1px; FONT-FAMILY:Arial,Helvetica,sans-serif"><center><strong>COMPROMISO DE PAGO <?php if ($periodo!="NO DEFINIDO") echo $periodo; ?></strong></center></h5>
			
			<ol>
				<li><strong>RESPONSABLE(S) FINANCIERO(S):</strong></li>

					<ul class="list-unstyled">
<?php 					if($imprimirPadre=="Si" ){	?>
						<table class="table table-hover table-condensed">
							<tr>
								<td width="300" <?=$estilo?> >RELACIÓN CON EL ESTUDIANTE</td>
								<td width="200" <?=$estilo?> >PADRE</td>
							</tr>
							<tr>
								<td <?=$estilo?> >APELLIDOS Y NOMBRES</td>
								<td <?=$estilo?> ><?=$_SESSION['p3padre'][0]['apellido_paterno']." ".$_SESSION['p3padre'][0]['apellido_materno']." ".$_SESSION['p3padre'][0]['nombres'] ?></td>
							</tr>
							<tr>
								<td <?=$estilo?> >DNI</td>
								<td <?=$estilo?> ><?=$_SESSION['p3padre'][0]['dni'] ?></td>
							</tr>
							<tr>
								<td <?=$estilo?> >DIRECCIÓN</td>
								<td <?=$estilo?> ><?=$_SESSION['p3padre'][0]['direccion'] ?></td>
							</tr>
							<tr>
								<td <?=$estilo?> >TELÉFONO(S)</td>
								<td <?=$estilo?> ><?=$_SESSION['p3padre'][0]['movistar']." ".$_SESSION['p3padre'][0]['rpm']." ".$_SESSION['p3padre'][0]['claro']." ".$_SESSION['p3padre'][0]['otro']." ".$_SESSION['p3padre'][0]['fijo'] ?></td>
							</tr>
						</table>
						<br>
<?php 					}	?>

<?php 					if($imprimirMadre=="Si" ){	?>
						<table class="table table-hover table-condensed">
							<tr>
								<td <?=$estilo?> >RELACIÓN CON EL ESTUDIANTE</td>
								<td <?=$estilo?> >MADRE</td>
							</tr>
							<tr>
								<td width="300" <?=$estilo?> >APELLIDOS Y NOMBRES</td>
								<td width="200" <?=$estilo?> ><?=$_SESSION['p3madre'][0]['apellido_paterno']." ".$_SESSION['p3madre'][0]['apellido_materno']." ".$_SESSION['p3madre'][0]['nombres'] ?></td>
							</tr>
							<tr>
								<td <?=$estilo?> >DNI</td>
								<td <?=$estilo?> ><?=$_SESSION['p3madre'][0]['dni'] ?></td>
							</tr>
							<tr>
								<td <?=$estilo?> >DIRECCIÓN</td>
								<td <?=$estilo?> ><?=$_SESSION['p3madre'][0]['direccion'] ?></td>
							</tr>
							<tr>
								<td <?=$estilo?> >TELÉFONO(S)</td>
								<td <?=$estilo?> ><?=$_SESSION['p3madre'][0]['movistar']." ".$_SESSION['p3madre'][0]['rpm']." ".$_SESSION['p3madre'][0]['claro']." ".$_SESSION['p3madre'][0]['otro']." ".$_SESSION['p3madre'][0]['fijo'] ?></td>
							</tr>
						</table>
						<br>
<?php 					}	?>

<?php 					if($imprimirApoderado=="Si" ){	?>
						<table class="table table-hover table-condensed">
							<tr>
								<td <?=$estilo?> >RELACIÓN CON EL ESTUDIANTE</td>
								<td <?=$estilo?> >APODERADO</td>
							</tr>
							<tr>
								<td width="300" <?=$estilo?> >APELLIDOS Y NOMBRES</td>
								<td width="200" <?=$estilo?> ><?=$_SESSION['p3apoderado'][0]['apellido_paterno']." ".$_SESSION['p3apoderado'][0]['apellido_materno']." ".$_SESSION['p3apoderado'][0]['nombres'] ?></td>
							</tr>
							<tr>
								<td <?=$estilo?> >DNI</td>
								<td <?=$estilo?> ><?=$_SESSION['p3apoderado'][0]['dni'] ?></td>
							</tr>
							<tr>
								<td <?=$estilo?> >DIRECCIÓN</td>
								<td <?=$estilo?> ><?=$_SESSION['p3apoderado'][0]['direccion'] ?></td>
							</tr>
							<tr>
								<td <?=$estilo?> >TELÉFONO(S)</td>
								<td <?=$estilo?> ><?=$_SESSION['p3apoderado'][0]['movistar']." ".$_SESSION['p3apoderado'][0]['rpm']." ".$_SESSION['p3apoderado'][0]['claro']." ".$_SESSION['p3apoderado'][0]['otro']." ".$_SESSION['p3apoderado'][0]['fijo'] ?></td>
							</tr>
						</table>
						<br>
<?php 					}	?>

					</ul>
				
				<li><strong>DATOS DEL ESTUDIANTE</strong></li>
					<ul class="list-unstyled">
						<table class="table table-hover table-condensed">
							<tr>
								<td width="300" <?=$estilo?> >APELLIDOS Y NOMBRES</td>
								<td width="200" <?=$estilo?> ><?php if ($alumno!="NO DEFINIDO") echo $alumno['apellido_paterno']." ".$alumno['apellido_materno'].", ".$alumno['nombres']; ?></td>
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
							<tr>
								<td <?=$estilo?> >NIVEL</td>
								<td <?=$estilo?> ><?php if ($grupo!="NO DEFINIDO") echo $grupo['nivel']; ?></td>
							</tr>
							<tr>
								<td <?=$estilo?> >GRADO</td>
								<td <?=$estilo?> ><?php if ($grupo!="NO DEFINIDO") echo $grupo['grado']; ?></td>
							</tr>
							<tr>
								<td <?=$estilo?> >SECCIÓN</td>
								<td <?=$estilo?> ><?php if ($grupo!="NO DEFINIDO") echo $grupo['seccion']; ?></td>
							</tr>
						</table>
					</ul>
					<br>
				<li><strong>SERVICIO EDUCATIVO</strong></li>
					<ul class="list-unstyled">
						<table class="table table-hover table-condensed">
<?php 					if( isset($_SESSION['p3cuentas']) and isset($_SESSION['p3pagos'])  ) {
							$cuentas = $_SESSION['p3cuentas'];
							$pagos = $_SESSION['p3pagos'];
							for ($k=0; $k < count($cuentas); $k++) {
								$acumulador = 0;
								$contador = 0;
								for ($i=0; $i < count($pagos); $i++) { 
									if ($pagos[$i]['cuenta']==$cuentas[$k]['cuenta']){
										$contador++;
										$acumulador+=$pagos[$i]['monto'];
									}
								}
								$promedio = $acumulador/$contador;
?>
							<tr>
								<td <?=$estilo?>>
<?php 								if($cuentas[$k]['cuenta']=="Ensenanza") {
										echo "Enseñanza (*)"; 
										$mensaje1 = "(*) PAGO OPORTUNO: Si pagas dentro de los 7 días del siguiente mes";
									} elseif ($cuentas[$k]['cuenta']=="Vacacional") {
										echo "Ciclo Vacacional (**)";
										$mensaje1 = "";
									} else {
										echo $cuentas[$k]['cuenta'];
										$mensaje1 = "";
									}
?>
								</td>
								<td <?=$estilo?> ><?=$contador." cuota(s) de S/. ".$promedio.".00" ?></td>
							</tr>
<?php 						}
						}
?>
							<tr>
								<td <?=$estilo?> >Certificado</td>
								<?php if ($grupo['nivel']=="Inicial") {?> <td <?=$estilo?> >S/. 30.00</td> <?php }?>
								<?php if ($grupo['nivel']=="Primaria") {?> <td <?=$estilo?> >S/. 40.00</td> <?php }?>
								<?php if ($grupo['nivel']=="Secundaria") {?> <td <?=$estilo?> >S/. 50.00</td> <?php }?>
							</tr>
							<tr>
								<td <?=$estilo?> >Traslado</td>
								<td <?=$estilo?> >S/. 50.00</td>
							</tr>
							<tr>
								<td <?=$estilo?> >Interes Moratorio (%)</td>
								<td <?=$estilo?> >0.015 %</td>
							</tr>
							<tr>
								<td colspan="2" <?=$estilo?> ><?=$mensaje1 ?></td>
							</tr>
						</table>
					</ul>
					<br>
				<li><strong>DESCUENTOS</strong></li>
					<ul class="list-unstyled">
						<table class="table table-hover table-condensed">
<?php 					if( isset($_SESSION['p3cuentas']) and isset($_SESSION['p3descuentos'])  ) {
							$cuentas = $_SESSION['p3cuentas'];
							$descuentos = $_SESSION['p3descuentos'];
							for ($k=0; $k < count($cuentas); $k++) {
								for ($i=0; $i < count($descuentos); $i++) { 
									if ($descuentos[$i]['cuenta']==$cuentas[$k]['cuenta'] and $descuentos[$i]['seleccion']==1){
										$descuento=$descuentos[$i];
									}
								}
?>
							<tr>
								<td <?=$estilo?> >
<?php 								if($cuentas[$k]['cuenta']=="Ensenanza") {
										echo "Enseñanza (*)";
										if ($descuento['porcentaje']>0)
											$mensaje2 = "(*) Los descuentos en ENSEÑANZA solo se aplican bajo la modalidad de PAGO OPORTUNO (dentro los 7 días del siguiente mes).";
										else
											$mensaje2 = "(*) El COLEGIO DE CIENCIAS BUEN PASTOR premia tu PUNTUALIDAD: Accede a un descuento de S/. 10.00 en ENSEÑANZA pagando bajo la modalidad de PAGO OPORTUNO.";													 
									} elseif ($cuentas[$k]['cuenta']=="Vacacional") {
										echo "Ciclo Vacacional (**)";
										$mensaje2 = "(**) Los descuentos en el CICLO VACACIONAL se aplican si efectúa el pago total antes del 20-01-2017";
									} else {
										echo $cuentas[$k]['cuenta'];
										$mensaje2 = "";
									}
?>
								</td>
								<td <?=$estilo?> ><?=$descuento['descuento'] ?></td>
								<td <?=$estilo?> ><?=$descuento['porcentaje']."%" ?></td>
							</tr>
<?php 						}
						}
?>
							<tr>
								<td colspan="3" <?=$estilo?> ><?=$mensaje2 ?></td>
							</tr>
						</table>
					</ul>
					<br>
				<li><strong>IMPORTANTE</strong></li>
					<ul class="list-unstyled">
						<li align="justify">Todos los importes están expresados en soles.</li>
						<li align="justify">Los descuentos no son acumulables.</li>
						<li align="justify">El colegio se reserva el derecho de realizar ajustes a los costos del servicio educativo.</li>
						<li align="justify">El colegio puede retener los certificados y/o boleta de notas correspondientes a períodos no pagados.</li>
					</ul>
			</ol>

			<p align="right"><?=$fecha?></p>
			<p align="right"><?=$hora?></p>
			<br>
			<br>
		</div>
	<br>
	<br>
	
	
	<table align="center" >
		<tr>
<?php 
	if( $imprimirPadre=="Si" ){
?>
			<td width="300">
				<FONT FACE="arial narrow" size="1">
					<hr align="center" noshade="noshade" width="80%" />
					<p align="center" style="line-height: 10%;"><?=$_SESSION['p3padre'][0]['apellido_paterno']." ".$_SESSION['p3padre'][0]['apellido_materno']." ".$_SESSION['p3padre'][0]['nombres'] ?></p>
					<p align="center" style="line-height: 10%;"><?="DNI ".$_SESSION['p3padre'][0]['dni'] ?></p>
					<p align="center" style="line-height: 10%;"><?=$_SESSION['p3padre'][0]['role'] ?></p>
				</FONT>
			</td>
			<td width="100">
				<FONT FACE="arial narrow" size="1">
					<br>
					<br>
					<br><br><br>
					<p align="center" style="line-height: 10%;">Huella Digital</p>
				</FONT>
			</td>
<?php 
	}
	if( $imprimirMadre=="Si" ){
?>
			<td width="300">
				<FONT FACE="arial narrow" size="1">
					<hr align="center" noshade="noshade" width="80%" />
					<p align="center" style="line-height: 10%;"><?=$_SESSION['p3madre'][0]['apellido_paterno']." ".$_SESSION['p3madre'][0]['apellido_materno']." ".$_SESSION['p3madre'][0]['nombres'] ?></p>
					<p align="center" style="line-height: 10%;"><?="DNI ".$_SESSION['p3madre'][0]['dni'] ?></p>
					<p align="center" style="line-height: 10%;"><?=$_SESSION['p3madre'][0]['role'] ?></p>
				</FONT>
			</td>
			<td width="100">
				<FONT FACE="arial narrow" size="1">
					<br>
					<br>
					<br><br><br>
					<p align="center" style="line-height: 10%;">Huella Digital</p>
				</FONT>
			</td>
<?php 
	}
	if( $imprimirApoderado=="Si" ){
?>
			<td width="300">
				<FONT FACE="arial narrow" size="1">
					<hr align="center" noshade="noshade" width="80%"  style="line-height: 10%;"/>
					<p align="center" style="line-height: 10%;"><?=$_SESSION['p3apoderado'][0]['apellido_paterno']." ".$_SESSION['p3apoderado'][0]['apellido_materno']." ".$_SESSION['p3apoderado'][0]['nombres'] ?></p>
					<p align="center" style="line-height: 10%;"><?="DNI ".$_SESSION['p3apoderado'][0]['dni'] ?></p>
					<p align="center" style="line-height: 10%;"><?=$_SESSION['p3apoderado'][0]['role'] ?></p>
				</FONT>
			</td>
			<td width="100">
				<FONT FACE="arial narrow" size="1">
					<br>
					<br>
					<br><br><br>
					<p align="center" style="line-height: 10%;">Huella Digital</p>
				</FONT>
			</td>
<?php 
	}
?>
		</tr>
	</table>
	<br><br>
	<p align="right" ="navbar-text">Usuario: <?=$user[0]['username']?></p>
	</FONT>
	</div>
<br>
	<div class="col-md-6" align="right">
			<button type="submit" class="btn btn-default" onclick="imprimir();" <?php if(!isset($_SESSION['p3firmantes'])) echo "disabled='disabled'"?> >Imprimir</button>
	</div>
	<div class="col-md-6" align="right">
		<form class="form-inline" role="form" name="form_firmantes" id="form_firmantes" method="POST" form action='../Controladores/MatriculaControl.php' >
			<input type='hidden' name='control' id='control' value='FinalizarP3'>
			<button type="submit" class="btn btn-default" <?php if(!isset($_SESSION['p3firmantes'])) echo "disabled='disabled'"?> >Finalizar</button>
		</form>
	</div>
</div>

<script type="text/javascript">
	function imprimir(){
		var objeto=document.getElementById('ImprimirCompromiso');  //obtenemos el objeto a imprimir
		var ventana=window.open('','_blank');  //abrimos una ventana vacía nueva
		ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
		ventana.document.close();  //cerramos el documento
		ventana.print();  //imprimimos la ventana
		ventana.close();  //cerramos la ventana
	}
</script>