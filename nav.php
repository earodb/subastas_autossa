<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="#">Venta de Autos S.A.</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <!--<input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">-->
  <?php 

    if ($_SESSION['id_tipoUser']==1) { ?>
      <div class="badge badge-primary text-monospace" style="width: 6rem;">
        Administrador
      </div>
   <?php }else{ ?>
      <div class="badge badge-success text-monospace" style="width: 6rem;">
        Cliente
      </div>
   <?php }

  ?>
  
  <div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fa fa-user"></i><?php echo " ".$_SESSION["nomb_comp"]; ?>
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="perfil.php"><i class="fa fa-fw fa-user"></i> Perfil</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="logout.php"><i class="fa fa-fw fa-power-off"></i> Cerrar sesion</a>
  </div>
</div>
</nav>