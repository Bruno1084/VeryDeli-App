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
        #direcciones {
            display:flex;
        }
        #direcciones h2{
            margin: 10px 5px;
        }
        #direcciones div div{
            display: flex;
            justify-content: space-between;
            margin:5px 10px 10px;
        }
        #btn-container {
            height:30px;
            width:30px;
            position: relative;
            top: -8vh;
            right: -55vh;
            z-index: 1000; /* Asegura que el botón esté por encima del mapa */
        }

        #btn-centrar-mapa {
            height:auto;
            width:auto;
            background-color: white;
            border:2px solid rgba(0, 0, 0, 0.2);
            color: black;
            padding: 1px;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>

    <form action="../utils/ubicacion.php" method="post">
        <div>
            <h2>Mapa interactivo</h2>
            <div id="map"></div>
            <div id="btn-container">
                <img src="../assets/gps-location-off.png" id="btn-centrar-mapa">
            </div>
            <div id="direcciones">
                <div>
                    <h2>Origen:</h2>
                    <div>
                        <label for="origen_barrio">Barrio:</label>
                        <input type="text" name="origen_barrio">
                    </div>
                    <div>
                        <label for="origen_manzana_piso">Manzana/Piso:</label>
                        <input type="text" name="origen_manzana_piso">
                    </div>
                    <div>
                        <label for="origen_casa_depto">Casa/Depto:</label>
                        <input type="text" name="origen_casa_depto">
                    </div>
                    <input type="text" name="origen_coordenadas" id="coordsOrigen" hidden>
                </div>
                <div>
                    <h2>Destino:</h2>
                    <div>
                        <label for="destino_barrio">Barrio:</label>
                        <input type="text" name="destino_barrio">
                    </div>
                    <div>
                        <label for="destino_manzana_piso">Manzana/Piso:</label>
                        <input type="text" name="destino_manzana_piso">
                    </div>
                    <div>
                        <label for="destino_casa_depto">Casa/Depto:</label>
                        <input type="text" name="destino_casa_depto">
                    </div>
                    <input type="text" name="destino_coordenadas" id="coordsDestino" hidden>
                </div>
            </div>
        </div>
        <button type="submit">Enviar</button>
    </form>
    <div>
    <h3>Búsqueda de lugar:</h3>
    <input type="text" id="search" placeholder="Ingrese un lugar">
    <input type="radio" name="distanciaBusqueda" id="500m" value="500" checked>
    <label for="500m">500</label>
    <input type="radio" name="distanciaBusqueda" id="1000m" value="1000">
    <label for="1000m">1000</label>
    <input type="radio" name="distanciaBusqueda" id="1500m" value="1500">
    <label for="1500m">1500</label>
    <button onclick="buscarLugar()">Buscar</button>
    </div>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    
    <script>
        var vertical=-33.3020736;
        var horizontal=-66.3369577;
        var origen=null;
        var destino=null;
        var ruta = null;
        var miUbicacion = null;
        var resBusqueda = null
        var circle = null;

        //Icono color Rojo, Origen
        var redIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-shadow.png',
            shadowSize: [41, 41]
        });
        
        //Icono color Verde, Destino
        var greenIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-shadow.png',
            shadowSize: [41, 41]
        });
        
        //Icono color Azul, My Location
        var blueIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-blue.png',
            iconSize: [15, 25],
            iconAnchor: [7, 25],
            popupAnchor: [1, -21],
            shadowUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-shadow.png',
            shadowSize: [25, 25]
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
                if(origen==null){
                    if(ruta!=null&&destino==null){
                        if(ruta!=null){
                            map.removeLayer(ruta);
                            ruta=null;
                        };
                    }
                    document.getElementById('coordsOrigen').value=lat+','+lng;
                    origen = L.marker([lat, lng],{ icon: redIcon }).addTo(map).bindPopup('Origen').openPopup();
                    if(destino!=null) obtenerRuta();
                    origen.on('click', function(event) {
                        // Eliminar el origen anterior
                        document.getElementById('coordsOrigen').value="";
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
                    document.getElementById('coordsDestino').value=lat+','+lng;
                    destino = L.marker([lat, lng],{ icon: greenIcon }).addTo(map).bindPopup('Destino').openPopup();
                    if(origen!=null) obtenerRuta();
                    destino.on('click', function(event) {
                        // Eliminar el destino anterior
                        document.getElementById('coordsDestino').value="";
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
            .catch(error => alert('Error al obtener la ruta'));
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
            var radio=document.querySelector("input[name='distanciaBusqueda']:checked");
            var lugar = document.getElementById('search').value;
            var url = 'https://nominatim.openstreetmap.org/search?format=json&q=' + lugar;

            fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                var lat = data[0].lat;
                var lon = data[0].lon;
                if(resBusqueda!=null){
                    map.removeLayer(resBusqueda);
                }
                if(circle!=null){
                    map.removeLayer(circle);
                }
                console.log(radio.value);
                switch(radio.value){
                    case("500"): map.setView([lat, lon], 15);break; // Recentrar mapa en el resultado
                    case("1000"): map.setView([lat, lon], 14);break; // Recentrar mapa en el resultado
                    case("1500"): map.setView([lat, lon], 13);break; // Recentrar mapa en el resultado
                    default: map.setView([lat, lon], 10); // Recentrar mapa en el resultado
                }
                
                resBusqueda = L.marker([lat, lon]).addTo(map).bindPopup('Ubicación: ' + lugar).openPopup();
                circle = L.circle([lat,lon], {
                    color: 'blue',
                    opacity:0.8,
                    fillColor: '#0003ff',
                    fillOpacity: 0.3,
                    radius: radio.value
                }).addTo(map);
                resBusqueda.on('click', function(e) {
                    map.removeLayer(e.target);
                    map.removeLayer(circle);
                    resBusqueda=null;
                    circle=null;
                });
                } else {
                alert('Lugar no encontrado');
                }
            })
            .catch(error => alert('Error al buscar el lugar:', error));
        }

        var btnCentrar=document.querySelector("#btn-centrar-mapa");
        btnCentrar.addEventListener("click",()=>{
            btnCentrar.src="../assets/gps-location-on.png";
            centrarEnMiUbicacion(btnCentrar);
        });

        function centrarEnMiUbicacion(btnCentrar) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;
                    // Centra el mapa en la ubicación actual
                    map.setView([lat, lon], 25);  // 25 es el nivel de zoom que puedes ajustar
                
                    // Añadir un marcador en la ubicación actual
                    if(miUbicacion!=null){
                        map.removeLayer(miUbicacion);
                        miUbicacion=null;
                    }
                    miUbicacion=L.marker([lat, lon],{icon: blueIcon}).addTo(map)
                        .bindPopup("Estás aquí.")
                        .openPopup();
                }, (error) => {
                    alert("No se pudo obtener la ubicación");
                    btnCentrar.src="../assets/gps-location-off.png";
                });
            } else {
                alert("Geolocalización no soportada por este navegador.");
                btnCentrar.src="../assets/gps-location-off.png";
            }
        }

        function getMyLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    const myLocation={lat:position.coords.latitude,lng: position.coords.longitude};
                    return myLocation;
                }, (error) => {
                    console.log("No se pudo obtener la ubicación: " + error.message);
                });
            } else {
                alert("Geolocalización no soportada por este navegador.");
            }
            return false;
        }
        function redirectGPS(){
            myLocation=getMyLocation();
            if(myLocation!=false){

            }
        }
    </script>
</body>
</html>