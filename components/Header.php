<?php require_once($_SERVER["DOCUMENT_ROOT"]."/components/CSS.php")?>
<header id="header" class="conainer-fluid ">
    <div class="content-fluid">
        <div class="col-12">
            <nav class="navbar navbar-expand-lg">
                <div class="col-1 logoNav">
                    <a class="navbar-brand" href="/index.php">
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
                <div class="col-1 d-flex notYprof">
                    <div class="col-auto notifications">
                        <?php
                            function tipoNotify($notify){
                                switch($notify["notificacion_tipo"]){
                                    case 1: return "/pages/publicacion.php?id=".$notify["publicacion_id"];
                                            
                                    case 2: if(str_contains($notify["notificacion_mensaje"],"!Su verificacion ha sido Rechazada"))
                                                return "/index.php";
                                            elseif(str_contains($notify["notificacion_mensaje"],"!Su verificacion ha sido Aceptada"))
                                                return "/pages/miPerfil.php";
                                            else return "/pages/verificaciones.php";

                                    case 3: if(str_contains($notify["notificacion_mensaje"],"¡Alguien"))
                                                return "/pages/miPerfil.php";
                                            else return "/pages/denuncias.php";

                                    case 4: if(str_contains($notify["notificacion_mensaje"],"¡Alguien"))
                                                return "/pages/publicacion.php?id=".$notify["publicacion_id"];
                                            else return "/pages/denuncias.php";
                                            
                                    default: return "/pages/notificaciones.php";
                                }
                            }
                            function tieneFoto(){
                                if($_SESSION["fotoPerfil"]==0) return "../assets/user.png";
                                else return $_SESSION["fotoPerfil"];
                            }
                            require_once($_SERVER["DOCUMENT_ROOT"]."/utils/get/getAllNotificacionesNoVistasFromUsuario.php"); 
                            $notificaciones=getNotificacionesActivasFromUsuario(5); 
                        ?>
                        <div class="dropdown">
                                <button class="btn dropdown-toggle py-2 px-0 px-lg-2 d-flex align-items-center" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" data-bs-display="static" aria-label="Toggle theme (light)">
                                    <img src="/assets/bell.png" class="img-fluid" alt="notify">
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <?php 
                                        if(sizeof($notificaciones)>0){
                                            foreach($notificaciones as $notify){?>
                                                <a class="dropdown-item" href=<?php echo idIsNull($notify["publicacion_id"])?>><?php echo $notify["notificacion_mensaje"] ?></a>
                                                <hr class="dropdown-divider">
                                                <a class="dropdown-item" href="../pages/notificaciones.php">Ver mas</a>
                                    <?php       }
                                        }
                                        else{
                                    ?>
                                            <p class="dropdown-item">Nada por aqui</p>
                                            <hr class="dropdown-divider">
                                            <a class="dropdown-item" href="../pages/notificaciones.php">Ver Todo</a>
                                    <?php
                                        }
                                    ?>
                                </div>
                        </div>
                    </div>
                    <div class="col-auto perfilNav">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php if($_SESSION["marcoFoto"]==0)
                                    {
                                ?>
                                    <img src="<?php echo tieneFoto() ?>" class="userFoto" alt="account">
                            <?php   }
                                    else{
                                        echo '<div class="fondoFoto"></div><img src="'.$_SESSION["marcoFoto"].'" class="decoFoto'.$_SESSION["marcoFoto"][(strlen($_SESSION["marcoFoto"])-5)].'">';
                                        echo '<div class="divFoto"><img src="'.tieneFoto().'" alt="user"></div>';
                                    }
                                ?>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="../pages/miPerfil.php">Mi Perfil</a>
                                <a class="dropdown-item" href="../utils/functions/cerrarSesion.php">Cerrar Sesion</a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>
<? require_once($_SERVER["DOCUMENT_ROOT"]."/components/JS.php");?>