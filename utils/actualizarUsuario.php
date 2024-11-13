<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/database/conection.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/utils/functions/limpiarCadena.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/utils/functions/verificarObligatorios.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/utils/functions/verificarDatos.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/utils/functions/manejaError.php");
require_once($_SERVER['DOCUMENT_ROOT']."/utils/get/getUsuario.php");

$db = new DB();
$conexion = $db->getConnection();
$id = $_POST['usuario_id'];
$datos = getUsuario($id);
//Almacena los datos
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$correo = $_POST['correo'];
$localidad = $_POST['localidad'];
$usuario = $_POST['usuario'];
$usuarioConfirm = $_POST['usuario_confirm'];
$contraseniaConfirm = $_POST['contraseña_confirm'];
$contrasenia = $_POST['contraseña'];

if($usuarioConfirm != $datos['usuario_usuario'] || !password_verify($contraseniaConfirm, $datos['usuario_contraseña'])){
  manejarError('false','Datos invalidos','Usuario o clave incorrectos.');
  exit(); 
} 

//Verificar campos obligatorios
if(!verificarCamposObligatorios([$nombre, $apellido, $correo, $localidad, $usuario])){
  manejarError('false','Campos sin completar','No se han llenado todos los campos obligatorios.');
  exit();
};

//Validar formato del nombre
if(verificarDatos('[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,30}', $nombre)){
  manejarError('false','Nombre invalido','El nombre no coincide con el formato solicitado.');  
  exit();
};

//Validar formato del apellido
if(verificarDatos('[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,30}', $apellido)){
  manejarError('false','Apellido invalido','El apellido no coincide con el formato solicitado.');
  exit();
};

//Validar formato del correo
if($correo != $datos['usuario_correo']){
  if(filter_var($correo, FILTER_VALIDATE_EMAIL)){
    //Verificar si el correo ya está registrado
    $checkcorreo = $conexion->prepare("SELECT usuario_correo FROM usuarios WHERE usuario_correo = ?");
    $checkcorreo->bindValue(1, $correo, PDO::PARAM_STR);
    $checkcorreo->execute();
    if($checkcorreo->rowCount() > 0){
      manejarError('false',"Correo inválido",'El correo ingresado ya se encuentra registrado.');
      $checkcorreo = null;
      $conexion = null;
      exit();
    };
    $checkcorreo = null;
  } else{
    manejarError('false',"Correo inválido",'El correo ingresado no es válido.');
    $conexion = null;
    exit();
    };
}

//Validar formato de la localidad
if(verificarDatos('[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,30}', $localidad)){
  manejarError('false','Localidad inválida',"La localidad ingresada no es válida");
  exit();
};

//Validar formato del usuario
if(verificarDatos('[a-zA-Z0-9]{4,20}', $usuario)){
  manejarError('false','Nombre de usuario inválido',"El usuario no coincide con el formato solicitado.");
  exit();
};

if($datos['usuario_usuario'] != $usuario){
  //Verificar si el nombre de usuario ya está en uso
  $checkUsuario = $conexion->prepare("SELECT usuario_usuario FROM usuarios WHERE usuario_usuario = ?");
  $checkUsuario->bindValue(1, $usuario, PDO::PARAM_STR);
  $checkUsuario->execute();

  if($checkUsuario->rowCount() > 0){
    manejarError('false',"Usuario inválido",'El nombre de usuario ingresado ya se encuentra en uso, ingrese otro.');
    $checkUsuario = null;
    $conexion = null;
    exit();
  };
}

$checkUsuario = null;

if(trim($contraseña) != ""){
  // Validar formato de la contraseña
  if(verificarDatos('[a-zA-Z0-9$@.\-]{7,100}', $contrasenia)){
    manejarError('false','Contraseña inválida','La contraseña ingresada no coincide con el formato solicitado.');
    exit();
  };
  //Generar hash de la contraseña con BCRYPT y costo 10
  $contrasenia = password_hash($contrasenia, PASSWORD_BCRYPT, ["cost"=>10]);
} else{
  $contrasenia = $datos['usuario_contraseña'];
}

// Actualizando los datos

$actualizarUsuario = $conexion->prepare(
  "UPDATE usuarios 
          SET usuario_nombre=?, usuario_apellido=?, usuario_usuario=?, usuario_clave=?, usuario_email=?, usuario_localidad=? 
          WHERE usuario_id = ?");
$actualizarUsuario->bindValue(1, $nombre, PDO::PARAM_STR);
$actualizarUsuario->bindValue(2, $apellido, PDO::PARAM_STR);
$actualizarUsuario->bindValue(3, $usuario, PDO::PARAM_STR);
$actualizarUsuario->bindValue(4, $contrasenia, PDO::PARAM_STR);
$actualizarUsuario->bindValue(5, $correo, PDO::PARAM_STR);
$actualizarUsuario->bindValue(6, $localidad, PDO::PARAM_STR);

if($actualizarUsuario->execute()){
  manejarError('true','Datos Actualizados', 'Sus datos se actualizaron con exito');
}else{
  manejarError('false', 'Error inesperado', 'Ocurrio un error, intente de nuevo mas tarde');
} 
$actualizarUsuario = null;
$conexion = null;