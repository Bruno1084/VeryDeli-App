<?php 
function stateExist($arreglo){
    if(isset($arreglo["state"])){
        return ", ".$arreglo["state"];
    }
}
function isCheck($i,$check){
    if($i==$check)return"checked";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/components/head.php")?>
    <link rel="stylesheet" href="../css/resultSearch.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"/>
    <title>Resultados</title>
</head>
<body>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/components/Header.php")?>
    <div class="addSearch">
        <form action="#" method="GET">
            <input class="form-control" type="text" name="addBusqueda" placeholder="Search" aria-label="Search">
        </form>
    </div>
    <div class="col-12 bodyRes">
        <aside class="col-3">
    <?php
        if(isset($_GET["buscar"])||isset($_GET["reubicar"])){
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
                $coord=array();
                $coordAMostrar=null;
                if(isset($_GET["ubicacion"])) $coordAMostrar=$_GET["ubicacion"];
                else $coordAMostrar=0;
                if(sizeof($data)>0){
                    echo "<form method='GET' action='#'>";
                    for($i=0;$i<sizeof($data["hits"]);$i++){
                        echo "<div class='resultado'>";
                        echo "<label for='lugar-".($i+1)."'>Resultado ".($i+1).":</br>".$data["hits"][$i]["name"].stateExist($data["hits"][$i]).", ".$data["hits"][$i]["country"]."</label>";
                        echo '<input type="radio" name=ubicacion id="lugar-'.($i+1).'" data-value="'.$data["hits"][$i]["point"]["lat"].','.$data["hits"][$i]["point"]["lng"].'" value="'.$i.'" '.isCheck($i,$coordAMostrar).'></br>';
                        echo "</div>";
                        $coord[]=$data["hits"][$i]["point"]["lat"].','.$data["hits"][$i]["point"]["lng"];
                        if($i==$coordAMostrar){
                            $_GET["aBuscar"]=$data["hits"][$i]["point"]["lat"].','.$data["hits"][$i]["point"]["lng"];
                        }
                    }
                    echo "</div>";
                    echo "<input type='text' name='busqueda' value='".$_GET["busqueda"]."' hidden>";
                    echo "<input type='text' name='tipoBusqueda' value='".$_GET["tipoBusqueda"]."' hidden>";
                    echo "<input type='submit' name='reubicar' value='Reubicar'>";
                    echo "</form>";
                }
                $_GET["coordenadas"]=$coord;
                $_GET["metodoBusqueda"]=1;

            }
            else{
                echo "<div id='resultados'>";
                echo "<div>";
                echo "</div>";
                echo "</div>";
                $_GET["metodoBusqueda"]=2;
                $_GET["aBuscar"]=$_GET["busqueda"];
            };
    ?>
        </aside>
        <div class="col-6">
        <?php
            echo renderPublicacionesBusqueda($_GET["aBuscar"],$_GET["metodoBusqueda"]);
        }
        ?>
        </div>
        <aside class="col-3">
            <div id="map" style="width:300px;height:300px"></div>
        </aside>
    </div>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/components/Footer.php")?>
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
                var checkRes=document.querySelector("#resultados .resultado input:checked");
                lati=checkRes.getAttribute("data-value").split(",")[0];
                longi=checkRes.getAttribute("data-value").split(",")[1];
                map = L.map('map').setView([lati, longi], 14); // Primera ubicacion encontrada
                
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                   //maxZoom: 14,
                    //minZoom: 14
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
                lati=resultadoCheck.getAttribute("data-value").split(",")[0];
                longi=resultadoCheck.getAttribute("data-value").split(",")[1];
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