<?php
function borrarImagenImgBB($delete_url) {
  try{
    $con = curl_init();
    curl_setopt($con, CURLOPT_URL, $delete_url);
    curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($con, CURLOPT_CUSTOMREQUEST, "GET");
    
    $response = curl_exec($con);
    
    if(curl_errno($con)){
      return curl_error($con);
    }
    else{
      curl_close($con);
      return $response;
    }
  }
  catch(Exception $e){
    return $e->getMessage();
  }
}
