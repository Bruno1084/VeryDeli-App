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
    newInput.remove();
    nuevoInput();
    if ((count+fotos.length)<=5 && fotos.length>0) {
        if (formatoFoto(fotos)) {
            await addFotos(fotos);
        } else {
            alert("Error de formato");
        }
    } else if(fotos.length>5||(count+fotos.length)>5){
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
    var imgOk=0;
    for(var i=1;i<=fotos.length;i++){
        var tmpImg=null;
        img=new Image();
        img.src=await file_promise(fotos[i-1]);
        tmpImg=document.querySelector("#photosId option[value='"+(img.src.split(',')[1])+"']");
        if(tmpImg==null){
            img.setAttribute('data-id', "fotoUsuario_"+(count+imgOk));
            img.alt = "userPhoto";
            img.onclick = (e) => deleteFoto(e.target);
            document.querySelector("#photos").appendChild(img);
            var newOption=document.createElement("option");
            newOption.setAttribute("data-id",img.getAttribute("data-id"));
            newOption.setAttribute("value",img.src.split(',')[1]);
            newOption.setAttribute("selected","");
            photosId.appendChild(newOption);
            var newOption=document.createElement("option");
            newOption.setAttribute("data-id",img.getAttribute("data-id"));
            newOption.setAttribute("value",fotos[i-1].type);
            newOption.setAttribute("selected","");
            photosId.appendChild(newOption);
            imgOk+=1;
        }
    }
    count+=imgOk;
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
    var photo=document.querySelector("#photosId option[data-id='"+photoId+"']");
    photo.remove();
    var type=document.querySelector("#photosId option[data-id='"+photoId+"']");
    type.remove();
    actualizarFotos(Number(photoId.split("_")[1]));
    count-=1;
    if(count==4){
        document.querySelector("#addPhoto").addEventListener("click",clickAdd);
    }
}

function actualizarFotos(i){
    var photosId=document.querySelector("#photosId");
    var photos=document.querySelector("#photos").childNodes;
    for(var j=(i*2);j<photosId.length;j+=2){
        photosId[j].setAttribute("data-id","fotoUsuario_"+i);
        photosId[j+1].setAttribute("data-id","fotoUsuario_"+i);
        photos[i].setAttribute("data-id","fotoUsuario_"+i);
        i+=1;
    }
}
function nuevoInput(){
    var newInput=document.createElement('input');
    newInput.setAttribute("type","file");
    newInput.setAttribute("accept","image/png, image/jpeg, image/jpg");
    newInput.setAttribute("name","addNewPhoto[]");
    newInput.setAttribute("id","addNewPhoto");
    newInput.setAttribute("onchange","preVisual(event)");
    newInput.setAttribute("multiple","");
    document.querySelector("#add").append(newInput);
}

const btnEnviar=document.querySelector("#btn-enviar");

var showMessage=(status, message)=>{
    console.log('ejecutando showMessage');
    btnEnviar.disabled=false;
    alert(message);
}

const sendData = async(data)=>{
    console.log('ejecutando sendData');
    return await fetch("../utils/ControlFormPublicacion.php", {
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
                showMessage("error",response);
            }
            else{
                showMessage("success",response);
            }
        }
    )
}
