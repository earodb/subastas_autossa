<?php
  include ("conexion/Conexion.php");
  //include ("Encryptar.php");
  $bd = new Conexion();
  //$enc = new Encryptar();
  session_start();
  if(!isset($_SESSION["id_usuario"])){
    header("Location: login.php");
  }

  if ($_SESSION["id_tipoUser"] == 2) {
    header("Location: index.php");
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

    <title>Agregar categoría</title>
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

    if(isset($_POST["agregar"])){

      $categoria = $_POST["categoria"];
      $descripcion = $_POST["descripcion"];

      $res = $bd->query("INSERT into categoria(categoria, descripcion) values('$categoria','$descripcion');");

      if($res==true){
        echo "<script>alert('Categoria agregada correctamente');</script>";
      }else{
        echo "<script>alert('No se pudo agregar categoria');</script>";
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
                            Categoria <small>Agregar nueva categoria</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <i class="fa fa-dashboard"></i> Panel de control
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="fa fa-tag"></i> Nueva categoria
                            </li>
                        </ol>
                    </div>
                </div>

                      <div class="row">

                          <div class="col-lg-6">

                            <form role="form" action="" method="post" enctype="multipart/form-data">

                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" name="categoria" class="form-control" required>
                                </div>

                                  <div class="form-group">
                                      <label>Descripcion</label>
                                      <textarea name="descripcion" class="form-control" required></textarea>
                                  </div>

                                  <button name="agregar" type="submit" class="btn btn-success">Agregar</button>
                                  <button type="reset" class="btn btn-danger">Cancelar</button>

                                  <br><br><br><br>

                                </form>
                          </div>

                      </div>
                      <!-- /.row -->



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


  

