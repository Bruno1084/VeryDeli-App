var count=0;
window.addEventListener("load",()=>{
    document.querySelector("#addPhoto").addEventListener("click",clickAdd);
});

var clickAdd=function(){
    if(count==5){
        document.querySelector("#addPhoto").removeEventListener("click",clickAdd);
    }
    else{
        document.querySelector('#addNewPhoto').click();
    }
}

async function preVisual(e){
    var newInput=e.target;
    var fotos=newInput.files;
    if ((count+fotos.length)<=5 && fotos.length>0) {
        if (formatoFoto(fotos)) {
            await addFotos(fotos);
        } else {
            alert("Error de formato");
        }
    } else if(fotos.length>5){
            alert("Error. Máximo 5 fotos");
        }
};

function formatoFoto(fotos){
    var formatSuportPhoto=["image/png","image/jpeg","image/jpg"];
    for(var i=0;i<fotos.length;i++){
        if(!formatSuportPhoto.includes(fotos[i].type)) return false;
    };
    return true;
}

async function addFotos(fotos){
    var photosId=document.querySelector("#photosId");
    for(var i=1;i<=fotos.length;i++){
        img=new Image();
        img.src=await file_promise(fotos[i-1]);
        img.id="fotoUsuario-"+(i+count);
        img.setAttribute('data-id', "fotoUsuario_"+(count+i-1));
        img.setAttribute('data-type', fotos[i-1].type);
        img.alt = "userPhoto";
        img.onclick = (e) => deleteFoto(e.target);
        document.querySelector("#photos").append(img);
        var newOption=document.createElement("option");
        newOption.setAttribute("name",img.getAttribute("data-id"));
        newOption.setAttribute("value",img.src.split(',')[1]);
        newOption.setAttribute("selected","");
        photosId.appendChild(newOption);
        var newOption=document.createElement("option");
        newOption.setAttribute("data-type",img.getAttribute("data-id"));
        newOption.setAttribute("value",fotos[i-1].type);
        newOption.setAttribute("selected","");
        photosId.appendChild(newOption);
    }
    count+=fotos.length;
}

let file_promise=(foto)=>{
    return new Promise((resolve,reject)=>{
        let reader=new FileReader();
        reader.onload=()=>{
            resolve(reader.result);
        }
        reader.readAsDataURL(foto);
    })
}

function deleteFoto(foto){
    var photoId=foto.getAttribute("data-id");
    foto.remove();
    var photo=document.querySelector("#photosId option[name='"+photoId+"']");
    photo.remove();
    var type=document.querySelector("#photosId option[data-type='"+photoId+"']");
    type.remove();
    actualizarFotos(photoId.split("_")[1]);
    count-=1;
    if(count==4){
        document.querySelector("#addPhoto").addEventListener("click",clickAdd);
    }
}

function actualizarFotos(i){
    var photosId=document.querySelector("#photosId");
    for(i;i<photosId.length;i+=2){
        photosId[i].setAttribute("name","fotoUsuario_"+i);
        photosId[i+1].setAttribute("data-type","fotoUsuario_"+i);
    }
}


/*
const btnEnviar=document.querySelector("#enviar");

let showMessage=(status, message)=>{
    btnEnviar.disabled=false;
    if(status=="error"){
        alert(message)
    }
    else if(status=="success"){
        console.log(message);
        
    }
}

btnEnviar.onclick = e =>{
    e.preventDefault();
    btnEnviar.disabled=true;
    const data=new FormData(document.querySelector("#newPublicacion"));
    sendData(data);
    
}
const sendData = async(data)=>{
    return await fetch("./eje.php", {
        method:"POST",
        body: data
    })
    .then(
        response=>{
            if(response.ok){
                return response.json();
            }
            else{
                throw "Ocurrio un error inesperado";
            }
        }
    )
    .then(
        response=>{
            if(response.error){
                showMessage("error",toString(response));
            }
            else{
                showMessage("success",toString(response));
            }
        }
    )
}*/