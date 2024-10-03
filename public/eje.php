<?php
    $data=array();
    $ok="";
    function getExtencion(string $name):string{
        $ext=explode(".",$name);
        return ".".$ext[1];
    }
    function stringRandom(int $tam):string{
        $txt="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($txt),0, $tam);
    }
    function curlImgBB($img,$name){
        $apiKey="b9a4cf5a03920383d33b750bae0914a0";
        define("URL","https://api.imgbb.com/1/upload?key=".$apiKey);
        $con=curl_init();
        $header=array("Content-Type : application/x-www-form-urlencoded");
        $imageFinal=array("image"=>$img,"name"=>$name);

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
        }else{
            curl_close($con);
            $item=json_decode($strResponse);
            echo json_encode($item);
            $res["status"]=$item->status;
            $res["success"]=$item->success;
            $res["url_viewer"]=$item->data->url_viewer;
            $res["url"]=$item->data->url;
            $res["delete_url"]=$item->data->delete_url;
    
            echo json_encode($res);
        }
    }
    if(isset($_FILES)&& !empty($_FILES)){
        $fotosASubir=$_POST["photosId"];
        $fotos=array_filter($_FILES,function($foto){
            return $foto["name"][0]!="";
        });
        foreach($fotos as $foto){
            for($i=0;$i<count($foto["name"]);$i++){
                $name=$foto["name"][$i];
                if(in_array($name,$fotosASubir)){
                    $tmp_name=$foto["tmp_name"][$i];
                    $extencion=getExtencion($name);
                    $newName=stringRandom(10).$extencion;
                    curlImgBB($tmp_name,$newName);
                }
            }
        };
    }
    else{
        $data["error"]="Error, No hay fotos";
    }
    if(!empty($data)){
        echo json_encode($data);
    }