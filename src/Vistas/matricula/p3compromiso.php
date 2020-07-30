<div name="menu">
	<ul class="nav nav-tabs nav-justified">
		<li><a href='#' onclick='javascript:document.form_alumnos.submit()'>Lista de Alumnos<?php if(isset($_SESSION['p3llave'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_pagos.submit()'>Condiciones Económicas <?php if(isset($_SESSION['p3pagosConfirmados'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li class='active'><a href='#' onclick='javascript:document.form_compromiso.submit()'>Compromiso de Pago<?php if(isset($_SESSION['p3firmantes'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_finalizar.submit()'>Finalizar</a></li>
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
<?php ?>

<?php 
date_default_timezone_set('America/Lima');
setlocale(LC_TIME, "Spanish");		
$fecha=strftime("Juliaca, %A %d de %B del %Y");
$hora=strftime("%H:%M");
//$user = $_SESSION['user'];
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

?>

<div class="container">
<br>
<div style="border : solid 2px #000000;
            background : #F0F8FF;
            color : #696969;
            padding : 4px;
            width : auto;
            height : 310px;
            overflow : auto; ">
		<div class="col-md-12">
			<br>
			<p><center><strong>ASOCIACIÓN EDUCATIVA DE GESTION NO ESTATAL</strong></center></p>
			<p><center><strong>“COLEGIO DE CIENCIAS BUEN PASTOR”</strong></center></p>
			
			<p><center><strong>R.D.N°2506-DREP / R.D.N°0795-2005-DUGE-SR</strong></center></p>
			<br>
			<h5><center><strong>CONVENIO EDUCATIVO</strong></center></h5>
			<h5><center><strong> COMPROMISO DE PAGO <?php if ($periodo!="NO DEFINIDO") echo $periodo; ?></strong></center></h5>
			
			<ol>
				<li><strong>RESPONSABLE(S) FINANCIERO(S):</strong></li>

					<ul class="list-unstyled">
						<table class="table table-hover table-condensed">
							<tr>
								<td>APELLIDOS Y NOMBRES</td><td></td>
							</tr>
							<tr>
								<td>DNI</td><td></td>
							</tr>
							<tr>
								<td>DIRECCIÓN</td><td></td>
							</tr>
							<tr>
								<td>TELÉFONO(S)</td><td></td>
							</tr>
							<tr>
								<td>RELACIÓN CON EL ESTUDIANTE</td><td></td>
							</tr>
						</table>
					</ul>
				
				<li><strong>DATOS DEL ESTUDIANTE</strong></li>
					<ul class="list-unstyled">
						<table class="table table-hover table-condensed">
							<tr>
								<td>APELLIDOS Y NOMBRES</td>
								<td><?php if ($alumno!="NO DEFINIDO") echo $alumno['apellido_paterno']." ".$alumno['apellido_materno'].", ".$alumno['nombres']; ?></td>
							</tr>
							<tr>
								<td>DNI</td>
								<td><?php if ($alumno!="NO DEFINIDO") echo $alumno['dni']; ?></td>
							</tr>
							<tr>
								<td>DIRECCIÓN</td>
								<td><?php if ($alumno!="NO DEFINIDO") echo $alumno['direccion']; ?></td>
							</tr>
							<tr>
								<td>TELÉFONO(S)</td>
								<td><?php if ($alumno!="NO DEFINIDO") echo $alumno['movistar']."  ".$alumno['rpm']."  ".$alumno['claro']."  ".$alumno['otro']."  ".$alumno['fijo']; ?></td>
							</tr>
							<tr>
								<td>NIVEL</td>
								<td><?php if ($grupo!="NO DEFINIDO") echo $grupo['nivel']; ?></td>
							</tr>
							<tr>
								<td>GRADO</td>
								<td><?php if ($grupo!="NO DEFINIDO") echo $grupo['grado']; ?></td>
							</tr>
							<tr>
								<td>SECCIÓN</td>
								<td><?php if ($grupo!="NO DEFINIDO") echo $grupo['seccion']; ?></td>
							</tr>
						</table>
					</ul>
				<li><strong>SERVICIO EDUCATIVO</strong></li>
					<ul class="list-unstyled">
						<table class="table table-hover table-condensed">
<?php 					if( isset($_SESSION['p3cuentas']) and isset($_SESSION['p3pagos'])  ) {
							$cuentas = $_SESSION['p3cuentas'];
							$pagos = $_SESSION['p3pagos'];
							for ($k=0; $k < count($cuentas); $k++) {
								$acumulador = 0;
								$contador = 0;
//								echo "<br>".$cuentas[$k]['cuenta']."<br>";
								for ($i=0; $i < count($pagos); $i++) { 
									if ($pagos[$i]['cuenta']==$cuentas[$k]['cuenta']){
										$contador++;
										$acumulador+=$pagos[$i]['monto'];
//										echo $pagos[$i]['detalle'].$pagos[$i]['monto'] ;
//										echo $pagos[$i]['fecha_vencimiento'];
//										echo "<br>";
									}
								}
								$promedio = $acumulador/$contador;
?>
							<tr>
								<td>
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
								<td><?=$contador." cuota(s) de S/. ".$promedio.".00" ?></td>
							</tr>
<?php 						}
						}
?>
							<tr>
								<td>Certificado</td>
								<?php if ($grupo['nivel']=="Inicial") {?> <td>S/. 30.00</td> <?php }?>
								<?php if ($grupo['nivel']=="Primaria") {?> <td>S/. 40.00</td> <?php }?>
								<?php if ($grupo['nivel']=="Secundaria") {?> <td>S/. 50.00</td> <?php }?>
							</tr>
							<tr>
								<td>Traslado</td>
								<td>S/. 50.00</td>
							</tr>
							<tr>
								<td>Interes Moratorio (%)</td>
								<td>0.015 %</td>
							</tr>
							<tr>
								<td colspan="2"><?=$mensaje1 ?></td>
							</tr>
						</table>
					</ul>





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
								<td>
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
								<td><?=$descuento['descuento'] ?></td>
								<td><?=$descuento['porcentaje']."%" ?></td>
							</tr>
<?php 						}
						}
?>
							<tr>
								<td colspan="3"><?=$mensaje2 ?></td>
							</tr>
						</table>
					</ul>
				<li><strong>IMPORTANTE</strong></li>
					<ul class="list-unstyled">
						<li align="justify">Todos los importes están expresados en soles.</li>
						<li align="justify">Los descuentos no son acumulables.</li>
						<li align="justify">El colegio se reserva el derecho de realizar ajustes a los costos del servicio educativo.</li>
						<li align="justify">El colegio puede retener los certificados y/o boleta de notas correspondientes a períodos no pagados.</li>
					</ul>
			</ol>
		</div>
</div>
	<br>
	<h4>SELECCIONAR FIRMANTES:<small> Mínimo 1 firmantes.</small></h4>	
<?php 
	if(isset($_SESSION['p3llave'])){
		if ($_SESSION['p3apoderado']==null)
			$class = "col-md-4";
		else
			$class = "col-md-3";
?>
	<form onsubmit="return Valida()" class="form-inline" role="form" name="form_firmantes" id="form_firmantes" method="POST" form action='../Controladores/MatriculaControl.php' >
		<div class="checkbox">
			<div class="<?=$class?>">
				<label>
					<input type="checkbox" name="firmantes[]" id="firmantes[]" value="Padre"><?=$_SESSION['p3padre'][0]['apellido_paterno']." ".$_SESSION['p3padre'][0]['apellido_materno'].", ".$_SESSION['p3padre'][0]['nombres']?> (Padre)
				</label>
			</div>
			<div class="<?=$class?>">
				<label>
					<input type="checkbox" name="firmantes[]" id="firmantes[]" value="Madre"><?=$_SESSION['p3madre'][0]['apellido_paterno']." ".$_SESSION['p3madre'][0]['apellido_materno'].", ".$_SESSION['p3madre'][0]['nombres'] ?> (Madre)
				</label>
			</div>
<?php 	if ($_SESSION['p3apoderado']!=null){ ?>			
			<div class="<?=$class?>">
				<label>
					<input type="checkbox" name="firmantes[]" id="firmantes[]" value="Apoderado"><?=$_SESSION['p3apoderado'][0]['apellido_paterno']." ".$_SESSION['p3apoderado'][0]['apellido_materno'].", ".$_SESSION['p3apoderado'][0]['nombres'] ?> (Apoderado)
				</label>
			</div>
<?php 	}	?>
			<div class="<?=$class?>" align="right">
				<input type='hidden' name='control' id='control' value='ConfirmarCompromisoP3'>
				<button align="right" type="submit" class="btn btn-default" <?php if(!isset($_SESSION['p3pagosConfirmados'])) echo "disabled='disabled'"?> >Confirmar</button>
			</div>
		</div>
	</form>
<?php 
	}
?>

</div>

<script type="text/javascript">

function Valida(){
	if (IsChk('firmantes')){ //ok, hay al menos 1 elemento checkeado envía el form!
		return true;
	} else { //ni siquiera uno chequeado no envía el form
		alert ('Selecciona por lo menos 01 firmantes!');
		return false;
	}
}

function IsChk(chkName){
//	var found = false;
	var j=0;
	var chk = document.getElementsByName(chkName+'[]');
	for (var i=0 ; i < chk.length ; i++){
		//found = chk[i].checked ? true : found;
		if (chk[i].checked) j++;
	}
	if (j>=1) return true;
	else return false;
}

function validacion() {
	alert("hola");
	elemento = form_firmantes.getElementById("firmantes[]");
	alert(elemento.length);
	return false;
}

</script>