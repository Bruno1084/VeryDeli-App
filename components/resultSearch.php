<?php 
function stateExist($arreglo){
    if(isset($arreglo["state"])){
        return ", ".$arreglo["state"];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/components/head.php")?>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"/>
    <title>Resultados</title>
</head>
<body>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/components/Header.php")?>
    <aside class="col-3">
    <?php
        if(isset($_GET["buscar"])){
            require_once($_SERVER["DOCUMENT_ROOT"]."/components/publicacionesBusqueda.php");
            if($_GET["tipoBusqueda"]=="zona"){
                echo "<div id='resultados'>";
                echo "<h3>Resultados:</h3>";
                
                $url = "https://graphhopper.com/api/1/geocode?q=".urlencode($_GET["busqueda"].", Argentina")."&key=96865858-2f5d-4a0a-9c0b-d56b3f1e20cc";

                // Configuración de cURL
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // Esto desactiva la verificación SSL, no recomendado en producción
                $response = curl_exec($ch);

                if(curl_errno($ch)) {
                    echo '<div class="text-bg-danger p-3"><strong>¡Error inesperado!</strong><br>Ha ocurrido un error al momento de buscar la locacion solicitada</div>';
                }

                curl_close($ch);
                $data = json_decode($response, true);
                for($i=0;$i<sizeof($data["hits"]);$i++){
                    echo "<div class='resultado'>";
                    echo "<label for='lugar-".($i+1)."'>Resultado ".($i+1).":</br>".$data["hits"][$i]["name"].stateExist($data["hits"][$i]).", ".$data["hits"][$i]["country"]."</label>";
                    echo '<input type="radio" name="lugar" id="lugar-'.($i+1).'" value="'.$data["hits"][$i]["point"]["lat"].','.$data["hits"][$i]["point"]["lng"].'"></br>';
                    echo "</div>";
                    $_GET["busqueda"]=$data["hits"][$i]["point"]["lat"].','.$data["hits"][$i]["point"]["lng"];
                    $_GET["tipoBusqueda"]=1;
                }
                echo "</div>";
            }
            else{
                echo "<div id='resultados'>";
                echo "<div>";
                echo "</div>";
                echo "</div>";
                $_GET["tipoBusqueda"]=2;
            };
    ?>
        <div id="map" style="width:300px;height:300px"></div>
    </aside>
    <div class="col-6">
    <?php
        echo renderPublicacionesBusqueda($_GET["busqueda"],$_GET["tipoBusqueda"]);
    }
    
    ?>
    </div>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/components/JS.php")?>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        var lati=null;
        var longi=null;
        var map=null;
        var radio=650;
        var circle=null;
        window.addEventListener("load",()=>{
            var resultado1=document.querySelector("#resultados div");
            if(resultado1.classList.contains("resultado")){
                resultado1.children[1].setAttribute("checked","");
                lati=resultado1.children[1].value.split(",")[0];
                longi=resultado1.children[1].value.split(",")[1];
                map = L.map('map').setView([lati, longi], 14); // Primera ubicacion encontrada
                
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                    maxZoom: 14,
                    minZoom: 14
                }).addTo(map);
                var label=resultado1.children[0].textContent.split(":")[0];
                cargarPublicaciones(resultado1,label);
                accionCheck();
            }
        });
        function cargarPublicaciones(resultadoCheck=null,label=null){
            if(resultadoCheck==null){
                resultadoCheck=document.querySelector("#resultados .resultado input:checked");
                label=resultadoCheck.previousElementSibling.textContent.split(":")[0];
                lati=resultadoCheck.value.split(",")[0];
                longi=resultadoCheck.value.split(",")[1];
                map.removeLayer(ubicacion);
                map.removeLayer(circle);
                map.setView([lati, longi], 14);
            }
            marcarLugar(label);
        }
        function marcarLugar(label){
            ubicacion = L.marker([lati, longi]).addTo(map).bindPopup(label).openPopup();
            circle = L.circle([lati,longi], {
                color: 'blue',
                opacity:0.8,
                fillColor: '#0003ff',
                fillOpacity: 0.3,
                radius: radio
            }).addTo(map);
        }
       
        function accionCheck(){
            var inputs=document.querySelectorAll("#resultados input[type='radio']");
            inputs.forEach(input=>{
                input.addEventListener("change",(e)=>{
                    if(e.target.checked){
                        cargarPublicaciones();
                    }
                });
            });
        }

    </script>

</body>
</html>