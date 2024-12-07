<?php
function obtenerFoto($fYm,$userName=false){
  if($userName==false){
    if($fYm["foto"]==0 && $fYm["marco"]==0){
      return "<div class='defaultPicture'><img src='../assets/user.png' alt='user'></div>";
    }
    elseif($fYm["foto"]!=0 && $fYm["marco"]==0){
      return "<div class='defaultPicture'><img src='".$fYm["foto"]."' alt='user'></div>";
    }
    elseif($fYm["foto"]==0 && $fYm["marco"]!=0){
      return '<div class="profilePicture">
              <div class="fondoFoto"></div><img src="'.$fYm["marco"].'" class="decoFoto'.$fYm["marco"][(strlen($fYm["marco"])-5)].'">
              <div class="divFoto"><img src="../assets/user.png" alt="user"></div>
              </div>';
    }
    else{
      return '<div class="profilePicture">
              <div class="fondoFoto"></div><img src="'.$fYm["marco"].'" class="decoFoto'.$fYm["marco"][(strlen($fYm["marco"])-5)].'">
              <div class="divFoto"><img src="'.$fYm["foto"].'" alt="user"></div>
              </div>';
    }
  }
  else{
    if($fYm["foto"]==0 && $fYm["marco"]==0){
      return "<a href='/pages/miPerfil.php?user=".$userName."' class='defaultPicture'><img src='../assets/user.png' alt='user'></a>";
    }
    elseif($fYm["foto"]!=0 && $fYm["marco"]==0){
      return "<a href='/pages/miPerfil.php?user=".$userName."' class='defaultPicture'><img src='".$fYm["foto"]."' alt='user'></a>";
    }
    elseif($fYm["foto"]==0 && $fYm["marco"]!=0){
      return '<a href="/pages/miPerfil.php?user='.$userName.'" class="profilePicture">
              <div class="fondoFoto"></div><img src="'.$fYm["marco"].'" class="decoFoto'.$fYm["marco"][(strlen($fYm["marco"])-5)].'">
              <div class="divFoto"><img src="../assets/user.png" alt="user"></div>
              </a>';
    }
    else{
      return '<a href="/pages/miPerfil.php?user='.$userName.'" class="profilePicture">
              <div class="fondoFoto"></div><img src="'.$fYm["marco"].'" class="decoFoto'.$fYm["marco"][(strlen($fYm["marco"])-5)].'">
              <div class="divFoto"><img src="'.$fYm["foto"].'" alt="user"></div>
              </a>';
    }
  }
}

function locacion($coordLat,$coordLng){
  $point=$coordLat.",".$coordLng;
  $query = array(
      "limit" => "1",
      "reverse" => "true",
      "point" => $point,
      "provider" => "default",
      "key" => "96865858-2f5d-4a0a-9c0b-d56b3f1e20cc"
    );
        
    // Configuración de cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://graphhopper.com/api/1/geocode?". http_build_query($query));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // Esto desactiva la verificación SSL, no recomendado en producción
    $response = curl_exec($ch);
    
    if(curl_errno($ch)) {
      return '';
    }else{
      curl_close($ch);
      $data = json_decode($response, true);
      return $data;
    }
}

function transportistaPublicacion($idPublicacion, $estado){
  if($estado!=1){
    $res=getTransportistaPublicacion($idPublicacion);
    if($res!=false){
      return $res;
    }
  }
  return false;
}

function postulantesPublicacion($idPublicacion){
  $db=new DB();
  $conexion=$db->getConnection();
  $sql="SELECT usuario_postulante FROM postulaciones WHERE publicacion_id = ?";
  $stmtPost=$conexion->prepare($sql);
  $stmtPost->bindParam(1,$idPublicacion,PDO::PARAM_INT);
  $res=array();
  if($stmtPost->execute()){
    $res=$stmtPost->fetchAll(PDO::FETCH_NUM);
  }
  $postulantes=array();
  foreach($res as $re){
    $postulantes[]=$re[0];
  }
  $stmtPost=null;
  $conexion=null;
  $db=null;
  return $postulantes;
}

