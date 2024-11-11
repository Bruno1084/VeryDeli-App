<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/database/conection.php");
class User {
    public static function userExist($usuario){
        //Verifica si el nombre de usuario está registrado
        $db = new DB();
        $conexion = $db->getConnection();

        $sql = "SELECT usuario_usuario FROM usuarios WHERE usuario_usuario = ? AND usuario_esActivo=1";
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(1, $usuario, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch();

        $stmt = null;
        $conexion = null;

        return $user;
    }
    public static function emailExist($correo){
        //Verifica si el nombre de usuario está registrado
        $db = new DB();
        $conexion = $db->getConnection();

        $sql = "SELECT usuario_correo FROM usuarios WHERE usuario_correo = ? AND usuario_esActivo=1";
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(1, $correo, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch();

        $stmt = null;
        $conexion = null;

        return $user;
    }

    public static function userPassExist($usuario, $contrasenia){
        $db = new DB();
        $conexion = $db->getConnection();

        $sql = "SELECT usuario_contraseña FROM usuarios WHERE usuario_usuario = ? AND usuario_esActivo = 1";
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(1, $usuario, PDO::PARAM_STR);
        $stmt->execute();

        $pass = $stmt->fetchColumn();
        if ($pass && password_verify($contrasenia, $pass)) {

            $sql = "
                SELECT 
                    u.usuario_id, 
                    u.usuario_esResponsable,
                    u.usuario_esVerificado, 
                    CASE WHEN a.administrador_id IS NOT NULL THEN 1 ELSE 0 END AS usuario_esAdmin,
                    COALESCE(fp.imagen_url, 0) AS usuario_fotoPerfil,
                    COALESCE(m.marco_url, 0) AS usuario_marcoFoto
                FROM 
                    usuarios u
                LEFT JOIN 
                    administradores a ON a.administrador_id = u.usuario_id
                LEFT JOIN 
                    fotosPerfil fp ON fp.usuario_id = u.usuario_id AND fp.imagen_estado = 1
                LEFT JOIN 
                    userMarcoFoto umf ON umf.usuario_id = u.usuario_id
                LEFT JOIN
                    marcos m ON m.marco_id = umf.marco_id
                WHERE 
                    u.usuario_usuario = ? 
                    AND u.usuario_esActivo = 1";

            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(1, $usuario, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmt = null;
            $conexion = null;
            return $user;
        }
        $stmt = null;
        $conexion = null;
        return false;
    }

    public static function emailUserPassExist($correo, $contrasenia){
        //Verifica que la contraseña corresponda al usuario
        $db = new DB();
        $conexion = $db->getConnection();

        $sql = "SELECT usuario_contraseña FROM usuarios WHERE usuario_correo = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(1, $correo, PDO::PARAM_STR);
        $stmt->execute();

        $pass = $stmt->fetch();
        $stmt = null;
        $conexion = null;
        if ($pass != false) {
            if (password_verify($contrasenia, $pass[0])) {
                return 1;
            } else {
                return 2;
            }
        } else {
            return false;
        }
    }

    public static function setEmailUserPass($correo, $contrasenia){
        $db = new DB();
        $conexion = $db->getConnection();
        $hashPass = password_hash($contrasenia, PASSWORD_BCRYPT, ["cost" => 10]);
        $sql = "UPDATE usuarios SET usuario_contraseña = ? WHERE usuario_correo = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(1, $hashPass, PDO::PARAM_STR);
        $stmt->bindValue(2, $correo, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $stmt = null;
            $conexion = null;
            return true;
        } else return false;
    }
}
