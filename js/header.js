(()=>{
    var clickTipo=function(){
        var tipo=document.querySelector("#header form .tipoBusqueda");
        if(tipo.classList[1].trim()=="visible"){
            tipo.removeEventListener("click",clickTipo);
        }
        else{
            document.querySelector('#header form input').focus();
        }
    }
    document.querySelector("#header form .tipoBusqueda").addEventListener("click",clickTipo);
    var buscador=document.querySelector(".buscarNav form input");
    buscador.addEventListener("input",()=>{
        var tipo=document.querySelector("#header form .tipoBusqueda");
        var tipoBusqueda=tipo.children;
        if(buscador.value.trim()!=""){
            tipo.classList.remove("no-visible");
            tipoBusqueda[0].setAttribute("style","display:flex");
            tipoBusqueda[1].setAttribute("style","display:flex");
            tipo.classList.add("visible");
            tipo.addEventListener("hover",tipo.setAttribute("style","cursor:default"));
        }
        else{
            tipo.classList.remove("visible");
            tipoBusqueda[0].setAttribute("style","display:none");
            tipoBusqueda[1].setAttribute("style","display:none");
            tipo.classList.add("no-visible");
            tipo.addEventListener("click",clickTipo);
            tipo.addEventListener("hover",tipo.setAttribute("style","cursor:text"));
        }
   });
})()