function renderPublicacionExtendida ($idPublicacion, $idUsuario, $username, $profileIcon, $date, $userLocation, $tituloPublicacion, $productDetail, $weight, $volume, $nombreRecibe, $telefono, $origin, $destination, $images, $estado, $denunciada=false) {
  include_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/funcionesCalificaciones.php');
  include_once($_SERVER['DOCUMENT_ROOT'] . '/utils/get/getAVGCalificacionesFromUsuario.php');
  include_once($_SERVER["DOCUMENT_ROOT"] . '/components/postComentario.php');
  include_once($_SERVER["DOCUMENT_ROOT"] . '/components/comentario.php');
  include_once($_SERVER['DOCUMENT_ROOT'] . "/utils/get/getAllComentariosFromPublicacion.php");
  include_once($_SERVER['DOCUMENT_ROOT'] . "/utils/get/getMiUsuario.php");
  include_once($_SERVER['DOCUMENT_ROOT'] . '/database/conection.php');
  require_once($_SERVER["DOCUMENT_ROOT"]. "/utils/get/getTransportistaPublicacion.php");
  if($denunciada){
    require_once($_SERVER["DOCUMENT_ROOT"]. "/utils/get/getAutoresDenunciasFromPublicacion.php");
    $autoresDenuncias=getAutoresDenunciasFromPublicacion($idPublicacion);
  }
  else{
    $autoresDenuncias=null;
  }

  $transportista=transportistaPublicacion($idPublicacion, $estado);


  $postulantes=null;
  $contadorComentarios = 0;
  $calificacionUsuario = getAVGCalificacionesFromUsuario($idUsuario);
  ob_start();
?>
  <div class='publicacionExtendida-container container-fluid shadow border border-dark-subtle rounded my-3'>
    <div class='row p-2' name='publicacion_A' id='publicacion-A'>
      <div class="cabeceraPublicacion d-flex col-12 justify-content-center datosUsuario border-bottom align-items-center">
        <div class='d-flex col-6 mt-1 text-start lh-1'>

          <?php if($_SESSION["id"]!=$idUsuario)echo obtenerFoto($profileIcon,$username);else echo obtenerFoto($profileIcon);?>
          <div class="col">
            <div class="d-flex usuario-calificacion">
          <?php if($_SESSION["id"]!=$idUsuario){?>
              <a class="mb-2 text-reset text-decoration-none" href="/pages/miPerfil.php?user=<?php echo $username;?>"><?php echo $username;?></a>
          <?php }else{?>
              <p class="mb-2"><?php echo $username;?></p>
          <?php }?>
            <a class="ms-1 text-reset text-decoration-none" href="/pages/reseñas.php<?php if($_SESSION["id"]!=$idUsuario) echo "?user=".$username;?>" class="text-reset text-decoration-none">
              <?php echo estadoCalif($calificacionUsuario) ?>
            </a>
              <p class="ps-1"><?php if(is_array($calificacionUsuario))echo round($calificacionUsuario['calificacion_promedio'],1)." (".$calificacionUsuario["calificacion_cantidad"].")"; else echo "0 (0)";?></p>
          </div>
            <div>
              <p><?php echo $userLocation; ?></p>
            </div>
          </div>
        </div>
        
        <div class='col-6 mt-1 text-end lh-1 d-flex d-flex justify-content-end'>
          <div>
            <p> <?php echo (date('H:i', strtotime($date))) ?> </p>
            <p> <?php echo (date('d/m/Y', strtotime($date))) ?> </p>
          </div>

          <?php 
              require_once($_SERVER['DOCUMENT_ROOT'] . "/utils/get/getAutorPublicacion.php");
              $autor = getAutorPublicacion($idPublicacion);
              if($_SESSION['id'] == $autor['usuario_autor'] && $denunciada==false && $estado==1){?>
                <div class="dropdown publicacionExtendida-menuButton-container">
                  <img class="publicacionExtendida-menuIcon" src="/assets/three-dots-vertical.svg" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" onclick="eliminarPublicacion(<?php echo $idPublicacion; ?>)">Eliminar publicacion</a></li>
                  </ul>
                </div>
        <?php  }
            ?>

        </div>
      </div>
      <div class='mt-3'>
        <div class="mb-3">
          <h2><?php echo $tituloPublicacion;?></h2>
        </div>
        <div>
          <div>
            <p class='text-start fs-5 lh-1'>Detalles del producto:</p>
          </div>
          <div class="ps-1">
            <p class='publicacion-descripcion'><?php echo $productDetail; ?></p>
          </div>
        </div>
        <?php $postulantes=postulantesPublicacion($idPublicacion);?>
        <div class="col-12 d-flex">
          <div class="col-6">
            <div class="d-flex">
              <div class='col-4 text-start lh-1'>
                <p class='fs-5'>Peso:</p>
                <p class="ps-1"><?php echo $weight; ?> Kg</p>
              </div>
              <div class='col-4 text-start lh-1'>
                <p class='fs-5'>Volumen:</p>
                <p class="ps-1"><?php echo $volume; ?> m³</p>
              </div>
            </div>
            <div class='text-start lh-1'>
              <p class='fs-5'>Origen:</p>
              <?php $dataOrig=locacion($origin->latitud,$origin->longitud);?>
              <p class="ps-1"><?php echo $origin->barrio.", ".$dataOrig["hits"][0]["state"].", ".$dataOrig["hits"][0]["country"];?></p>
              <?php if($transportista){?>
                <?php if(($_SESSION["id"]==$autor["usuario_autor"] || $_SESSION["id"]==$transportista["usuario_transportista"] && !$denunciada) || ($denunciada && !in_array($_SESSION["id"],$autoresDenuncias))){?>
                  <div class="ps-1 d-flex">
                    <p><p class="fw-semibold">Manzana/Piso</p>: <?php echo $origin->manzana;?></p>
                    <p class="ms-2"><p class="fw-semibold">Casa/Depto</p>: <?php echo $origin->casa;?></p>
                  </div>
                <?php }?>
              <?php }elseif(($_SESSION["id"]==$autor["usuario_autor"] && !$denunciada) || ($denunciada && !in_array($_SESSION["id"],$autoresDenuncias))){?>
                  <div class="ps-1 d-flex">
                    <p><p class="fw-semibold">Manzana/Piso</p>: <?php echo $origin->manzana;?></p>
                    <p class="ms-2"><p class="fw-semibold">Casa/Depto</p>: <?php echo $origin->casa;?></p>
                  </div>
              <?php }?>
            </div>
            <div class='text-start lh-1'>
              <p class='fs-5'>Destino:</p>
              <?php $dataDest=locacion($destination->latitud,$destination->longitud);?>
              <p class="ps-1"><?php echo $destination->barrio.", ".$dataDest["hits"][0]["state"].", ".$dataDest["hits"][0]["country"]; ?></p>
              <?php if($transportista){?>
                <?php if(($_SESSION["id"]==$autor["usuario_autor"] || $_SESSION["id"]==$transportista["usuario_transportista"] && !$denunciada) || ($denunciada && !in_array($_SESSION["id"],$autoresDenuncias))){?>
                  <div class="ps-1 d-flex">
                    <p><p class="fw-semibold">Manzana/Piso</p>: <?php echo $origin->manzana;?></p>
                    <p class="ms-2"><p class="fw-semibold">Casa/Depto</p>: <?php echo $origin->casa;?></p>
                  </div>
                <?php }?>
              <?php }elseif(($_SESSION["id"]==$autor["usuario_autor"] && !$denunciada) || ($denunciada && !in_array($_SESSION["id"],$autoresDenuncias))){?>
                  <div class="ps-1 d-flex">
                    <p><p class="fw-semibold">Manzana/Piso</p>: <?php echo $origin->manzana;?></p>
                    <p class="ms-2"><p class="fw-semibold">Casa/Depto</p>: <?php echo $origin->casa;?></p>
                  </div>
              <?php }?>
            </div>
          </div>
          <?php if($transportista){?>
            <?php if(($_SESSION["id"]==$autor["usuario_autor"] || $_SESSION["id"]==$transportista["usuario_transportista"] && !$denunciada) || ($denunciada && !in_array($_SESSION["id"],$autoresDenuncias))){?>
              <div class="divMap col-6 d-flex align-items-center justify-content-center">
                <div id="map" class="shadow border"></div>
              </div>
            <?php }?>
          <?php }elseif(($_SESSION["id"]==$autor["usuario_autor"] && !$denunciada) || ($denunciada && !in_array($_SESSION["id"],$autoresDenuncias))){?>
              <div class="divMap col-6 d-flex align-items-center justify-content-center">
                <div id="map" class="shadow border"></div>
              </div>
          <?php }?>
        </div>
      </div>
      <?php if(!$transportista){?>
        <?php if(($_SESSION["id"]==$autor["usuario_autor"] && !$denunciada) || ($denunciada && !in_array($_SESSION["id"],$autoresDenuncias))){?>
          <div class="col-12 d-flex">
            <div class="col-6">
              <p class='fs-5'>Destinatario:</p>
              <div class="ps-1 pe-5 d-flex justify-content-between col-12">
                <p class="text-start col-6 lh-1 text-break"><?php echo $nombreRecibe;?></p>
                <div class='text-start col-5 lh-1'>
                  <a class="text-reset text-decoration-none d-flex" href="tel:<?php echo $telefono;?>"><p class="fw-semibold">Tel</p><p>: <?php echo $telefono;?></p></a>
                </div>
              </div>
            </div>
            <div class="col-6 d-flex align-items-center justify-content-around redirectMap">
              <a href="https://www.google.com.ar/maps/dir//<?php echo $origin->latitud.",".$origin->longitud?>" class="mt-2 btn btn-outline-primary" target="_blank">Origen</a>
              <a href="https://www.google.com.ar/maps/dir//<?php echo $destination->latitud.",".$destination->longitud?>" class="mt-2 btn btn-outline-primary" target="_blank">Destino</a>
            </div>
          </div>
        <?php } ?>
      <?php }elseif((($_SESSION["id"]==$autor["usuario_autor"] || $_SESSION["id"]==$transportista["usuario_transportista"]) && !$denunciada) || ($denunciada && !in_array($_SESSION["id"],$autoresDenuncias))){?>
          <div class="col-12 d-flex">
            <div class="col-6">
              <p class='fs-5'>Destinatario:</p>
              <div class="ps-1 pe-5 d-flex justify-content-between col-12">
                <p class="text-start col-6 lh-1 text-break"><?php echo $nombreRecibe;?></p>
                <div class='text-start col-5 lh-1'>
                  <a class="text-reset text-decoration-none d-flex" href="tel:<?php echo $telefono;?>"><p class="fw-semibold">Tel</p><p>: <?php echo $telefono;?></p></a>
                </div>
              </div>
            </div>
            <div class="col-6 d-flex align-items-center justify-content-around redirectMap">
              <a href="https://www.google.com.ar/maps/dir//<?php echo $origin->latitud.",".$origin->longitud?>" class="mt-2 btn btn-outline-primary" target="_blank">Origen</a>
              <a href="https://www.google.com.ar/maps/dir//<?php echo $destination->latitud.",".$destination->longitud?>" class="mt-2 btn btn-outline-primary" target="_blank">Destino</a>
            </div>
          </div>
        <?php } ?>
      <div class='my-4 d-flex justify-content-between align-items-center'>
        <?php  
        if($denunciada==false){?>
      <div><?php
          if($_SESSION["id"] != $autor["usuario_autor"]){
            if ($estado != 3 && $estado != 2){ ?>
            <button type='button' class='btn btn-gris btn-md' data-bs-target="#modalPostularse<?php echo $idPublicacion ?>" data-bs-toggle="modal">Postularse</button>
            <?php } else {
              require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/get/getPostRatingUsuario.php');
              
              if($_SESSION['id'] == $transportista['usuario_transportista'] AND getPostRatingUsuario($idPublicacion, $transportista['usuario_transportista']) == false AND $estado == '3') {
                require_once($_SERVER['DOCUMENT_ROOT'] . '/components/calificarUsuario.php');
                renderCalificarUsuario($idPublicacion);
              }
            }
          }elseif($estado == 2){?>
            <button type="button" class="btn btn-gris btn-md" href="#" onclick="finalizarPublicacion(<?php echo $idPublicacion; ?>)">Finalizar publicacion</button>
   <?php  }?>
        </div>
  <?php  }
        ?>
      <?php if($denunciada==false){?>
        <?php if($estado==1 && $_SESSION["id"]!=$autor["usuario_autor"]){?>
          <button type="button" class="btn btn-outline-danger btn-md" data-bs-target="#modalReportar<?php echo $idPublicacion ?>" data-bs-toggle="modal">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-flag" viewBox="0 0 16 16">
              <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12 12 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A20 20 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a20 20 0 0 0 1.349-.476l.019-.007.004-.002h.001M14 1.221c-.22.078-.48.167-.766.255-.81.252-1.872.523-2.734.523-.886 0-1.592-.286-2.203-.534l-.008-.003C7.662 1.21 7.139 1 6.5 1c-.669 0-1.606.229-2.415.478A21 21 0 0 0 3 1.845v6.433c.22-.078.48-.167.766-.255C4.576 7.77 5.638 7.5 6.5 7.5c.847 0 1.548.28 2.158.525l.028.01C9.32 8.29 9.86 8.5 10.5 8.5c.668 0 1.606-.229 2.415-.478A21 21 0 0 0 14 7.655V1.222z"></path>
            </svg>Reportar
          </button>
        <?php }
          }
          elseif($denunciada==1 && !in_array($_SESSION["id"],$autoresDenuncias)){?>
          <button type="button" class="btn procesarDenuncia btn-outline-success btn-md" data-name="publicacion" data-id="<?php echo $idPublicacion ?>" onclick="procesarDenuncia(event)">Permitir</button>
          <div class="resultDenuncia"><p></p></div>
          <button type="button" class="btn procesarDenuncia btn-outline-danger btn-md" data-name="publicacion" data-id="<?php echo $idPublicacion ?>" onclick="procesarDenuncia(event)">Eliminar</button>
          <?php }
      ?>
      </div>


      <div class='col-12' id="carouselPublicacion">
        <div class='col-12'>
          <div id="carouselIndicators_A" class="carousel slide imgPubli-container border border-dark-3 d-flex flex-wrap justify-content-start">
            <div class="carousel-indicators">
              <?php for ($i = 0; $i < sizeof($images); $i++) { ?>
                <?php $a = "'" . ($i + 1) . "'";
                ?>
                <button type="button" data-bs-target="#carouselIndicators_A" data-bs-slide-to=<?php echo $i ?> <?php if ($i == 0) echo "class='active'"; ?> <?php if ($i == 0) echo "aria-current='true'"; ?> aria-label=<?php echo "'Slide " . ($i + 1) . "'"; ?>></button>
              <?php } ?>
            </div>
            <div class="carousel-inner">
              <?php $i = 0;
              foreach ($images as $imagen) { ?>
                <div class="carousel-item <?php if ($i == 0) echo "active"; ?>">
                  <img class='img u_photo img-fluid' src='<?php echo $imagen; ?>' alt='product-image'>
                </div>
              <?php $i++;
              } ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselIndicators_A" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselIndicators_A" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
      </div>

    <!-- POSTEAR COMENTARIO -->
    <?php 
      if($denunciada==false){
        //--------------ID de Postulantes-----------------
        if($postulantes==null){
          $postulantes=postulantesPublicacion($idPublicacion);
        }
        if($estado==1){
          if(in_array($_SESSION["id"],$postulantes) || $_SESSION["id"]==$autor["usuario_autor"]){
            require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/get/getUsuario.php');
            $username = getMiUsuario($_SESSION['id'])['usuario_usuario'];
            $fYm=array("foto"=>$_SESSION["fotoPerfil"],"marco"=>$_SESSION["marcoFoto"]);
            echo renderPostComentario($username, $fYm, $idPublicacion); 
          }
        }
        elseif($estado==2){
          if($_SESSION["id"]==$transportista['usuario_transportista'] || $_SESSION["id"]==$autor["usuario_autor"]){
            require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/get/getUsuario.php');
            $username = getMiUsuario($_SESSION['id'])['usuario_usuario'];
            $fYm=array("foto"=>$_SESSION["fotoPerfil"],"marco"=>$_SESSION["marcoFoto"]);
            echo renderPostComentario($username, $fYm, $idPublicacion); 
          }
        }
      }
    ?>


      <!-- COMENTARIOS DE USUARIOS -->
      <div class="comentarios-container">
        <?php
        $comentarios=array();
        if($denunciada)
        $comentarios = getAllComentariosFromPublicacion($idPublicacion,true);
        else
        $comentarios = getAllComentariosFromPublicacion($idPublicacion);

        foreach ($comentarios as $c) {
          $foto=array("foto"=>$c["usuario_fotoPerfil"],"marco"=>$c["usuario_marcoFoto"]);
          if(isset($c["esReportado"])){
            if($c["esReportado"]){
              echo renderComentario(
                $contadorComentarios,
                $c["comentario_id"],
                $c["usuario_usuario"],
                $foto,
                $c["comentario_fecha"],
                $c['comentario_mensaje'],
                $c["usuario_id"],
                $estado,
                2
              );
            }else{
              echo renderComentario(
                $contadorComentarios,
                $c["comentario_id"],
                $c["usuario_usuario"],
                $foto,
                $c["comentario_fecha"],
                $c['comentario_mensaje'],
                $c["usuario_id"],
                $estado,
                1
              );

            }
          }
          else{
            echo renderComentario(
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
        ?>
      </div>
    </div>

  <?php if($denunciada==false){
  ?>

  <!-- MODAL POSTULARSE -->
  <div class="modal fade" id="modalPostularse<?php echo $idPublicacion ?>" aria-hidden="true" aria-labelledby="modalPostularseLabel<?php echo $idPublicacion ?>" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content bg-modalPublicacion">
        <div class="modal-header" style="color:black; background-color:rgba(255, 255, 255, 80%)">
          <h1 class="modal-title fs-5" id="modalPostularseLabel<?php echo $idPublicacion ?>">Postularse</h1>
          <button type="button" class="btn-close" id="cerrarModalPostular<?php echo $idPublicacion ?>"  data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <form action="/utils/postularse.php" class="form-publicacion form-postularse needs-validation FormularioAjax" novalidate method="post" id="formPostularse<?php echo $idPublicacion ?>" autocomplete="off" onsubmit="return validarPostulacion(<?php echo $idPublicacion ?>)">
            <div class="row">
              <div class="col-12">
                <input type="number" step="0.01" class="form-control mb-3" id="postulacion-monto<?php echo $idPublicacion ?>" name="monto" placeholder="$0.00">
                <div class="invalid-feedback" id="invalid-monto<?php echo $idPublicacion ?>"></div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <textarea style="height: 120px; max-height:120px" class="form-control" id="postulacion-descripcion<?php echo $idPublicacion ?>" name="descripcion" placeholder="Descripcion"></textarea>
                <div class="invalid-feedback" id="invalid-pDescripcion<?php echo $idPublicacion ?>"></div>
              </div>
            </div>
            <input type="hidden" name="enviado">
            <input type="hidden" name="publicacion-id" value="<?php echo $idPublicacion ?>">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-morado mb-2" data-bs-dismiss="modal">Cerrar</button>
          <input type="submit" id="btn-enviar" form="formPostularse<?php echo $idPublicacion ?>" class="btn btn-amarillo"></input>
        </div>
      </div>
    </div>
  </div>


  <!-- MODAL REPORTAR PUBLICACION -->
  <div class="modal fade" id="modalReportar<?php echo $idPublicacion ?>" aria-hidden="true" aria-labelledby="modalReportarLabel<?php echo $idPublicacion ?>" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content bg-modalPublicacion">
        <div class="modal-header" style="color:black; background-color:rgba(255, 255, 255, 80%)">
          <h1 class="modal-title fs-5" id="modalReportarLabel<?php echo $idPublicacion ?>">Reportar Publicacion</h1>
          <button type="button" class="btn-close" id="cerrarModalReportar<?php echo $idPublicacion ?>" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <form action="/utils/reportar.php" class="form-publicacion form-reportarPublicacion needs-validation FormularioAjax" method="post" id="formReportar<?php echo $idPublicacion ?>" novalidate>
            <div class="row">
              <div class="col-12">
                <select class="form-select" aria-label="Default select example" name="motivo" id="input-motivo<?php echo $idPublicacion ?>">
                  <option selected disabled>Seleccione un motivo...</option>
                  <option value="spam">Spam</option>
                  <option value="lenguaje inapropiado">Lenguaje inapropiado</option>
                  <option value="otro">Otro</option>
                </select>
                <div class="invalid-feedback" id="invalid-motivo<?php echo $idPublicacion ?>"></div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <textarea style="height: 120px; max-height:120px" class="form-control" id="reporte-mensaje<?php echo $idPublicacion ?>" name="mensaje" placeholder="Mensaje"></textarea>
                <div class="invalid-feedback" id="invalid-reporteMensaje<?php echo $idPublicacion ?>"></div>
              </div>
            </div>
            <input type="hidden" name="reporteEnviado">
            <input type="hidden" name="publicacion-id" value="<?php echo $idPublicacion ?>">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-morado mb-2" data-bs-dismiss="modal">Cerrar</button>
          <input type="submit" id="btn-enviar" form="formReportar<?php echo $idPublicacion ?>" class="btn btn-amarillo"></input>
        </div>
      </div>
    </div>
  </div>

  <!-- MODAL REPORTAR COMENTARIO -->
  <div class="modal fade" id="modalReportarComentario" aria-hidden="true" aria-labelledby="modalReportarComentarioLabel" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content bg-modalPublicacion">
        <div class="modal-header" style="color:black; background-color:rgba(255, 255, 255, 80%)">
          <h1 class="modal-title fs-5" id="modalReportarComentarioLabel">Reportar Comentario</h1>
          <button type="button" class="btn-close" id="cerrarModalReportarComentario" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <form action="/utils/reportar.php" class="form-publicacion form-reportarComentario needs-validation FormularioAjax" method="post" id="formReportarComentario" novalidate>
            <div class="row">
              <div class="col-12">
                <select class="form-select" aria-label="Default select example" name="motivo" id="input-motivo">
                  <option selected disabled>Seleccione un motivo...</option>
                  <option value="spam">Spam</option>
                  <option value="lenguaje inapropiado">Lenguaje inapropiado</option>
                  <option value="otro">Otro</option>
                </select>
                <div class="invalid-feedback" id="invalid-motivo"></div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <textarea style="height: 120px; max-height:120px" class="form-control" id="reporte-mensaje" name="mensaje" placeholder="Mensaje"></textarea>
                <div class="invalid-feedback" id="invalid-reporteMensaje"></div>
              </div>
            </div>
            <input type="hidden" name="reporteEnviado">
            <input type="hidden" name="comentario-id" value="">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-morado mb-2" data-bs-dismiss="modal">Cerrar</button>
          <input type="submit" id="btn-enviar" form="formReportarComentario" class="btn btn-amarillo"></input>
        </div>
      </div>
    </div>
  </div>

  <?php
  }?>



  </div>
  <?php if($denunciada==false){?>
  <script>
    function reportarComentario(comentarioId){
      document.querySelector("#formReportarComentario input[name='comentario-id']").value=comentarioId;
    }
    function eliminarPublicacion(id){
      data=new FormData();
      data.append("publicacion_id",id);
      fetch("/utils/eliminarPublicacion.php",{
        method: "post",
        body: data
      })
      .then(respuesta => {
        if (!respuesta.ok) { // Verifica si la respuesta es un error
            throw new Error('Error en la solicitud: ' + respuesta.status);
        }
        return respuesta.text();
        })
      .then(text => {
        if (text) { 
            if(text.trim()=="Eliminado"){
              let contenedor = document.querySelector('.form-rest');
              contenedor.innerHTML = '<div class="text-bg-success p-3"><strong>¡Publicacion Eliminada!</strong><br>Se ha eliminado exitosamente la publicacion</div>';
              setTimeout(() => {
                window.history.back();
              }, 2000);
            }
        } else {
            throw new Error("Respuesta vacía del servidor");
        }
        })
      .catch(error => {});
    }
  </script>
  <?php }
    if($_SESSION["id"]==$autor["usuario_autor"] || in_array($_SESSION["id"],$postulantes) || $denunciada){?>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
      var orgLat=<?php echo $origin->latitud;?>;
      var orgLng=<?php echo $origin->longitud;?>;
      var destLat=<?php echo $destination->latitud;?>;
      var destLng=<?php echo $destination->longitud;?>;
      //Distintas capas para el mapa
      var porDefecto = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
      var simple = L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png');
      var satelite = L.tileLayer('https://api.maptiler.com/maps/satellite/{z}/{x}/{y}@2x.jpg?key=OpTD9h2MxIr6P9bmwMLz');

      //Icono color Rojo, Origen
      var redIcon = L.icon({
          iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
          iconSize: [25, 41],
          iconAnchor: [12, 41],
          popupAnchor: [1, -34],
          shadowUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-shadow.png',
          shadowSize: [41, 41]
      });

      //Icono color Verde, Destino
      var greenIcon = L.icon({
          iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png',
          iconSize: [25, 41],
          iconAnchor: [12, 41],
          popupAnchor: [1, -34],
          shadowUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-shadow.png',
          shadowSize: [41, 41]
      });

      // Añadir distintas capas al mapa
      var baseMaps = {
          "Default": porDefecto,
          "Simple": simple,
          "Satelite": satelite
      };

      var map;

      window.addEventListener("load",()=>{
          map=iniciarMapa();
          obtenerRuta();
      });
      function iniciarMapa(){
        // Inicializa el mapa centrado en el origen
        var map = L.map('map',{
            center:[orgLat,orgLng],
            zoom: 14,
            layers:[porDefecto]
        }); // San Luis, Argentina
        L.control.layers(baseMaps).addTo(map);
        destino = L.marker([destLat, destLng],{ icon: greenIcon }).addTo(map).bindPopup('Destino').openPopup();
        origen = L.marker([orgLat, orgLng],{ icon: redIcon }).addTo(map).bindPopup('Origen').openPopup();
        return map;
    }

    function obtenerRuta() {
      // Llamada a la API de OpenRouteService
      var apiKey = '5b3ce3597851110001cf62483b5a376be02e414cb6c37b1a68d7381f';
      var url = `https://api.openrouteservice.org/v2/directions/driving-car?api_key=${apiKey}&start=${orgLng},${orgLat}&end=${destLng},${destLat}`;

      fetch(url)
          .then(response =>response.json())
          .then(data => {
              // Obtener las coordenadas de la ruta
              var routeCoords = data.features[0].geometry.coordinates;

              // Convertir las coordenadas a formato Leaflet (lat, lng)
              var leafletCoords = routeCoords.map(coord => [coord[1], coord[0]]);

              // Dibujar la ruta en el mapa
              trazarRuta(leafletCoords);
          })
      .catch(error => alert('Error al obtener la ruta'));
    }
    function trazarRuta(leafletCoords){
      ruta = L.polyline(leafletCoords, {
          color: 'green',      // Color de la línea
          weight: 5,           // Grosor de la línea
          opacity: 0.7,        // Opacidad
          smoothFactor: 1      // Suavidad
      }).addTo(map);
    }

    </script>
  <?php }?>
<?php
  return ob_get_clean();
}