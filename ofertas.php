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

  if ($_SESSION["id_tipoUser"] == 1) {
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

    <title>Ofertas hechas</title>
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

                    <div class="table-responsive">
                      <h2>Ofertas realizadas</h2>
                      <hr>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Imagen</th>
                                    <th>Nombre</th>
                                    <th>Categoria</th>
                                    <th>Oferta</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>

                  <?php

                          $verOfertas = $bd->select("SELECT max(o.oferta) as max,a.id_auto,a.imagenes,a.marca,a.linea,c.categoria,s.id_subasta,o.oferta from categoria c 
                                        INNER JOIN auto a ON c.id_categoria=a.id_categoria
                                        INNER JOIN subasta s ON a.id_auto=s.id_auto
                                        INNER JOIN oferta o ON s.id_subasta=o.id_subasta
                             WHERE o.comprador='".$_SESSION['id_usuario']."' AND o.estado=0 group by s.id_subasta");
                          
                          $data=mysqli_num_rows($verOfertas);
                          
                          if ($data != 0) {
                        
                            while ($data=mysqli_fetch_array($verOfertas)) {
                              $id_auto = $data['id_auto'];
                              $id_subasta = $data['id_subasta'];
                              $marca = $data['marca'];
                              $linea = $data['linea'];
                              $categoria = $data['categoria'];
                              $oferta = $data['max'];
                              $imagenes = $data['imagenes'];

                              $img = json_decode($imagenes,true);
                              
                              $foto1 = implode($img[0]);

                      
                              
                       

                                  ?>


                                      <tr>
                                          <td width="180px">
                                            <center>
                                              <a href="<?php echo "subasta.php?id=$id_subasta&idAuto=$id_auto"; ?>">
                                               
                                                    <img src="<?php echo "$foto1";?>" style="height: 80px;">
                                                
                                                
                                              </a>
                                            </center>
                                          </td>
                                          <td><?php echo "<b class='text-success'>$marca $linea</b>";?></td>
                                          <td><?php echo $categoria;?></td>
                                          <td><?php echo "<b class='text-danger'>Q$oferta.00</b>";?></td>
                                          <?php 
                                           
                                           //Consultamos si el auto ya fue comprado, obtenemos la oferta mayor 
                                           $maxOferta = $bd->select("SELECT max(oferta) as oferMayor from oferta where id_subasta=$id_subasta and estado=1");

                                           while ($data2=mysqli_fetch_array($maxOferta)) {
                                             $ofertaMayor = $data2['oferMayor']; //monto que fue pagado por el auto.

                                             //Comparamos la oferta mayor de la subasta con la ultima oferta 
                                             //hecha por el cliente.
                                             if ($ofertaMayor>$oferta) { ?>
                                               <td><b class="text-danger">Vendido</b></td>
                                      <?php  }else{ ?>
                                              <td><b class="text-success">Activo</b></td>
                                    <?php  }
                                           }

                                          

                                          ?>
                                          
                                      </tr>


                                  <?php
                                }
                              }else{
                                echo "
                                <tr>
                                  <td colspan='5'>
                                    <div class='alert alert-warning text-center' role='alert'>
                                      No has realizado ninguna oferta
                                    </div>
                                </td>
                              </tr>";
                              }

                                
                          

                      //Termina consulta de subastas

                  ?>
                            </tbody>
                        </table>
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
   
  </body>
</html>
