<!DOCTYPE html>
<html lang="es">

<head>
    <title>Identifíquese...</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!--     link anteriores comentados para mejorar el diseño  
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen"> 
    <link href="css/login.css" rel="stylesheet" media="screen"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> 
    <script src="js/bootstrap.min.js"></script> 
-->
    <link rel="icon" href="imagenes/logo/insignia_bp.png">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
   
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  
 
</head>

<body class="hold-transition login-page">


    <div class="login-box">
        <div class="login-logo">
            <p><b>ACCEDER AL SISTEMA</b></p>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Colegio de Ciencias Buen Pastor  V  </p>

            <form name="login" id="login" action="src/Controladores/UsersControl.php" method="post">
                <div class="form-group has-feedback">
                    <input type="text" name="username" id="username" class="form-control" placeholder="Usuario" required/>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Contraseña" required/>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <input type="hidden" name="control" id="control" value="validar">

                <?php if(isset($_GET['mensaje'])){ ?>
                <div class="alert alert-danger">
                    <?=$_GET['mensaje']?>
                </div>
                <?php } ?>

                <center><input type="submit" class="btn btn-primary btn-lg " value="Conectarse"></center>

            </form>

        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

</body>


</html>
