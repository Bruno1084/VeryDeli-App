<?php

  require_once("../database/conection.php");
  require_once("../utils/functions/limpiarCadena.php");
  require_once("../utils/functions/verificarObligatorios.php");
  require_once("../utils/functions/manejaError.php");

  //Almacena los datos

  $nombre = $_POST['nombre'];
  $apellido = $_POST['apellido'];
  $correo = $_POST['correo'];
  $localidad = $_POST['localidad'];
  $usuario = $_POST['usuario'];
  $contrasenia = $_POST['contraseña'];

  if(!verificarCamposObligatorios([$nombre, $apellido, $correo, $localidad, $usuario, $contrasenia])){
    manejarError('No se han llenado todos los campos obligatorios.');
    exit();
  };


  if(verificarDatos('[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,30}', $nombre)){
    manejarError('No has llenado todos los campos obligatorios.');  
    exit();
  };

  if(verificarDatos('[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,30}', $apellido)){
    manejarError('El apellido no coincide con el formato solicitado.');
    exit();
  };

  if($correo != ""){
    if(filter_var($correo, FILTER_VALIDATE_EMAIL)){
      $checkcorreo = $conexion->prepare("SELECT usuario_correo FROM usuarios WHERE usuario_correo = :correo");
      $checkcorreo->bindParam(":correo", $correo);
      $checkcorreo->execute();
      if($checkcorreo->rowCount() > 0){
        manejarError('El correo ingresado ya se encuentra registrado.');
        $checkcorreo = null;
        $conexion = null;
        exit();
      }
    $checkcorreo = null;
  }
  else{
    manejarError('El correo ingresado no es válido.');
    $conexion = null;
    exit();
    }
  };

  if(verificarDatos('[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,30}', $localidad)){
    manejarError("La localidad ingresada no es válida");
    exit();
  }
  
  if(verificarDatos('[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,30}', $usuario)){
    manejarError("El usuario no coincide con el formato solicitado.");
    exit();
  }
  
  $checkUsuario = $conexion->prepare("SELECT usuario_usuario FROM usuarios WHERE usuario_usuario = :usuario");
  $checkUsuario->bindParam(':usuario', $usuario);
  $checkUsuario->execute();
  if($checkUsuario->rowCount() > 0){
    manejarError('El nombre de usuario ingresado ya se encuentra en uso, ingrese otro.');
    $checkUsuario = null;
    $conexion = null;
    exit();
  };
  $checkUsuario = null;
  
  if(verificarDatos('[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,30}', $contrasenia)){
    manejarError('La contraseña ingresada no coincide con el formato solicitado.');
    exit();
  }

  $contrasenia = password_hash($contrasenia, PASSWORD_BCRYPT, ["cost"=>10]);
  $sql = $conexion->prepare("INSERT INTO usuarios (usuario_nombre, usuario_apellido, usuario_correo, usuario_localidad, usuario_usuario, usuario_contraseña) VALUES (:nombre, :apellido, :correo, :localidad, :usuario, :contrasenia)");
  // Vincular los parámetros
  $datos = [
  ":nombre" => $nombre,
  ":apellido" => $apellido,
  ":correo" => $correo,
  ":localidad" => $localidad,
  ":usuario" => $usuario,
  ":contrasenia" => $contrasenia
  ];
  
  if ($sql->execute($datos)){
    echo '
      <div class="text-bg-success p-3">
        <strong>¡Usuario registrado exitosamente!</strong>
      </div>
    ';
  } else {
  manejarError('Error al registrar el usuario. Intente de nuevo más tarde.');
  }
  $conexion = null;
?>