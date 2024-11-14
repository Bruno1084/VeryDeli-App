<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/head.php"); ?>
  <link rel="stylesheet" href="../css/publicacionExtendida.css">
  <?php
  include_once($_SERVER['DOCUMENT_ROOT'] . "/components/publicacionExtendida.php");
  include_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");
  include_once($_SERVER['DOCUMENT_ROOT'] . "/utils/get/getPublicacion.php");
  include_once($_SERVER['DOCUMENT_ROOT'] . "/utils/get/getAutorPublicacion.php");
  require_once($_SERVER['DOCUMENT_ROOT'] . '/components/listaPostulaciones.php');
  require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/startSession.php');
  ?>

  <title>Very Deli</title>
</head>

<body>
  <?php require_once("../components/Header.php"); ?>
  <div class="d-flex justify-content-center">
    <div class="form-rest my-4 col-8"></div>
  </div>
  <div class="primerDivBody">
    <?php
    $publicacion = getPublicacion($_GET['id']);
    if ($publicacion != false) {

      $denuncia = false;
      if (isset($_GET["denuncia"])) {
        $denuncia = true;
      }
      $autor = getAutorPublicacion($_GET['id']);
      $imagenes = json_decode($publicacion['imagenes']);

      $ubicaciones = json_decode($publicacion["ubicaciones"]);
      if ($_SESSION['id'] == $autor['usuario_autor']) {
        echo renderPostulaciones($publicacion['publicacion_id']);
      }

      $foto = array("foto" => $publicacion["usuario_fotoPerfil"], "marco" => $publicacion["usuario_marcoFoto"]);

      echo renderPublicacionExtendida(
        $publicacion['publicacion_id'],
        $publicacion['usuario_usuario'],
        $foto,
        $publicacion['publicacion_fecha'],
        $publicacion['usuario_localidad'],
        $publicacion['publicacion_descr'],
        $publicacion['publicacion_peso'],
        $ubicaciones->origen->barrio,
        $ubicaciones->destino->barrio,
        $imagenes,
        $publicacion["publicacion_esActivo"],
        $denuncia
      );
    }
    ?>
  </div>
  <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/components/Footer.php"); ?>
  <script>
    var btnsAutor = null;
    var cuerpoComentario = null;
    var dropDAutor = null;
    var pOriginal = null;
    var comentarioId = null;

    function modificarComentario(e) {
      var modificar = e.target;
      btnsAutor = document.querySelectorAll(".publicacionExtendida-menuButton-container[data-id='" + modificar.getAttribute("data-id") + "']");
      dropDAutor = modificar.parentElement.parentElement.parentElement;
      comentarioId = dropDAutor.parentElement.parentElement.parentElement.getAttribute("data-id");
      cuerpoComentario = dropDAutor.parentElement.nextElementSibling;
      var p = cuerpoComentario.children[0];
      var botonModif = cuerpoComentario.children[1].children[1];
      var botonCance = botonModif.nextElementSibling;

      // Crear una copia del elemento <p>
      pOriginal = document.createElement("p");
      pOriginal.setAttribute = ("name", p.getAttribute("name"));
      pOriginal.classList = p.classList;
      pOriginal.textContent = p.textContent; // Pasar el contenido del <p> al temporal <p>


      // Crear un nuevo elemento <textarea>
      var textarea = document.createElement("textarea");
      textarea.setAttribute = ("name", p.getAttribute("name"));
      textarea.classList = p.classList;
      textarea.value = p.textContent; // Pasar el contenido del <p> al <textarea>

      // Reemplazar el <p> con el <textarea>
      p.parentNode.replaceChild(textarea, p);

      btnsAutor.forEach(btn => {
        if (btn.id != dropDAutor.id) {
          btn.classList.add("inputHidden");
        }
      })
      // habilita los botónes para guardar cambios y cancelar
      botonModif.classList.remove("inputHidden");
      botonCance.classList.remove("inputHidden");
    }

    function cancelarActualizar(e) {
      var botonCance;
      var botonModif;
      if (e.target.nextElementSibling != null) {
        botonModif = e.target;
        botonCance = botonModif.nextElementSibling;
      } else {
        botonCance = e.target;
        botonModif = botonCance.previousElementSibling;
      }
      var textarea = botonCance.parentElement.previousElementSibling;

      textarea.parentNode.replaceChild(pOriginal, textarea);

      // habilita los botónes para guardar cambios y cancelar
      botonModif.classList.add("inputHidden");
      botonCance.classList.add("inputHidden");
      btnsAutor.forEach(btn => {
        if (btn.id != dropDAutor.id) {
          btn.classList.remove("inputHidden");
        }
      })
    }


    function actualizarComentario(e) {
      var botonModif = e.target;
      var textarea = botonModif.parentElement.previousElementSibling;
      var data = new FormData();
      data.append("id", comentarioId);
      data.append("comentario", textarea.value);

      fetch("/utils/modificarComentario.php", {
          method: "POST",
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
            if (text.trim() == "modificado") {
              var p = document.createElement("p");
              p.textContent = textarea.value;
              p.setAttribute("name", textarea.getAttribute("name"));
              p.classList = textarea.classList;
              textarea.parentNode.replaceChild(p, textarea);
              botonModif.classList.add("inputHidden");
              botonModif.nextElementSibling.classList.add("inputHidden");
              btnsAutor.forEach(btn => {
                if (btn.id != dropDAutor.id) {
                  btn.classList.remove("inputHidden");
                }
              })
            } else if (text.trim() == "error") {
              cancelarActualizar(e);
            }
          } else {
            throw new Error("Respuesta vacía del servidor");
          }
        })
        .catch(error => {
          cancelarActualizar(e);
        });

    }

    function eliminarComentario(e) {
      eliminar = e.target;
      var comentario = eliminar.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement;
      comentarioId = comentario.getAttribute("data-id");
      var data = new FormData();
      data.append("id", comentarioId);
      fetch("/utils/modificarComentario.php", {
          method: "POST",
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
            if (text.trim() == "eliminado") {
              comentario.remove();
            }
          } else {
            throw new Error("Respuesta vacía del servidor");
          }
        })
        .catch(error => {});
    }
  </script>
  <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/components/JS.php") ?>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="/js/postulacion.js"></script>
  <script src="/js/ajax.js"></script>
  <script src="/js/validarReporte.js"></script>
  <script src="/js/cambiarEstado.js"></script>
  <script src="/js/validarCalificacion.js"></script>
  <script src="/js/finalizarPublicacion.js"></script>
</body>

</html>