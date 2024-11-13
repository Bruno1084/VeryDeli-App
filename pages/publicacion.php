<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/head.php");?>
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
  <?php require_once("../components/Header.php");?>
  <div class="d-flex justify-content-center">
    <div class="form-rest my-4 col-8"></div>
  </div>
  <div class="primerDivBody">
  <?php 
    $publicacion = getPublicacion($_GET['id']);
    if($publicacion!=false){

      $denuncia=false;
      if(isset($_GET["denuncia"])){
        $denuncia=true;
      }
      $autor = getAutorPublicacion($_GET['id']);
      $imagenes = json_decode($publicacion['imagenes']);
  
      $ubicaciones = json_decode($publicacion["ubicaciones"]);
      if($_SESSION['id'] == $autor['usuario_autor']){
        echo renderPostulaciones($publicacion['publicacion_id']);
      }
      
      $foto=array("foto"=>$publicacion["usuario_fotoPerfil"],"marco"=>$publicacion["usuario_marcoFoto"]);
  
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
  <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/components/Footer.php");?>
  <script>
    
    function actualizarComentario(e){
      
    }
    var textOriginal="";
    function modificarComentario(e){
      var modificar=e.target;
      console.log(modificar.getAttribute("data-id"));
      var btnsAutor=document.querySelectorAll(".publicacionExtendida-menuButton-container[data-id='"+modificar.getAttribute("data-id")+"']");
      var form = modificar.parentElement.parentElement.parentElement.parentElement.nextElementSibling.children[0];
      var dropDAutor = form.parentElement.previousElementSibling.children[2];
      var p = form.children[0];
      var botonModif = form.children[1].children[1];
      var botonCance =botonModif.nextElementSibling;
      textOriginal=p.textContent;
      // Crear un nuevo elemento <textarea>
      var textarea = document.createElement("textarea");
      textarea.setAttribute = ("name",p.getAttribute("name"));
      textarea.classList=p.classList;
      textarea.value = p.textContent; // Pasar el contenido del <p> al <textarea>

      // Reemplazar el <p> con el <textarea>
      p.parentNode.replaceChild(textarea, p);

      btnsAutor.forEach(btn=>{
        console.log(btn.id);
        if(btn.id!=dropDAutor.id){
          btn.classList.add("inputHidden");
        }
      })
      // habilita los botónes para guardar cambios y cancelar
      botonModif.classList.remove("inputHidden");
      botonCance.classList.remove("inputHidden");

    }
    function cancelarActualizar(e){
      var botonCance=e.target;
      var botonModif=botonCance.previousElementSibling;
      var textarea=botonCance.parentElement.previousElementSibling;

      // Crear un nuevo elemento <p>
      var p = document.createElement("p");
      p.setAttribute = ("name",textarea.getAttribute("name"));
      p.classList=textarea.classList;
      p.value = textOriginal; // Pasar el contenido del <textArea> al <p>
      // Reemplazar el <p> con el <textarea>
      textarea.parentNode.replaceChild(p, textarea);

      // habilita los botónes para guardar cambios y cancelar
      botonModif.classList.add("inputHidden");
      botonCance.classList.add("inputHidden");
    }
  </script>
  <?php require_once($_SERVER["DOCUMENT_ROOT"]."/components/JS.php")?>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="/js/postulacion.js"></script>
  <script src="/js/ajax.js"></script>
  <script src="/js/validarReporte.js"></script>
  <script src="/js/cambiarEstado.js"></script>
  <script src="/js/validarCalificacion.js"></script>
  <script src="/js/finalizarPublicacion.js"></script>
</body>
</html>