<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"/>
    <title>Resultados</title>
</head>
<body>
    <style>
        #map {
        width: 400px;
        height: 300px;
        }
        #info {
        margin-top: 10px;
        }
    </style>


    <h2>Mapa interactivo</h2>
    <div id="map"></div>
    <div id="info">
    <h3>Coordenadas seleccionadas:</h3>
    <p id="coords">Haga clic en el mapa para obtener las coordenadas.</p>
    </div>
    <div>
    <h3>Búsqueda de lugar:</h3>
    <input type="text" id="search" placeholder="Ingrese un lugar">
    <button onclick="buscarLugar()">Buscar</button>
    </div>




    <div>
        <?php
        
        session_start(); 
        /*$query = urlencode("Cerro de la Cruz, San Luis, Argentina");
        $url="https://graphhopper.com/api/1/geocode?q=" . urlencode($query)."&key=96865858-2f5d-4a0a-9c0b-d56b3f1e20cc";
        */
            $query = array(
                "q" => "San Luis, San Luis, Argentina",
                "locale" => "",
                "limit" => "5",
                "provider" => "default",
                "key" => "96865858-2f5d-4a0a-9c0b-d56b3f1e20cc"
            );
            
            $curl = curl_init();
            
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://graphhopper.com/api/1/geocode?" . http_build_query($query),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_SSL_VERIFYPEER => false,
            ]);
            
            $response = curl_exec($curl);
            $error = curl_error($curl);
            
            curl_close($curl);
            
            if ($error) {
                echo "cURL Error #:" . $error;
            } else {
                
                $res=json_decode($response);
                
                $_SESSION["Ubicacion_Defecto"]=array(
                    "Latitud"=>$res->hits[1]->point->lat,
                    "Longitud"=>$res->hits[1]->point->lng);
            }
        ?>
    </div>
    <div>
        <?php

            $query = array(
                "key" => "96865858-2f5d-4a0a-9c0b-d56b3f1e20cc"
            );
            
            $curl = curl_init();
            
            $payload = array(
                "profile" => "car",
                "points" => array(
                array(
                    -32.883167,
                    -65.222558
                ),
                array(
                    -32.916652,
                    -65.3721781
                )
                ),
                "snap_preventions" => array(
                "motorway"
                ),
                "details" => array(
                "road_class",
                "surface"
                )
            );
            
            curl_setopt_array($curl, [
                CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
                ],
                CURLOPT_POSTFIELDS => json_encode($payload),
                CURLOPT_PORT => "",
                CURLOPT_URL => "https://graphhopper.com/api/1/route?" . http_build_query($query),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_SSL_VERIFYPEER => false,
            ]);
            
            $response = curl_exec($curl);
            $error = curl_error($curl);
            
            curl_close($curl);
            
            if ($error) {
                echo "cURL Error #:" . $error;
            } else {
                //echo $response;
            }
        ?>
    </div>












    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    
    <script>
        var vertical=<?php echo $_SESSION["Ubicacion_Defecto"]["Latitud"]?>;
        var horizontal=<?php echo $_SESSION["Ubicacion_Defecto"]["Longitud"]?>;

        //Icono color Rojo
        var redIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-shadow.png',
            shadowSize: [41, 41]
        });

        // Inicializa el mapa centrado en una ubicación por defecto
        var map = L.map('map').setView([vertical,horizontal], 13); // San Luis, Argentina

        // Añadir teselas de OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Detectar clics en el mapa para obtener coordenadas
        map.on('click', function(e) {
            let lat = e.latlng.lat;
            let lng = e.latlng.lng;
            document.getElementById('coords').textContent = 'Latitud: ' + lat + ', Longitud: ' + lng;
            marker = L.marker([lat, lng],{ icon: redIcon }).addTo(map).bindPopup('Origen').openPopup();
            marker.on('click', function(event) {
                map.removeLayer(event.target);
            });
        });
        // Función para buscar un lugar usando Nominatim
        function buscarLugar() {
            var lugar = document.getElementById('search').value;
            var url = 'https://nominatim.openstreetmap.org/search?format=json&q=' + lugar;

            fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                var lat = data[0].lat;
                var lon = data[0].lon;
                map.setView([lat, lon], 13); // Recentrar mapa en el resultado
                marker = L.marker([lat, lon]).addTo(map).bindPopup('Ubicación: ' + lugar).openPopup();
                marker.on('click', function(e) {
                    map.removeLayer(e.target);
                });
                document.getElementById('coords').textContent = 'Latitud: ' + lat + ', Longitud: ' + lon;
                } else {
                alert('Lugar no encontrado');
                }
            })
            .catch(error => console.log('Error al buscar el lugar:', error));
        }
    </script>
</body>
</html>