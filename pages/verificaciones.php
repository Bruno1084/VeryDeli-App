<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/head.php");?>
  <link rel="stylesheet" href="../css/publicacionExtendida.css">
  <link rel="stylesheet" href="/css/miPerfil.css">
  <?php 

  include_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");
  include_once($_SERVER['DOCUMENT_ROOT']. "/utils/get/getAllVerificaciones.php");
  require_once($_SERVER['DOCUMENT_ROOT'] . "/utils/functions/startSession.php");
  require_once($_SERVER['DOCUMENT_ROOT'] . "/components/verificarUser.php");
  ?>
  
  <title>verificaciones</title>
</head>
<body>
  <?php require_once("../components/Header.php");?>
  <div class="d-flex justify-content-center primerDivBody">
  <section class="col-12 cuerpo">
    <?php
      foreach ($verificaciones as $verificacion) {
        renderVerificacion(
          $verificacion["verificacion_id"],
          $verificacion["verificacion_foto-doc1"],
          $verificacion["verificacion_foto-doc2"],
          $verificacion["verificacion_foto-boleta1"],
          $verificacion["verificacion_foto-boleta2"],
          $verificacion["verificacion_tipo-doc"],
          $verificacion["verificacion_tipo-boleta"],
          $verificacion["verificacion_estado"],
          $verificacion["usuario_id"],
        );
      }
    ?>
    </aside>
  </section>
  </div>
  <?php require_once("../components/Footer.php");?>
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