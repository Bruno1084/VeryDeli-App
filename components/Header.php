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
                <div class="col-auto perfilNav">
                    <div class="dropdown">
                        <button class="dropdown-toggle" href="#" id="profileButton" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="/assets/user.png" class="img-fluid" alt="account">
                        </button>
                        <div class="dropdown-menu" aria-labelledby="profileButton">
                            <a class="dropdown-item" href="/public/miPerfil.php">Mi Perfil</a>
                            <a class="dropdown-item" href="/utils/functions/cerrarSesion.php">Cerrar Sesion</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>