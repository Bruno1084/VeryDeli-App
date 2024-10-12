<!DOCTYPE html>
<html lang="en">
<?php
session_start();
?>
<head>
    <?php 
    require_once($_SERVER['DOCUMENT_ROOT'] . "/components/head.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/components/JS.php");
    ?>
</head>

<body class="container d-flex justify-content-center">
    <div class="border col-8 my-4 rounded shadow">
        <div class="text-center">
            <img class="img-fluid" src="../../assets/Very.png" alt="Very Deli" title="Very Deli logo" width="235" height="235">
            <h2> Ingrese el codigo de verificacion para continuar </h2>
        </div>

        <div class="d-flex justify-content-center">
            <div class="form-rest my-4 col-8"></div>
        </div>

        <div class="container py-3">
            <form class="formulario-recuperacion" action="../../utils/resetPass/validarToken.php" method="post">
                <div class="row justify-content-center">
                    <div class="form-group col-md-6 mb-3">
                        <label for="codigo">Codigo de Verificacion</label>
                        <input type="number" min="100000" max="999999" class="form-control bg-input" id="codigo" name="codigo" required placeholder="Ej: 123456">
                    </div>
                </div>

                <div class="row justify-content-center my-3">
                    <div class="col-8 col-md-5 text-center">
                        <button type="submit" class="btn btn-morado btn-block">verificar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
<script>
    //Boolean que indica si el codigo a pasado el limite de 8 minutos sin ser usado
    let codVencido=false;
    //Obtiene la hora a la que se envio el correo de verificacion en milisegundos
    const tse=Number(<?php echo json_encode($_SESSION["timeSendEmail"]) ?>);
    //Obtiene la hora actual del servidor en milisegundos
    let at=Number(<?php
    date_default_timezone_set("America/Argentina/Buenos_Aires");
    echo json_encode(date("U")) ?>);
    //Numero de intentos del usuario
    let intentos=Number(<?php echo json_encode($_SESSION["attempts"]) ?>);
    //suma 1 segundo a la hora actual obtenida, cada 1 segundo
    let intervalo=setInterval(()=>{
        if(at>=(tse+480)){
            clearInterval(intervalo);
        }
        else{
            at+=1;
        }
    },1000);
    
    //correo ya validado
    const correo=JSON.stringify(<?php echo json_encode($_SESSION["email"]) ?>);

    var form=document.querySelector("form");
    form.addEventListener("submit",(e)=>{
        e.preventDefault();
        if(intentos<5&&at<(tse+480)){
            let contenedor = document.querySelector('.form-rest');
            let data = new FormData(form); // Almacena los datos del formulario
            let method = form.getAttribute("method"); // Almacena el metodo de envio
            let action = form.getAttribute("action"); // Almacena la url donde se enviara el formulario
            let config = {  // Almacena las configuraciones a utilizar en el envio por fetch
                method: method,
                mode: "cors",
                cache: "no-cache",
                body: data
            };
            fetch(action, config)
            .then(respuesta => {
            if (!respuesta.ok) { // Verifica si la respuesta es un error
                throw new Error('Error en la solicitud: ' + respuesta.status);
            }
            return respuesta.json(); 
            })
            .then(data => {
            // Muestra la respuesta en el contenedor
            intentos+=1;
            contenedor.innerHTML = data.message
            if (data.redirect) {
                setTimeout(() => {
                window.location.href = data.redirect;
                }, 2000); 
            }
            })
            .catch(error => {
                contenedor.innerHTML = '<div class="text-bg-danger p-3">Error: ' + error.message + '</div>'; // Muestra el error
            });
        }
        else{
            if(at>=tse+480){
                codigoVencido();
            }
            else{
                codVencido=true;
                let contenedor = document.querySelector('.form-rest');
                contenedor.innerHTML = '<div class="text-bg-danger"><strong>¡Intentos agotados!</strong><br>El numero de intentos ha superado el limite de 5 intentos.</div>';
                contenedor.innerHTML += '<form id="reenviarT" method="post" action="../../utils/resetPass/reenviarToken.php"><input name="reenviar" hidden></input><button type="submit">Reenviar codigo de verificacion</button></form>';
                rForm=document.querySelector("#reenviarT");
                rForm.addEventListener("submit",(e)=>{
                    e.preventDefault();
                    resendToken();
                });
            }

        }
    })


    function codigoVencido(){
        if(!codVencido){
            codVencido=true;
            let tmpForm=document.createElement("form");
            tmpForm.setAttribute("action","../../utils/resetPass/resetToken.php");
            tmpForm.setAttribute("method","post");
            let tmpInput=document.createElement("input");
            tmpInput.setAttribute("type","text");
            tmpInput.setAttribute("name","resetToken");
            tmpInput.setAttribute("value","");
            tmpForm.appendChild(tmpInput);
            let tmpContenedor = document.querySelector('.form-rest');
            let tmpData = new FormData(tmpForm); // Almacena los datos del formulario
            let tmpMethod = tmpForm.getAttribute("method"); // Almacena el metodo de envio
            let tmpAction = tmpForm.getAttribute("action"); // Almacena la url donde se enviara el formulario
            let tmpConfig = {  // Almacena las configuraciones a utilizar en el envio por fetch
                method: tmpMethod,
                mode: "cors",
                cache: "no-cache",
                body: tmpData
            };
            fetch(tmpAction, tmpConfig)
            .then(respuesta => {
            if (!respuesta.ok) { // Verifica si la respuesta es un error
                throw new Error('Error en la solicitud: ' + respuesta.status);
            }
            return respuesta.json(); 
            })
            .then(data => {
                // Muestra la respuesta en el contenedor
                intentos=5;
                tmpContenedor.innerHTML = data.message
                tmpContenedor.innerHTML += '<form id="reenviarT" method="post" action="../../utils/resetPass/reenviarToken.php"><input name="reenviar" hidden></input><button type="submit">Reenviar codigo de verificacion</button></form>';
                rForm=document.querySelector("#reenviarT");
                rForm.addEventListener("submit",(e)=>{
                    e.preventDefault();
                    resendToken();
                });
            })
            .catch(error => {
                tmpContenedor.innerHTML = '<div class="text-bg-danger p-3">Error: ' + error.message + '</div>'; // Muestra el error
            })
        }
    }
    
    
    function resendToken(){
        let rContenedor = document.querySelector('.form-rest');
        let rData=new FormData(rForm);
        let rMethod = rForm.getAttribute("method"); // Almacena el metodo de envio
        let rAction = rForm.getAttribute("action"); // Almacena la url donde se enviara el formulario
        let rConfig = {  // Almacena las configuraciones a utilizar en el envio por fetch
            method: rMethod,
            mode: "cors",
            cache: "no-cache",
            body: rData
        };
        fetch(rAction, rConfig)
        .then(respuesta => {
        if (!respuesta.ok) { // Verifica si la respuesta es un error
            throw new Error('Error en la solicitud: ' + respuesta.status);
        }
        return respuesta.json(); 
        })
        .then(data => {
            // Si la respuesta es verdadera recarga la pagina
            rContenedor.innerHTML = data.message
            if (data.redirect) {
                setTimeout(() => {
                window.location.href = data.redirect;
                }, 2000); 
            }
        })
        .catch(error => {
            rContenedor.innerHTML = '<div class="text-bg-danger p-3">Error: ' + error.message + '</div>'; // Muestra el error
        })
    }
</script>
</html>