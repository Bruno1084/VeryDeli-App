<!DOCTYPE html>
<html lang="en">
<head>
    <?php require($_SERVER["DOCUMENT_ROOT"]."/utils/functions/startSession.php");?>
    <?php require_once($_SERVER['DOCUMENT_ROOT']."/components/head.php") ?>
</head>
<body>
<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/components/Header.php");
    require_once($_SERVER["DOCUMENT_ROOT"].'/database/conection.php');
    include_once($_SERVER["DOCUMENT_ROOT"]."/utils/get/getUsuario.php");
    $datos = getUsuario($_SESSION['id']);
?>
<h1 class="text-center my-3">Actualizar datos</h1>
  <div class="d-flex justify-content-center">
    <div class="form-rest my-4 p-3 col-12 col-md-8"></div>
  </div>
<div class="container py-3 mt-2">
            <form class="form-registrarse FormularioAjax" action="/utils/actualizarUsuario.php" method="post">
              <input type="hidden" value="<?= $_SESSION['id'] ?>" name="usuario_id" required>
                <div class="row justify-content-center">
                    <div class="form-group col-12 col-md-5 mb-3">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control bg-input" id="nombre" name="nombre" required value="<?= $datos['usuario_nombre'] ?>">
                    </div>
                    <div class="form-group col-12 col-md-5 mb-3">
                        <label for="apellido">Apellido</label>
                        <input type="text" class="form-control bg-input" id="apellido" name="apellido" required value="<?= $datos['usuario_apellido'] ?>">
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="form-group col-12 col-md-5 mb-3">
                        <label for="correo">Correo</label>
                        <input type="email" class="form-control bg-input" id="correo" name="correo" required value="<?= $datos['usuario_correo'] ?>">
                    </div>
                    <div class="form-group col-12 col-md-5 mb-3">
                        <label for="localidad">Localidad</label>
                        <input type="text" class="form-control bg-input" id="localidad" name="localidad" required value="<?= $datos['usuario_localidad'] ?>">
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="form-group col-12 col-md-5 mb-3">
                      <label for="usuario">Usuario</label>
                      <input type="text" class="form-control bg-input" id="usuario" name="usuario" required value="<?= $datos['usuario_usuario'] ?>">
                    </div>
                    <div class="form-group col-12 col-md-5 mb-3">
                      <label for="contraseña">Contraseña</label>
                      <input type="password" class="form-control bg-input" id="contraseña" name="contraseña" placeholder="Ingrese la nueva contraseña">
                    </div>
                </div>

                <div class="row justify-content-center my-3">
                    <div class="col-12 text-center">
                      <h5>Para actualizar sus datos debe ingresar el usuario y clave con los que inicio sesión</h5>
                    </div>
                </div>

                <div class="row justify-content-center">
                        <div class="form-group col-12 col-md-5 mb-3">
                            <label>Usuario</label>
                            <input class="form-control bg-input" type="text" name="usuario_confirm" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required >
                        </div>
                        <div class="form-group col-12 col-md-5 mb-3">
                            <label>Clave</label>
                            <input class="form-control bg-input" type="password" name="contraseña_confirm" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
                        </div>
                </div>

                <div class="row justify-content-center my-3">
                    <div class="col-12 col-md-5 text-center">
                        <button type="submit" class="btn btn-amarillo btn-block w-100">Actualizar</button>
                    </div>
                </div>
            </form>
</div>

<script src="/js/ajax.js"></script>