<?php
    require_once($_SERVER["DOCUMENT_ROOT"]."/utils/functions/startSession.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."/utils/functions/obtenerFoto.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."/components/comentario.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."/database/conection.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."/utils/get/getAllComentariosFromPublicacion.php");
    if(isset($_POST["more"])){
        $totalComentarios=$_POST["totalComentarios"];
        $contadorComentarios=$_POST["countComentarios"];
        $idPublicacion=$_POST["idPublicacion"];
        $limit=$_POST["limit"];
        $offset=$_POST["offset"];
        $denuncia=$_POST["denuncia"];
        $pubEstado=$_POST["pubEstado"];
        if($denuncia==1)$denuncia=false;
        else $denuncia=true;
        $res=getAllComentariosFromPublicacion($idPublicacion,$offset,$limit,$denuncia);
        $comentarios=array();
        foreach ($res as $c) {
            $foto=array("foto"=>$c["usuario_fotoPerfil"],"marco"=>$c["usuario_marcoFoto"]);
            if(isset($c["esReportado"])){
              if($c["esReportado"]){
                $comentarios[]=renderComentario(
                  $contadorComentarios,
                  $c["comentario_id"],
                  $c["usuario_usuario"],
                  $foto,
                  $c["comentario_fecha"],
                  $c['comentario_mensaje'],
                  $c["usuario_id"],
                  $pubEstado,
                  2
                );
              }else{
                $comentarios[]=renderComentario(
                  $contadorComentarios,
                  $c["comentario_id"],
                  $c["usuario_usuario"],
                  $foto,
                  $c["comentario_fecha"],
                  $c['comentario_mensaje'],
                  $c["usuario_id"],
                  $pubEstado,
                  1
                );
  
              }
            }
            else{
                $comentarios[]=renderComentario(
                $contadorComentarios,
                $c["comentario_id"],
                $c["usuario_usuario"],
                $foto,
                $c["comentario_fecha"],
                $c['comentario_mensaje'],
                $c["usuario_id"],
                $estado
              );
            }
            $contadorComentarios++;
        }
        $masComents=array();
        if($totalComentarios>$contadorComentarios){
            $masComents[]='<div id="masComentarios" class="text-center mb-3 pb-1 pt-2 border-top border-bottom border-dark-subtle col-12">
                <h5>Cargar mas</h5>
            </div>';
        }
        $respuesta=array("comentarios"=>$comentarios,"masComents"=>$masComents,"cantComentarios"=>$contadorComentarios);
        echo json_encode($respuesta);
        exit();
    }
    