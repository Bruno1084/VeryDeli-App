<?php 
    require_once($_SERVER["DOCUMENT_ROOT"]."/database/conection.php");
  class User{
    public static function userExist($usuario){
        //Verifica si el nombre de usuario está registrado
        $db=new DB();
        $conexion=$db->getConnection();
        
        $sql="SELECT usuario_usuario FROM usuarios WHERE usuario_usuario = ? AND usuario_esActivo='1'";
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
        
        $sql="SELECT usuario_correo FROM usuarios WHERE usuario_correo = ? AND usuario_esActivo='1'";
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
        
        $sql="SELECT usuario_contraseña FROM usuarios WHERE usuario_usuario = ? AND usuario_esActivo='1'";
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(1, $usuario, PDO::PARAM_STR);
        $stmt->execute();

        $pass=$stmt->fetch();
        if($pass!=false){
            if(password_verify($contrasenia, $pass[0])){
                $sql="  SELECT 
                            usuarios.usuario_id, 
                            usuarios.usuario_esResponsable,
                            usuarios.usuario_esVerificado, 
                            CASE WHEN administradores.administrador_id IS NOT NULL THEN 1 ELSE 0 END AS usuario_esAdmin,
                            CASE WHEN fotosPerfil.usuario_id IS NOT NULL THEN fotosPerfil.imagen_url ELSE 0 END AS usuario_fotoPerfil,
                            CASE WHEN usuarios.usuario_esVerificado = '1' THEN marcos.marco_url ELSE 0 END AS usuario_marcoFoto
                        FROM 
                            usuarios
                        LEFT JOIN 
                            administradores ON administradores.administrador_id = usuarios.usuario_id
                        LEFT JOIN 
                            fotosPerfil ON fotosPerfil.usuario_id = usuarios.usuario_id AND fotosPerfil.imagen_estado = '1'
                        LEFT JOIN 
                        	userMarcoFoto ON userMarcoFoto.usuario_id=usuarios.usuario_id
                        LEFT JOIN
                            marcos ON marcos.marco_id = userMarcoFoto.marco_id
                        WHERE 
                            usuarios.usuario_usuario = ? 
                            AND usuarios.usuario_contraseña = ?
                            AND usuarios.usuario_esActivo = '1'";
                
                $stmt = $conexion->prepare($sql);
                $stmt->bindValue(1, $usuario, PDO::PARAM_STR);
                $stmt->bindValue(2, $pass[0], PDO::PARAM_STR);
                $stmt->execute();

                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
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
                return 1;
            }
            else{
                return 2;
            }
        }
        else{
            return false;
        }
    }

    public static function setEmailUserPass($correo,$contrasenia){
        $db=new DB();
        $conexion=$db->getConnection();
        $hashPass=password_hash($contrasenia, PASSWORD_BCRYPT, ["cost"=>10]);
        $sql="UPDATE usuarios SET usuario_contraseña = ? WHERE usuario_correo = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(1, $hashPass, PDO::PARAM_STR);
        $stmt->bindValue(2, $correo, PDO::PARAM_STR);
        if($stmt->execute()){
            $stmt=null;
            $conexion=null;
            return true;
        }
        else return false;
    }
  }
