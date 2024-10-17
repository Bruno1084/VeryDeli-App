<?php 
    require_once($_SERVER["DOCUMENT_ROOT"]."/database/conection.php");
  class User{
    public static function userExist($usuario){
        //Verifica si el nombre de usuario está registrado
        $db=new DB();
        $conexion=$db->getConnection();
        
        $sql="SELECT usuario_usuario FROM usuarios WHERE usuario_usuario = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(1, $usuario, PDO::PARAM_STR);
        $stmt->execute();

        $user=$stmt->fetch();
        
        $stmt=null;
        $conexion=null;
        
        return $user;
    }
    public static function emailExist($correo){
        //Verifica si el nombre de usuario está registrado
        $db=new DB();
        $conexion=$db->getConnection();
        
        $sql="SELECT usuario_correo FROM usuarios WHERE usuario_correo = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(1, $correo, PDO::PARAM_STR);
        $stmt->execute();

        $user=$stmt->fetch();
        
        $stmt=null;
        $conexion=null;
        
        return $user;
    }

    public static function userPassExist($usuario,$contrasenia){
        //Verifica que la contraseña corresponda al usuario
        $db=new DB();
        $conexion=$db->getConnection();
        
        $sql="SELECT usuario_contraseña FROM usuarios WHERE usuario_usuario = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(1, $usuario, PDO::PARAM_STR);
        $stmt->execute();

        $pass=$stmt->fetch();
        if($pass!=false){
            if(password_verify($contrasenia, $pass[0])){
                $sql="SELECT usuario_id FROM usuarios WHERE usuario_usuario = ? AND usuario_contraseña = ?";
                $stmt = $conexion->prepare($sql);
                $stmt->bindValue(1, $usuario, PDO::PARAM_STR);
                $stmt->bindValue(2, $pass[0], PDO::PARAM_STR);
                $stmt->execute();

                $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $stmt=null;
                $conexion=null;
                return $user;
            }
        }
        $stmt=null;
        $conexion=null;
        return false;
    }
    public static function emailUserPassExist($correo,$contrasenia){
        //Verifica que la contraseña corresponda al usuario
        $db=new DB();
        $conexion=$db->getConnection();
        
        $sql="SELECT usuario_contraseña FROM usuarios WHERE usuario_correo = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(1, $correo, PDO::PARAM_STR);
        $stmt->execute();

        $pass=$stmt->fetch();
        $stmt=null;
        $conexion=null;
        if($pass!=false){
            if(password_verify($contrasenia, $pass[0])){
                return true;
            }
        }
        return false;
    }

    public static function setEmailUserPass($correo,$contrasenia){
        $db=new DB();
        $conexion=$db->getConnection();
        $hashPass=password_hash($contrasenia, PASSWORD_BCRYPT, ["cost"=>10]);
        $sql="UPDATE usuarios SET usuario_contraseña = ? WHERE usuario_correo = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(1, $hashPass, PDO::PARAM_STR);
        $stmt->bindValue(2, $correo, PDO::PARAM_STR);
        $stmt->execute();

        $res=$stmt->fetch();
        $stmt=null;
        $conexion=null;
        return $res;
    }


  }