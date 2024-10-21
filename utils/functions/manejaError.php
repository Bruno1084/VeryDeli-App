<?php
function manejarError($estado, $titulo, $mensaje, $redirect = "") {
  if(($estado == "false")){
    if($redirect == ""){
      echo json_encode(['success' => $estado, 'message' => '<div class="text-bg-danger p-3"><strong>¡' . $titulo . '!</strong><br>' . $mensaje . '</div>']);
    }
    else{
      echo json_encode(['success' => $estado, 'message' => '<div class="text-bg-danger p-3"><strong>¡' . $titulo . '!</strong><br>' . $mensaje . '</div>', 'redirect' => $redirect]);

    }
  } else {
    if($redirect == ""){
      echo json_encode(['success' => $estado, 'message' => '<div class="text-bg-success p-3"><strong>¡' . $titulo . '!</strong><br>'.$mensaje . '</div>']);
    } else {
      echo json_encode(['success' => $estado, 'message' => '<div class="text-bg-success p-3"><strong>¡' . $titulo . '!</strong><br>'.$mensaje . '</div>', 'redirect' => $redirect]);
    }
  }
  exit();
};
