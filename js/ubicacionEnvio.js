//San Luis
var vertical=-33.3020736;
var horizontal=-66.3369577;
//Distintas capas para el mapa
var porDefecto = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
var simple = L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png');
var satelite = L.tileLayer('https://api.maptiler.com/maps/satellite/{z}/{x}/{y}@2x.jpg?key=OpTD9h2MxIr6P9bmwMLz');

var origen=null;
var destino=null;
var ruta = null;
var miUbicacion = null;


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

    
// Añadir distintas capas al mapa
var baseMaps = {
    "Default": porDefecto,
    "Simple": simple,
    "Satelite": satelite
};

var map;

window.addEventListener("load",()=>{
    map=iniciarMapa();
    addMyLocation();
    getMyLocation();
    
});
function iniciarMapa(){
    // Inicializa el mapa centrado en una ubicación por defecto
    var map = L.map('map',{
        center:[vertical,horizontal],
        zoom: 13,
        layers:[porDefecto]
    }); // San Luis, Argentina
    L.control.layers(baseMaps).addTo(map);
    clickMap(map);
    reCentrarMapa(map);
    return map;
}

function addMyLocation(){
    var divMap=document.querySelector("#map .leaflet-control-container");
    var myLocation=document.createElement("div");
    myLocation.setAttribute("id","btn-container");
    var imgLocation=new Image();
    imgLocation.src="../assets/gps-location-off.png";
    imgLocation.setAttribute("id","btn-centrar-mapa");
    myLocation.appendChild(imgLocation);
    divMap.appendChild(myLocation);
}

function clickMap(map){
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
}

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

function getMyLocation(){
    var btnCentrar=document.querySelector("#btn-centrar-mapa");
    btnCentrar.addEventListener("click",()=>{
        btnCentrar.src="../assets/gps-location-on.png";
        centrarEnMiUbicacion(btnCentrar);
    });
}

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

function reCentrarMapa(map){
    var modal=document.querySelector("#modalCrearPublicacion");
    modal.addEventListener('shown.bs.modal', function () {
        map.invalidateSize();  // Recalcula el tamaño del mapa
        map.setView([vertical, horizontal], 13);  // Recentrar el mapa en las coordenadas deseadas
    });
}
