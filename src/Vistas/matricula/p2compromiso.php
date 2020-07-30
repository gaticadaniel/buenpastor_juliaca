<div name="menu">
	<ul class="nav nav-tabs nav-justified">
		<li><a href='#' onclick='javascript:document.form_p2alumnos.submit()'>Lista de Alumnos<?php if(isset($_SESSION['p2llave'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li class='active'><a href='#' onclick='javascript:document.form_p2compromiso.submit()'>Compromiso <?php if(isset($_SESSION['p2firmantes'])) echo "<span class='glyphicon glyphicon-ok'></span>"?></a></li>
		<li><a href='#' onclick='javascript:document.form_p2finalizar.submit()'>Finalizar</a></li>
	</ul>
	
	
	<form method='POST' name='form_p2alumnos' id='form_p2alumnos' action='../Controladores/MatriculaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='p2alumnos.php'>
	</form>
	<form method='POST' name='form_p2compromiso' id='form_p2compromiso' action='../Controladores/MatriculaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='p2compromiso.php'>
	</form>
	<form method='POST' name='form_p2finalizar' id='form_p2finalizar' action='../Controladores/MatriculaControl.php'>
		<input type='hidden' name='control' id='control' value='CambiarVista'>
		<input type='hidden' name='vista' id='vista' value='p2finalizar.php'>
	</form>
</div>

<?php 
date_default_timezone_set('America/Lima');
setlocale(LC_TIME, "Spanish");		
$fecha=strftime("Juliaca, %A %d de %B del %Y");
$hora=strftime("%H:%M");
//$user = $_SESSION['user'];

if ( isset($_SESSION['p2periodos']) and isset($_SESSION['p2periodo_id']) ){
	for ($i=0; $i < count($_SESSION['p2periodos']) ; $i++) { 
		if ($_SESSION['p2periodos'][$i]['id']==$_SESSION['p2periodo_id']) $periodo = $_SESSION['p2periodos'][$i]['periodo'];
	}
} else $periodo = "NO DEFINIDO";

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
			<h5><center><strong>ASOCIACIÓN EDUCATIVA DE GESTION NO ESTATAL</strong></center></h5>
			<h5><center><strong>“COLEGIO DE CIENCIAS BUEN PASTOR”</strong></center></h5>
			
			<h6><center><strong>R.D.N°2506-DREP / R.D.N°0795-2005-DUGE-SR</strong></center></h6>
			<br>
			<p style="text-align: center;"><span style="font-size: 12pt;"><strong>CONVENIO EDUCATIVO</strong></span>
			</p>
			<p>
				<strong>DECLARACI&Oacute;N JURADA DEL PADRE / MADRE DE FAMILIA O APODERADO</strong>
				<br />Conste por el presente documento, que en mi condici&oacute;n de padre, madre o apoderado del estudiante <?=$_SESSION['p2alumnos'][$_SESSION['p2llave']]['apellido_paterno']." ".$_SESSION['p2alumnos'][$_SESSION['p2llave']]['apellido_materno']." ".$_SESSION['p2alumnos'][$_SESSION['p2llave']]['nombres'] ?> con DNI <?=$_SESSION['p2alumnos'][$_SESSION['p2llave']]['dni'] ?>, en conformidad a lo establecido en los art&iacute;culos 3&deg;, 14&deg; de la Ley N&deg; 26548, concordante con el art&iacute;culo 5&deg; de la Ley de Promoci&oacute;n de la Inversi&oacute;n de la Educaci&oacute;n, Decreto Legislativo N&deg; 882 y conforme a lo establecido en las dem&aacute;s disposiciones legales vigentes, que han sido puestas en mi conocimiento, declaro lo siguiente:
			</p>
			<p>
				<strong>PRIMERO.- DECLARO MI CONFORMIDAD COMO PADRE, MADRE O APODERADO.</strong>
				<br />
				<strong>1.- DECLARO:</strong> Conocer y estar conforme con la informaci&oacute;n relacionada al costo del servicio educativo, as&iacute; como el marco doctrinal que sustenta la educaci&oacute;n del Colegio de Ciencias &ldquo;Buen Pastor&rdquo; y por tanto, sus fines y objetivos establecidos en el Reglamento Interno, expresando mi compromiso de observar y respetar dicho Marco Doctrinal y Reglamento mencionado.
				<br />
				<strong>2.- DECLARO:</strong> Conocer, que el monto de las pensiones de ense&ntilde;anza durante el a&ntilde;o 2019, podr&aacute;n ser incrementadas de acuerdo a las necesidades institucionales, la inflaci&oacute;n y/o aumento de precios de los bienes y servicios necesarios para la continuidad de la prestaci&oacute;n del servicio educativo, fundamentalmente con las pensiones de ense&ntilde;anza, que a su vez solventan el pago de remuneraciones del personal de docentes, administrativo, de servicio como: adquisici&oacute;n de bienes y pago de servicios.
				<br />
				<strong>3.- DECLARO:</strong> Conocer que el costo de un Seguro de Vida y/o Contra Accidentes, no est&aacute; incorporado en la pensi&oacute;n mensual de ense&ntilde;anza y que es nuestra responsabilidad como padres proveer de este seguro a nuestros hijos e informar oportunamente al colegio.
				<br />
				<strong>4.- DECLARO:</strong> Conocer que el colegio tiene la facultad de informar a las centrales de riesgo u otras instituciones como: INFOCORP, FISCAL&Iacute;A DE FAMILIA, DEFENSORIA DEL PUEBLO, UGEL SAN ROMAN y otras instituciones, las deudas por incumplimiento en el pago por el servicio educativo en la fecha convenida.
				<br />
				<strong>5.- DECLARO:</strong> Conocer que al inicio del a&ntilde;o escolar, el colegio contar&aacute; con el mobiliario en el aula solo para estudiantes matriculados, por lo que no debo enviar a mi menor hijo(a), sin antes haber concluido con el proceso de matr&iacute;cula y el Compromiso de Pago de ense&ntilde;anza.
				<br />
				<strong>6.- DECLARO:</strong> Conocer que nuestra participaci&oacute;n como padres de familia es fundamental para el logro de los objetivos educacionales y formativos, por lo que, asumo participar activamente en el proceso educativo de nuestro(a) menor hijo(a) como son:
				<br />
					<strong>a)</strong> Actividades acad&eacute;micas: presentarse en el momento de la matr&iacute;cula y actualizar los datos de mi hijo(a), recepci&oacute;n de libretas de notas, asistir a las reuniones convocadas por los directores, profesores y/o departamento psicopedag&oacute;gico, coordinaci&oacute;n de normas de convivencia, tutores, etc., seguir las recomendaciones dadas por las autoridades del Colegio (Directores, Docentes, Tutores y Psicolog&iacute;a).
					<br />
					<strong>b)</strong> Actividades formativas: escuela de padres, actividades religiosas.
					<br />
					<strong>c)</strong> Actividades recreativas: deportivas, culturales, cient&iacute;ficas, entre otras.
					<br />
				<strong>7.- DECLARO:</strong> Conocer que el colegio se reserva al derecho de modificar la plana docente por motivos de fuerza mayor o por disponibilidad del profesor, garantizando que la calidad del curso no se vea afectada.
				<br />
				<strong>8.- ACEPTO:</strong> Que, en caso que mi menor hijo(a), sea retirado(a) o trasladado(a) del colegio por cualquier motivo y en cualquier &eacute;poca del a&ntilde;o escolar, me comprometo expresamente a no efectuar peticiones o reclamos ante el colegio o entidad promotora del colegio, respecto a devoluciones de los pagos de matr&iacute;cula y pensiones de ense&ntilde;anza.
				<br />
				<strong>9.- ACEPTO:</strong> Que, en caso que mi hijo(a), ocasiones deterioros en contra del centro educativo (infraestructura, mobiliario, servicios higi&eacute;nicos, otros), me comprometo expresamente a responsabilizarme moral y econ&oacute;micamente por el da&ntilde;o ocasionado.
			</p>
			<p>
				<strong>SEGUNDO: COMPROMISO DE LOS PADRES DE FAMILIA O APODERADO.</strong>
				<br />
				<strong>1.- ASUMO:</strong> El compromiso de pagar puntualmente las pensiones de ense&ntilde;anza de mi menor hijo(a), ya que el incumplimiento en el pago de pensiones dar&aacute; lugar a un inter&eacute;s moratorio diario de 0.015%, el cual ser&aacute; abonado a las cuentas del Colegio de Ciencias &ldquo;Buen Pastor&rdquo; y de acuerdo a las disposiciones legales vigentes. El colegio de Ciencias &ldquo;Buen Pastor&rdquo;, tiene la facultad de retener la boleta de notas, los certificados de estudios correspondientes a periodos no pagados y en caso de mantener alguna deuda con el colegio, mi menor hijo(a), no ser&aacute; admitido en el proceso de matr&iacute;culas del pr&oacute;ximo a&ntilde;o (2019).
				<br />
				<strong>2.- ACEPTO:</strong> Que en caso de retrasarnos en el pago de pensiones a partir de 2 meses, debemos firmar una letra de cambio como garant&iacute;a de pago por el servicio educativo recibido. Adem&aacute;s el colegio podr&aacute; reportar autom&aacute;ticamente esta deuda a: UGEL SAN ROMAN, INFOCORP, DEMUNA, INDECOPI, DEFENSORIA DEL PUEBLO o LA FISCALIA DE FAMILIA, para la investigaci&oacute;n sobre el presunto abandono familiar, adem&aacute;s los Padres de Familia deudores, asumiremos los costos y costas (pago por cartas notariales, centros de conciliaciones, demandas y otros relacionados con la deuda).
				<br />
				<strong>3.- ME COMPROMETO:</strong> A no involucrar a la instituci&oacute;n educativa en procesos judiciales o extrajudiciales sobre asuntos de tenencia, difamaci&oacute;n y otros. Esto condicionar&aacute; mi permanencia como Padre de Familia en el Colegio de Ciencias &ldquo;Buen Pastor&rdquo;.
				<br />
				<strong>4.- ME COMPROMETO:</strong> A enviar a mi menor hijo(a) al Colegio respetando los horarios establecidos, portando la agenda escolar todos los d&iacute;as, caso contrario no se registrar&aacute; su asistencia; asimismo, a revisar y firmar diariamente dicha Agenda Escolar y/o Cuadernos de Avance.
				<br />
				<strong>5.- DECLARO CONOCER Y ACEPTO:</strong> Que el inicio de clases ser&aacute; el LUNES 5 DE MARZO DEL 2018 y en caso de haber paros de 48 o 72 hora, la Instituci&oacute;n Educativa no est&aacute; en la obligaci&oacute;n de recuperar las clases perdidas.
				<br />
				<strong>FINALMENTE: </strong>Acepto los t&eacute;rminos y condiciones del presente CONVENIO EDUCATIVO y las obligaciones econ&oacute;micas durante el a&ntilde;o escolar 2018.
			</p>
		</div>

	<br>
	<h4>SELECCIONAR FIRMANTES:<small> Mínimo 2 firmantes.</small></h4>	
