<!DOCTYPE html>
<html lang="en">

<head>
    <?php require($_SERVER["DOCUMENT_ROOT"] . "/utils/functions/startSession.php"); ?>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/head.php") ?>
    <link rel="stylesheet" href="/css/reseñas.css">
    <title>Reseñas</title>
</head>

<body>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/components/Header.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . '/database/conection.php');
    include_once($_SERVER["DOCUMENT_ROOT"] . "/utils/get/getIdUsuario.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/utils/get/getUsuario.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/utils/get/getMiUsuario.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/utils/get/getAllCalificacionesFromUsuario.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/utils/functions/funcionesCalificaciones.php");
    ?>
    <?php
    if(isset($_GET["user"])){
        $idUser = getIdUsuario($_GET["user"]);
        if($idUser) $idUser=$idUser["usuario_id"];
    }else{
        $idUser = $_SESSION["id"];
    }
    if($idUser){
    $info_usuario=null;
    if($_SESSION["id"]!=$idUser)$info_usuario = getUsuario($idUser);
    else $info_usuario = getMiUsuario($idUser);
    $promedios = getAllDataCalificacionesFromUsuario($idUser);
    $limit=10;
    $offset=0;
    $mensajesCalifs = getAllCalificacionesFromUsuario($idUser,$limit,$offset);
    $db=new DB();
    $conexion=$db->getConnection();
    $totalMensajesCalifStmt = $conexion->query("SELECT COUNT(*) FROM calificaciones WHERE usuario_calificado = $idUser AND calificacion_mensaje IS NOT NULL");
    $totalMensajesCalif = $totalMensajesCalifStmt->fetchColumn();
    $totalMensajesCalifStmt=null;
    $coneccion=null;
    $db=null;
    ?>
    <section class="col-12 cuerpo d-flex justify-content-center">
        <div class="col-10 mt-4 perfil shadow border border-dark-subtle rounded">
            <div class="d-flex">
                <div class="col-3 border-end border-dark-subtle">
                    <div class="perfil_user d-flex flex-column align-items-center">
                        <div class="col-12 user_photo">
                        <?php if($_SESSION["id"]==$idUser){?>
                            <?php if ($_SESSION["marcoFoto"] == 0) { ?>
                                <div class="userFoto">
                                    <img src="<?php echo tieneFoto() ?>" class="userFoto" alt="user">
                                </div>
                            <?php   } else {
                                echo '<div class="fondoFoto"></div><img src="' . $_SESSION["marcoFoto"] . '" class="decoFoto' . $_SESSION["marcoFoto"][(strlen($_SESSION["marcoFoto"]) - 5)] . '">';
                                echo '<div class="divFoto"><img src="' . tieneFoto() . '" alt="user"></div>';
                            } ?>
                        <?php }else{?>
                            <?php if ($info_usuario["usuario_marcoFoto"] == 0) { ?>
                                <div class="userFoto">
                                    <img src="<?php echo tieneFoto($info_usuario["usuario_fotoPerfil"]) ?>" class="userFoto" alt="user">
                                </div>
                            <?php   } else {
                                echo '<div class="fondoFoto"></div><img src="' . $info_usuario["usuario_marcoFoto"] . '" class="decoFoto' . $info_usuario["usuario_marcoFoto"][(strlen($info_usuario["usuario_marcoFoto"]) - 5)] . '">';
                                echo '<div class="divFoto"><img src="' . tieneFoto($info_usuario["usuario_fotoPerfil"]) . '" alt="user"></div>';
                            } ?>
        
                        <?php }?>
                        </div>
                        <div class="col-10 user_name text-center border-bottom border-dark-subtle">
                            <h4><?php echo $info_usuario['usuario_usuario']; ?></h4>
                        </div>
                    </div>
                    <div class="col-12 perfil_publicaciones mb-1 col-8 text-center">
                        <h6 class="my-1"><?php if(is_array($promedios))if($promedios["calificacion_promedio_total"]!=null)echo $promedios["total_publicaciones"];else echo 0;else echo 0;?> Publicaciones Finalizadas</h6>
                        <h6 class="mb-2"><?php if(is_array($promedios))if($promedios["calificacion_promedio_total"]!=null)echo $promedios["total_postulaciones"];else echo 0;else echo 0;?> Postulaciones Finalizadas</h6>
                    </div>
                </div>
                <div class="col-9 d-flex flex-column align-items-center">
                    <div class="col-9 pb-2 mt-3 mb-2 pb-2 border-bottom border-dark-subtle d-flex justify-content-center align-items-center">
                        <div class="col-auto me-4 perfil_calificacion d-flex flex-column justify-content-center align-items-center">
                            <div class="calificacion_titulo col-auto text-center">
                                <h3 class="my-1">Calificacion</h3>
                            </div>
                            <div class="calificacion_puntaje">
                                <h1 class="mb-2 me-2"><?php if(is_array($promedios))if($promedios["calificacion_promedio_total"]!=null)echo round($promedios["calificacion_promedio_total"],2);else echo "0";else echo "0";?></h1>
                                <div class="d-flex flex-column align-items-center">
                                <?php if(is_array($promedios))if($promedios["calificacion_promedio_total"]!=null)echo estadoCalif($promedios["calificacion_promedio_total"]);else estadoCalif(0);else estadoCalif(0); ?>
                                    <p><?php if(is_array($promedios))if($promedios["calificacion_promedio_total"]!=null)echo $promedios["calificacion_cantidad_total"];else echo "0";else echo "0"; if(is_array($promedios))if($promedios["calificacion_cantidad_total"]==1) echo " Calificacion"; else echo " Calificaciones"; else echo " Calificaciones";?></p>
                                </div>
                            </div>
                        </div>  
                        <div class="col-5">
                            <div class="ratings col-12">
                                <div class="rating">
                                    <div class="progress_bar">
                                        <div>
                                            <span class="relleno" style='width:<?php if(is_array($promedios)) if($promedios["calificacion_cantidad_total"]!=0 && $promedios["calificacion_cantidad_total"]!=null)echo ((100/$promedios["calificacion_cantidad_total"])*$promedios["calif5_total"]);else echo 0; else echo 0;?>%;'></span>
                                            <span class="fondo"></span>
                                        </div>
                                    </div>
                                    <div class="stars">
                                        <span>5★</span>
                                    </div>
                                </div>
                                <div class="rating">
                                    <div class="progress_bar">
                                        <div>
                                            <span class="relleno" style='width:<?php if(is_array($promedios)) if($promedios["calificacion_cantidad_total"]!=0 && $promedios["calificacion_cantidad_total"]!=null)echo ((100/$promedios["calificacion_cantidad_total"])*$promedios["calif4_total"]);else echo 0; else echo 0;?>%;'></span>
                                            <span class="fondo"></span>
                                        </div>
                                    </div>
                                    <div class="stars">
                                        <span>4★</span>
                                    </div>
                                </div>
                                <div class="rating">
                                    <div class="progress_bar">
                                        <div>
                                            <span class="relleno" style='width:<?php if(is_array($promedios)) if($promedios["calificacion_cantidad_total"]!=0 && $promedios["calificacion_cantidad_total"]!=null)echo ((100/$promedios["calificacion_cantidad_total"])*$promedios["calif3_total"]);else echo 0; else echo 0;?>%;'></span>
                                            <span class="fondo"></span>
                                        </div>
                                    </div>
                                    <div class="stars">
                                        <span>3★</span>
                                    </div>
                                </div>
                                <div class="rating">
                                    <div class="progress_bar">
                                        <div>
                                            <span class="relleno" style='width:<?php if(is_array($promedios)) if($promedios["calificacion_cantidad_total"]!=0 && $promedios["calificacion_cantidad_total"]!=null)echo ((100/$promedios["calificacion_cantidad_total"])*$promedios["calif2_total"]);else echo 0; else echo 0;?>%;'></span>
                                            <span class="fondo"></span>
                                        </div>
                                    </div>
                                    <div class="stars">
                                        <span>2★</span>
                                    </div>
                                </div>
                                <div class="rating">
                                    <div class="progress_bar">
                                        <div>
                                            <span class="relleno" style='width:<?php if(is_array($promedios)) if($promedios["calificacion_cantidad_total"]!=0 && $promedios["calificacion_cantidad_total"]!=null)echo ((100/$promedios["calificacion_cantidad_total"])*$promedios["calif1_total"]);else echo 0; else echo 0;?>%;'></span>
                                            <span class="fondo"></span>
                                        </div>
                                    </div>
                                    <div class="stars">
                                        <span>1★</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-1 pb-2 d-flex justify-content-evenly <?php if(!empty($mensajesCalifs)) echo "border-bottom border-dark-subtle";?> align-items-center">
                        <div class="col-auto d-flex align-items-center">
                            <div class="col-auto me-3 perfil_calificacion d-flex flex-column justify-content-center align-items-center">
                                <div class="calificacion_titulo col-12 text-center">
                                    <h3 class="my-1">Usuario</h3>
                                </div>
                                <div class="calificacion_puntaje">
                                    <h1 class="mb-2 me-2"><?php if(is_array($promedios))if($promedios["calificacion_promedio_autor"]!=null)echo round($promedios["calificacion_promedio_autor"],2);else echo "0";else echo "0";?></h1>
                                    <div class="d-flex flex-column align-items-center">
                                    <?php if(is_array($promedios))if($promedios["calificacion_promedio_autor"]!=null)echo estadoCalif($promedios["calificacion_promedio_autor"]);else estadoCalif(0);else estadoCalif(0); ?>
                                        <p><?php if(is_array($promedios))if($promedios["calificacion_promedio_autor"]!=null)echo $promedios["calificacion_cantidad_autor"];else echo "0";else echo "0"; if(is_array($promedios))if($promedios["calificacion_cantidad_autor"]==1) echo " Calificacion"; else echo " Calificaciones"; else echo " Calificaciones";?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto me-3">
                                <div class="ratings col-12">
                                    <div class="rating">
                                        <div class="progress_bar">
                                            <div>
                                                <span class="relleno" style='width:<?php if(is_array($promedios)) if($promedios["calificacion_cantidad_autor"]!=0 && $promedios["calificacion_cantidad_autor"]!=null)echo ((100/$promedios["calificacion_cantidad_autor"])*$promedios["calif5_autor"]);else echo 0; else echo 0;?>%;'></span>
                                                <span class="fondo"></span>
                                            </div>
                                        </div>
                                        <div class="stars">
                                            <span>5★</span>
                                        </div>
                                    </div>
                                    <div class="rating">
                                        <div class="progress_bar">
                                            <div>
                                                <span class="relleno" style='width:<?php if(is_array($promedios)) if($promedios["calificacion_cantidad_autor"]!=0 && $promedios["calificacion_cantidad_autor"]!=null)echo ((100/$promedios["calificacion_cantidad_autor"])*$promedios["calif4_autor"]);else echo 0; else echo 0;?>%;'></span>
                                                <span class="fondo"></span>
                                            </div>
                                        </div>
                                        <div class="stars">
                                            <span>4★</span>
                                        </div>
                                    </div>
                                    <div class="rating">
                                        <div class="progress_bar">
                                            <div>
                                                <span class="relleno" style='width:<?php if(is_array($promedios)) if($promedios["calificacion_cantidad_autor"]!=0 && $promedios["calificacion_cantidad_autor"]!=null)echo ((100/$promedios["calificacion_cantidad_autor"])*$promedios["calif3_autor"]);else echo 0; else echo 0;?>%;'></span>
                                                <span class="fondo"></span>
                                            </div>
                                        </div>
                                        <div class="stars">
                                            <span>3★</span>
                                        </div>
                                    </div>
                                    <div class="rating">
                                        <div class="progress_bar">
                                            <div>
                                                <span class="relleno" style='width:<?php if(is_array($promedios)) if($promedios["calificacion_cantidad_autor"]!=0 && $promedios["calificacion_cantidad_autor"]!=null)echo ((100/$promedios["calificacion_cantidad_autor"])*$promedios["calif2_autor"]);else echo 0; else echo 0;?>%;'></span>
                                                <span class="fondo"></span>
                                            </div>
                                        </div>
                                        <div class="stars">
                                            <span>2★</span>
                                        </div>
                                    </div>
                                    <div class="rating">
                                        <div class="progress_bar">
                                            <div>
                                                <span class="relleno" style='width:<?php if(is_array($promedios))if($promedios["calificacion_cantidad_autor"]!=0 && $promedios["calificacion_cantidad_autor"]!=null)echo ((100/$promedios["calificacion_cantidad_autor"])*$promedios["calif1_autor"]);else echo 0; else echo 0;?>%;'></span>
                                                <span class="fondo"></span>
                                            </div>
                                        </div>
                                        <div class="stars">
                                            <span>1★</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto d-flex align-items-center">
                            <div class="col-auto me-3 perfil_calificacion d-flex flex-column justify-content-center align-items-center">
                                <div class="calificacion_titulo col-12 text-center">
                                    <h3 class="my-1">Transportista</h3>
                                </div>
                                <div class="calificacion_puntaje">
                                    <h1 class="mb-2 me-2"><?php if(is_array($promedios))if($promedios["calificacion_promedio_transportista"]!=null)echo round($promedios["calificacion_promedio_transportista"],2);else echo "0";else echo "0";?></h1>
                                    <div class="d-flex flex-column align-items-center">
                                    <?php if(is_array($promedios))if($promedios["calificacion_promedio_transportista"]!=null)echo estadoCalif($promedios["calificacion_promedio_transportista"]);else estadoCalif(0);else estadoCalif(0); ?>
                                        <p><?php if(is_array($promedios))if($promedios["calificacion_promedio_transportista"]!=null)echo $promedios["calificacion_cantidad_transportista"];else echo "0";else echo "0"; if(is_array($promedios))if($promedios["calificacion_cantidad_transportista"]==1) echo " Calificacion"; else echo " Calificaciones"; else echo " Calificaciones";?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="ratings col-12">
                                    <div class="rating">
                                        <div class="progress_bar">
                                            <div>
                                                <span class="relleno" style='width:<?php if(is_array($promedios)) if($promedios["calificacion_cantidad_transportista"]!=0 && $promedios["calificacion_cantidad_transportista"]!=null)echo ((100/$promedios["calificacion_cantidad_transportista"])*$promedios["calif5_transportista"]);else echo 0; else echo 0;?>%;'></span>
                                                <span class="fondo"></span>
                                            </div>
                                        </div>
                                        <div class="stars">
                                            <span>5★</span>
                                        </div>
                                    </div>
                                    <div class="rating">
                                        <div class="progress_bar">
                                            <div>
                                                <span class="relleno" style='width:<?php if(is_array($promedios)) if($promedios["calificacion_cantidad_transportista"]!=0 && $promedios["calificacion_cantidad_transportista"]!=null)echo ((100/$promedios["calificacion_cantidad_transportista"])*$promedios["calif4_transportista"]);else echo 0; else echo 0;?>%;'></span>
                                                <span class="fondo"></span>
                                            </div>
                                        </div>
                                        <div class="stars">
                                            <span>4★</span>
                                        </div>
                                    </div>
                                    <div class="rating">
                                        <div class="progress_bar">
                                            <div>
                                                <span class="relleno" style='width:<?php if(is_array($promedios)) if($promedios["calificacion_cantidad_transportista"]!=0 && $promedios["calificacion_cantidad_transportista"]!=null)echo ((100/$promedios["calificacion_cantidad_transportista"])*$promedios["calif3_transportista"]);else echo 0; else echo 0;?>%;'></span>
                                                <span class="fondo"></span>
                                            </div>
                                        </div>
                                        <div class="stars">
                                            <span>3★</span>
                                        </div>
                                    </div>
                                    <div class="rating">
                                        <div class="progress_bar">
                                            <div>
                                                <span class="relleno" style='width:<?php if(is_array($promedios)) if($promedios["calificacion_cantidad_transportista"]!=0 && $promedios["calificacion_cantidad_transportista"]!=null)echo ((100/$promedios["calificacion_cantidad_transportista"])*$promedios["calif2_transportista"]);else echo 0; else echo 0;?>%;'></span>
                                                <span class="fondo"></span>
                                            </div>
                                        </div>
                                        <div class="stars">
                                            <span>2★</span>
                                        </div>
                                    </div>
                                    <div class="rating">
                                        <div class="progress_bar">
                                            <div>
                                                <span class="relleno" style='width:<?php if(is_array($promedios)) if($promedios["calificacion_cantidad_transportista"]!=0 && $promedios["calificacion_cantidad_transportista"]!=null)echo ((100/$promedios["calificacion_cantidad_transportista"])*$promedios["calif1_transportista"]);else echo 0; else echo 0;?>%;'></span>
                                                <span class="fondo"></span>
                                            </div>
                                        </div>
                                        <div class="stars">
                                            <span>1★</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                    <?php if(!empty($mensajesCalifs)){?>
                        <div class="col-12 mt-1 pb-2 mb-2 border-bottom border-dark-subtle d-flex justify-content-end">
                            <div class="col-6 d-flex justify-content-evenly">
                                <Select id="filtrarCalif" onchange="actualizarCalificaciones()">
                                    <option value="Todo">Todo</option>
                                    <option value="Usuario">Usuario</option>
                                    <option value="Transportista">Transportista</option>
                                </Select>
                                <Select id="ordenarCalif" onchange="actualizarCalificaciones()">
                                    <option value="Reciente">Mas Reciente</option>
                                    <option value="Antiguo">Mas Antiguo</option>
                                </Select>
                                <Select id="starsCalif" onchange="actualizarCalificaciones()">
                                    <option value="Todo">Estrellas</option>
                                    <option value="1">1 ★</option>
                                    <option value="2">2 ★</option>
                                    <option value="3">3 ★</option>
                                    <option value="4">4 ★</option>
                                    <option value="5">5 ★</option>
                                </Select>
                            </div>
                        </div>
                        <div id="mensajesCalif" class="mensajes_calif">
                        <?php foreach($mensajesCalifs as $mensaje){?>
                            <div class="mensaje m-2 border-top border-bottom border-dark-subtle">
                                <div class="mensaje_head d-flex align-items-center justify-content-between">
                                    <div class="rating ms-1"><?php echo estadoCalif($mensaje["calificacion_puntaje"]);?></div>
                                    <div class="date me-1"><p class="mb-0"><?php echo date('d/m/Y', strtotime($mensaje["calificacion_fecha"]));?></p></div>
                                </div>
                                <div class="mensaje_body mx-1"><p class="my-1"><?php echo $mensaje["calificacion_mensaje"]?></p></div>
                            </div>
                        <?php }
                          if($totalMensajesCalif>sizeof($mensajesCalifs)){?>
                            <div id="masMensajesCalif" class="text-center mb-3 pb-1 pt-2 border-top border-bottom border-dark-subtle col-12">
                                <h5>Cargar mas</h5>
                            </div>
                    <?php }?>
                        </div>
                    <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php }?>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/Footer.php") ?>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/JS.php") ?>
