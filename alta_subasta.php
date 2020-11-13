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

  if (!isset($_GET['id'])) {
    header("Location:index.php");
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

    <title>Agregar subasta</title>
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

      //Variables que se guardaran en la tabla auto
      $umarca = $_POST["marca"];
      $ulinea = $_POST["linea"];
      $umodelo = $_POST["modelo"];
      $umotor = $_POST["motor"];
      $uchasis = $_POST["chasis"];
      $ucilindros = $_POST["cilindros"];
      $ucc = $_POST["cc"];
      $utransmision = $_POST["transmision"];
      $uestado = $_POST["estado"];
      $uimagenes = $_POST["imagenes"];

      $descripcion = $_POST["descripcion"];
      $categoria = $_POST["categoria"];
  
      //$foto = $_FILES["foto"]["name"];//nombre de la imagen del producto
      //$ruta = $_FILES["foto"]["tmp_name"];//ruta de la imagen del producto

      //Variables que se guardaran en la tabla subasta
      $p_minimo = $_POST["minimo"];
      $p_maximo = $_POST["maximo"];
      
      date_default_timezone_set('America/Guatemala');
      $fecha_hora_actual = date("Y-m-d H:i:s");

      $fecha_fin = $_POST["fecha_fin"];//Esto no se insertara en la tabla
      $hora_fin = $_POST["hora_fin"];//Esto no se insertara en la tabla
      $fecha_hora_fin = "$fecha_fin $hora_fin:00";
      $estado = 0;//1 = vendida && 0 = disponible
      $subastador = $_SESSION["id_usuario"];

      //echo "<script>alert('$fecha_hora_actual - $fecha_hora_fin');</script>";


      if($uimagenes == null){

        $res = $bd->query("INSERT into auto(marca, linea, modelo, num_motor, num_chasis, num_cilindros, cc, tipo_transmision, estado, id_categoria, imagenes, descripcion)
                            values('$umarca','$ulinea', '$umodelo', '$umotor', '$uchasis', '$ucilindros', '$ucc', '$utransmision', '$uestado', '$categoria', 'default.jpg', '$descripcion');");

        if($res==true){
          echo "<script>alert('Automóvil agregado correctamente');</script>";
          $id_auto = $bd->insert_id();

          $res2 = $bd->query("INSERT into subasta(min, max, tiempo_ini, tiempo_fin, estado, subastador, id_auto)
                              values($p_minimo,$p_maximo,'$fecha_hora_actual','$fecha_hora_fin',$estado,$subastador,$id_auto);");

          if($res2==true){
            echo "<script>alert('Subasta agregada correctamente');</script>";
          }else{
            echo "<script>alert('No se pudo agregar subasta');</script>";
          }
        }else{
          echo "<script>alert('No se pudo agregar el producto ni la subasta');</script>";
        }

      }else{

        //$dest = "images/productos/";
        //copy($ruta,$dest.''.$foto);

        $res = $bd->query("INSERT into auto(marca, linea, modelo, num_motor, num_chasis, num_cilindros, cc, tipo_transmision, estado, id_categoria, imagenes, descripcion)
                          values('$umarca','$ulinea', '$umodelo', '$umotor', '$uchasis', '$ucilindros', '$ucc', '$utransmision', '$uestado', '$categoria', '$uimagenes', '$descripcion');");

        if($res==true){
          echo "<script>alert('Automóvil agregado correctamente');</script>";
          $id_auto = $bd->insert_id();

          $res2 = $bd->query("INSERT into subasta(min, max, tiempo_ini, tiempo_fin, estado, subastador, id_auto)
                              values($p_minimo,$p_maximo,'$fecha_hora_actual','$fecha_hora_fin',$estado,$subastador,$id_auto);");

          if($res2==true){
            echo "<script>alert('Subasta agregada correctamente');</script>";
          }else{
            echo "<script>alert('No se pudo agregar subasta');</script>";
          }
        }else{
          echo "<script>alert('No se pudo agregar el producto ni la subasta');</script>";
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
                          <small>Agregar nueva subasta</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <i class="fa fa-dashboard"></i> Panel de control
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="fa fa-plus"></i> Nueva subasta
                            </li>
                        </ol>
                    </div>
                </div>

                <div class="row">
                <?php  
                  function API($ruta){
                      $url = "http://localhost/deposito_autos/";
                      $respuesta = $url . $ruta;
                      return $respuesta;
                  }

                  if (isset($_GET['id'])) {
                    $sacarID = $_GET['id'];
                  
                        
                  



                  $direcID = API("autos?id=$sacarID");
               
                  $json = file_get_contents($direcID);

                  $Auto = json_decode($json,true);
                     
                      
                  foreach ($Auto as $key => $value) {
                      $id_auto = $value['id_auto'];
                      $marca = $value['marca'];
                      $linea = $value['linea'];
                      $modelo = $value['modelo'];
                      $num_motor = $value['num_motor'];
                      $num_chasis = $value['num_chasis'];
                      $num_cilindros = $value['num_cilindros'];
                      $cc = $value['cc'];
                      $tipo_transmision = $value['tipo_transmision'];
                      $estado = $value['estado'];
                      $imagenes = $value['imagenes']; 

                      ?>

                      

                        <div class="col-lg-6">
                        <form role="form" action="" method="post" enctype="multipart/form-data">

                          

                                <h3>Detalle automóvil</h3>

                                  <div class="form-group">
                                      <label>Marca</label>
                                      <input type="text" name="marca" class="form-control" value="<?php echo $marca; ?>" required>
                                  </div>

                                    <div class="form-group">
                                      <label>Línea</label>
                                      <input type="text" name="linea" class="form-control" value="<?php echo $linea; ?>" required>
                                  </div>

                                    <div class="form-group">
                                      <label>Modelo</label>
                                      <input type="text" name="modelo" class="form-control" value="<?php echo $modelo; ?>" required>
                                  </div>

                                  <div class="form-group">
                                    <label>Número de motor</label>
                                    <input type="text" name="motor" class="form-control" value="<?php echo $num_motor; ?>" required>
                                  </div>

                                  <div class="form-group">
                                    <label>Número de chasis</label>
                                    <input type="text" name="chasis" class="form-control" value="<?php echo $num_chasis; ?>" required>
                                  </div>

                                  <div class="form-group">
                                    <label>Número de cilindros</label>
                                    <input type="text" name="cilindros" class="form-control" value="<?php echo $num_cilindros; ?>" required>
                                  </div>

                                  <div class="form-group">
                                    <label>Centímetros cúbicos</label>
                                    <input type="text" name="cc" class="form-control" value="<?php echo $cc; ?>" required>
                                  </div>

                                  <div class="form-group">
                                    <label>Transmisión</label>
                                    <input type="text" name="transmision" class="form-control" value="<?php echo $tipo_transmision; ?>" required>
                                  </div>

                                  <div class="form-group">
                                    <label>Estado</label>
                                    <input type="text" name="estado" class="form-control" value="<?php echo $estado; ?>" required>
                                  </div>

                                  <div class="form-group">
                                      <label>Descripcion</label>
                                      <textarea name="descripcion" class="form-control"></textarea>
                                  </div>

                                  <div class="form-group">
                                      <label>Categoria</label>
                                      <select class="form-control" name="categoria">
                                          <?php
                                            $res = $bd->select("SELECT * from categoria");
                                            if($res->num_rows > 0){
                                              while($row = $res->fetch_assoc()){
                                                echo "<option value='".$row["id_categoria"]."'>".$row["categoria"]."</option>";
                                              }
                                            }else{
                                              echo "<option value='s/c'>Agrega una desde tu panel lateral</option>";
                                            }
                                          ?>
                                      </select>
                                      <p class="text-info">Si no esta la categoria que busca puede agregar una desde el panel lateral.</p>
                                  </div> 

                               
                                      
                                  <div class="form-group">
                                      
                                      <input hidden type="text" name="imagenes" value='<?php echo $imagenes; ?>'>
                                  </div>
                              
                        </div>
                        <div class="col-lg-6">

                              <h3>Detalle subasta</h3>

                                  <div class="form-group">
                                      <label>Precio minimo</label>
                                      <input type="number" name="minimo" class="form-control">
                                  </div>

                                  <div class="form-group">
                                      <label>Precio maximo</label>
                                      <input type="number" name="maximo" class="form-control"  required>
                                  </div>

                                  <div class="form-group">
                                      <label>Fecha de cierre</label>
                                      <input type="date" name="fecha_fin" class="form-control" required>
                                  </div>

                                  <div class="form-group">
                                      <label>Hora de cierre</label>
                                      <input type="time" name="hora_fin" class="form-control" required>
                                  </div>

                                  <br>

                                  <button name="agregar" type="submit" class="btn btn-success">Subastar</button>
                                  <button type="reset" class="btn btn-danger">Cancelar</button>

                          

                        </form>
                        </div>
<?php    } }

?>
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
  
                 
