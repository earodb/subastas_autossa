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

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"> 
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/dashboard.css">
    <script src="js/plotly-latest.min.js"></script>

    <title>Panel de control</title>
  </head>
  <body>
            <?php 
                include('nav.php');   
            ?>
    <div class="container-fluid">
      
   <div class="row mt-3">
              <?php 
               
                include('lateral.php');
            ?>  
               <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4"><div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                

                <?php if ($_SESSION['id_tipoUser']==1){
    
                //Se incluye el archivo que contiene el header
                  include ("header.php");
            
                  //Se hacen los count que se mostraran en la pantalla principal
                  //Count para las subastas disponibles
                  $res_count=$bd->select("SELECT count(*) as total from subasta");
                  $data=mysqli_fetch_array($res_count);
                  $count_sub = $data['total'];//En esta variable se guardan el total

                 
                  //Count para las subastas propias activas
                  $res_count=$bd->select("SELECT count(*) as total from subasta where estado=0");
                  $data=mysqli_fetch_array($res_count);
                  $count_sub_act = $data['total'];//En esta variable se guardan el total

                  //Count para las subastas propias cerradas
                  $res_count=$bd->select("SELECT count(*) as total from subasta where estado=1");
                  $data=mysqli_fetch_array($res_count);
                  $count_sub_cerr = $data['total'];//En esta variable se guardan el total

                  //Contar el total de dinero de las subastas concretadas.
                  $res_dinero=$bd->select("SELECT sum(oferta) as total from oferta where estado=1");
                  $data=mysqli_fetch_array($res_dinero);
                  $count_dinero = $data['total'];
                ?>
             
                  <div class="row row-cols-3 mb-3">
                    <div class="col-12 col-lg-6 mt-2">
                      <div class="card" style="height: 33.5rem;">
                        <div class="card-header bg-dark text-white text-center">
                          <strong>Estado de autos subastados</strong>
                        </div>
                        <div class="card-body">
                              <div id="cargabarras"></div>
                        </div>
                      </div> 
                    </div>

                    <div class="col-12 col-lg-3 mt-2">
                      <div class="row">
                        <div class="col">
                           <div class="card">
                        <div class="card-header text-center font-weight-bold bg-dark text-white">
                          Total subastas
                        </div>
                        <div class="card-body">
                          <h1 class="card-title text-center"><?php echo $count_sub;//Aqui se imprime el total?></h1>
                          <p class="card-text"></p>
                          <div class="col-xs-3 text-center">
                                  <i class="fa fa-th-list fa-5x"></i>
                              </div>
                          <a href="total_subastas.php" class="btn btn-primary">Ver detalles</a>
                        </div>
                      </div>
                        </div>
                         <div class="w-100"></div>

                        <div class="col mt-3">
                          <div class="card">
                        <div class="card-header text-center font-weight-bold bg-dark text-white">
                          Total ingresos
                        </div>
                        <div class="card-body">
                          <h1 class="card-title text-center"><?php echo "Q".number_format($count_dinero);//Aqui se imprime el total?></h1>
                          <p class="card-text"></p>
                          <div class="col-xs-3 text-center">
                                  
                                  <i class="fa fa-money fa-5x"></i>

                                 
                              </div>
                          <a href="cesta.php" class="btn btn-primary">Ver detalles</a>
                        </div>
                      </div>
                        </div>
                      </div>
                    </div>
                   
                    <div class="col-12 col-lg-3 mt-2">
                      <div class="row">
                        <div class="col">
                           <div class="card">
                        <div class="card-header text-center font-weight-bold bg-success text-white">
                          Subastas activas
                        </div>
                        <div class="card-body">
                          <h1 class="card-title text-center"><?php echo $count_sub_act;//Aqui se imprime el total?></h1>
                          <p class="card-text"></p>
                          <div class="col-xs-3 text-center">
                                  <i class="fa fa-unlock fa-5x"></i>
                              </div>
                          <a href="subastas.php" class="btn btn-primary">Ver detalles</a>
                        </div>
                      </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col mt-3">
                            <div class="card">
                        <div class="card-header text-center font-weight-bold bg-danger text-white">
                          Subastas cerradas
                        </div>
                        <div class="card-body">
                          <h1 class="card-title text-center"><?php echo $count_sub_cerr;//Aqui se imprime el total?></h1>
                          <p class="card-text"></p>
                          <div class="col-xs-3 text-center">
                                  <i class="fa fa-lock fa-5x"></i>
                              </div>
                          <a href="subastas_cerradas.php" class="btn btn-primary">Ver detalles</a>
                        </div>
                      </div>
                        </div>
                      </div>
                     
                    </div>
                    
                  </div>

                  <div class="row">
                    <div class="col-lg-6">

                      <?php 
                        $top5 = $bd->select("SELECT sum(o.oferta) as max,a.id_auto,a.imagenes,a.marca,a.linea,c.categoria,s.id_subasta,u.nombre,u.apellido, count(o.estado) as totalAutos from categoria c 
                                        INNER JOIN auto a ON c.id_categoria=a.id_categoria
                                        INNER JOIN subasta s ON a.id_auto=s.id_auto
                                        INNER JOIN oferta o ON s.id_subasta=o.id_subasta
                                        INNER JOIN usuario u ON o.comprador=u.id_usuario
                             WHERE o.estado=1 group by o.comprador order by max desc limit 5"); ?>

                        

                    
                      <b class="text-center">Mejores compradores</b>
                      <table class="table">
                        <thead class="thead-dark">
                          <tr class="text-center">
                            <th scope="col">No.</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Autos comprados</th>
                            <th scope="col">Total gastado</th>
                          </tr>
                        </thead>
                        <tbody>

                          <?php
                          $cont = 0;
                          while ($obtTop5 = mysqli_fetch_array($top5)) {
                            $cont++;
                            $ofertaMax = $obtTop5['max'];
                            $totalAutos = $obtTop5['totalAutos'];
                            $comprador = $obtTop5['nombre'];
                            $apellido = $obtTop5['apellido'];
                            $ofTot = number_format($ofertaMax);
                             ?>
                          <tr>
                            <th scope="row" class="text-center"><?php echo $cont; ?></th>
                            <td><i class="fa fa-user" aria-hidden="true"></i><?php echo " $comprador $apellido"; ?></td>
                            <td class="text-center"><i class="fa fa-car" aria-hidden="true"></i><?php echo " ".$totalAutos; ?></td>
                            <td class="text-center"><i class="fa fa-money" aria-hidden="true"></i><?php echo " Q".$ofTot; ?></td>
                          </tr>

                      <?php  }

                      ?>
                         
                         
                        </tbody>
                      </table>
                    </div>   
                    <div class="col-lg-6">
                      <?php 
                        $top5ofertas = $bd->select("SELECT count(o.oferta) as cont,a.marca,a.linea,s.estado from categoria c 
                                        INNER JOIN auto a ON c.id_categoria=a.id_categoria
                                        INNER JOIN subasta s ON a.id_auto=s.id_auto
                                        INNER JOIN oferta o ON s.id_subasta=o.id_subasta
                                        INNER JOIN usuario u ON o.comprador=u.id_usuario
                              group by s.id_subasta order by cont desc limit 5"); 

                             ?>

                      <b>Autos más ofertados</b>
                      <table class="table">
                        <thead class="thead-dark">
                          <tr class="text-center">
                            <th scope="col">No.</th>
                            <th scope="col">Automóvil</th>
                            <th scope="col">Cantidad de ofertas</th>
                            <th scope="col">Estado</th>
                          </tr>
                        </thead>
                        <tbody>

                          <?php

                          $cont = 0;
                          while ($obtTop5ofertas = mysqli_fetch_array($top5ofertas)) {
                            $cont++;
                            $cantOfertas = $obtTop5ofertas['cont'];
                            $auto = $obtTop5ofertas['marca'];
                            $linea = $obtTop5ofertas['linea'];
                            $estado = $obtTop5ofertas['estado'];
                       
                             ?>
                          <tr>
                            <th scope="row" class="text-center"><?php echo $cont; ?></th>
                            <td><i class="fa fa-car" aria-hidden="true"></i><?php echo " $auto $linea"; ?></td>
                            <td class="text-center"><?php echo " ".$cantOfertas; ?></td>
                            <?php 
                              if ($estado==1) { ?>
                                <td class="text-center">Vendido</td>
                       <?php  }else{ ?>
                                <td class="text-center">Activo</td>
                        <?php }

                             ?>
                            
                          </tr>

                      <?php  }

                      ?>
                         
                         
                        </tbody>
                      </table>
                      
                    </div> 
                  </div>

                <?php }else{ ///

                    //Contar los productos de mi cesta
                  $res_count=$bd->select("SELECT count(*) as total from cesta where id_usuario=".$_SESSION["id_usuario"]);
                  $data=mysqli_fetch_array($res_count);
                  $contar_cesta = $data['total'];//En esta variable se guardan el total

                  //Contar las subastas que están disponibles.
                  $res_count=$bd->select("SELECT count(*) as total from subasta where estado=0");
                  $data=mysqli_fetch_array($res_count);
                  $sub_activas = $data['total'];//En esta variable se guardan el total

                  //Sumar la cantidad de dinero que ha gastado cada cliente.
                  $res_dinero=$bd->select("SELECT sum(oferta) as total from oferta where estado=1 and comprador=".$_SESSION["id_usuario"]);
                  $data=mysqli_fetch_array($res_dinero);
                  $count_dinero = $data['total'];

                  //Contar la cantidad de ofetas que ha realizado cada cliente.
                  $res_dinero=$bd->select("SELECT count(*) as ofertas from (SELECT max(oferta) as max from oferta where estado=0 and comprador='".$_SESSION["id_usuario"]."' group by id_subasta) as total");





                  $data=mysqli_fetch_array($res_dinero);
                  $contar_oferta = $data['ofertas']; ?>

                  <div class="row row-cols-3 mb-3">
                    <div class="col-12 col-lg-6 mt-2">
                      <div class="card" style="height: 33.5rem;">
                        <div class="card-header bg-dark text-white text-center">
                          <strong>Estado de autos comprados</strong>
                        </div>
                        <div class="card-body">
                              <div id="cargabarras2"></div>
                        </div>
                      </div> 
                    </div>

                    <div class="col-12 col-lg-3 mt-2">
                      <div class="row">
                        <div class="col">
                           <div class="card">
                        <div class="card-header text-center font-weight-bold bg-dark text-white">
                          Mis compras
                        </div>
                        <div class="card-body">
                          <h1 class="card-title text-center"><?php echo $contar_cesta;//Aqui se imprime el total?></h1>
                          <p class="card-text"></p>
                          <div class="col-xs-3 text-center">
                                  <i class="fa fa-fw fa-shopping-cart fa-5x"></i>
                              </div>
                          <a href="cesta.php" class="btn btn-primary">Ver detalles</a>
                        </div>
                      </div>
                        </div>
                         <div class="w-100"></div>

                        <div class="col mt-3">
                          <div class="card">
                        <div class="card-header text-center font-weight-bold bg-dark text-white">
                          Total gastado
                        </div>
                        <div class="card-body">
                          <h1 class="card-title text-center"><?php 
                          if ($count_dinero==0) {
                            echo "Q 0.00";
                          }else{
                            echo "Q".$count_dinero;//Aqui se imprime el total
                          }
                          ?></h1>
                          <p class="card-text"></p>
                          <div class="col-xs-3 text-center">
                                  
                                  <i class="fa fa-money fa-5x"></i>

                                 
                              </div>
                          <a href="cesta.php" class="btn btn-primary">Ver detalles</a>
                        </div>
                      </div>
                        </div>
                      </div>
                    </div>
                   
                    <div class="col-12 col-lg-3 mt-2">
                      <div class="row">
                        <div class="col">
                           <div class="card">
                        <div class="card-header text-center font-weight-bold bg-success text-white">
                          Subastas disponibles
                        </div>
                        <div class="card-body">
                          <h1 class="card-title text-center"><?php echo $sub_activas;//Aqui se imprime el total?></h1>
                          <p class="card-text"></p>
                          <div class="col-xs-3 text-center">
                                  <i class="fa fa-unlock fa-5x"></i>
                              </div>
                          <a href="subastas.php" class="btn btn-primary">Ver detalles</a>
                        </div>
                      </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col mt-3">
                            <div class="card">
                        <div class="card-header text-center font-weight-bold bg-danger text-white">
                          Ofertas realizadas
                        </div>
                        <div class="card-body">
                          <h1 class="card-title text-center"><?php echo $contar_oferta;//Aqui se imprime el total?></h1>
                          <p class="card-text"></p>
                          <div class="col-xs-3 text-center">
                                  <i class="fa fa-lock fa-5x"></i>
                              </div>
                          <a href="ofertas.php" class="btn btn-primary">Ver detalles</a>
                        </div>
                      </div>
                        </div>
                      </div>
                     
                    </div>
                    
                  </div>


             <?php   }




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

    <script type="text/javascript">
      $(document).ready(function(){
        $('#cargabarras').load('barras.php');
      });
    </script>
    <script type="text/javascript">
      $(document).ready(function(){
        $('#cargabarras2').load('barras2.php');
      });
    </script>
   
  </body>
</html>




 