<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/database/conection.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/utils/functions/limpiarCadena.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/utils/functions/verificarObligatorios.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/utils/functions/verificarDatos.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/utils/functions/manejaError.php");

$db = new DB();
$conexion = $db->getConnection();

//Almacena los datos
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$correo = $_POST['correo'];
$localidad = $_POST['localidad'];
$usuario = $_POST['usuario'];
$contrasenia = $_POST['contraseña'];
$tipoVehiculo = $_POST["tipoVehiculo"];
$patente = $_POST["patente"];
$pesoSoportado =(double) str_replace(",","",(explode(" ",$_POST["pesoSoportado"])[0]));
$volumenSoportado =(double) explode(" ",$_POST["volumenSoportado"])[0];

//Verificar campos obligatorios
if(!verificarCamposObligatorios([$nombre, $apellido, $correo, $localidad, $usuario, $contrasenia])){
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

$checkUsuario = null;

// Validar formato de la contraseña
if(verificarDatos('[a-zA-Z0-9$@.\-]{7,100}', $contrasenia)){
  manejarError('false','Contraseña inválida','La contraseña ingresada no coincide con el formato solicitado.');
  exit();
};

// Validar patente del Transportista
if(isset($_POST["serTransportista"])){

}

//Generar hash de la contraseña con BCRYPT y costo 10
$contrasenia = password_hash($contrasenia, PASSWORD_BCRYPT, ["cost"=>10]);

//Insertar el nuevo usuario en la base de datos
$sql = "INSERT INTO usuarios (usuario_nombre, usuario_apellido, usuario_correo, usuario_localidad, usuario_usuario, usuario_contraseña) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bindValue(1, $nombre, PDO::PARAM_STR);
$stmt->bindValue(2, $apellido, PDO::PARAM_STR);
$stmt->bindValue(3, $correo, PDO::PARAM_STR);
$stmt->bindValue(4, $localidad, PDO::PARAM_STR);
$stmt->bindValue(5, $usuario, PDO::PARAM_STR);
$stmt->bindValue(6, $contrasenia, PDO::PARAM_STR);

if ($stmt->execute()){
  $stmt=null;
  if(isset($_POST["serTransportista"])){
    $idUser=$conexion->lastInsertId();
    $conexion=null;
    require_once($_SERVER["DOCUMENT_ROOT"]."/utils/registrarTransportista.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."/utils/registrarVehiculo.php");

    if(!registrarTransportista($idUser))
      manejarError("false","Registro parcial","Error al registrar como transportista","../components/login.php");
    
    if(!registrarVehiculo_Sing_up($idUser,$tipoVehiculo,$patente,$pesoSoportado,$volumenSoportado))
      manejarError("false","Registro parcial","Error al registrar el vehiculo", "../components/login.php");
    
  }
  else $conexion=null;
  manejarError('true', 'Registrado con exito', "", "../components/login.php");
} else {
  $stmt=null;
  $conexion=null;
manejarError('false','Ocurrio un error inesperado','Error al registrar el usuario. Intente de nuevo más tarde.');
};
$conexion = null;
