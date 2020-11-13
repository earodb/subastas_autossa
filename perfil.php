<?php
  //Se incluye el archivo Conexion.php que contiene la clase usada para la conexion a la bd
  include ("conexion/Conexion.php");
  //Se crea el objeto conexion
  $bd = new Conexion();
  //Se inicia la sesion o se propaga
  session_start();
  //Condicion que no deja entrar al index a menos que exista una variable de session
  if(!isset($_SESSION["id_usuario"])){
    //Redirecciona al login
    header("Location: login.php");
  }
?>

<html !doctype>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/dashboard.css">

    <title>Mi perfil</title>
  </head>

  <body>
    <?php 
      include('nav.php');           
    ?>

    <div class="container-fluid">
      
      <div class="row">
        <?php     
          include('lateral.php');
        ?>  
               
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4"><div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>

          <?php

    if(isset($_POST["guardar"])){

      $id_usuario = $_POST["id_usuario"];
      $nombre = $_POST["nombre"];
      $apellido = $_POST["apellido"];
      $edad = $_POST["edad"];
      //$foto = $_POST["foto"];
      $correo = $_POST["correo"];
      $user = $_POST["user"];
      $pass = $_POST["pass"];

      $foto = $_FILES["foto"]["name"];
      $ruta = $_FILES["foto"]["tmp_name"];

      if($foto == null){
        echo "<script>alert('Foto vacia (Continuaras con la misma foto)');</script>";

        $res = $bd->query("UPDATE usuario set nombre='$nombre', apellido='$apellido', edad='$edad',
                          correo='$correo', user='$user', pass='$pass' where id_usuario=$id_usuario;");

        if($res==true){
          echo "<script>alert('Datos modificados correctamente');</script>";
          $_SESSION["nomb_comp"] = $nombre." ".$apellido;
        }else{
          echo "<script>alert('No se modificaron los datos');</script>";
        }

      }else{
        echo "<script>alert('Tu nueva foto sera modificada o agregada');</script>";

        $dest = "images/";
        copy($ruta,$dest.''.$foto);

        $res = $bd->query("UPDATE usuario set nombre='$nombre', apellido='$apellido', edad='$edad',
                          foto='$foto', correo='$correo', user='$user', pass='$pass' where id_usuario=$id_usuario;");

        if($res==true){
          echo "<script>alert('Datos modificados correctamente');</script>";
          $_SESSION["nomb_comp"] = $nombre." ".$apellido;
        }else{
          echo "<script>alert('No se modificaron los datos');</script>";
        }
      }

    }

  ?>


            <?php
              include ("header.php");
            ?>
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Perfil <small>Datos personales</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <i class="fa fa-dashboard"></i> Consola
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="fa fa-user"></i> Perfil
                            </li>
                        </ol>
                    </div>
                </div>

                <?php
                  $id_user = $_SESSION["id_usuario"];
                  $res = $bd->select("SELECT * from usuario where id_usuario=$id_user");

                  if($res->num_rows == 1){
                    while($row = $res->fetch_assoc()){
                      $id_usuario = $row["id_usuario"];
                      $nombre = $row["nombre"];
                      $apellido = $row["apellido"];
                      $edad = $row["edad"];
                      $foto = $row["foto"];
                      $correo = $row["correo"];
                      $user = $row["user"];
                      $pass = $row["pass"];

                      ?>
                      <div class="row">
                        <div class="col">
                          <?php if ($foto==NULL){ ?>
                            <img src="images/user.png" class="img-thumbnail rounded mx-auto d-block" style="height: 220px;">
                          <?php }else{ ?>
                             <img src="images/<?php echo $foto ?>" class="img-thumbnail rounded mx-auto d-block" style="height: 220px;">  

                         <?php } ?>
                          
                         

                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col-lg-6">
                        <form role="form" action="" method="post" enctype="multipart/form-data">

                          

                                  <div class="form-group">
                                      <label>Id</label>
                                      <input type="text" name="id_usuario" class="form-control" readonly value="<?php echo $id_usuario; ?>">
                                  </div>

                                  <div class="form-group">
                                      <label>Nombre</label>
                                      <input type="text" name="nombre" class="form-control" value="<?php echo $nombre; ?>">
                                  </div>

                                  <div class="form-group">
                                      <label>Apellido</label>
                                      <input type="text" name="apellido" class="form-control" value="<?php echo $apellido; ?>">
                                  </div>

                                  <div class="form-group">
                                      <label>Edad</label>
                                      <input type="number" name="edad" class="form-control" value="<?php echo $edad; ?>">
                                  </div>

                        </div>
                        <div class="col-lg-6">

                                  <div class="form-group">
                                      <label>Foto</label>
                                      <input type="file" name="foto">
                                  </div>

                                  <div class="form-group">
                                      <label>Correo</label>
                                      <input type="email" name="correo" class="form-control" value="<?php echo $correo; ?>" required>
                                  </div>

                                  <div class="form-group">
                                      <label>Usuario</label>
                                      <input type="text" name="user" class="form-control" value="<?php echo $user; ?>" required>
                                  </div>

                                  <div class="form-group">
                                      <label>Contraseña</label>
                                      <input type="text" name="pass" class="form-control" value="<?php echo $pass; ?>" required>
                                  </div>

                                  <br>

                                  <button name="guardar" type="submit" class="btn btn-success">Guardar</button>
                                  <button type="reset" class="btn btn-danger">Cancelar</button>

                          

                        </form>
                        </div>

                      </div>
                      <!-- /.row -->

                      <?php
                    }
                  }
                ?>


        </main>
      </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="bootstrap/js/jquery-3.5.1.slim.min.js"></script> 
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
   
  </body>
</html>


  


