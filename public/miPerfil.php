<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/head.php") ?>
    <link rel="stylesheet" href="/css/miPerfil.css">
    <title>Mi Perfil</title>
</head>
<body>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/Header.php") ?>



<section class="col-12 cuerpo">
    <aside class="col-3 perfil">
        <div class="perfil_user">
            <div class="col-12 user_photo">
                <img class="img-fluid"src="/assets/Logo.png" alt="user">
            </div>
            <div class="col-12 user_name">
                <h3>User Name</h3>
            </div>
        </div>
        <div class="perfil_links">
            <a href="#">Modificar datos de usuario</a>
            <a href="#">Modificar datos personales</a>
            <a href="#">Algo mas</a>
            <a href="#">Otra cosa</a>
        </div>
        <div class="perfil_calificacion">
            <div class="calificacion_titulo">
                <h3>Calificacion</h3>
            </div>
            <div class="calificacion_puntaje">
                <img class="img-fluid" src="/assets/rating(0).svg" alt="rate">
                <p>0.0 de 0 calificaciones</p>
            </div>
        </div>
    </aside>
    <div class="col-5 contenedor">
        <dialog class="activa publicacion col-7" name="publicacion_D" id="publicacion-N_AD">
            <div class="publicacion_cabecera col-12">
                <div class="col-10">
                    <div class="col-2 user_photo">
                        <img class="img-fluid u_photo" src="/assets/Logo.png" alt="user">
                    </div>
                    <div class="col-5 user_info">
                        <div class="col-12"><p>User Name</p></div>
                        <div class="col-12"><p>User, location</p></div>
                    </div>
                    <div class="col-5 publication_date">
                        <div class="col-12 "><p>Hour</p></div>
                        <div class="col-12 "><p>Date</p></div>
                    </div>
                </div>
                <div class="col-auto" name=cerrar_D id="publicacion-N_AD_C">
                    <?php require($_SERVER['DOCUMENT_ROOT'] . "/assets/close.svg") ?>
                </div>
            </div>
            <div class="publicacion_cuerpo col-12">
                <div class="publication_info col-12">
                    <div>
                        <p>Detalles del producto:</p>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Velit voluptate, veritatis, quis tempore laudantium dicta a libero esse fugiat eius impedit, doloribus quaerat sapiente reprehenderit quo iusto molestiae recusandae aspernatur ut. Itaque hic distinctio, voluptas tempora quisquam id veritatis eius?</p>
                    </div>
                    <div>
                        <p>Peso aproximado:</p>
                        <p>000.00Kg</p>
                    </div>
                    <div class="publication_location col-12">
                        <p class="publication_origin">Origen:</br>ipsum dolor sit, amet consectetur adipisicing elit.</p>
                        <p class="publication_destiny">Destino:</br>ipsum dolor sit amet.</p>
                    </div>
                    <div class="col-12 publicacion_postularse">
                        <button name="postularse">Postularse</button>
                    </div>
                </div>
            </div>
            <div class="publicacion_pie">
                <div id="carouselIndicators_A-N" class="carousel slide">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselIndicators_A-N" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselIndicators_A-N" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselIndicators_A-N" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="/assets/table_photo.jpeg" class="img-fluid d-block w-100" alt="publication_photo">
                        </div>
                        <div class="carousel-item">
                            <img src="/assets/table_photo.jpeg" class="img-fluid d-block w-100" alt="publication_photo">
                        </div>
                        <div class="carousel-item">
                            <img src="/assets/table_photo.jpeg" class="img-fluid d-block w-100" alt="publication_photo">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselIndicators_A-N" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselIndicators_A-N" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="publicacion_comentarios">
                <div class="accordion" id="accordion_A-N">
                    <div class="accordion-item">
                        <h2 name="accordionComentarios" id="accordionHeader_A-N" class="accordion-header">
                            <button name="mostComentarios" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_A-N" aria-expanded="false" aria-controls="collapse_A-N">
                                <p>Mostrar comentarios</p>
                            </button>
                        </h2>
                        <div id="collapse_A-N" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <div class="col-12 comentario">
                                    <form class="comentario_form">
                                        <div class="col-12">
                                            <textarea class="col-9 form-control" placeholder="Agregar un comentario" cols="auto" rows="5"></textarea>
                                            <input class="col-auto btn" id="enviar_A" type="submit" value="Publicar" class="item">
                                        </div>
                                    </form>
                                </div>
                                <div class="col-12 comentario" name="comentario" id="comentario-N">
                                    <div class="col-2 user_photo">
                                        <img class="img-fluid u_photo" src="/assets/Logo.png" alt="user">
                                    </div>
                                    <div class="col-10 comentario_cuerpo">
                                        <div class="12 comentario_cabecera_cuerpo">
                                            <div class="col-6"><p>User name</p></div>
                                            <div class="col-6 comentario_date"><p>Hour y Date</p></div>
                                        </div>
                                        <div class="col-12"><p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolorem molestiae et ipsum vitae ratione</p></div>
                                    </div>
                                </div>
                                <div class="col-12 comentario" name="comentario" id="comentario-N">
                                    <div class="col-2 user_photo">
                                        <img class="img-fluid u_photo" src="/assets/Logo.png" alt="user">
                                    </div>
                                    <div class="col-10 comentario_cuerpo">
                                        <div class="12 comentario_cabecera_cuerpo">
                                            <div class="col-6"><p>User name</p></div>
                                            <div class="col-6 comentario_date"><p>Hour y Date</p></div>
                                        </div>
                                        <div class="col-12"><p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolorem molestiae et ipsum vitae ratione, aspernatur culpa aliquam magni animi voluptas?</p></div>
                                    </div>
                                </div>
                                <div class="col-12 comentario" name="comentario" id="comentario-N">
                                    <div class="col-2 user_photo">
                                        <img class="img-fluid u_photo" src="/assets/Logo.png" alt="user">
                                    </div>
                                    <div class="col-10 comentario_cuerpo">
                                        <div class="12 comentario_cabecera_cuerpo">
                                            <div class="col-6"><p>User name</p></div>
                                            <div class="col-6 comentario_date"><p>Hour y Date</p></div>
                                        </div>
                                        <div class="col-12"><p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolorem molestiae et ipsum vitae ratione, aspernatur culpa aliquam magni animi voluptas?</p></div>
                                    </div>
                                </div>
                                <div class="col-12 comentario" name="comentario" id="comentario-N">
                                    <div class="col-2 user_photo">
                                        <img class="img-fluid u_photo" src="/assets/Logo.png" alt="user">
                                    </div>
                                    <div class="col-10 comentario_cuerpo">
                                        <div class="12 comentario_cabecera_cuerpo">
                                            <div class="col-6"><p>User name</p></div>
                                            <div class="col-6 comentario_date"><p>Hour y Date</p></div>
                                        </div>
                                        <div class="col-12"><p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolorem molestiae et ipsum vitae ratione, aspernatur culpa aliquam magni animi voluptas?</p></div>
                                    </div>
                                </div>
                                <div class="col-12 comentario" name="comentario" id="comentario-N">
                                    <div class="col-2 user_photo">
                                        <img class="img-fluid u_photo" src="/assets/Logo.png" alt="user">
                                    </div>
                                    <div class="col-10 comentario_cuerpo">
                                        <div class="12 comentario_cabecera_cuerpo">
                                            <div class="col-6"><p>User name</p></div>
                                            <div class="col-6 comentario_date"><p>Hour y Date</p></div>
                                        </div>
                                        <div class="col-12"><p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolorem molestiae et ipsum vitae ratione, aspernatur culpa aliquam magni animi voluptas?</p></div>
                                    </div>
                                </div>
                                <div class="col-12 comentario" name="comentario" id="comentario-N">
                                    <div class="col-2 user_photo">
                                        <img class="img-fluid u_photo" src="/assets/Logo.png" alt="user">
                                    </div>
                                    <div class="col-10 comentario_cuerpo">
                                        <div class="12 comentario_cabecera_cuerpo">
                                            <div class="col-6"><p>User name</p></div>
                                            <div class="col-6 comentario_date"><p>Hour y Date</p></div>
                                        </div>
                                        <div class="col-12"><p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolorem molestiae et ipsum vitae ratione, aspernatur culpa aliquam magni animi voluptas?</p></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </dialog>

        <div class="activa publicacion col-12" name="publicacion" id="publicacion-N_A">
            <div class="publicacion_cabecera col-12">
                <div class="col-2 user_photo">
                    <img class="img-fluid u_photo" src="/assets/Logo.png" alt="user">
                </div>
                <div class="col-5 user_info">
                    <div class="col-12"><p>User Name</p></div>
                    <div class="col-12"><p>User, location</p></div>
                </div>
                <div class="col-5 publication_date">
                    <div class="col-12 "><p>Hour</p></div>
                    <div class="col-12 "><p>Date</p></div>
                </div>
            </div>
            <div class="publicacion_cuerpo col-12">
                <div class="publication_info col-12">
                    <div>
                        <p>Detalles del producto:</p>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Velit voluptate, veritatis, quis tempore laudantium dicta a libero esse fugiat eius impedit, doloribus quaerat sapiente reprehenderit quo iusto molestiae recusandae aspernatur ut. Itaque hic distinctio, voluptas tempora quisquam id veritatis eius?</p>
                    </div>
                </div>
                
            </div>
            <div class="publicacion_pie">
                <div class="carousel-inner">
                    <img src="/assets/table_photo.jpeg" class="img-fluid d-block w-100" alt="publication_photo">
                </div>
            </div>
        </div>

        <dialog class="ajena publicacion col-7" name="comentario-N_PA_" id="comentario-N_PA">
            <div class="publicacion_cabecera col-12">
                <div class="col-10">
                    <div class="col-2 user_photo">
                        <img class="img-fluid u_photo" src="/assets/Logo.png" alt="user">
                    </div>
                    <div class="col-5 user_info">
                        <div class="col-12"><p>User Name</p></div>
                        <div class="col-12"><p>User, location</p></div>
                    </div>
                    <div class="col-5 publication_date">
                        <div class="col-12 "><p>Hour</p></div>
                        <div class="col-12 "><p>Date</p></div>
                    </div>
                </div>
                <div class="col-auto" name=cerrar_D id="comentario-N_PA_C">
                    <?php require($_SERVER['DOCUMENT_ROOT'] . "/assets/close.svg") ?>
                </div>
            </div>
            <div class="publicacion_cuerpo col-12">
                <div class="publication_info col-12">
                    <div>
                        <p>Detalles del producto:</p>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Velit voluptate, veritatis, quis tempore laudantium dicta a libero esse fugiat eius impedit, doloribus quaerat sapiente reprehenderit quo iusto molestiae recusandae aspernatur ut. Itaque hic distinctio, voluptas tempora quisquam id veritatis eius?</p>
                    </div>
                    <div>
                        <p>Peso aproximado:</p>
                        <p>000.00Kg</p>
                    </div>
                    <div class="publication_location col-12">
                        <p class="publication_origin">Origen:</br>ipsum dolor sit, amet consectetur adipisicing elit.</p>
                        <p class="publication_destiny">Destino:</br>ipsum dolor sit amet.</p>
                    </div>
                </div>
            </div>
            <div class="publicacion_pie">
                <div id="carouselIndicators_PA-N" class="carousel slide">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselIndicators_PA-N" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselIndicators_PA-N" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselIndicators_PA-N" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="/assets/table_photo.jpeg" class="img-fluid d-block w-100" alt="publication_photo">
                        </div>
                        <div class="carousel-item">
                            <img src="/assets/table_photo.jpeg" class="img-fluid d-block w-100" alt="publication_photo">
                        </div>
                        <div class="carousel-item">
                            <img src="/assets/table_photo.jpeg" class="img-fluid d-block w-100" alt="publication_photo">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselIndicators_PA-N" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselIndicators_PA-N" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="publicacion_comentarios">
                <div class="accordion" id="accordion_PA-N">
                    <div class="accordion-item">
                        <h2 name="accordionComentarios" id="accordionHeader_PA-N" class="accordion-header">
                            <button name="mostComentarios" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_PA-N" aria-expanded="false" aria-controls="collapse_PA-N">
                                <p>Mostrar comentarios</p>
                            </button>
                        </h2>
                        <div id="collapse_PA-N" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <div class="col-12 comentario" name="comentario" id="comentario-N">
                                    <div class="col-2 user_photo">
                                        <img class="img-fluid u_photo" src="/assets/Logo.png" alt="user">
                                    </div>
                                    <div class="col-10 comentario_cuerpo">
                                        <div class="12 comentario_cabecera_cuerpo">
                                            <div class="col-6"><p>User name</p></div>
                                            <div class="col-6 comentario_date"><p>Hour y Date</p></div>
                                        </div>
                                        <div class="col-12"><p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolorem molestiae et ipsum vitae ratione</p></div>
                                    </div>
                                </div>
                                <div class="col-12 comentario" name="comentario" id="comentario-N">
                                    <div class="col-2 user_photo">
                                        <img class="img-fluid u_photo" src="/assets/Logo.png" alt="user">
                                    </div>
                                    <div class="col-10 comentario_cuerpo">
                                        <div class="12 comentario_cabecera_cuerpo">
                                            <div class="col-6"><p>User name</p></div>
                                            <div class="col-6 comentario_date"><p>Hour y Date</p></div>
                                        </div>
                                        <div class="col-12"><p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolorem molestiae et ipsum vitae ratione, aspernatur culpa aliquam magni animi voluptas?</p></div>
                                    </div>
                                </div>
                                <div class="col-12 comentario" name="comentario" id="comentario-N">
                                    <div class="col-2 user_photo">
                                        <img class="img-fluid u_photo" src="/assets/Logo.png" alt="user">
                                    </div>
                                    <div class="col-10 comentario_cuerpo">
                                        <div class="12 comentario_cabecera_cuerpo">
                                            <div class="col-6"><p>User name</p></div>
                                            <div class="col-6 comentario_date"><p>Hour y Date</p></div>
                                        </div>
                                        <div class="col-12"><p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolorem molestiae et ipsum vitae ratione, aspernatur culpa aliquam magni animi voluptas?</p></div>
                                    </div>
                                </div>
                                <div class="col-12 comentario" name="comentario" id="comentario-N">
                                    <div class="col-2 user_photo">
                                        <img class="img-fluid u_photo" src="/assets/Logo.png" alt="user">
                                    </div>
                                    <div class="col-10 comentario_cuerpo">
                                        <div class="12 comentario_cabecera_cuerpo">
                                            <div class="col-6"><p>User name</p></div>
                                            <div class="col-6 comentario_date"><p>Hour y Date</p></div>
                                        </div>
                                        <div class="col-12"><p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolorem molestiae et ipsum vitae ratione, aspernatur culpa aliquam magni animi voluptas?</p></div>
                                    </div>
                                </div>
                                <div class="col-12 comentario" name="comentario" id="comentario-N">
                                    <div class="col-2 user_photo">
                                        <img class="img-fluid u_photo" src="/assets/Logo.png" alt="user">
                                    </div>
                                    <div class="col-10 comentario_cuerpo">
                                        <div class="12 comentario_cabecera_cuerpo">
                                            <div class="col-6"><p>User name</p></div>
                                            <div class="col-6 comentario_date"><p>Hour y Date</p></div>
                                        </div>
                                        <div class="col-12"><p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolorem molestiae et ipsum vitae ratione, aspernatur culpa aliquam magni animi voluptas?</p></div>
                                    </div>
                                </div>
                                <div class="col-12 comentario" name="comentario" id="comentario-N">
                                    <div class="col-2 user_photo">
                                        <img class="img-fluid u_photo" src="/assets/Logo.png" alt="user">
                                    </div>
                                    <div class="col-10 comentario_cuerpo">
                                        <div class="12 comentario_cabecera_cuerpo">
                                            <div class="col-6"><p>User name</p></div>
                                            <div class="col-6 comentario_date"><p>Hour y Date</p></div>
                                        </div>
                                        <div class="col-12"><p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolorem molestiae et ipsum vitae ratione, aspernatur culpa aliquam magni animi voluptas?</p></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </dialog>

        <div class="col-12 comentario publicacion" name="comentario" id="comentario-N">
            <div class="col-2 user_photo">
                <img class="img-fluid u_photo" src="/assets/Logo.png" alt="user">
            </div>
            <div class="col-10 comentario_cuerpo">
                <div class="12 comentario_cabecera_cuerpo">
                    <div class="col-6"><p>User name</p></div>
                    <div class="col-6 comentario_date"><p>Hour y Date</p></div>
                </div>
                <div class="col-12"><p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolorem molestiae et ipsum vitae ratione, aspernatur culpa aliquam magni animi voluptas?</p></div>
            </div>
        </div>

      <!--   <div class="cerrada publicacion" name="publicacion" id="publicacion-N_C">

        </div> -->

        <dialog class="cerrada publicacion col-7" name="publicacion_D" id="publicacion-N_CD">
            <div class="publicacion_cabecera col-12">
                <div class="col-10">
                    <div class="col-2 user_photo">
                        <img class="img-fluid u_photo" src="/assets/Logo.png" alt="user">
                    </div>
                    <div class="col-5 user_info">
                        <div class="col-12"><p>User Name</p></div>
                        <div class="col-12"><p>User, location</p></div>
                    </div>
                    <div class="col-5 publication_date">
                        <div class="col-12 "><p>Hour</p></div>
                        <div class="col-12 "><p>Date</p></div>
                    </div>
                </div>
                <div class="col-auto" name=cerrar_D id="publicacion-N_CD_C">
                    <?php require($_SERVER['DOCUMENT_ROOT'] . "/assets/close.svg") ?>
                </div>
            </div>
            <div class="publicacion_cuerpo col-12">
                <div class="publication_info col-12">
                    <div>
                        <p>Detalles del producto:</p>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Velit voluptate, veritatis, quis tempore laudantium dicta a libero esse fugiat eius impedit, doloribus quaerat sapiente reprehenderit quo iusto molestiae recusandae aspernatur ut. Itaque hic distinctio, voluptas tempora quisquam id veritatis eius?</p>
                    </div>
                    <div>
                        <p>Peso aproximado:</p>
                        <p>000.00Kg</p>
                    </div>
                    <div class="publication_location col-12">
                        <p class="publication_origin">Origen:</br>ipsum dolor sit, amet consectetur adipisicing elit.</p>
                        <p class="publication_destiny">Destino:</br>ipsum dolor sit amet.</p>
                    </div>
                </div>
            </div>
            <div class="publicacion_pie">
                <div id="carouselIndicators_C-N" class="carousel slide">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselIndicators_C-N" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselIndicators_C-N" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselIndicators_C-N" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="/assets/table_photo.jpeg" class="img-fluid d-block w-100" alt="publication_photo">
                        </div>
                        <div class="carousel-item">
                            <img src="/assets/table_photo.jpeg" class="img-fluid d-block w-100" alt="publication_photo">
                        </div>
                        <div class="carousel-item">
                            <img src="/assets/table_photo.jpeg" class="img-fluid d-block w-100" alt="publication_photo">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselIndicators_C-N" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselIndicators_C-N" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="publicacion_comentarios">
                <div class="accordion" id="accordion_C-N">
                    <div class="accordion-item">
                        <h2 name="accordionComentarios" id="accordionHeader_C-N" class="accordion-header">
                            <button name="mostComentarios" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_C-N" aria-expanded="false" aria-controls="collapse_C-N">
                                <p>Mostrar comentarios</p>
                            </button>
                        </h2>
                        <div id="collapse_C-N" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <div class="col-12 comentario" name="comentario" id="comentario-N">
                                    <div class="col-2 user_photo">
                                        <img class="img-fluid u_photo" src="/assets/Logo.png" alt="user">
                                    </div>
                                    <div class="col-10 comentario_cuerpo">
                                        <div class="12 comentario_cabecera_cuerpo">
                                            <div class="col-6"><p>User name</p></div>
                                            <div class="col-6 comentario_date"><p>Hour y Date</p></div>
                                        </div>
                                        <div class="col-12"><p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolorem molestiae et ipsum vitae ratione</p></div>
                                    </div>
                                </div>
                                <div class="col-12 comentario" name="comentario" id="comentario-N">
                                    <div class="col-2 user_photo">
                                        <img class="img-fluid u_photo" src="/assets/Logo.png" alt="user">
                                    </div>
                                    <div class="col-10 comentario_cuerpo">
                                        <div class="12 comentario_cabecera_cuerpo">
                                            <div class="col-6"><p>User name</p></div>
                                            <div class="col-6 comentario_date"><p>Hour y Date</p></div>
                                        </div>
                                        <div class="col-12"><p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolorem molestiae et ipsum vitae ratione, aspernatur culpa aliquam magni animi voluptas?</p></div>
                                    </div>
                                </div>
                                <div class="col-12 comentario" name="comentario" id="comentario-N">
                                    <div class="col-2 user_photo">
                                        <img class="img-fluid u_photo" src="/assets/Logo.png" alt="user">
                                    </div>
                                    <div class="col-10 comentario_cuerpo">
                                        <div class="12 comentario_cabecera_cuerpo">
                                            <div class="col-6"><p>User name</p></div>
                                            <div class="col-6 comentario_date"><p>Hour y Date</p></div>
                                        </div>
                                        <div class="col-12"><p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolorem molestiae et ipsum vitae ratione, aspernatur culpa aliquam magni animi voluptas?</p></div>
                                    </div>
                                </div>
                                <div class="col-12 comentario" name="comentario" id="comentario-N">
                                    <div class="col-2 user_photo">
                                        <img class="img-fluid u_photo" src="/assets/Logo.png" alt="user">
                                    </div>
                                    <div class="col-10 comentario_cuerpo">
                                        <div class="12 comentario_cabecera_cuerpo">
                                            <div class="col-6"><p>User name</p></div>
                                            <div class="col-6 comentario_date"><p>Hour y Date</p></div>
                                        </div>
                                        <div class="col-12"><p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolorem molestiae et ipsum vitae ratione, aspernatur culpa aliquam magni animi voluptas?</p></div>
                                    </div>
                                </div>
                                <div class="col-12 comentario" name="comentario" id="comentario-N">
                                    <div class="col-2 user_photo">
                                        <img class="img-fluid u_photo" src="/assets/Logo.png" alt="user">
                                    </div>
                                    <div class="col-10 comentario_cuerpo">
                                        <div class="12 comentario_cabecera_cuerpo">
                                            <div class="col-6"><p>User name</p></div>
                                            <div class="col-6 comentario_date"><p>Hour y Date</p></div>
                                        </div>
                                        <div class="col-12"><p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolorem molestiae et ipsum vitae ratione, aspernatur culpa aliquam magni animi voluptas?</p></div>
                                    </div>
                                </div>
                                <div class="col-12 comentario" name="comentario" id="comentario-N">
                                    <div class="col-2 user_photo">
                                        <img class="img-fluid u_photo" src="/assets/Logo.png" alt="user">
                                    </div>
                                    <div class="col-10 comentario_cuerpo">
                                        <div class="12 comentario_cabecera_cuerpo">
                                            <div class="col-6"><p>User name</p></div>
                                            <div class="col-6 comentario_date"><p>Hour y Date</p></div>
                                        </div>
                                        <div class="col-12"><p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolorem molestiae et ipsum vitae ratione, aspernatur culpa aliquam magni animi voluptas?</p></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </dialog>


     <!--    <div class="finalizada publicacion" name="publicacion" id="publicacion-N_F">

        </div> -->

        <dialog class="finalizada publicacion col-7" name="publicacion_D" id="publicacion-N_FD">
            <div class="publicacion_cabecera col-12">
                <div class="col-10">
                    <div class="col-2 user_photo">
                        <img class="img-fluid u_photo" src="/assets/Logo.png" alt="user">
                    </div>
                    <div class="col-5 user_info">
                        <div class="col-12"><p>User Name</p></div>
                        <div class="col-12"><p>User, location</p></div>
                    </div>
                    <div class="col-5 publication_date">
                        <div class="col-12 "><p>Hour</p></div>
                        <div class="col-12 "><p>Date</p></div>
                    </div>
                </div>
                <div class="col-auto" name=cerrar_D id="publicacion-N_FD_C">
                    <?php require($_SERVER['DOCUMENT_ROOT'] . "/assets/close.svg") ?>
                </div>
            </div>
            <div class="publicacion_cuerpo col-12">
                <div class="publication_info col-12">
                    <div>
                        <p>Detalles del producto:</p>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Velit voluptate, veritatis, quis tempore laudantium dicta a libero esse fugiat eius impedit, doloribus quaerat sapiente reprehenderit quo iusto molestiae recusandae aspernatur ut. Itaque hic distinctio, voluptas tempora quisquam id veritatis eius?</p>
                    </div>
                    <div>
                        <p>Peso aproximado:</p>
                        <p>000.00Kg</p>
                    </div>
                    <div class="publication_location col-12">
                        <p class="publication_origin">Origen:</br>ipsum dolor sit, amet consectetur adipisicing elit.</p>
                        <p class="publication_destiny">Destino:</br>ipsum dolor sit amet.</p>
                    </div>
                </div>
            </div>
            <div class="publicacion_pie">
                <div id="carouselIndicators_F-N" class="carousel slide">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselIndicators_F-N" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselIndicators_F-N" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselIndicators_F-N" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="/assets/table_photo.jpeg" class="img-fluid d-block w-100" alt="publication_photo">
                        </div>
                        <div class="carousel-item">
                            <img src="/assets/table_photo.jpeg" class="img-fluid d-block w-100" alt="publication_photo">
                        </div>
                        <div class="carousel-item">
                            <img src="/assets/table_photo.jpeg" class="img-fluid d-block w-100" alt="publication_photo">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselIndicators_F-N" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselIndicators_F-N" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="publicacion_comentarios">
                <div class="accordion" id="accordion_F-N">
                    <div class="accordion-item">
                        <h2 name="accordionComentarios" id="accordionHeader_F-N" class="accordion-header">
                            <button name="mostComentarios" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_F-N" aria-expanded="false" aria-controls="collapse_F-N">
                                <p>Mostrar comentarios</p>
                            </button>
                        </h2>
                        <div id="collapse_F-N" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <div class="col-12 comentario" name="comentario" id="comentario-N">
                                    <div class="col-2 user_photo">
                                        <img class="img-fluid u_photo" src="/assets/Logo.png" alt="user">
                                    </div>
                                    <div class="col-10 comentario_cuerpo">
                                        <div class="12 comentario_cabecera_cuerpo">
                                            <div class="col-6"><p>User name</p></div>
                                            <div class="col-6 comentario_date"><p>Hour y Date</p></div>
                                        </div>
                                        <div class="col-12"><p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolorem molestiae et ipsum vitae ratione</p></div>
                                    </div>
                                </div>
                                <div class="col-12 comentario" name="comentario" id="comentario-N">
                                    <div class="col-2 user_photo">
                                        <img class="img-fluid u_photo" src="/assets/Logo.png" alt="user">
                                    </div>
                                    <div class="col-10 comentario_cuerpo">
                                        <div class="12 comentario_cabecera_cuerpo">
                                            <div class="col-6"><p>User name</p></div>
                                            <div class="col-6 comentario_date"><p>Hour y Date</p></div>
                                        </div>
                                        <div class="col-12"><p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolorem molestiae et ipsum vitae ratione, aspernatur culpa aliquam magni animi voluptas?</p></div>
                                    </div>
                                </div>
                                <div class="col-12 comentario" name="comentario" id="comentario-N">
                                    <div class="col-2 user_photo">
                                        <img class="img-fluid u_photo" src="/assets/Logo.png" alt="user">
                                    </div>
                                    <div class="col-10 comentario_cuerpo">
                                        <div class="12 comentario_cabecera_cuerpo">
                                            <div class="col-6"><p>User name</p></div>
                                            <div class="col-6 comentario_date"><p>Hour y Date</p></div>
                                        </div>
                                        <div class="col-12"><p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolorem molestiae et ipsum vitae ratione, aspernatur culpa aliquam magni animi voluptas?</p></div>
                                    </div>
                                </div>
                                <div class="col-12 comentario" name="comentario" id="comentario-N">
                                    <div class="col-2 user_photo">
                                        <img class="img-fluid u_photo" src="/assets/Logo.png" alt="user">
                                    </div>
                                    <div class="col-10 comentario_cuerpo">
                                        <div class="12 comentario_cabecera_cuerpo">
                                            <div class="col-6"><p>User name</p></div>
                                            <div class="col-6 comentario_date"><p>Hour y Date</p></div>
                                        </div>
                                        <div class="col-12"><p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolorem molestiae et ipsum vitae ratione, aspernatur culpa aliquam magni animi voluptas?</p></div>
                                    </div>
                                </div>
                                <div class="col-12 comentario" name="comentario" id="comentario-N">
                                    <div class="col-2 user_photo">
                                        <img class="img-fluid u_photo" src="/assets/Logo.png" alt="user">
                                    </div>
                                    <div class="col-10 comentario_cuerpo">
                                        <div class="12 comentario_cabecera_cuerpo">
                                            <div class="col-6"><p>User name</p></div>
                                            <div class="col-6 comentario_date"><p>Hour y Date</p></div>
                                        </div>
                                        <div class="col-12"><p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolorem molestiae et ipsum vitae ratione, aspernatur culpa aliquam magni animi voluptas?</p></div>
                                    </div>
                                </div>
                                <div class="col-12 comentario" name="comentario" id="comentario-N">
                                    <div class="col-2 user_photo">
                                        <img class="img-fluid u_photo" src="/assets/Logo.png" alt="user">
                                    </div>
                                    <div class="col-10 comentario_cuerpo">
                                        <div class="12 comentario_cabecera_cuerpo">
                                            <div class="col-6"><p>User name</p></div>
                                            <div class="col-6 comentario_date"><p>Hour y Date</p></div>
                                        </div>
                                        <div class="col-12"><p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolorem molestiae et ipsum vitae ratione, aspernatur culpa aliquam magni animi voluptas?</p></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </dialog>
    </div>
    <aside class="col-3">
        <div class="col-12 postulaciones">
            <div class="col-12 postulacion_titulo">
                <h3>Postulaciones</h3>
            </div>
            <div>
                <div class="col-12 postulacion" name="postulacionP" id="postulacionP-N">
                    <p>Pendiente</p>
                    <p>20/12/2023</p>
                </div>
                <div class="col-12 postulacion" name="postulacionA" id="postulacionA-N">
                    <p>Aceptada</p>
                    <p>20/12/2023</p>
                </div>
                <div class="col-12 postulacion" name="postulacionR" id="postulacionR-N">
                    <p>Rechazada</p>
                    <p>20/12/2023</p>
                </div>
                <div class="col-12 postulacion" name="postulacionF" id="postulacionF-N">
                    <p>Finalizada</p>
                    <p>20/12/2023</p>
                </div>
            </div>
        </div>
    </aside>
</section>












<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/Footer.php") ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/JS.php") ?>
<script src="/js/publicacion.js"></script>
</body>
</html>