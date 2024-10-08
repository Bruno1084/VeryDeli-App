<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/utils/functions/startSession.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/utils/functions/manejaError.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/utils/functions/verificarObligatorios.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/utils/functions/verificarDatos.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/database/conection.php");

$db = new DB();
$conexion = $db->getConnection();

//Obtiene los datos
$usuario = $_POST['usuario'];
$contrasenia = $_POST['contraseña'];

//Verifica campos obligatorios
if(!verificarCamposObligatorios([$usuario, $contrasenia])){
    manejarError('Campos sin completar','No se han llenado todos los campos obligatorios.');
    exit();
}

//Validar formato del usuario
if(verificarDatos('[a-zA-Z0-9]{4,20}', $usuario)){
  manejarError('Nombre de usuario invalido','El usuario no coincide con el formato solicitado.');
  exit();
}

//Validar formato de la contraseña
if(verificarDatos('[a-zA-Z0-9$@.\-]{7,100}', $contrasenia)){
  manejarError('Contraseña invalida','La contraseña no coincide con el formato solicitado.');
  exit();
}

//Verifica si el nombre de usuario está registrado
$verificarUsuario = $conexion->prepare("SELECT * FROM usuario WHERE usuario_usuario = ?");
$verificarUsuario->bindValue(1, $usuario, PDO::PARAM_STR);
$verificarUsuario->execute();

if($verificarUsuario->rowCount() == 1){
  $verificarUsuario = $verificarUsuario->fetch();
  //Verifica que la contraseña corresponda al usuario
  if($verificarUsuario["usuario_usuario"] == $usuario && password_verify($contrasenia, $verificarUsuario["usuario_clave"])){
    $_SESSION['id'] = $verificarUsuario['usuario_id'];
    $_SESSION['nombre'] = $verificarUsuario['usuario_nombre'];
    $_SESSION['apellido'] = $verificarUsuario['usuario_apellido'];
    $_SESSION['localidad'] = $verificarUsuario['usuario_localidad'];
    $_SESSION['correo'] = $verificarUsuario['usuario_correo'];
    $_SESSION['usuario'] = $verificarUsuario['usuario_usuario'];
    $_SESSION['esResponsable'] = $verificarUsuario['usuario_esResponsable'];
    $_SESSION['esActivo'] = true;

    header('Location: ../public/index.php');
  }
  else{
    manejarError('Datos invalidos','Usuario o clave incorrectos.');
  }
}
else{
  manejarError('Datos invalidos','Usuario o clave incorrectos.');
}

$verificarUsuario = null;
$conexion = null;
?>