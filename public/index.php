<?php

if(empty($_SESSION)){
  require_once($_SERVER["DOCUMENT_ROOT"]."/components/login.php");
}
else{
  require_once($_SERVER["DOCUMENT_ROOT"]."/pages/inicio.php");
}
