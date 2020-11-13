<?php  
    function API($ruta){
        $url = "http://localhost/deposito_autos/";
        $respuesta = $url . $ruta;
        return $respuesta;
    }
          
    $sacarID = $_POST['idAuto'];


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

        $img = json_decode($imagenes,true);

        ?>
        <div class="container">
            <div class="row">
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
                <th scope="row">ID</th>
                <td><?php  echo $id_auto; ?></td>
            </tr>
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
                  foreach ($img as $value) {
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
                  foreach ($img as $value) {
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
            </div>
        </div>
        

    
<?php    } 

?>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button> 
    <a href="alta_subasta.php?id=<?php echo $sacarID; ?>" class="btn btn-primary">Agregar a subasta</a> 
</div>