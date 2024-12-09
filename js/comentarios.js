window.addEventListener("load",()=>{
    var cargarMas=document.querySelector("#masComentarios");
    if(cargarMas!=null){
        cargarMas=cargarMas.children[0];
        cargarMas.addEventListener("click",masComentarios);
    }
})
var tmpComs=null;
function masComentarios(){
    var cargarMas=document.querySelector("#masComentarios").children[0];
    cargarMas.removeEventListener("click",masComentarios);
    var form=new FormData();
    form.append("totalComentarios",totalComentarios);
    form.append("countComentarios",comentarios);
    form.append("idPublicacion",idPublicacion);
    form.append("offset",offsetComentarios);
    form.append("limit",limitComentarios);
    form.append("denuncia",denuncia);
    form.append("pubEstado",estadoPublicacion);
    form.append("more",true);
    fetch("/utils/functions/masComentarios.php",{
        method: "post",
        body: form
    })
    .then(respuesta => {
        if (!respuesta.ok) { 
            throw new Error('Error en la solicitud: ' + respuesta.status);
        }
        return respuesta.json(); 
    })
    .then(data => { tmpComs=data;
        if (data.cantComentarios>0) {
            offsetComentarios+=limitComentarios;
            comentarios=data.cantComentarios;
            cargarMas.parentElement.remove();
            data.comentarios.forEach(comentario => {
                document.querySelector("#comentarios").innerHTML+=comentario;
            });
            if(data.masComents.length>0){
                document.querySelector("#comentarios").innerHTML+=data.masComents[0];
                cargarMas=document.querySelector("#masComentarios").children[0];
                cargarMas.addEventListener("click",masComentarios);
            }
        } else {
            throw new Error("Respuesta vacía del servidor");
        }
    })
    .catch(error => {});
}