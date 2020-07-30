MATRICULA REALIZADA CON EXITO...

<?php
// CONFIGURA EL NUMERO DE COLUMNAS A MOSTRAR EN LA PRESENTACION
echo "</br>";
echo "Alumno: ".$_SESSION['alumnoMatri'];
echo "</br>";
echo "Padre: ".$_SESSION['padreMatri'];
echo "</br>";
echo "Madre: ".$_SESSION['madreMatri'];
echo "</br>";
echo "Apoderado: ".$_SESSION['apoderadoMatri'];
echo "</br>";
echo "Matricula: ".$_SESSION['grupoMatri'];


$_SESSION['alumnoMatri']=null;
$_SESSION['padreMatri']=null;
$_SESSION['madreMatri']=null;
$_SESSION['apoderadoMatri']=null;
$_SESSION['periodoMatri']=null;
$_SESSION['grupoMatri']=null;

$_SESSION['alumnoMatricula']=null;
$_SESSION['padreMatricula']=null;
$_SESSION['madreMatricula']=null;
$_SESSION['apoderadoMatricula']=null;
$_SESSION['periodosMatricula']=null;
$_SESSION['gruposMatricula']=null;

?>
