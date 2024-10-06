<?php

// Requiere el autoload de Composer
require_once('../vendor/autoload.php');

// Cargar las variables del archivo .env
$dotenv = Dotenv\Dotenv::createImmutable("../");
$dotenv->load();


require_once('../database/conection.php');

class DBIMG {
  private static $KEY;

  public function __construct () {
      self::$KEY = $_ENV['IMG_DB_KEY'];
      define("URL","https://api.imgbb.com/1/upload?key=".self::$KEY);
  }

  public static function guardarImagenImgBB($imageFinal,$publicacion_id){
      try{
        $con=curl_init();
        curl_setopt($con,CURLOPT_URL,URL);
        //hacer solicitud POST
        curl_setopt($con,CURLOPT_POST,true);
        //enviar la imagen
        curl_setopt($con,CURLOPT_POSTFIELDS,$imageFinal);
        //almacenar la respuesta del Servidor
        curl_setopt($con,CURLOPT_RETURNTRANSFER,true);
        //verificar se el certificado del servidor es autentico | false:Evita que verifique por estar en localhost 
        curl_setopt($con,CURLOPT_SSL_VERIFYPEER,false);
        
        $strResponse=curl_exec($con);
        
        //Corta el proceso si la conexion dio error
        
        if(curl_errno($con)){
            return 2;
        }
        else{
            //Cierra la conexion y almacena la respueta del hosting de imagenes 
            curl_close($con);
            $decode=json_decode($strResponse,true);
            var_dump($decode);
            //almacena las url obtenidas
            
            if(self::guardarImagenDB($decode["data"]["url"],$publicacion_id,$decode["data"]["delete_url"])){
                return 0;
            }
            else{
                //elimina las fotos que se hallan subido, en caso de error al guardar las url de las mismas en la DB
    
                self::borrarImagenImgBB($decode["data"]["delete_url"]);
                return 3;
            }
        }
    }
    catch(Exception $e){
        $data["error"]=$e->getMessage();
        return 1;
    }
}

  private static function guardarImagenDB($url,$p_id,$url_delete){
    $db = new DB();
    $conexion = $db->getConnection();
  
    $sql = "INSERT INTO `imagenes` (`imagen_url`, `publicacion_id`, `imagen_url_delete`) VALUES (?,?,?)";
    $stmt = $conexion->prepare($sql);
    
    $stmt->bindValue(1, $url, PDO::PARAM_STR);
    $stmt->bindValue(2, $p_id, PDO::PARAM_INT);
    $stmt->bindValue(3, $url_delete, PDO::PARAM_STR);

    $response=$stmt->execute();
    $stmt = null;
    $conexion = null;
    return $response;
  }
  public static function borrarImagenImgBB($delete_url) {
    $con = curl_init();
    curl_setopt($con, CURLOPT_URL, $delete_url);
    curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($con, CURLOPT_CUSTOMREQUEST, "GET");

    $response = curl_exec($con);
    
    return $response;
  }
  public static function borrarImagenDB($id,bool $foto_publicacion=false) {
    //foto_publicacion refiere a que se va a eliminar, la foto como singular, o las fotos pertenecientes a una publicacion
    //false: se elimina la foto en singular
    //true: se eliminan todas las fotos de una publicacion

    require '../database/conection.php';
    $db = new DB();
    $conexion = $db->getConnection();

    if($foto_publicacion) $sql = "DELETE FROM `imagenes` WHERE `publicacion_id`=?";
    else $sql = "DELETE FROM `imagenes` WHERE `imagen_id`=?";
    
    $stmt = $conexion->prepare($sql);
    
    $stmt->bindParam(1, $id, PDO::PARAM_INT);
    
    $response=$stmt->execute();
    $stmt = null;
    $conexion = null;
    return $response;    
  }

}
