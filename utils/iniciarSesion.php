<?php
require_once("../utils/functions/startSession.php");
require_once("../utils/functions/manejaError.php");
require_once("../database/conection.php");

$usuario = $_POST['usuario'];
$contrasenia = $_POST['contraseña'];

if(!verificarCamposObligatorios([$usuario, $contrasenia])){
    manejarError('No se han llenado todos los campos obligatorios.');
    exit();
}

if(verificarDatos('[a-zA-Z0-9]{4,20}', $usuario)){
  manejarError('El usuario no coincide con el formato solicitado.');
  exit();
}
  
if(verificarDatos('[a-zA-Z0-9$@.\-]{7,100}', $contrasenia)){
  manejarError('La contraseña no coincide con el formato solicitado.');
  exit();
}

$verificarUsuario = $conexion->prepare("SELECT * FROM usuario WHERE usuario_usuario = ?");
$verificarUsuario->bindValue('s', $usuario);
$verificarUsuario->execute();

if($verificarUsuario->rowCount() == 1){
  $verificarUsuario = $verificarUsuario->fetch();
  if($verificarUsuario["usuario_usuario"] == $usuario && password_verify($contrasenia, $verificarUsuario["usuario_clave"])){
    $_SESSION['id'] = $verificarUsuario['usuario_id'];
    $_SESSION['nombre'] = $verificarUsuario['usuario_nombre'];
    $_SESSION['apellido'] = $verificarUsuario['usuario_apellido'];
    $_SESSION['localidad'] = $verificarUsuario['usuario_localidad'];
    $_SESSION['correo'] = $verificarUsuario['usuario_correo'];
    $_SESSION['usuario'] = $verificarUsuario['usuario_usuario'];
    $_SESSION['esResponsable'] = $verificarUsuario['usuario_esResponsable'];
    $_SESSION['esActivo'] = true;

    // header("rutaHomen");  ---> Aqui se redirecciona al usuario
  }
  else{
    manejarError('Usuario o clave incorrectos.');
  }
}
else{
  manejarError('Usuario o clave incorrectos.');
}

$verificarUsuario->close();
$conexion->close();
?>