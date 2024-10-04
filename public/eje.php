<?php
    $data=array();
    define("URL","https://api.imgbb.com/1/upload?key=edbd60e6db615da0b89a51189c5e4fe3");
    $ok="";
    function getExtencion($text){
        return explode("/",$text)[1];
    }
    function stringRandom(int $tam):string{
        $txt="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($txt),0, $tam);
    }
    function curlImgBB($img,$name){
        $header=array("Content-Type : application/x-www-form-urlencoded");
        $imageFinal=array("image"=>$img,"name"=>$name);
        
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
        //añadir el header a la solicitud
        curl_setopt($con,CURLOPT_HTTPHEADER,$header);

        $strResponse=curl_exec($con);
        if(curl_errno($con)){
            $curlError=curl_error($con);
            $data["error"]=$curlError;
            return false;
        }
        curl_close($con);
        echo $strResponse;
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
            for($i=0;$i<count($fotos);$i+=2){
                $extencion=getExtencion($fotos[$i+1]);
                $newName=stringRandom(10).$extencion;
                curlImgBB($fotos[$i],$newName);
            };
        }
    }
    else{
        $data["error"]="Error, No hay fotos";
    }
    if(!empty($data)){
        echo json_encode($data);
    }