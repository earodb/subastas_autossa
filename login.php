<?php
  include ("conexion/Conexion.php");

  $bd = new Conexion();
 
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

    <title>Iniciar sesión</title>

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
      if(isset($_POST["entrar"])){

        $user = $_POST["user"];
        $pass = $_POST["pass"];

        $query = "SELECT * from usuario where user='$user' and pass='$pass';";

        $result = $bd->select($query);

        if($result->num_rows > 0){

          while($row = $result->fetch_assoc()){
            $id_us = $row["id_usuario"];
            $nombre = $row["nombre"];
            $apellido = $row["apellido"];
            $id_tipouser = $row["id_tipouser"];

          }

          //echo "hoola";

          $_SESSION["id_usuario"] = $id_us;
          $_SESSION["nomb_comp"] = $nombre." ".$apellido;
          $_SESSION["id_tipoUser"] = $id_tipouser;
          header("Location: index.php");
        }else{
          echo "<script>alert('Datos incorrectos');</script>";
        }

      }
    ?>

     <div class="container h-100">
    <div class="row h-100   justify-content-center align-items-center">
      <div class="col-10 col-sm-10 col-md-8 col-lg-5 col-xl-5">
        <form method="post" action="" class="bg-light p-5 text-center rounded shadow">
          <div class="form-group">
            <img src="images/logoumg.png" height="100" width="100">
          </div>

          <div class="form-group">
              <!--<label for="exampleInputEmail1">Usuario</label>-->
            <div class="input-group mb-3">
              <div class="input-group-prepend ">
                <span class="input-group-text bg-secondary" id="basic-addon1"><img src="images/usuariocolor.png"></span>
              </div>
              <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Usuario" name="user" maxlength="15">
            </div>
            <!--<small id="emailHelp" class="form-text text-muted">Debes ingresar el usuario con el que te registraste.</small>-->
          </div>
          <br>
          <div class="form-group">
            <!--<label for="exampleInputPassword1">Contraseña</label>-->
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text bg-secondary" id="basic-addon1"><img src="images/passwordcolor.png"></span>
              </div>
              <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Contraseña" name="pass">
            </div>
          </div>
    
          <button type="submit" class="btn btn-primary" name="entrar">Iniciar Sesión</button><br><br>
          ¿No tienes una cuenta?<br>
          <a href="registro.php">Regístrate</a>
          <br><br>
          
          
        </form>
      </div>
    </div>
  </div>

 

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>


</body>

</html>






