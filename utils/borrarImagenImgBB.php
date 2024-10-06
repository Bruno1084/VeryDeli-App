<?php
    function borrarImagenImgBB($delete_url) {
        $con = curl_init();
        curl_setopt($con, CURLOPT_URL, $delete_url);
        curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($con, CURLOPT_CUSTOMREQUEST, "GET");
    
        $response = curl_exec($con);
        
        return $response;
      }