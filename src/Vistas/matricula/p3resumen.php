<h3 align="center">Resultados del Proceso: <small>Matrícula Paso 3</small></h3>

<?php

if( isset($_SESSION['p3resultado']) ){
	echo "</br>";
	echo "</br>";
	echo "</br>";
	echo "Paso 3: ".$_SESSION['p3resultado'];
	echo "</br>";
	
	$_SESSION['p3periodos']= null;
	$_SESSION['p3periodo_id']=null;
	$_SESSION['p3grupos']=null;
	$_SESSION['p3grupo_id']=null;
	$_SESSION['p3alumnos']=null;
	$_SESSION['p3llave']=null;
	$_SESSION['p3cuentas']=null;
	$_SESSION['p3descuentos']=null;
	$_SESSION['p3padre']=null;
	$_SESSION['p3madre']=null;
	$_SESSION['p3apoderado']=null;
	$_SESSION['p3firmantes']=null;
	$_SESSION['p3resultado']=null;
	$_SESSION['p3pagosConfirmados']=null;
	$_SESSION['p3pagos']=null;
} else {
	echo "</br>";
	echo "Paso 3: ERROR CONSULTE CON EL ADMINISTRADOR";
	echo "</br>";
}
?>