<?php 
	if(isset($_SESSION['p2llave'])){
		if ($_SESSION['p2apoderado']==null)
			$class = "col-md-4";
		else
			$class = "col-md-3";
//		echo $class;
?>
	<form onsubmit="return Valida()" class="form-inline" role="form" name="form_firmantes" id="form_firmantes" method="POST" form action='../Controladores/MatriculaControl.php' >
		<div class="checkbox">
			<div class="<?=$class?>">
				<label>
					<input type="checkbox" name="firmantes[]" id="firmantes[]" value="Padre"><?=$_SESSION['p2padre'][0]['apellido_paterno']." ".$_SESSION['p2padre'][0]['apellido_materno'].", ".$_SESSION['p2padre'][0]['nombres']?> (Padre)
				</label>
			</div>
			<div class="<?=$class?>">
				<label>
					<input type="checkbox" name="firmantes[]" id="firmantes[]" value="Madre"><?=$_SESSION['p2madre'][0]['apellido_paterno']." ".$_SESSION['p2madre'][0]['apellido_materno']." ".$_SESSION['p2madre'][0]['nombres'] ?> (Madre)
				</label>
			</div>
<?php 	if ($_SESSION['p2apoderado']!=null){ ?>			
			<div class="<?=$class?>">
				<label>
					<input type="checkbox" name="firmantes[]" id="firmantes[]" value="Apoderado"><?=$_SESSION['p2apoderado'][0]['apellido_paterno']." ".$_SESSION['p2apoderado'][0]['apellido_materno']." ".$_SESSION['p2apoderado'][0]['nombres'] ?> (Apoderado)
				</label>
			</div>
<?php 	}	?>
			<div class="<?=$class?>">
				<label>
					<input type="checkbox" name="firmantes[]" id="firmantes[]" value="Alumno"><?=$_SESSION['p2alumnos'][$_SESSION['p2llave']]['apellido_paterno']." ".$_SESSION['p2alumnos'][$_SESSION['p2llave']]['apellido_materno']." ".$_SESSION['p2alumnos'][$_SESSION['p2llave']]['nombres'] ?> (Alumno)
				</label>
			</div>
		</div>
		<div class="col-md-12" align="right">
			<input type='hidden' name='control' id='control' value='ConfirmarCompromisoP2'>
			<button type="submit" class="btn btn-default">Listo</button>
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
		alert ('Selecciona por lo menos 02 firmantes!');
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
	if (j>1) return true;
	else return false;
}

function validacion() {
	alert("hola");
	elemento = form_firmantes.getElementById("firmantes[]");
	alert(elemento.length);
	return false;
}

</script>


