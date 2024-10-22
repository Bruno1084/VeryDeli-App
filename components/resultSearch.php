<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"/>
    <link rel="stylesheet" href="../css/ubicacionEnvio.css">
    <title>Resultados</title>
</head>
<body>
    <form action="../utils/ubicacion.php" method="post">
    <div class="row">
              <div class="col-6" id="direcciones">
                  <div class="col-6">
                      <h2>Origen:</h2>
                      <div>
                          <input type="text" name="origen_barrio" placeholder="Barrio">
                      </div>
                      <div>
                          <input type="text" name="origen_manzana-piso" placeholder="Manzana/Piso">
                      </div>
                      <div>
                          <input type="text" name="origen_casa-depto" placeholder="Casa/Depto">
                      </div>
                      <input type="text" name="origen_coordenadas" id="coordsOrigen" hidden>
                  </div>
                  <div class="col-6">
                      <h2>Destino:</h2>
                      <div>
                          <input type="text" name="destino_barrio" placeholder="Barrio">
                      </div>
                      <div>
                          <input type="text" name="destino_manzana-piso" placeholder="Manzana/Piso">
                      </div>
                      <div>
                          <input type="text" name="destino_casa-depto" placeholder="Casa/Depto">
                      </div>
                      <input type="text" name="destino_coordenadas" id="coordsDestino" hidden>
                  </div>
              </div>
              <div class="col-6 divMapa_Boton">
                  <div id="map"></div>
                  <div id="btn-container">
                      <img src="../assets/gps-location-off.png" id="btn-centrar-mapa">
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
    <script src="../js/ubicacionEnvio.js"></script>
    <script>
        var resBusqueda = null
        var circle = null;
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


        function getMyLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    const myLocation={lat:position.coords.latitude,lng: position.coords.longitude};
                    return myLocation;
                }, (error) => {
                    alert("No se pudo obtener la ubicación");
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