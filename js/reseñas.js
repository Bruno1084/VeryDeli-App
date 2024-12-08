window.addEventListener("load",()=>{
    var cargarMas=document.querySelector("#masMensajesCalif");
    if(cargarMas!=null){
        cargarMas.children[0].addEventListener("click",masCalificaciones);
    }
})

function masCalificaciones(){
    var cargarMas=document.querySelector("#masMensajesCalif").children[0];
    cargarMas.removeEventListener("click",masCalificaciones);
    var lastChild=cargarMas.parentElement;
    var filtro=document.querySelector("#filtrarCalif").selectedIndex;
    var order=document.querySelector("#ordenarCalif").selectedIndex;
    var stars=document.querySelector("#starsCalif").selectedIndex;
    var form=new FormData();
    form.append("idUser",idUser);
    form.append("offset",offset);
    form.append("limit",limit);
    form.append("filtro",filtro);
    form.append("orden",order);
    form.append("stars",stars);
    form.append("more",true);
    fetch("/utils/functions/masCalifs.php",{
        method: "post",
        body: form
    })
    .then(respuesta => {
        if (!respuesta.ok) { 
            throw new Error('Error en la solicitud: ' + respuesta.status);
        }
        return respuesta.json(); 
    })
    .then(data => {
        if (data.length>0) {
            offset+=limit;
            mensajesCalifs+=data.length;
            data.forEach(mensaje => {
                var divMensaje=document.createElement("div");
                divMensaje.classList="mensaje m-2 border-top border-bottom border-dark-subtle";

                var divMensajeHead=document.createElement("div");
                divMensajeHead.classList="mensaje_head d-flex align-items-center justify-content-between";

                var divRating=document.createElement("div");
                divRating.classList="rating ms-1";

                var imgRating=document.createElement("img");
                imgRating.classList="img-fluid";
                imgRating.src="/assets/rating("+(mensaje.calificacion_puntaje*2)+").png";
                imgRating.alt="rate";

                divRating.appendChild(imgRating);

                var divDate=document.createElement("div");
                divDate.classList="date me-1";

                var pDate=document.createElement("p");
                pDate.classList="mb-0";
                pDate.textContent=mensaje.calificacion_fecha.split(" ")[0].split("-")[2]+"/"+mensaje.calificacion_fecha.split(" ")[0].split("-")[1]+"/"+mensaje.calificacion_fecha.split(" ")[0].split("-")[0];
                
                divDate.appendChild(pDate);

                var divmensajeBody=document.createElement("div");
                divmensajeBody.classList="mensaje_body mx-1";

                var pBody=document.createElement("p");
                pBody.classList="my-1";
                pBody.textContent=mensaje.calificacion_mensaje;

                divmensajeBody.appendChild(pBody);

                divMensajeHead.appendChild(divRating);
                divMensajeHead.appendChild(divDate);

                divMensaje.appendChild(divMensajeHead);
                divMensaje.appendChild(divmensajeBody);

                lastChild.parentElement.insertBefore(divMensaje, lastChild);
            });
            if(mensajesCalifs<totalMensajesCalif){
                cargarMas.addEventListener("click",masCalificaciones);
            }else{
                cargarMas.parentElement.remove();
            }
        } else {
            throw new Error("Respuesta vacía del servidor");
        }
    })
    .catch(error => {});
}

function actualizarCalificaciones(){
    var filtro=document.querySelector("#filtrarCalif").selectedIndex;
    var order=document.querySelector("#ordenarCalif").selectedIndex;
    var stars=document.querySelector("#starsCalif").selectedIndex;
    offset=0;
    var form=new FormData();
    form.append("idUser",idUser);
    form.append("offset",offset);
    form.append("limit",limit);
    form.append("filtro",filtro);
    form.append("orden",order);
    form.append("stars",stars);
    fetch("/utils/functions/masCalifs.php",{
        method: "post",
        body: form
    })
    .then(respuesta => {
        if (!respuesta.ok) { 
            throw new Error('Error en la solicitud: ' + respuesta.status);
        }
        return respuesta.json(); 
    })
    .then(data => {
        mensajesCalifs=data.mensajes.length;
        totalMensajesCalif=data.totalMensajes;
        
        var newDivMensajes=document.createElement("div");
        newDivMensajes.id="mensajesCalif";
        newDivMensajes.classList="mensajes_calif";
        
        var divMensajes=document.querySelector("#mensajesCalif");
        divMensajes.parentNode.replaceChild(newDivMensajes,divMensajes);

        if (data.mensajes.length>0 && data.totalMensajes>0) {
            data.mensajes.forEach(mensaje => {
                var divMensaje=document.createElement("div");
                divMensaje.classList="mensaje m-2 border-top border-bottom border-dark-subtle";

                var divMensajeHead=document.createElement("div");
                divMensajeHead.classList="mensaje_head d-flex align-items-center justify-content-between";

                var divRating=document.createElement("div");
                divRating.classList="rating ms-1";

                var imgRating=document.createElement("img");
                imgRating.classList="img-fluid";
                imgRating.src="/assets/rating("+(mensaje.calificacion_puntaje*2)+").png";
                imgRating.alt="rate";

                divRating.appendChild(imgRating);

                var divDate=document.createElement("div");
                divDate.classList="date me-1";

                var pDate=document.createElement("p");
                pDate.classList="mb-0";
                pDate.textContent=mensaje.calificacion_fecha.split(" ")[0].split("-")[2]+"/"+mensaje.calificacion_fecha.split(" ")[0].split("-")[1]+"/"+mensaje.calificacion_fecha.split(" ")[0].split("-")[0];
                
                divDate.appendChild(pDate);

                var divmensajeBody=document.createElement("div");
                divmensajeBody.classList="mensaje_body mx-1";

                var pBody=document.createElement("p");
                pBody.classList="my-1";
                pBody.textContent=mensaje.calificacion_mensaje;

                divmensajeBody.appendChild(pBody);

                divMensajeHead.appendChild(divRating);
                divMensajeHead.appendChild(divDate);

                divMensaje.appendChild(divMensajeHead);
                divMensaje.appendChild(divmensajeBody);

                newDivMensajes.appendChild(divMensaje);
            });
            if(mensajesCalifs<totalMensajesCalif){
                var divCargarMas=document.createElement("div");
                divCargarMas.id="masMensajesCalif";
                divCargarMas.classList="text-center mb-3 pb-1 pt-2 border-top border-bottom border-dark-subtle col-12";
                
                var h5CargarMas=document.createElement("h5");
                h5CargarMas.value="Cargar mas";
                h5CargarMas.addEventListener("click",masCalificaciones());

                divCargarMas.appendChild(h5CargarMas);
                
                newDivMensajes.appendChild(divCargarMas);
            }
        }else{
            var divmensajeBody=document.createElement("div");
            divmensajeBody.classList="text-center m-4";

            var pBody=document.createElement("p");
            pBody.classList="mb-0";
            pBody.textContent="Ninguna coincidencia encontrada";

            divmensajeBody.appendChild(pBody);
            newDivMensajes.appendChild(divmensajeBody);
        }
    })
    .catch(error => {});
}