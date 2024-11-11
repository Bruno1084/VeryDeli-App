<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/startSession.php');
    session_unset();
    session_destroy();
    setcookie("VERY-SESSION", "", time() - 3600, "/");
    header('Location: /public/index.php');
    exit();
