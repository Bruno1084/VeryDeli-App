<?php
    function estadoCalif($calificacion){
      if(is_array($calificacion)){
        $calificacion = round($calificacion['calificacion_promedio']);
      }
      if($calificacion == 1){
          return "<img class='img-fluid' src='/assets/rating(1).svg' alt='rate'>";
      }
      else if($calificacion == 2){
          return "<img class='img-fluid' src='/assets/rating(2).svg' alt='rate'>";
      }
      else if($calificacion == 3){
          return "<img class='img-fluid' src='/assets/rating(3).svg' alt='rate'>";
      }
      else if($calificacion == 4){
          return "<img class='img-fluid' src='/assets/rating(4).svg' alt='rate'>";
      }
      else if($calificacion == 5){
          return "<img class='img-fluid' src='/assets/rating(5).svg' alt='rate'>";
      }
      else{
          return "<img class='img-fluid' src='/assets/rating(0).svg' alt='rate'>";
      }
    }

    function renderCalificaciones($calificaciones){
      echo '
        <style>
    .tabla-calif td, .tabla-calif th {
        vertical-align: middle;
        text-align: center;
        padding: 4px; 
    }
    .rating-stars {
        justify-content: center;
        font-size: 1.5rem; 
    }
    .rating-stars svg {
        width: 14px; 
        height: 14px;
    }
    .container {
        max-width: 800px; 
        heigth: 600px;
        margin: 0 auto;
    }
    
    table tr {
      heigth: 100px;
    }
</style>
        <div class="container">
          <table class="table table-bordered table-hover tabla-calif">
            <thead class="table-dark">
              <tr>
                <th>Usuario Calificador</th>
                <th>Usuario Calificado</th>
                <th>Puntaje</th>
              </tr>
            </thead>
            <tbody>';
              foreach($calificaciones as $calificacion){
              echo'
                  <tr>
                      <td>'.$calificacion['nombre_calificador'].'</td>
                      <td>'.$calificacion['nombre_calificado'].'</td>
                      <td>
                          <div class="d-flex rating-stars">
                            '.estadoCalif($calificacion['calificacion_puntaje']).'
                          </div>
                      </td>
                </tr>'; 
              }
            echo 
            '</tbody>
          </table>
        </div>';
    }
?>