</body>
<script>
    var idUser=<?php echo $idUser;?>;
    var totalMensajesCalif=<?php echo $totalMensajesCalif;?>;
    var limit=<?php echo $limit;?>;
    var mensajesCalifs=<?php echo sizeof($mensajesCalifs)?>;
    var offset=<?php echo $offset;?>;

    window.addEventListener("load",()=>{
        var cargarMas=document.querySelector("#masMensajesCalif");
        if(cargarMas!=null){
            cargarMas.children[0].addEventListener("click",masCalificaciones);
        }
    })
    
    function masCalificaciones(){
        var cargarMas=document.querySelector("#masMensajesCalif").children[0];
        cargarMas.removeEventListener("click",masCalificaciones);
        var lastChild=cargarMas.parentElement;
        offset=mensajesCalifs;
        var filtro=document.querySelector("#filtrarCalif").selectedIndex;
        var order=document.querySelector("#ordenarCalif").selectedIndex;
        var stars=document.querySelector("#starsCalif").selectedIndex;
        var form=new FormData();
        form.append("idUser",idUser);
        form.append("offset",offset);
        form.append("limit",limit);
        form.append("filtro",filtro);
        form.append("orden",order);
        form.append("stars",stars);
        form.append("more",true);
        fetch("/utils/functions/masCalifs.php",{
            method: "post",
            body: form
        })
        .then(respuesta => {
            if (!respuesta.ok) { 
                throw new Error('Error en la solicitud: ' + respuesta.status);
            }
            return respuesta.json(); 
        })
        .then(data => {
            if (data.length>0) {
                data.forEach(mensaje => {
                    var divMensaje=document.createElement("div");
                    divMensaje.classList="mensaje m-2 border-top border-bottom border-dark-subtle";

                    var divMensajeHead=document.createElement("div");
                    divMensajeHead.classList="mensaje_head d-flex align-items-center justify-content-between";

                    var divRating=document.createElement("div");
                    divRating.classList="rating ms-1";

                    var imgRating=document.createElement("img");
                    imgRating.classList="img-fluid";
                    imgRating.src="/assets/rating("+(mensaje.calificacion_puntaje*2)+").png";
                    imgRating.alt="rate";

                    divRating.appendChild(imgRating);

                    var divDate=document.createElement("div");
                    divDate.classList="date me-1";

                    var pDate=document.createElement("p");
                    pDate.classList="mb-0";
                    pDate.textContent=mensaje.calificacion_fecha.split(" ")[0].split("-")[2]+"/"+mensaje.calificacion_fecha.split(" ")[0].split("-")[1]+"/"+mensaje.calificacion_fecha.split(" ")[0].split("-")[0];
                    
                    divDate.appendChild(pDate);

                    var divmensajeBody=document.createElement("div");
                    divmensajeBody.classList="mensaje_body mx-1";

                    var pBody=document.createElement("p");
                    pBody.classList="my-1";
                    pBody.textContent=mensaje.calificacion_mensaje;

                    divmensajeBody.appendChild(pBody);

                    divMensajeHead.appendChild(divRating);
                    divMensajeHead.appendChild(divDate);

                    divMensaje.appendChild(divMensajeHead);
                    divMensaje.appendChild(divmensajeBody);

                    lastChild.parentElement.insertBefore(divMensaje, lastChild);
                });
                mensajesCalifs+=data.length;
                if(mensajesCalifs<totalMensajesCalif){
                    cargarMas.addEventListener("click",masCalificaciones);
                }else{
                    cargarMas.parentElement.remove();
                }
            } else {
                throw new Error("Respuesta vacía del servidor");
            }
        })
        .catch(error => {});
    }

    function actualizarCalificaciones(){
        var filtro=document.querySelector("#filtrarCalif").selectedIndex;
        var order=document.querySelector("#ordenarCalif").selectedIndex;
        var stars=document.querySelector("#starsCalif").selectedIndex;
        offset=0;
        var form=new FormData();
        form.append("idUser",idUser);
        form.append("offset",offset);
        form.append("limit",limit);
        form.append("filtro",filtro);
        form.append("orden",order);
        form.append("stars",stars);
        fetch("/utils/functions/masCalifs.php",{
            method: "post",
            body: form
        })
        .then(respuesta => {
            if (!respuesta.ok) { 
                throw new Error('Error en la solicitud: ' + respuesta.status);
            }
            return respuesta.json(); 
        })
        .then(data => {
            mensajesCalifs=data.mensajes.length;
            totalMensajesCalif=data.totalMensajes;
            
            var newDivMensajes=document.createElement("div");
            newDivMensajes.id="mensajesCalif";
            newDivMensajes.classList="mensajes_calif";
            
            var divMensajes=document.querySelector("#mensajesCalif");
            divMensajes.parentNode.replaceChild(newDivMensajes,divMensajes);

            if (data.mensajes.length>0 && data.totalMensajes>0) {
                data.mensajes.forEach(mensaje => {
                    var divMensaje=document.createElement("div");
                    divMensaje.classList="mensaje m-2 border-top border-bottom border-dark-subtle";

                    var divMensajeHead=document.createElement("div");
                    divMensajeHead.classList="mensaje_head d-flex align-items-center justify-content-between";

                    var divRating=document.createElement("div");
                    divRating.classList="rating ms-1";

                    var imgRating=document.createElement("img");
                    imgRating.classList="img-fluid";
                    imgRating.src="/assets/rating("+(mensaje.calificacion_puntaje*2)+").png";
                    imgRating.alt="rate";

                    divRating.appendChild(imgRating);

                    var divDate=document.createElement("div");
                    divDate.classList="date me-1";

                    var pDate=document.createElement("p");
                    pDate.classList="mb-0";
                    pDate.textContent=mensaje.calificacion_fecha.split(" ")[0].split("-")[2]+"/"+mensaje.calificacion_fecha.split(" ")[0].split("-")[1]+"/"+mensaje.calificacion_fecha.split(" ")[0].split("-")[0];
                    
                    divDate.appendChild(pDate);

                    var divmensajeBody=document.createElement("div");
                    divmensajeBody.classList="mensaje_body mx-1";

                    var pBody=document.createElement("p");
                    pBody.classList="my-1";
                    pBody.textContent=mensaje.calificacion_mensaje;

                    divmensajeBody.appendChild(pBody);

                    divMensajeHead.appendChild(divRating);
                    divMensajeHead.appendChild(divDate);

                    divMensaje.appendChild(divMensajeHead);
                    divMensaje.appendChild(divmensajeBody);

                    newDivMensajes.appendChild(divMensaje);
                });
                if(mensajesCalifs<totalMensajesCalif){
                    var divCargarMas=document.createElement("div");
                    divCargarMas.id="masMensajesCalif";
                    divCargarMas.classList="text-center mb-3 pb-1 pt-2 border-top border-bottom border-dark-subtle col-12";
                    
                    var h5CargarMas=document.createElement("h5");
                    h5CargarMas.value="Cargar mas";
                    h5CargarMas.addEventListener("click",masCalificaciones());

                    divCargarMas.appendChild(h5CargarMas);
                    
                    newDivMensajes.appendChild(divCargarMas);
                }
            }else{
                var divmensajeBody=document.createElement("div");
                divmensajeBody.classList="text-center m-4";

                var pBody=document.createElement("p");
                pBody.classList="mb-0";
                pBody.textContent="Ninguna coincidencia encontrada";

                divmensajeBody.appendChild(pBody);
                newDivMensajes.appendChild(divmensajeBody);
            }
        })
        .catch(error => {});
    }

</script>
</html>