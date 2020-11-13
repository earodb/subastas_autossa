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

    <title>Subastas cerradas</title>
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
               <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                          <small>Subastas cerradas</small>
                        </h1>
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item">
                              <i class="fa fa-dashboard"></i>  Panel de control
                          </li>
                          <li class="breadcrumb-item active">
                              <i class="fa fa-tasks"></i>subastas cerradas
                          </li>
                        </ol>
                    </div>
                </div>
           <div class="col-lg-12">

                    <div class="table-responsive">
                     
                      <hr>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Imagen</th>
                                    <th>Nombre</th>
                                    <th>Categoria</th>
                                    <th>Pagado</th>
                                    <th>Comprador</th>
                                </tr>
                            </thead>
                            <tbody>

                  <?php

                          //Inicia consulta de subastas
                          $iduser = $_SESSION['id_usuario'];
                          $res = $bd->select("SELECT * from subasta where subastador=$iduser and estado=1 order by id_subasta desc");
                          if($res->num_rows > 0){
                            while($row = $res->fetch_assoc()){
                              $sub = $row["id_subasta"];
                              $min = $row["min"];
                              $max = $row["max"];
                              $ini = $row["tiempo_ini"];
                              $fin = $row["tiempo_fin"];
                              $id_auto = $row["id_auto"];
                              $comprador = $row["comprador"];

                              //Inicia consulta de producto de las subastas
                              $res2 = $bd->select("SELECT * from auto where id_auto=$id_auto");
                              if($res2->num_rows > 0){
                                while($row2 = $res2->fetch_assoc()){
                                  $marca_p = $row2["marca"];
                                  $linea_p = $row2["linea"];
                                  $imagen_p = $row2["imagenes"];
                                  $catego_p = $row2["id_categoria"];

                                  $img2 = json_decode($imagen_p,true);

                                  $f1 = implode($img2[0]);

                                  //Inicia consulta de categoria del producto
                                  $result = $bd->select("SELECT * from categoria where id_categoria=$catego_p");
                                  $categoria_arr = mysqli_fetch_array($result);
                                  $categoria = $categoria_arr["categoria"];

                                  //Inicia consulta de oferta final del producto
                                  $result1 = $bd->select("SELECT * from oferta where id_subasta=$sub order by id_oferta desc limit 1");
                                  $oferta = mysqli_fetch_array($result1);
                                  $of_final = $oferta["oferta"];

                                    //Inicia consulta de comprador del producto
                                  $result2 = $bd->select("SELECT nombre,apellido from usuario where id_usuario=$comprador");
                                  $compr = mysqli_fetch_array($result2);
                                  $nombre = $compr["nombre"];
                                  $apellido = $compr["apellido"];

                                
                                    // print_r($comp);
                                  
                                 


                                  ?>


                                      <tr>
                                          <td width="180px">
                                            <center>
                                              <a href="<?php echo "subasta.php?id=$sub&idAuto=$id_auto"; ?>">
                                                <img src="<?php echo "$f1";?>" style="height: 80px;">
                                              </a>
                                            </center>
                                          </td>
                                          <td><?php echo "<b class='text-success'>$marca_p $linea_p</b>";?></td>
                                          <td><?php echo $categoria;?></td>
                                          <td><?php echo "<b class='text-danger'>Q$of_final.00</b>";?></td>
                                          <?php 

                                          if ($comprador==0) {
                                            echo "<td>Sin comprador</td>";
                                          }else{
                                            echo "<td>$nombre $apellido</td>";
                                          } 
                                          ?>
                                      </tr>


                                  <?php


                                }
                              }
                            }
                          }

                      //Termina consulta de subastas

                  ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Termina subastas mias que ya fueron vendidas -->


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