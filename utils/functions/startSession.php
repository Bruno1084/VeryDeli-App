<?php
if(isset($_SESSION [""])){
    session_unset();
    session_destroy();
}
session_name("VERY-SESSION");
session_start();
