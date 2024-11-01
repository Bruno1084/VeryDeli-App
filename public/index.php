<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/utils/functions/startSession.php");

if(empty($_SESSION)){
  session_unset();
  session_destroy();
  setcookie("VERY-SESSION", "", time() - 3600, "/");
  require_once($_SERVER["DOCUMENT_ROOT"]."/components/login.php");
}
else{
  require_once($_SERVER["DOCUMENT_ROOT"]."/pages/inicio.php");
}