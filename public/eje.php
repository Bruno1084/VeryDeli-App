<?php
    $data=array();
    $ok="";
    function getExtencion($text){
        return explode("/",$text)[1];
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
            require("./conectionImgBB.php");
            $dbImgBB=new DBIMG();
            $fotosASubir=array();
            for($i=0;$i<count($fotos);$i+=2){
                $extencion=getExtencion($fotos[$i+1]);
                $newName=stringRandom(10).$extencion;
                $fotoFinal=array("image"=>$fotos[$i],"name"=>$newName);
                $response=$dbImgBB->guardarImagenImgBB($fotoFinal,1);
                if($response==2){
                    $data["error"]="Error al guardar las fotos en la nube de imagenes";
                }
                else if($response==3){
                         $data["error"]="Error al guardar los datos de las fotos en la Base de Datos";
                     }
                     else if($response==0){
                             echo("Se han guardado las fotos correctamente");
                          }
            };
        }
    }
    else{
        $data["error"]="Error, No hay fotos";
    }
    if(!empty($data)){
        var_dump($data);
    }