<?php
    $data=array();
    function getExtencion($text){
        return ".".explode("/",$text)[1];
    }
    function stringRandom(int $tam):string{
        $txt="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($txt),0, $tam);
    }
    
    if(!empty($_POST["photosId"]) && isset($_POST['enviado'])){
        session_start();
        require_once($_SERVER['DOCUMENT-ROOT'] . "/utils/functions/manejaError.php");
        require_once($_SERVER['DOCUMENT-ROOT'] . "/database/conection.php");
        $fotos = $_POST["photosId"];
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $volumen = $_POST['volumen'];
        $peso = $_POST['peso'];
        $origen = $_POST['origen'];
        $destino = $_POST['destino'];
        $recibe = $_POST['recibe'];
        $telContacto = $_POST['contacto'];
        $formatSuportPhoto=["image/png","image/jpeg","image/jpg"];
        $usuarioAutor = $_SESSION['id'];
        $db = new DB();
        $conexion = $db->getConnection();
        
        if(!$_SESSION['esResponsable']){
          $stmtCantPublicaciones = $conexion->prepare("SELECT * FROM publicaciones WHERE usuario_autor = ? AND publicacion_esActivo = true");
          $stmtCantPublicaciones->bindParam(1, $usuarioAutor, PDO::PARAM_INT);
          if($stmtCantPublicaciones->execute()){
            if($stmtCantPublicaciones->rowCount() > 3){
              manejarError('Limite excedido', "Has excedido el limite de publicaciones activas.");
              $stmtCantPublicaciones = null;
              exit;
            }
          } else {
            $stmtCantPublicaciones = null;
            manejarError("Error Inesperado", "Ocurrio un error al momento de validar su cantidad de publicaciones");
            exit;
          }
        }
        
        $stmtPublicacion = $conexion->prepare("INSERT INTO publicaciones (publicacion_titulo, publicacion_descr, publicacion_peso, publicacion_volumen, publicacion_origen, publicacion_destino, publicacion_nombreRecibe, publicacion_telefono, usuario_autor, publicacion_esActivo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, true)");
        $stmt->bindParam(1, $titulo, PDO::PARAM_STR);
        $stmt->bindParam(2, $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(3, $peso);
        $stmt->bindParam(4, $volumen);
        $stmt->bindParam(5, $origen, PDO::PARAM_STR);
        $stmt->bindParam(6, $destino, PDO::PARAM_STR);
        $stmt->bindParam(7, $recibe, PDO::PARAM_STR);
        $stmt->bindParam(8, $telContacto, PDO::PARAM_STR);
        $stmt->bindParam(9, $usuarioAutor, PDO::PARAM_INT);
        
        if($stmtPublicacion->execute()){
          $newPubli = $stmtPublicacion->fetch();
          $idPub = $newPubli['publicacion_id'];
        } else {
          $stmtPublicacion = null;
          manejarError("Error Inesperado", "Ocurrio un error al momento de subir tu publicacion, intente de nuevo más tarde");
          exit;
        }

        for($i=0;$i<count($fotos);$i+=2){
            if(!in_array($fotos[$i+1],$formatSuportPhoto)){
                $data["error"]="Error, Se encontro un tipo no valido";
                break;
            }
        }
        if(empty($data)){
            require("../database/conectionImgBB.php");
            $dbImgBB=new DBIMG();
            $urlFotos=array();
            for($i=0;$i<count($fotos);$i+=2){
                $extencion=getExtencion($fotos[$i+1]);
                $newName=stringRandom(10).$extencion;
                $fotoFinal=array("image"=>$fotos[$i],"name"=>$newName);
                $response=$dbImgBB->guardarImagenImgBB($fotoFinal);
                if(is_array($response)){
                    $urlFotos[]=$response;
                }
                else{
                    $data["error"]=$response;
                    break;
                }
            }
            if(empty($data)){
                $response=$dbImgBB->guardarImagenesDB($urlFotos,$idPub);
                if(!$response){
                    $data["error"]="Error al guardar las fotos en la Base de Datos";
                    require_once("../utils/getImagen.php");
                    require_once("../utils/borrarImagenImgBB.php");
                    foreach($urlFotos as $foto){
                        $tmpImg=getImagen($foto["imagen_url"]);
                        if(empty($tmpImg)){
                            $response=borrarImagenImgBB($foto["delete_url"]);
                            if(!$response){
                                $data["error"]+="Error al querer eliminar las fotos de la nube de fotos";
                                break;
                            }
                        }
                    }
                }
                else{
                    echo json_encode("Se han guardado las fotos correctamente");
                }
            }
            else{
                require_once("../utils/getImagen.php");
                require_once("../utils/borrarImagenImgBB.php");
                foreach($urlFotos as $foto){
                    $tmpImg=getImagen($foto["imagen_url"]);
                    if(empty($tmpImg)){
                        $response=borrarImagenImgBB($foto["delete_url"]);
                        if(!$response){
                            $data["error"]+="Error al querer eliminar las fotos de la nube de fotos";
                            break;
                        }
                    }
                }
            }
        }
    }
    else{
        $data["error"]="Error, No hay fotos";
    }
    if(!empty($data)){
        echo json_encode($data);
    }