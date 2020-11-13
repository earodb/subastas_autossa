<?php
  include ("conexion/Conexion.php");
  //include ("Encryptar.php");
  $bd = new Conexion();
  //$enc = new Encryptar();
  session_start();
  if(isset($_SESSION["id_usuario"])){
    header("Location: index.php");
  }
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Registrarme</title>

    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">

    <style type="text/css">
      body{
        background: url(images/beige_paper.png );
      }
      body,html{
          height:100%;
      }
    </style>

</head>

<body>

    <?php
      if(isset($_POST["registro"])){
        //echo "<script>alert('Entrar');</script>";

        $correo = $_POST["correo"];
        $user = $_POST["user"];
        $pass = $_POST["pass"];

        $query = "INSERT into usuario(correo, user, pass,id_tipouser) values('$correo','$user','$pass',2);";

        $result = $bd->query($query);

        if($result == true){
          echo "<script>alert('Usuario registrado correctamente ve al login para que inicies sesion');</script>";
          //header("Location: login.php");
        }else{
          echo "<script>alert('No se pudo registrar el usuario');</script>";
        }

      }
    ?>

    <div class="container h-100">
        <div class="row h-100   justify-content-center align-items-center">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    
                    <div class="panel-body">
                        <form role="form" action="" method="post" class="bg-light p-5 text-center rounded shadow">
                            <div class="panel-heading">
                              <div class="row">
                                <div class="col-md-3">
                                  <img src="images/registro.png" width="65px">
                                </div>
                                <div class="col-md-9">
                                  <h3>Registrarme</h3>
                                </div>
                              </div>
                            </div>
                            <br>
                            <fieldset>

                                <div class="form-group">
                                    <input class="form-control" placeholder="Correo" name="correo" type="email" autofocus required>
                                </div>

                                <div class="form-group">
                                    <input class="form-control" placeholder="Usuario" name="user" type="text" required>
                                </div>

                                <div class="form-group">
                                    <input class="form-control" placeholder="Contraseña" name="pass" type="password" required>
                                </div>

                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" name="registro" class="btn btn-success btn-block" value="Registrarme">

                            </fieldset>
                            <br>
                            <div class="panel-footer">
                              <p>¿Ya estás registrado? <a href="login.php">Inicia sesión</a></p>
                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

</body>

</html>
