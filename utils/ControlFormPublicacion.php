<?php
    $data=array();
    function getExtencion($text){
        return ".".explode("/",$text)[1];
    }
    function stringRandom(int $tam):string{
        $txt="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($txt),0, $tam);
    }
    
    if(!empty($_POST["photosId"])){
        $fotos=$_POST["photosId"];
        $formatSuportPhoto=["image/png","image/jpeg","image/jpg"];
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
                $response=$dbImgBB->guardarImagenesDB($urlFotos,1);
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