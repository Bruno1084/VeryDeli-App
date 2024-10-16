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
        #btn-container {
            height:30px;
            width:30px;
            position: relative;
            top: -8vh;
            right: -55vh;
            z-index: 1000; /* Asegura que el botón esté por encima del mapa */
        }

        #btn-centra-mapa {
            height:100%;
            width:100%;
            background-color: white;
            border:2px solid rgba(0, 0, 0, 0.2);
            color: black;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>


    <h2>Mapa interactivo</h2>
    <div id="map"></div>
    <div id="btn-container">
        <button id="btn-centra-mapa" onclick="centrarEnMiUbicacion()"></button>
    </div>
    <div id="info">
    <h3>Coordenadas seleccionadas:</h3>
    <p id="coords">Haga clic en el mapa para obtener las coordenadas.</p>
    <a href="https://www.google.com/maps/place/-33.268538232410904,-66.30599319934846">abrir maps</a>
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
        var origen=null;
        var destino=null;
        var ruta = null;
        var miUbicacion = null;
        //Icono color Rojo
        var redIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-shadow.png',
            shadowSize: [41, 41]
        });
        //Icono color Verde
        var greenIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-shadow.png',
            shadowSize: [41, 41]
        });
        //Distintas capas para el mapa
        var porDefecto = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
        var simple = L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png');
        var satelite = L.tileLayer('https://api.maptiler.com/maps/satellite/{z}/{x}/{y}@2x.jpg?key=OpTD9h2MxIr6P9bmwMLz');
        // Inicializa el mapa centrado en una ubicación por defecto
        var map = L.map('map',{
            center:[vertical,horizontal],
            zoom: 13,
            layers:[porDefecto]   
        }); // San Luis, Argentina
        
        

        // Añadir distintas capas al mapa
        var baseMaps = {
            "Default": porDefecto,
            "Simple": simple,
            "Satelite": satelite
        };

        L.control.layers(baseMaps).addTo(map);
        
        // Detectar clics en el mapa para obtener coordenadas
        map.on('click', function(e) {
            if(origen==null||destino==null){
                let lat = e.latlng.lat;
                let lng = e.latlng.lng;
                document.getElementById('coords').textContent = 'Latitud: ' + lat + ', Longitud: ' + lng;
                if(origen==null){
                    if(ruta!=null&&destino==null){
                        if(ruta!=null){
                            map.removeLayer(ruta);
                            ruta=null;
                        };
                    }
                    origen = L.marker([lat, lng],{ icon: redIcon }).addTo(map).bindPopup('Origen').openPopup();
                    if(destino!=null) obtenerRuta();
                    origen.on('click', function(event) {
                        // Eliminar el origen anterior
                        map.removeLayer(event.target);
                        origen=null;
                        // Eliminar la ruta anterior si existe
                        if(ruta!=null){
                            map.removeLayer(ruta);
                            ruta=null;
                        };
                    });
                }
                else if(destino==null){
                    if(ruta!=null&&origen==null){
                        if(ruta!=null){
                            map.removeLayer(ruta);
                            ruta=null;
                        };
                    }
                    destino = L.marker([lat, lng]).addTo(map).bindPopup('Destino').openPopup();
                    if(origen!=null) obtenerRuta();
                    destino.on('click', function(event) {
                        // Eliminar el destino anterior
                        map.removeLayer(event.target);
                        destino=null;
                        // Eliminar la ruta anterior si existe
                        if(ruta!=null){
                            map.removeLayer(ruta);
                            ruta=null;
                        };
                    });
                }
            }
        });

        function obtenerRuta() {
            var tmpOrigen = origen.getLatLng();
            var tmpDestino = destino.getLatLng();

            // Llamada a la API de OpenRouteService
            var apiKey = '5b3ce3597851110001cf62483b5a376be02e414cb6c37b1a68d7381f';
            var url = `https://api.openrouteservice.org/v2/directions/driving-car?api_key=${apiKey}&start=${tmpOrigen.lng},${tmpOrigen.lat}&end=${tmpDestino.lng},${tmpDestino.lat}`;

            fetch(url)
                .then(response =>response.json())
                .then(data => {
                    // Obtener las coordenadas de la ruta
                    var routeCoords = data.features[0].geometry.coordinates;

                    // Convertir las coordenadas a formato Leaflet (lat, lng)
                    var leafletCoords = routeCoords.map(coord => [coord[1], coord[0]]);

                    // Dibujar la ruta en el mapa
                    trazarRuta(leafletCoords);
                })
            .catch(error => console.error('Error al obtener la ruta:', error));
        }
        function trazarRuta(leafletCoords){
            if(ruta!=null){
                map.removeLayer(ruta);
            }
            ruta = L.polyline(leafletCoords, {
                color: 'green',      // Color de la línea
                weight: 5,           // Grosor de la línea
                opacity: 0.7,        // Opacidad
                smoothFactor: 1      // Suavidad
            }).addTo(map);
        }

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

        function centrarEnMiUbicacion() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;
                    
                    // Centra el mapa en la ubicación actual
                    map.setView([lat, lon], 13);  // 13 es el nivel de zoom que puedes ajustar
                
                    // Añadir un marcador en la ubicación actual
                    if(miUbicacion!=null){
                        map.removeLayer(miUbicacion);
                        miUbicacion=null;
                    }
                    miUbicacion=L.marker([lat, lon],{icon: greenIcon}).addTo(map)
                        .bindPopup("Estás aquí.")
                        .openPopup();
                }, (error) => {
                    console.log("No se pudo obtener la ubicación: " + error.message);
                });
            } else {
                alert("Geolocalización no soportada por este navegador.");
            }
        }

    </script>
</body>
</html>