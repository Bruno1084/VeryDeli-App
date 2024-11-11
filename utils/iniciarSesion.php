<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/utils/user.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/utils/functions/manejaError.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/utils/functions/verificarObligatorios.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/utils/functions/verificarDatos.php");

//Obtiene los datos
$usuario = $_POST['usuario'];
$contrasenia = $_POST['contraseña'];

//Verifica campos obligatorios
if(!verificarCamposObligatorios([$usuario, $contrasenia])){
  manejarError('false', 'Campos sin completar', 'No se han llenado todos los campos obligatorios');
  exit();
}

//Validar formato del usuario
if(verificarDatos('[a-zA-Z0-9]{4,20}', $usuario)){
  manejarError("false",'Usuario invalido', 'El usuario no coincide con el formato solicitado');
  exit();
}

//Validar formato de la contraseña
if(verificarDatos('[a-zA-Z0-9$@.\-]{7,100}', $contrasenia)){
  manejarError('false','Contraseña invalida','La contraseña no coincide con el formato solicitado.');
  exit();
}


//Verifica si el nombre de usuario está registrado
$res=User::userExist($usuario);
if($res!=false){
  //Verifica que la contraseña corresponda al usuario
  $res=User::userPassExist($usuario,$contrasenia);
  if($res!=false){
    //Inicia la sesion y almacena el id del usuario en la sesion
    require_once($_SERVER["DOCUMENT_ROOT"].'/utils/functions/startSession.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/utils/get/getEsResponsable.php');
    $_SESSION['id'] = $res["usuario_id"];
    $_SESSION['esVerificado'] = $res["usuario_esVerificado"];
    $_SESSION['esResponsable'] = getEsResponsable($res["usuario_id"]);
    $_SESSION['esAdmin'] = $res["usuario_esAdmin"];
    $_SESSION['fotoPerfil'] = $res["usuario_fotoPerfil"];
    $_SESSION['marcoFoto'] = $res["usuario_marcoFoto"];
    manejarError('true', 'Sesion iniciada con exito', 'Espere un momento mientras lo redirigimos a la pagina principal', "/index.php");
  }
  else manejarError('false','Datos invalidos','Usuario o clave incorrectos.');
}
else manejarError('false','Datos invalidos','Usuario o clave incorrectos.');

