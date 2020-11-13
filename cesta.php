<?php
  include ("conexion/Conexion.php");
  //include ("Encryptar.php");
  $bd = new Conexion();
  //$enc = new Encryptar();
  session_start();
  if(!isset($_SESSION["id_usuario"])){
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

    <title>Cesta</title>
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
                          <?php 
                            if ($_SESSION["id_tipoUser"]==1) {
                              echo "<small>Automóviles vendidos</small>";
                            }else{
                              echo "<small>Automóviles adquiridos</small>";
                            }

                          ?>
                        </h1>
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item">
                              <i class="fa fa-dashboard"></i> Panel de control
                          </li>
                          <li class="breadcrumb-item active">
                              <i class="fa fa-shopping-cart"></i> Mi cesta
                          </li>
                        </ol>
                    </div>
                </div>

                <!-- Listado de subastas -->
                <div class="row">
                  <div class="col-lg-12">

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Imagen</th>
                                    <th>Nombre</th>
                                    <th>Estado</th>
                                    <th>Categoría</th>
                                    <th>Minimo</th>
                                    <th>Maximo</th>
                                    <th>Pagado</th>
                                </tr>
                            </thead>
                            <tbody>

                  <?php
                      //Inicia consulta de cestas
                      if ($_SESSION["id_tipoUser"]==1) {
                        $res0 = $bd->select("SELECT * from cesta");
                      }else{
                        $res0 = $bd->select("SELECT * from cesta where id_usuario=".$_SESSION["id_usuario"].";");
                      }
                      
                      if($res0->num_rows > 0){
                        while($row0 = $res0->fetch_assoc()){
                          $cesta = $row0["id_cesta"];
                          $sub = $row0["id_subasta"];

                          //echo "$cesta, $user, $sub<br>";

                          //Inicia consulta de subastas
                          $res = $bd->select("SELECT * from subasta where id_subasta=$sub order by id_subasta desc");
                          if($res->num_rows > 0){
                            while($row = $res->fetch_assoc()){
                              $min = $row["min"];
                              $max = $row["max"];
                              $ini = $row["tiempo_ini"];
                              $fin = $row["tiempo_fin"];
                              $id_auto = $row["id_auto"];

                              //Inicia consulta de producto de las subastas
                              $res2 = $bd->select("SELECT * from auto where id_auto=$id_auto");
                              if($res2->num_rows > 0){
                                while($row2 = $res2->fetch_assoc()){
                                  $marca_p = $row2["marca"];
                                  $linea_p = $row2["linea"];
                                  $estado_p = $row2["estado"];
                                  $imagen_p = $row2["imagenes"];
                                  $catego_p = $row2["id_categoria"];


                                  $img = json_decode($imagen_p,true);

                                  $foto1 = implode($img[0]);

                                  //Inicia consulta de categoria del producto
                                  $result = $bd->select("SELECT * from categoria where id_categoria=$catego_p");
                                  $categoria_arr = mysqli_fetch_array($result);
                                  $categoria = $categoria_arr["categoria"];

                                  //Inicia consulta de categoria del producto
                                  $result1 = $bd->select("SELECT * from oferta where id_subasta=$sub order by id_oferta desc limit 1");
                                  $oferta = mysqli_fetch_array($result1);
                                  $of_final = $oferta["oferta"];

                                  ?>


                                      <tr>
                                          <td width="180px"><center><img src="<?php echo "$foto1";?>" style="height: 80px;"></center></td>
                                          <td><?php echo "<b class='text-success'>$marca_p $linea_p</b>";?></td>
                                          <td><?php echo "<p class='text-info'>$estado_p</p>";?></td>
                                          <td><?php echo $categoria;?></td>
                                          <td><?php echo "Q".number_format($min);?></td>
                                          <td><?php echo "Q".number_format($max);?></td>
                                          <td><?php echo "<b class='text-danger'>Q".number_format($of_final)."</b>";?></td>
                                      </tr>


                                  <?php


                                }
                              }
                            }
                          }


                        }
                      }else{
                        echo "<h3>Cesta vacia</h3>";
                      }
                      //Termina consulta de subastas

                  ?>
                            </tbody>
                        </table>
                    </div>
                </div>
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

           

            