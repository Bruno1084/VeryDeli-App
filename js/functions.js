var clickAdd=function(){
    if(count==5){
        document.querySelector("#addPhoto").removeEventListener("click",clickAdd);
    }
    else{
        document.querySelector('#addNewPhoto').click();
    }
}
function formatoFoto(fotos){
    var formatSuportPhoto=["image/png","image/jpeg","image/jpg"];
    for(var i=0;i<fotos.length;i++){
        if(!formatSuportPhoto.includes(fotos[i].type)) return false;
    };
    return true;
}

function addFotos(fotos) {
    for (let i = 1; i <= fotos.length; i++) {
        const codifPhoto = URL.createObjectURL(fotos[i - 1]);
        const img = document.createElement('img');
        img.src = codifPhoto;
        img.setAttribute('data-id', "fotoUsuario_"+(nAdd-1)+"_"+(i-1));
        img.id = "fotoUsuario-"+(i+count)+"";
        img.alt = "userPhoto";
        img.onclick = () => deleteFoto(img);

        document.querySelector("#photos").append(img);  // Añadir imagen al contenedor
    }
    count += fotos.length;
}

function deleteFoto(foto){
    foto.remove();
    count-=1;
    if(count==4){
        document.querySelector("#addPhoto").addEventListener("click",clickAdd);
        document.querySelector("#addNewPhoto").removeAttribute("id");
        nuevoInput();
    }
    actualizarInputs();
}
function nuevoInput(){
    var newInput=document.createElement('input');
    newInput.setAttribute("type","file");
    newInput.setAttribute("class","addNewPhoto");
    newInput.setAttribute("accept","image/png, image/jpeg, image/jpg");
    newInput.setAttribute("name","addNewPhoto-"+nAdd+"[]");
    newInput.setAttribute("id","addNewPhoto");
    newInput.setAttribute("multiple","");
    newInput.addEventListener("change", ()=>{
        if ((count+newInput.files.length)<=5 && newInput.files.length>0) {
            if (formatoFoto(newInput.files)) {
                addFotos(newInput.files);
                if (count<5) {
                    newInput.removeAttribute("id");
                    nuevoInput();
                }
            } else {
                alert("Error de formato");
            }
        } else {
            alert("Error. Máximo 5 fotos");
        }
    });
    document.querySelector("#add").append(newInput);
    nAdd+=1;
}

/*function actualizarInputs() {
    const fotos = document.querySelector("#photos").children;
    const inputs = document.querySelectorAll('input[type="file"]');
    var i=0;
    if(fotos.length!=0){
        // Eliminacion del input sin referencias en las imágenes restantes
        while(i < inputs.length) {
            if (!Array.from(fotos).some(foto => foto.getAttribute("data-id").includes("_" + i + "_"))) {
                inputs[i].remove();
                nAdd--;
                break;
            }
            i++;
        }
    }
    // Reasignar nombres a los inputs basados en las imágenes restantes
    if(i<inputs.length){
        for(i;i<inputs.length;i++){
            inputs[i].setAttribute("name","addNewPhoto-"+(i)+"[]");
        }
    }
}*/
function actualizarInputs(){
    var fotos=document.querySelector("#photos").children;
    var i=0;
    while(i<nAdd-1){
        if(!Array.from(fotos).some(foto =>foto.getAttribute("data-id").includes("_"+i+"_")))break;
        i++;
    }
    if(i<nAdd-1){
        var aux=document.querySelector("[name='addNewPhoto-"+i+"\[\]']");
        aux.remove();
        nAdd--;
        var nInputs=document.querySelector("#add").children;
        var countInputs=document.querySelector("#add").childElementCount;
        for((i+2);(i+2)<countInputs;i++){
            nInputs[i+2].setAttribute("name","addNewPhoto-"+(i)+"[]");
        }
    }
}