    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="sidebar-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link <?php if(basename($_SERVER['PHP_SELF'])=="index.php"){echo "active";}else{echo "";} ?>" href="index.php">
              <i class="fa fa-fw fa-dashboard"></i>
              Panel de control 
            </a>
          </li>
         
          
          <?php 
            if ($_SESSION["id_tipoUser"]==1) { ?>
               <li class="nav-item">
                <a class="nav-link <?php if(basename($_SERVER['PHP_SELF'])=="consumir.php"){echo "active";}else{echo "";} ?>" href="consumir.php">
                  <i class="fa fa-car" aria-hidden="true"></i>
                  Automóviles
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?php if(basename($_SERVER['PHP_SELF'])=="cesta.php"){echo "active";}else{echo "";} ?>" href="cesta.php">
                  <i class="fa fa-money" aria-hidden="true"></i>
                  Ventas
                </a>
              </li>
             <!-- <li class="nav-item">
                <a class="nav-link <?php // if(basename($_SERVER['PHP_SELF'])=="alta_subasta.php"){echo "active";}else{echo "";} ?>" href="consumir.php">
                  <i class="fa fa-fw fa-plus"></i>
                  Nueva subasta
                </a>
              </li> -->
              <li class="nav-item">
                <a class="nav-link <?php if(basename($_SERVER['PHP_SELF'])=="alta_categoria.php"){echo "active";}else{echo "";} ?>" href="alta_categoria.php">
                  <i class="fa fa-fw fa-tags"></i>
                  Nueva categoría
                </a>
              </li>
          <?php  }else{ ?>
              <li class="nav-item">
                <a class="nav-link <?php if(basename($_SERVER['PHP_SELF'])=="cesta.php"){echo "active";}else{echo "";} ?>" href="cesta.php">
                  <i class="fa fa-fw fa-shopping-cart"></i>
                  Mis compras
                </a>
              </li>
        <?php  }
          ?>
        
          
      
        </ul>

       <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>Datos subastas</span>
        </h6>
        <ul class="nav flex-column mb-2">
         
          <li class="nav-item">
            <a class="nav-link <?php if(basename($_SERVER['PHP_SELF'])=="subastas.php"){echo "active";}else{echo "";} ?>" href="subastas.php">
              <i class="fa fa-file-text-o" aria-hidden="true"></i>
              Subastas activas
            </a>
          </li>
          <?php if ($_SESSION['id_tipoUser']==2): ?>
          <li class="nav-item">
            <a class="nav-link <?php if(basename($_SERVER['PHP_SELF'])=="ofertas.php"){echo "active";}else{echo "";} ?>" href="ofertas.php">
              <i class="fa fa-file-text-o" aria-hidden="true"></i>
              Ofertas realizadas
            </a>
          </li>  
          <?php endif ?>
          

          <?php if ($_SESSION['id_tipoUser']==1): ?>
          
          <li class="nav-item">
            <a class="nav-link <?php if(basename($_SERVER['PHP_SELF'])=="subastas_cerradas.php"){echo "active";}else{echo "";} ?>" href="subastas_cerradas.php">
              <i class="fa fa-file-text-o" aria-hidden="true"></i>
              Subastas cerradas
            </a>
          </li>
           <li class="nav-item">
            <a class="nav-link <?php if(basename($_SERVER['PHP_SELF'])=="total_subastas.php"){echo "active";}else{echo "";} ?>" href="total_subastas.php">
              <i class="fa fa-file-text-o" aria-hidden="true"></i>
              Total subastas
            </a>
          </li>

          <?php endif ?>

          
        </ul> 
      </div> 
    </nav>

 
