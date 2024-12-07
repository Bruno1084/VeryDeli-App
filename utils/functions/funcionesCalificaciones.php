<?php
    function estadoCalif($calificacion){
      if(is_array($calificacion)){
        $calificacion = round($calificacion['calificacion_promedio'],1);
      }
      if(!is_numeric($calificacion)||($calificacion>=0 && $calificacion<0.5)){
        return "<img class='img-fluid' src='/assets/rating(0).png' alt='rate'>";
      }elseif($calificacion>=0.5 && $calificacion<1){
        return "<img class='img-fluid' src='/assets/rating(1).png' alt='rate'>";
      }elseif($calificacion>=1 && $calificacion<1.5){
        return "<img class='img-fluid' src='/assets/rating(2).png' alt='rate'>";
      }elseif($calificacion>=1.5 && $calificacion<2){
        return "<img class='img-fluid' src='/assets/rating(3).png' alt='rate'>";
      }elseif($calificacion>=2 && $calificacion<2.5){
        return "<img class='img-fluid' src='/assets/rating(4).png' alt='rate'>";
      }elseif($calificacion>=2.5 && $calificacion<3){
        return "<img class='img-fluid' src='/assets/rating(5).png' alt='rate'>";
      }elseif($calificacion>=3 && $calificacion<3.5){
        return "<img class='img-fluid' src='/assets/rating(6).png' alt='rate'>";
      }elseif($calificacion>=3.5&&$calificacion<4){
        return "<img class='img-fluid' src='/assets/rating(7).png' alt='rate'>";
      }elseif($calificacion>=4 && $calificacion<4.5){
        return "<img class='img-fluid' src='/assets/rating(8).png' alt='rate'>";
      }elseif($calificacion>=4.5&&$calificacion<5){
        return "<img class='img-fluid' src='/assets/rating(9).png' alt='rate'>";
      }elseif($calificacion=5){
        return "<img class='img-fluid' src='/assets/rating(10).png' alt='rate'>";
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
    .rating-stars img {
        width: 70px; 
        height: auto;
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
