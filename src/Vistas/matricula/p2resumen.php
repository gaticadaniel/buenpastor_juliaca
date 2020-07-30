<h3 align="center">Resultados del Proceso: <small>Matrícula Paso 2</small></h3>

<?php

if( isset($_SESSION['p2resultado']) ){
	echo "</br>";
	echo "</br>";
	echo "</br>";
	echo "Paso 2: ".$_SESSION['p2resultado'];
	echo "</br>";
	
	$_SESSION['p2periodos']= null;
	$_SESSION['p2periodo_id']=null;
	$_SESSION['p2grupos']=null;
	$_SESSION['p2grupo_id']=null;
	$_SESSION['p2alumnos']=null;
	$_SESSION['p2llave']=null;
	$_SESSION['p2padre']=null;
	$_SESSION['p2madre']=null;
	$_SESSION['p2apoderado']=null;
	$_SESSION['p2firmantes']=null;
	$_SESSION['p2resultado']=null;
} else {
	echo "</br>";
	echo "Paso 2: ERROR CONSULTE CON EL ADMINISTRADOR";
	echo "</br>";
}


?>

