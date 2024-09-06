<?php
require_once("../database/conection.php");
require_once("../utils/functions/limpiarCadena.php");
require_once("../utils/functions/verificarObligatorios.php");
require_once("../utils/functions/manejaError.php");
require_once("../utils/functions/verificarDatos.php");

//Almacena los datos
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$correo = $_POST['correo'];
$localidad = $_POST['localidad'];
$usuario = $_POST['usuario'];
$contrasenia = $_POST['contraseña'];

//Verificar campos obligatorios
if(!verificarCamposObligatorios([$nombre, $apellido, $correo, $localidad, $usuario, $contrasenia])){
  manejarError('No se han llenado todos los campos obligatorios.');
  exit();
};

//Validar formato del nombre
if(verificarDatos('[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,30}', $nombre)){
  manejarError('El nombre no coincide con el formato solicitado.');  
  exit();
};

//Validar formato del apellido
if(verificarDatos('[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,30}', $apellido)){
  manejarError('El apellido no coincide con el formato solicitado.');
  exit();
};

//Validar formato del correo
if(filter_var($correo, FILTER_VALIDATE_EMAIL)){
  //Verificar si el correo ya está registrado
  $conexion = conectarBD();
  $checkcorreo = $conexion->prepare("SELECT usuario_correo FROM usuarios WHERE usuario_correo = ?");
  $checkcorreo->bind_param("s", $correo);
  $checkcorreo->execute();
  $checkcorreo->store_result();
  if($checkcorreo->num_rows > 0){
    manejarError('El correo ingresado ya se encuentra registrado.');
    $checkcorreo->close();
    $conexion->close();
    exit();
  };
  $checkcorreo->close();
} else{
  manejarError('El correo ingresado no es válido.');
  $conexion->close();
  exit();
  };

//Validar formato de la localidad
if(verificarDatos('[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,30}', $localidad)){
  manejarError("La localidad ingresada no es válida");
  exit();
};

//Validar formato del usuario
if(verificarDatos('[a-zA-Z0-9]{4,20}', $usuario)){
  manejarError("El usuario no coincide con el formato solicitado.");
  exit();
};

//Verificar si el nombre de usuario ya está en uso
$checkUsuario = $conexion->prepare("SELECT usuario_usuario FROM usuarios WHERE usuario_usuario = ?");
$checkUsuario->bind_param('s', $usuario);
$checkUsuario->execute();
$checkUsuario->store_result();

if($checkUsuario->num_rows > 0){
  manejarError('El nombre de usuario ingresado ya se encuentra en uso, ingrese otro.');
  $checkUsuario->close();
  $conexion->close();
  exit();
};

$checkUsuario->close();

// Validar formato de la contraseña
if(verificarDatos('[a-zA-Z0-9$@.\-]{7,100}', $contrasenia)){
  manejarError('La contraseña ingresada no coincide con el formato solicitado.');
  exit();
};

//Generar hash de la contraseña con BCRYPT y costo 10
$contrasenia = password_hash($contrasenia, PASSWORD_BCRYPT, ["cost"=>10]);

$serTransportista = "";

if(!empty($_POST['serTransportista'])){
  require_once("../utils/registrarVehiculo.php");
  $serTransportista = $_POST['serTransportista'];
  if(!isset($_POST['tipoVehiculo'])){
    manejarError("Seleccione el tipo de vehiculo");
    exit();
  }
  
  $tipoVehiculo = $_POST['tipoVehiculo'];
  $patente = $_POST['patente'];
  
  if(empty($patente)){
    manejarError("Ingrese la patente del vehiculo.");
    exit();
  }

  if(verificarDatos("[a-zA-Z0-9]{6,7}", $patente)){
    manejarError("La patente no coincide con el formato solicitado.");
    exit();
  }
  
  if(!isset($_POST['volumenSoportado'])){
    manejarError("Seleccione el volumen soportado por el vehiculo.");
    exit();
  }

  $volumenSoportado = $_POST['volumenSoportado'];
  
  if(!isset($_POST['pesoSoportado'])){
    manejarError("Seleccione el peso soportado por el vehiculo.");
    exit();
  }
  
  $pesoSoportado = $_POST['pesoSoportado'];
}

//Insertar el nuevo usuario en la base de datos
$sql = "INSERT INTO usuarios (usuario_nombre, usuario_apellido, usuario_correo, usuario_localidad, usuario_usuario, usuario_contraseña) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param('ssssss', $nombre, $apellido, $correo, $localidad, $usuario, $contrasenia);
$excExitoso = $stmt->execute();

if ($excExitoso AND $serTransportista == ""){
  echo '
  <div class="text-bg-success p-3">
    <strong>¡Usuario registrado exitosamente!</strong>
  </div>
  ';
} elseif ($excExitoso AND $serTransportista != ""){
  $stmt = $conexion->prepare("SELECT usuario_id FROM usuarios WHERE usuario_correo = ?");
  $stmt->bind_param("s", $correo);
  $stmt->execute();
  $id = $stmt->get_result();
  $id = $id->fetch_assoc();
  require_once("../utils/registrarTransportista.php");
  if(registrarTransportista($id['usuario_id'])){
    echo '
    <div class="text-bg-success p-3">
      <strong>¡Usuario transportista registrado exitosamente!</strong>
    </div>
  ';
  }else{
    manejarError("Error al registrar al usuario como transportista. Sera registrado como un usuario normal.");
    exit();
  }

  if(!guardarVehiculo($id['usuario_id'], $tipoVehiculo, $patente, $pesoSoportado, $volumenSoportado)){
    manejarError('Error al registrar el vehiculo. Intente de nuevo más tarde.');
    exit();
  }
} else{
  manejarError('Error al registrar el usuario. Intente de nuevo más tarde.');
};

$conexion->close();
?>