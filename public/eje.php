<?php
    if(isset($_POST["enviar"])){
        if(isset($_FILES)&& !empty($_FILES)){
            $fotos=array_filter($_FILES,function($item){
                return $item["name"][0]!="";
            });
            $photosId=$_POST["photosId"];
            if(str_contains($photosId,";")){
                $photosId=explode(";",$photosId);
                for($i=0;$i<sizeof($photosId);$i++){
                    if(str_contains($photosId[$i],",")){
                        $photosId[$i]=explode(",",$photosId[$i]);
                        for($j=0;$j<sizeof($photosId[$i]);$j++){
                            $photosId[$i][$j]=str_replace($photosId[$i][$j],"fotoUsuario_","");
                        }
                    }
                    else{
                        $photosId[$i]=str_replace($photosId[$i],"fotoUsuario_","");
                    }
                }
            }
            else{
                if(str_contains($photosId,",")){
                    $photosId=explode(",",$photosId);
                    for($i=0;$i<sizeof($photosId);$i++){
                        $photosId[$i]=str_replace($photosId[$i],"fotoUsuario_","");
                    }
                }
                else{
                    $photosId=str_replace($photosId,"fotoUsuario_","");
                }
            }
            
            echo "<pre>";
            var_dump($photosId);
            var_dump($fotos);
            echo "</pre>";
        }
    }
    //header("location: ./");