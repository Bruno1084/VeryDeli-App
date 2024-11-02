<?php
function stringRandom(int $tam):string{
    $txt="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr(str_shuffle($txt),0, $tam);
}