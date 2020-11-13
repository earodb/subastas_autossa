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
  //Se verifica si existe una variable get id si no redirecciona
  if(!$_GET["id"]){
    header("Location: subastas.php");
  }

  //Si no redirecciona guardamos la variable get en una variable
  $id_sub = $_GET["id"];
  $idAuto = $_GET["idAuto"]
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

    <title>Subasta</title>
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
      if (isset($_POST["ofertar"])) {
        //Si el usuario quiere ofertar por un producto
        $oferta = $_POST["oferta"];
        $id_user_1 = $_POST["id_user"];
        $id_sub_1 = $_POST["id_sub"];
        $max = $_POST["max"];
        $fecha_hora_actual = date("Y-m-d H:i:s");

          if($oferta == $max){
            //echo "<script>alert('$oferta, 0, $fecha_hora_actual, $id_sub_1, $id_user_1');</script>";
            $res_1 = $bd->query("INSERT into oferta(oferta, estado, fecha, id_subasta, comprador) values($oferta, 1, '$fecha_hora_actual',$id_sub_1, $id_user_1);");
            if($res_1 == false){
              echo "<script>alert('No se ha podido ofertar');</script>";
            }else{
              $res_2 = $bd->query("INSERT into cesta(id_usuario, id_subasta) values($id_user_1,$id_sub_1);");
              if($res_2 == false){
                echo "<script>alert('No se pudo agregar producto a la cesta');</script>";
              }else{
                $res_2_1 = $bd->query("UPDATE subasta set estado=1, comprador=$id_user_1 where id_subasta=$id_sub_1;");
                if($res_2_1 == false){
                  echo "<script>alert('No se pudo actualizar la subasta');</script>";
                }else{
                  echo "<script>alert('1... 2... 3... ¡VENDIDO!');</script>";
                }
              }
            }
          }else{
            //echo "<script>alert('Oferta hecha');</script>";
            $res_1 = $bd->query("INSERT into oferta(oferta, estado, fecha, id_subasta, comprador) values($oferta, 0, '$fecha_hora_actual',$id_sub_1, $id_user_1);");
            if($res_1 == false){
              echo "<script>alert('No se ha podido ofertar');</script>";
            }else{
              $res_2_1 = $bd->query("UPDATE subasta set comprador=$id_user_1 where id_subasta=$id_sub_1;");
              if($res_2_1 == false){
                echo "<script>alert('No se pudo actualizar la subasta');</script>";
              }else{
                echo "<script>alert('Oferta realizada con exito');</script>";
              }
            }
          }
      }elseif(isset($_POST["comprar"])){
        //echo "<script>alert('Vendido');</script>";
        //Si el usuario quiere comprar el producto pagando el monto maximo de la subasta
        $oferta = $_POST["max"];
        $id_user_1 = $_POST["id_user"];
        $id_sub_1 = $_POST["id_sub"];
        $max = $_POST["max"];
        $fecha_hora_actual = date("Y-m-d h:i:s");

          $res_1 = $bd->query("INSERT into oferta(oferta, estado, fecha, id_subasta, comprador) values($oferta, 1, '$fecha_hora_actual',$id_sub_1, $id_user_1);");
          if($res_1 == false){
            echo "<script>alert('No se ha podido ofertar');</script>";
          }else{
            $res_2 = $bd->query("INSERT into cesta(id_usuario, id_subasta) values($id_user_1,$id_sub_1);");
            if($res_2 == false){
              echo "<script>alert('No se pudo agregar producto a la cesta');</script>";
            }else{
              $res_2_1 = $bd->query("UPDATE subasta set estado=1, comprador=$id_user_1 where id_subasta=$id_sub_1;");
              if($res_2_1 == false){
                echo "<script>alert('No se pudo actualizar la subasta');</script>";
              }else{
                echo "<script>alert('1... 2... 3... ¡VENDIDO!');</script>";
              }
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
                          <small>Haz tu mejor oferta</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <i class="fa fa-comment"></i> Subastas
                            </li>
                            <li class="breadcrumb-item">
                                <i class="fa fa-comments"></i> Todas las subastas
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="fa fa-certificate"></i> Haz una oferta
                            </li>
                        </ol>
                    </div>
                </div>

                <!-- Listado de subastas -->
                <div class="row">

                  <?php
                      //Inicia consulta de subastas
                      $res = $bd->select("SELECT * from subasta where id_subasta=$id_sub");
                      if($res->num_rows > 0){
                        while($row = $res->fetch_assoc()){
                          $min = $row["min"];
                          $max = $row["max"];
                          $ini = $row["tiempo_ini"];
                          $fin = $row["tiempo_fin"];
                          $estado = $row["estado"];
                          $comprador = $row["comprador"];
                          $subastador = $row["subastador"];
                          $id_auto = $row["id_auto"];

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
                              $modelo_p = $row2["modelo"];
                              $imagen_p = $row2["imagenes"];
                              $descripcion_p = $row2["descripcion"];
                              $id_categoria = $row2["id_categoria"];

                              //Convertir la cadena Json a array
                              $img = json_decode($imagen_p,true);
                              //Acceder a la primera foto del array y convertirlo a string
                              $fotos = implode($img[0]);

                              //Inicia consulta de categoria del producto
                              $result = $bd->select("SELECT * from categoria where id_categoria=$id_categoria");
                              $categoria_arr = mysqli_fetch_array($result);
                              $categoria = $categoria_arr["categoria"];

                              //echo "$id_subasta, $min, $max, $ini, $fin, $comprador, $id_producto, $nombre_p, $imagen_p<br>";

                              $res_count=$bd->select("SELECT count(*) as total from oferta where id_subasta=$id_sub");
                              $data=mysqli_fetch_array($res_count);
                              $count_ofert = $data['total'];

                              $res3 = $bd->select("SELECT * from oferta where id_subasta=$id_sub order by id_oferta desc limit 1");
                              if($res3->num_rows > 0){
                                while($row3 = $res3->fetch_assoc()){
                                  $id_oferta = $row3["id_oferta"];
                                  $oferta = $row3["oferta"];
                                  $ofertante_comp = $row3["comprador"];

                                  //echo "$id_subasta, $min, $max, $ini, $fin, $comprador, $id_producto, $nombre_p, $imagen_p, $id_oferta, $oferta<br>";

                                  /*Aqui se mostraran los productos que tienen una oferta ya*/
                                  ?>
                                  <div class="col-sm-6 col-md-6">
                                      <?php
                                        //Aqui se mostrara la imagen del producto en grande
                                        echo "<img src='$fotos' style='max-height: 450px; width: 100%;'>";
                                      ?>
                                  </div>
                                  <div class="col-sm-6 col-md-6">
                                    <div class="thumbnail">
                                      <?php //echo "<img src='images/productos/$imagen_p' style='height: 220px;'>";?>
                                      <div class="caption">
                                        <?php
                                          if($estado == 1 && $ofertante_comp != null){
                                            echo "<h1 class='text-danger'>¡VENDIDO!</h1>";
                                          }
                                        ?>
                                        <h2 class="text-success"><?php echo $marca_p." ".$linea_p; ?></h2>
                                        <h4 class="text-info"><?php echo $modelo_p; ?></h4>
                                         <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#DetalleAuto">
                                                  Ver Detalles
                                              </button>
                                        <p class="text-warning text-right"><i class="fa fa-tag"></i> <?php echo $categoria; ?></p>
                                        <hr style="margin: 1px 1px 1px 1px;">

                                        <p>Producto publicado el <?php echo "<b>$ini</b>"; ?></p>
                                        <p><?php //print $interval->format('%R %a días %H horas %I minutos'); ?></p>

                                        <p id="tiempo"></p>
                                        <input type="hidden" id="limite" value="<?php echo $fin; ?>">

                                        <p><?php echo "<b>Ofertantes:</b> $count_ofert";?></p>
                                        <p><?php echo "<b>Oferta minima:</b> Q$min.00"; ?></p>
                                        <p><?php echo "<b>Oferta maxima:</b> Q$max.00"; ?></p>
                                        <h4>Oferta actual: <b class="text-danger"><?php echo "Q$oferta.00"; ?></b></h4>

                                        <form class="form-inline" action="" method="post">

                                          <input type="hidden" name="id_user" value="<?php echo $_SESSION['id_usuario']; ?>">
                                          <input type="hidden" name="id_sub" value="<?php echo $id_sub; ?>">
                                          <input type="hidden" name="max" value="<?php echo $max; ?>">
                                          <input type="hidden" name="fin" value="<?php echo $fin; ?>">

                                          <?php
                                            if($estado == 1 || $_SESSION["id_usuario"] == $ofertante_comp || $_SESSION["id_usuario"] == $subastador){
                                              ?>

                                              <div class="form-group">
                                                <input type="number" disabled name="oferta" max="<?php echo $max;?>" min="<?php echo $oferta+100;?>" class="form-control" value="<?php echo $oferta+100;?>">
                                              </div>
                                             
                                              <button type="submit" disabled class="btn btn-warning" name="ofertar">Mejorar oferta</button>
                                              <button type="submit" disabled class="btn btn-success" name="comprar">Comprar ahora</button>

                                              <?php
                                            }elseif($estado == 0){
                                              ?>
                                              <div class="form-group">
                                                <input type="number" name="oferta" max="<?php echo $max;?>" min="<?php echo $oferta+100;?>" class="form-control" value="<?php echo $oferta+100;?>">
                                              </div>

                                              <button type="submit" class="btn btn-warning" name="ofertar">Mejorar oferta</button>
                                              <button type="submit" class="btn btn-success" name="comprar">Comprar ahora</button>

                                             

                                              <?php
                                            }
                                          ?>


                                        </form>


                                      </div>
                                    </div>
                                  </div>
                                  <?php
                                  /*Fin de los productos que tienen una oferta ya*/

                                }
                              }else{
                                //echo "Registro sin ofertas aun<br>";

                                /*Aqui se mostraran los productos que aun no tienen oferta*/
                                ?>
                                      <div class="col-sm-6 col-md-6">
                                          <?php
                                            //Aqui se mostrara la imagen del producto en grande
                                            echo "<img src='$fotos' style='max-height: 450px; width: 100%;'>";
                                          ?>
                                      </div>
                                      <div class="col-sm-6 col-md-6">
                                        <div class="thumbnail">
                                          <?php //echo "<img src='images/productos/$imagen_p' style='height: 220px;'>";?>
                                          <div class="caption">
                                            <h2 class="text-success"><?php echo $marca_p." ".$linea_p; ?></h2>
                                            <h4 class="text-info"><?php echo $modelo_p; ?></h4>

                                           <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#DetalleAuto">
                                              Ver Detalles
                                          </button>

                                            <p class="text-warning text-right"><i class="fa fa-tag"></i> <?php echo $categoria; ?></p>
                                            <hr style="margin: 1px 1px 1px 1px;">
                                            <p>Producto publicado el <?php echo "<b>$ini</b>"; ?></p>
                                            <p><?php //print $interval->format('%R %a días %H horas %I minutos'); ?></p>

                                            <p id="tiempo"></p>
                                            <input type="hidden" id="limite" value="<?php echo $fin; ?>">

                                            <p><?php echo "<b>Oferta minima:</b> Q$min.00"; ?></p>
                                            <p><?php echo "<b>Oferta maxima:</b> Q$max.00"; ?></p>
                                            <h4>Oferta actual: <b class="text-danger"><?php echo "Q0.00"; ?></b></h4>

                                            <form class="form-inline" action="" method="post">

                                              <input type="hidden" name="id_user" value="<?php echo $_SESSION['id_usuario']; ?>">
                                              <input type="hidden" name="id_sub" value="<?php echo $id_sub; ?>">
                                              <input type="hidden" name="max" value="<?php echo $max; ?>">
                                              <input type="hidden" name="fin" value="<?php echo $fin; ?>">

                                              <?php
                                                if($_SESSION["id_usuario"] == $subastador){
                                                  ?>
                                                  <div class="form-group">
                                                    <input type="number" disabled name="oferta" class="form-control" max="<?php echo $max;?>" min="<?php echo $min;?>" value="<?php echo $min;?>">
                                                  </div>

                                                  <button type="submit" disabled class="btn btn-info" name="ofertar">Ofertar ahora</button>
                                                  <button type="submit" disabled class="btn btn-success" name="comprar">Comprar ahora</button>

                                                  <?php
                                                }else{
                                                  ?>
                                                  <div class="form-group">
                                                    <input type="number" name="oferta" class="form-control" max="<?php echo $max;?>" min="<?php echo $min;?>" value="<?php echo $min;?>">
                                                  </div>

                                                  <button type="submit" class="btn btn-info" name="ofertar">Ofertar ahora</button>
                                                  <button type="submit" class="btn btn-success" name="comprar">Comprar ahora</button>
                                                  <?php
                                                }
                                              ?>


                                            </form>


                                          </div>
                                        </div>
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
                        echo "<h3>Por el momento no existen subastas</h3>";
                      }
                      //Termina consulta de subastas

                  ?>

                </div>
                <!-- Fin de listado -->

                <!-- Modal -->
                <div class="modal fade" id="DetalleAuto" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Ficha Técnica del Automóvil</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                      
                      <div class="container-fluid">
                        <div class="row">
                          
                            <?php  
                            $DatosAuto = $bd->select("SELECT * from auto where id_auto=$idAuto");

                            while ($fila = mysqli_fetch_array($DatosAuto)) {
                             
                              $id_auto = $fila['id_auto'];
                              $marca = $fila['marca'];
                              $linea = $fila['linea'];
                              $modelo = $fila['modelo'];
                              $num_motor = $fila['num_motor'];
                              $num_chasis = $fila['num_chasis'];
                              $num_cilindros = $fila['num_cilindros'];
                              $cc = $fila['cc'];
                              $tipo_transmision = $fila['tipo_transmision'];
                              $estado = $fila['estado']; 
                              $imagenes = $fila['imagenes']; 

                              $image = json_decode($imagenes,true);

                              



                              ?>
                              <div class="col-sm-12 col-md-12 col-lg-4">
                              <table class="table">
                                <thead class="thead-dark">
                                  <tr>
                                    <th scope="col">Característica</th>
                                    <th scope="col">Detalle</th>  
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                      <th>Marca</th>
                                      <td><?php  echo $marca; ?></td>
                                  </tr>
                                  <tr>
                                      <th>Línea</th>
                                      <td><?php  echo $linea; ?></td>
                                  </tr>
                                   <tr>
                                      <th>Modelo</th>
                                      <td><?php  echo $modelo; ?></td>
                                  </tr>
                                  <tr>
                                      <th>Número de motor</th>
                                      <td><?php  echo $num_motor; ?></td>
                                  </tr>
                                  <tr>
                                      <th>Número de chasis</th>
                                      <td><?php  echo $num_chasis; ?></td>
                                  </tr>
                                   <tr>
                                      <th>Número de cilindros</th>
                                      <td><?php  echo $num_cilindros; ?></td>
                                  </tr>
                                  <tr>
                                      <th>Centímeros cúbicos</th>
                                      <td><?php  echo $cc; ?></td>
                                  </tr>
                                   <tr>
                                      <th>Tipo de transmisión</th>
                                      <td><?php  echo $tipo_transmision; ?></td>
                                  </tr>
                                  <tr>
                                      <th>Estado</th>

                                      <?php 
                                      if ($estado == "Nuevo") {
                                          echo "<th class='text-success'>$estado</th>";
                                      }elseif ($estado == "Usado") {
                                          echo "<th class='text-warning'>$estado</th>";
                                      }elseif ($estado == "Chocado") {
                                          echo "<th class='text-danger'>$estado</th>";
                                      }

                                      ?>
                                                          
                                  </tr>
                                </tbody>
                              </table>
                              </div>

                              <div class="col-lg-8 col-md-12 col-sm-12">

                                <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                                  <ol class="carousel-indicators">
                                    <?php 
                                      $i = 0;
                                      foreach ($image as $value) {
                                          $actives = '';
                                          if ($i == 0) {
                                            $actives = 'active';
                                          }
                                         

                                     ?>
                                    <li data-target="#carouselExampleCaptions" data-slide-to="<?= $i;  ?>" class="<?= $actives  ?>"></li>

                                    <?php $i++; } ?>
                                    
                                  </ol>
                                  <div class="carousel-inner">
                                    
                                <?php 
                                      $i = 0;
                                      foreach ($image as $value) {
                                        $fotosAuto = $value['foto']; 
                                          $actives = '';
                                          if ($i == 0) {
                                            $actives = 'active';
                                          }
                                         

                                     ?>
                                
                                    <div class="carousel-item <?= $actives;  ?>">
                                      <img src="<?php echo $fotosAuto ?>" class="d-block w-100" alt="...">
                                     <!-- <div class="carousel-caption d-none d-md-block">
                                        <h5>First slide label</h5>
                                        <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                                      </div> -->
                                    </div>
                                 <?php $i++; }
                                 ?>
                                    

                                    

                                  </div>
                                  <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                  </a>
                                  <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                  </a>
                                </div>
                                
                                
                              </div>
                              
                      <?php } ?> 
                          
                          
                        </div>
                      </div>
                      

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>  
                        </div>  
                      </div>
                    </div>
                  </div>
                </div>




        </main>
      </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="bootstrap/js/jquery-3.5.1.slim.min.js"></script> 
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

     <script>
      //Se le define el tiempo de ejecucion - al segundo
      setInterval("tiempo()",1000);

      function tiempo(){
        $.post("ajax/tiempo_regresivo.php",{tiempo_limite:$("#limite").val()}, function(data){

            $("#tiempo").html(data);

        });

      }
    </script>
   
  </body>
</html>


            
   
