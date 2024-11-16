function procesarDenuncia(e){
    var btn=e.target;
    var tipo=btn.getAttribute("data-name");
    var id=btn.getAttribute("data-id");
    var accion=btn.textContent;
    var p=null;
    if(accion.trim()=="Eliminar" && tipo.trim()=="comentario"){
        p=btn.previousElementSibling.previousElementSibling.children[0];
    }
    else if(accion.trim()=="Permitir" && tipo.trim()=="publicacion"){
        p=btn.nextElementSibling.children[0];
    }
    else{
        p=btn.previousElementSibling.children[0];
    }
    var prosDen=new FormData();
    prosDen.append("id", id);
    prosDen.append("tipo", tipo);
    prosDen.append("accion", accion);

    fetch("/utils/procesarDenuncia.php",{
        method: "POST",
        body: prosDen
    })
    .then(respuesta => {
    if (!respuesta.ok) { // Verifica si la respuesta es un error
        throw new Error('Error en la solicitud: ' + respuesta.status);
    }
    return respuesta.text();
    })
    .then(text => {
    if (text) { 
        if(text.trim()!="Error"){
        p.classList.add(text);
        p.textContent=text;
        setTimeout(() => {
            window.location.href = "/pages/denuncias.php";
        }, 2000);
        }
    } else {
        throw new Error("Respuesta vacía del servidor");
    }
    })
    .catch(error => {});
}