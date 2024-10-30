<header id="header" class="conainer-fluid ">
    <div class="content-fluid">
        <div class="col-12">
            <nav class="navbar navbar-expand-lg">
                <div class="col-auto logoNav">
                    <a class="navbar-brand" href="../public/index.php">
                        <img src="/assets/Logo.png" class="img-fluid" alt="logo">
                    </a>
                </div>
                <div class="col-8 buscarNav">
                    <div class="col-12">
                        <form class="d-flex" role="search" action="../components/resultSearch.php" method="get">
                            <input class="form-control" type="text" name="busqueda" placeholder="Search" aria-label="Search">
                            <div class="tipoBusqueda no-visible">
                                <div class="tipoBusqueda_hijo">
                                    <label for="zona">Zona</label>
                                    <input type="radio" name="tipoBusqueda" id="zona" value="zona" checked>
                                </div>
                                <div class="tipoBusqueda_hijo">
                                    <label for="articulo">Articulo</label>
                                    <input type="radio" name="tipoBusqueda" id="articulo" value="articulo">
                                </div>
                            </div>
                            <input class="btnBuscar" type="submit" name="buscar" value=""></input>
                        </form>
                    </div>
                </div>
                <div class="col-auto notifications">
                    <?php
                    require_once($_SERVER["DOCUMENT_ROOT"]."/utils/get/getAllNotificacionesNoVistasFromUsuario.php"); 
                    $notificaciones=getNotificacionesActivasFromUsuario(); ?>
                <ul class="navbar-nav me-auto mb-lg-0">
                        <li class="nav-item dropdown">
                            <button class="btn btn-link nav-link py-2 px-0 px-lg-2 dropdown-toggle d-flex align-items-center" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" data-bs-display="static" aria-label="Toggle theme (light)">
                                <img src="/assets/bell.png" class="img-fluid" alt="notify">
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <?php 
                                    if(sizeof($notificaciones)>0){
                                        foreach($notificaciones as $notify){?>
                                            <li><a class="dropdown-item" href="#"><?php echo $notify["notificacion_mensaje"] ?></a></li>
                                            <li><hr class="dropdown-divider"></li>
                            <?php       }
                                    }
                                    else{
                                ?>
                                        <li><p class="dropdown-item">Nada por aqui</p></li>
                                        <li><hr class="dropdown-divider"></li>
                                <?php
                                    }
                                ?>
                                <li><a class="dropdown-item" href="../components/Notificaciones.php">Ver mas</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="col-auto perfilNav">
                    <ul class="navbar-nav me-auto mb-lg-0">
                        <li class="nav-item dropdown">
                            <button class="btn btn-link nav-link py-2 px-0 px-lg-2 dropdown-toggle d-flex align-items-center" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" data-bs-display="static" aria-label="Toggle theme (light)">
                                <img src="/assets/user.png" class="img-fluid" alt="account">
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="/public/miPerfil.php">Mi Perfil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/utils/functions/cerrarSesion.php">Cerrar Sesion</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>