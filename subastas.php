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

    <title>Lista Subastas</title>
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
              include ("header.php");
            ?>
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                          <small>Todas las subastas disponibles</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <i class="fa fa-comment"></i> Subastas
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="fa fa-comments"></i> Todas las subastas
                            </li>
                        </ol>
                    </div>
                </div>

                <!-- Listado de subastas -->
                <div class="row justify-content-md-center">

                  <?php
                      //Inicia consulta de subastas
                      $res = $bd->select("SELECT * from subasta where estado=0 order by id_subasta desc");
                      if($res->num_rows > 0){
                        while($row = $res->fetch_assoc()){
                          $id_subasta = $row["id_subasta"];
                          $min = $row["min"];
                          $max = $row["max"];
                          $ini = $row["tiempo_ini"];
                          $fin = $row["tiempo_fin"];
                          $comprador = $row["comprador"];
                          $id_auto = $row["id_auto"];

                          date_default_timezone_set('America/Guatemala');
                          $datetime_actual = date("Y-m-d H:i:s");
                          $datetime1 = date_create($datetime_actual);
                          $datetime2 = date_create($fin);
                          $interval = $datetime1->diff($datetime2);

                          //Inicia consulta de producto de las subastas
                          $res2 = $bd->select("SELECT * from auto where id_auto=$id_auto");
                          if($res2->num_rows > 0){
                            while($row2 = $res2->fetch_assoc()){
                              $marca_p = $row2["marca"];
                              $linea_p = $row2["linea"];
                              $imagen_p = $row2["imagenes"];

                              //Convertir la cadena Json a array
                              $img = json_decode($imagen_p,true);
                              //Acceder a la primera foto del array y convertirlo a string
                              $fotos = implode($img[0]);

                              //echo "$id_subasta, $min, $max, $ini, $fin, $comprador, $id_producto, $nombre_p, $imagen_p<br>";

                              $res3 = $bd->select("SELECT * from oferta where id_subasta=$id_subasta order by id_oferta desc limit 1");
                              if($res3->num_rows > 0){
                                while($row3 = $res3->fetch_assoc()){
                                  $id_oferta = $row3["id_oferta"];
                                  $oferta = $row3["oferta"];

                                  //echo "$id_subasta, $min, $max, $ini, $fin, $comprador, $id_producto, $nombre_p, $imagen_p, $id_oferta, $oferta<br>";

                                  /*Aqui se mostraran los productos que tienen una oferta ya*/
                                  ?>
                                        <div class="col-sm-6 col-md-4 col-lg-4">
                                          <div class="img-thumbnail">
                                            <?php echo "<img src='$fotos' class='rounded mx-auto d-block img-fluid' style='height: 220px;'>";?>
                                            <div class="caption">
                                              <h3><?php echo $marca_p." ".$linea_p; ?></h3>
                                              <p><?php print $interval->format('%a días %H horas %I minutos'); ?></p>
                                              <p><?php echo "Q$min.00 - Q$max.00"; ?></p>
                                              <h4>Oferta actual: <b class="text-danger"><?php echo "Q$oferta.00"; ?></b></h4>
                                              <?php echo "<p><a href='subasta.php?id=$id_subasta&idAuto=$id_auto' class='btn btn-success btn-block' role='button'>Mejorar oferta</a></p>";?>
                                            </div>
                                          </div>
                                          <br>
                                        </div>
                                  <?php
                                  /*Fin de los productos que tienen una oferta ya*/

                                }
                              }else{
                                //echo "Registro sin ofertas aun<br>";

                                /*Aqui se mostraran los productos que aun no tienen oferta*/
                                ?>
                                      <div class="col-sm-6 col-md-4 col-lg-4">
                                        <div class="img-thumbnail">
                                          <?php echo "<img src='$fotos' class='rounded mx-auto d-block img-fluid' style='height: 220px;'>";?>
                                          <div class="caption">
                                            <h3><?php echo $marca_p." ".$linea_p; ?></h3>
                                            <p><?php print $interval->format('%a días %H horas %I minutos'); ?></p>
                                            <p><?php echo "Q$min.00 - Q$max.00"; ?></p>
                                            <h4>Oferta actual: <b class="text-danger"><?php echo "Q0.00"; ?></b></h4>
                                            <?php echo "<p><a href='subasta.php?id=$id_subasta&idAuto=$id_auto' class='btn btn-info btn-block' role='button'>Primero en ofertar</a></p>";?>
                                          </div>
                                        </div>
                                        <br>
                                      </div>
                                <?php
                                /*Fin de los productos que no tienen oferta*/
                              }

                            }
                          }else{
                            echo "<h4>Hubo un error al recuperar el producto</h4>";
                          }
                          //Termina consulta de producto de la subasta
                        }
                      }else{
                        echo "<div class='col text-center'>
                                <div class='alert alert-warning' role='alert'>
                                  No existen subastas
                                </div>
                              </div>";
                      }
                      //Termina consulta de subastas

                  ?>

                </div>
                <!-- Fin de listado -->


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
 
           

