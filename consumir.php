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


function API($ruta){
    $url = "http://localhost/deposito_autos/";
    $respuesta = $url . $ruta;
    return $respuesta;
}

$direccion = API("autos");
$json = file_get_contents($direccion);

$data = json_decode($json,true);


$res2 = $bd->select("SELECT marca,linea,modelo,imagenes,num_motor from auto");

//Obtner los datos de los autos que ya se han puesto en subasta
$dataBD = [];
while ($fila = mysqli_fetch_assoc($res2)) {

    array_push($dataBD, $fila);
   
}


foreach ($data as $clave => $fila) {
    $mot[] = $fila['num_motor'];
    
}

foreach ($dataBD as $clave => $fila) {
    $mot2[] = $fila['num_motor'];
    
}

//Se ordenan los arrays de acuerdo al índice num_motor
if ($dataBD != NULL) {
  array_multisort($mot,SORT_ASC,$data); //Array de la API
  array_multisort($mot2,SORT_ASC,$dataBD); //Array de la Base de datos
}


//Se muestran los arrays de la API que no se encuetrarn en el array de la Base de datos
$d = array_udiff($data, $dataBD, function($x, $y) use ($data, $dataBD){
if($x['num_motor'] === $y['num_motor']){
    return 0;
}else{
    return -1;
}
});

//Se configura la paginación
$totalcarros = sizeof($d);
$carrosxpagina = 3;
            
$paginas = $totalcarros/3;
$paginas = ceil($paginas);

$iniciar = ($_GET['pagina']-1)*$carrosxpagina;

//forzar que la paginación inicie en 1
if (!$_GET) {
    header('Location:consumir.php?pagina=1');
}
//Evitar mostrar páginas que no existen
if (count($d)!=0) {
   if ($_GET['pagina']>$paginas || $_GET['pagina']<=0  ) {
    header('Location:consumir.php?pagina=1');
}
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

    <title>Lista Autos</title>
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
<!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                         <small>Lista de Autos para subastar</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-fw fa-plus"></i> Agregar a subasta
                            </li>
                        </ol>
                    </div>
                </div>

                <div class="row">
                <?php 

                    //Paginar los array
                    $pagina_1 = array_slice($d, $iniciar,$carrosxpagina);

                    
                  if (count($pagina_1)==0) {
                    echo "

                          <div class='col text-center'>
                            <div class='alert alert-warning' role='alert'>
                            Todos los autos han sido subastados
                          </div>
                          </div>
                          ";
                  }
                    foreach ($pagina_1 as $key => $value) {
                        $id_auto = $value['id_auto'];
                        $marca = $value['marca'];
                        $linea = $value['linea'];
                        $modelo = $value['modelo'];
                        $imagenes = $value['imagenes'];

                        $img = json_decode($imagenes,true);
                        //Acceder a la primera foto del array y convertirlo a string
                        
                        if (isset($img)) {
                            $fotos = implode($img[0]);
                        }else{
                             $fotos = false;
                        }  ?>
                              

                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <div class="img-thumbnail">
                          <?php echo "<img src='$fotos' class='rounded mx-auto d-block img-fluid' style='height: 220px;'>";?>
                          <div class="caption">
                            <h3><?php echo $marca." ".$linea; ?></h3>
                            <p><?php echo $modelo;  ?></p>
                            
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#DetalleAuto" onclick="CargarID(<?php echo $id_auto; ?>);">
                                 
                                Ver Detalles
                            </button>
                          </div>
                        </div>
                    </div>


              <?php } ?>

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
                         
                            <div id='contenedor'>
                                
                            </div>  

                                    
                          </div>
                         
                        </div>
                      </div>
                    </div>

                </div> <!--Fin de Row-->

                <!--Paginación-->
                <br>
                <nav aria-label="...">
                  <ul class="pagination">
                    <li class="page-item <?php echo $_GET['pagina']<=1? 'disabled' : '' ?>">
                      <a class="page-link" href="consumir.php?pagina=<?php echo $_GET['pagina']-1 ?>">Anterior</a>
                    </li>
                    
                    <?php 
                        for ($i=0; $i <$paginas ; $i++): 
                    ?>
                    <li class="page-item <?php echo $_GET['pagina'] ==$i+1 ? 'active' : '' ?>">
                        <a class="page-link" href="consumir.php?pagina=<?php echo $i+1; ?>"><?php echo $i+1; ?></a>
                    </li>
                     <?php endfor ?>
                    
                    <li class="page-item <?php echo $_GET['pagina']>=$paginas? 'disabled' : '' ?> ">
                      <a class="page-link" href="consumir.php?pagina=<?php echo $_GET['pagina']+1 ?>">Siguiente</a>
                    </li>
                  </ul>
                </nav>
               
      


    </main>

           </div>
                
            </div>
            <!-- /.container-fluid -->
    

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="bootstrap/js/jquery-3.5.1.slim.min.js"></script> 
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
   


    <script type="text/javascript">
        function CargarID(id){
            var  url='detalle_auto.php';
            $.ajax({
                type:'POST',
                url:url,
                data:'id='+id,
                success:function(response){
                    $('#contenedor').load("detalle_auto.php",{idAuto:id});
                }
            });
        }
    </script>
  </body>
</html>





 