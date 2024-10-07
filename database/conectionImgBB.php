<?php
require_once("../database/conection.php");

class DBIMG {
  private static $KEY;

  public function __construct () {
      self::$KEY = $_ENV['IMG_DB_KEY'];
      define("URL","https://api.imgbb.com/1/upload?key=".self::$KEY);
  }

  public static function guardarImagenImgBB($imageFinal){
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
            return curl_error($con);
        }
        else{
            //Cierra la conexion y almacena la respueta del hosting de imagenes 
            curl_close($con);
            $decode=json_decode($strResponse,true);
            $res["url"]=$decode["data"]["url"];
            $res["delete_url"]=$decode["data"]["delete_url"];
            return $res;
        }
    }
    catch(Exception $e){
        return $e->getMessage();
    }
}

  public static function guardarImagenesDB($imagenes,$publicacion_id){
    $db = new DB();
    $conexion = $db->getConnection();
    for($i=0;$i<count($imagenes);$i++){
      $tmpImgs=array();
      
      $sql = "SELECT `imagen_id` FROM `imagenes` WHERE `imagen_url`=? AND `publicacion_id`=?";
      
      $stmt = $conexion->prepare($sql);
      $stmt->bindValue(1, $imagenes[$i]["url"], PDO::PARAM_STR);
      $stmt->bindValue(2, $publicacion_id, PDO::PARAM_INT);
      $stmt->execute();

      $tmpImgs = $stmt->fetchAll(PDO::FETCH_ASSOC);
      if(empty($tmpImgs)){
        $sql = "INSERT INTO `imagenes` (`imagen_url`, `publicacion_id`, `imagen_delete_url`) VALUES (?,?,?)";
        
        $stmt = $conexion->prepare($sql);
        
        $stmt->bindValue(1, $imagenes[$i]["url"], PDO::PARAM_STR);
        $stmt->bindValue(2, $publicacion_id, PDO::PARAM_INT);
        $stmt->bindValue(3, $imagenes[$i]["delete_url"], PDO::PARAM_STR);
  
        $response=$stmt->execute();
        if(!$response){
          $stmt = null;
          $conexion = null;
          return false;
        }
      }
    }
    $stmt = null;
    $conexion = null;
    return true;
  }
}
