<header id="header" class="conainer-fluid">
    <div class="content-fluid">
        <div class="col-12">
            <nav class="navbar navbar-expand-lg">
                <div class="col-auto logoNav">
                    <a class="navbar-brand" href="index.php">
                        <img src="../assets/Logo.png" class="img-fluid" alt="logo">
                    </a>
                </div>
                <div class="col-8 buscarNav">
                    <div class="col-12">
                        <form class="d-flex" role="search">
                            <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                            <div class="btnBuscar">
                                <?php require_once("../assets/search.svg") ?>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-auto perfilNav">
                    <ul class="navbar-nav me-auto mb-lg-0">
                        <li class="nav-item dropdown">
                            <button class="btn btn-link nav-link py-2 px-0 px-lg-2 dropdown-toggle d-flex align-items-center" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" data-bs-display="static" aria-label="Toggle theme (light)">
                                <img src="../assets/user.png" class="img-fluid" alt="account">
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="miPerfil.php">Mi Perfil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="../utils/functions/cerrarSesion.php">Cerrar Sesion</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>
