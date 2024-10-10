<?php
    if(isset($_SESSION [""])){
        session_unset();
        session_destroy();
    }
    header('Location: /components/registarse.php');