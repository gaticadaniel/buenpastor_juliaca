<?php
session_start();
$vista = $_SESSION['vista'];


//$user = $_SESSION['user'];
//echo $vista;
//header('Content-Type: text/html; charset=ISO-8859-1');
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <title>BP Virtual</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="icon" href="../../imagenes/logo/insignia_bp.png">
  <!--=====================================
   PLUGINS DE CSS
  ======================================-->
    <!-- Bootstrap 3.3.7 (MAQUETACION Y DISEÑO) -->
    <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="../../bower_components/select2/dist/css/select2.min.css">
    <!-- Theme style (MAQUETACION Y DISEÑO) -->
    <link rel="stylesheet" href="../../dist/css/AdminLTE.css">
    <!-- Font Awesome (MAQUETACION Y DISEÑO) -->
    <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons (MAQUETACION Y DISEÑO ICONOS) -->
    <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
    <!-- AdminLTE Skins (MAQUETACION Y DISEÑO) -->
    <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">
    <!-- Google Font (LETRAS)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/responsive.bootstrap.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../../bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="../../dist/css/tablas.css">

  <!--=====================================
  PLUGINS DE JAVASCRIPT
  ======================================-->
    <!-- jQuery 3 -->
    <script src="../../bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick (DISPOSITIVOS TACTILES) -->
    <script src="../../bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App (DISEÑO Y MAQUETACION) -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- DataTables (TABLAS DINAMICAS) -->
    <script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../../bower_components/datatables.net-bs/js/dataTables.responsive.min.js"></script>
    <script src="../../bower_components/datatables.net-bs/js/responsive.bootstrap.min.js"></script>
    <!-- SweetAlert 2 (Notificaciones)-->
    <script src="../../plugins/sweetalert2/sweetalert2.all.js"></script>
    <!-- Select2 -->
    <script src="../../bower_components/select2/dist/js/select2.full.min.js"></script>
    <!-- date-range-picker -->
    <script src="../../bower_components/moment/min/moment.min.js"></script>
    <script src="../../bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>  
  </head>

  <body>

    <div class="hold-transition sidebar-collapse ">

      <div class="panel panel-warning">
                
        <div class="panel-heading">

          <?php include 'menu.php'; ?>

        </div>

        <div class="panel-body">
<?php 
	        if(isset($_SESSION['error'])){ 	
		       echo "<div class='alert alert-danger'> <center><h3>".$_SESSION['error']."</h3></center></div>";
		       $_SESSION['error']=null;
	        } 
	        if(isset($_SESSION['alerta'])){ 	
		       echo "<div class='alert alert-warning'> <center><h3>".$_SESSION['alerta']."</h3></center></div>";
		       $_SESSION['alerta']=null;
	        } 
	        if(isset($_SESSION['mensaje'])){ 	
		       echo "<div class='alert alert-success'> <center><h3>".$_SESSION['mensaje']."</h3></center></div>";
		       $_SESSION['mensaje']=null;
	        } 
?>
	        <?php include $vista; ?>
        </div>

        <footer class="main-footer">
            
          <center>
            <strong>© 2016 Colegio de Ciencias Buen Pastor.</strong> Dirección: Jirón San Martín 421 - 
            Juliaca Teléfono: 051-331756
          </center>

        </footer>

      </div>

    </div>
        <script src="../../js/horario.js"></script>
        <script src="../../js/grupoHorario.js"></script>
        <script src="../../js/telefonos.js"></script>
        <script src="../../js/fechas.js"></script>
        <script src="../../js/horas.js"></script>
  </body>

</html>
