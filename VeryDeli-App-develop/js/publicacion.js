var mostComentarios=document.querySelectorAll("[name=mostComentarios]");
window.addEventListener("load",()=>{
    mostComentarios.forEach(mostComentario=>{
        mostComentario.addEventListener("click",()=>{
            if(mostComentario.ariaExpanded=="true"){
                mostComentario.firstElementChild.innerHTML="Cerrar comentarios";
                mostComentario.parentElement.style.borderBottom="solid 0.3vh #dee2e6";
            }
            else{
                mostComentario.firstElementChild.innerHTML="Mostrar comentarios";
                mostComentario.parentElement.style.borderBottom="none";
            }
        });
    });
});

var publicaciones=document.querySelectorAll("[name=publicacion]");
window.addEventListener("load",()=>{
    publicaciones.forEach(publicacion=>{
        publicacion.addEventListener("click",()=>{
            document.querySelector("#"+publicacion.id+"D").showModal();
        });
        var c=document.querySelector("#"+publicacion.id+"D_C").firstElementChild;
        if(c!=null){
            c.addEventListener("click",()=>{
                document.querySelector("#"+publicacion.id+"D").close();
            });
        }
    });
});

var postulaciones=document.querySelectorAll("[name=postulacion]");
window.addEventListener("load",()=>{
    for(i=1;i<postulaciones.length;i++){
        postulaciones[i].style.borderTop="solid 0.3vh black";
    }
});

var comentarios=document.querySelectorAll("[name=comentario]");
window.addEventListener("load",()=>{
    comentarios.forEach(comentario=>{
        comentario.addEventListener("click",()=>{
            document.querySelector("#"+comentario.id+"_PA").showModal();
        });
        var c=document.querySelector("#"+comentario.id+"_PA_C").firstElementChild;
        if(c!=null){
            c.addEventListener("click",()=>{
                document.querySelector("#"+comentario.id+"_PA").close();
            });
        }
    });
    
});