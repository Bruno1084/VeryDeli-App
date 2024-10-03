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

let file_promise=(foto)=>{
    return new Promise((resolve,reject)=>{
        let reader=new FileReader();
        reader.onload=()=>{
            resolve(reader.result);
        }
        reader.readAsDataURL(foto);
    })
}

async function preVisual(e){
    var newInput=e.target;
    var fotos=newInput.files;
    if ((count+fotos.length)<=5 && fotos.length>0) {
        if (formatoFoto(fotos)) {
            await addFotos(fotos);
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
};

async function addFotos(fotos){
    var photosId=document.querySelector("#photosId");
    for(var i=1;i<=fotos.length;i++){
        img=new Image();
        img.src=await file_promise(fotos[i-1]);
        img.id="fotoUsuario-"+(i+count);
        img.setAttribute('data-id', "fotoUsuario_"+(nAdd-1)+"_"+(i-1));
        img.alt = "userPhoto";
        img.onclick = (e) => deleteFoto(e.target);
        document.querySelector("#photos").append(img);
        var newOption=document.createElement("option");
        newOption.setAttribute("data-id",img.getAttribute("data-id"));
        newOption.setAttribute("value",fotos[i-1]["name"]);
        newOption.setAttribute("selected","");
        photosId.appendChild(newOption);
    }
    count+=fotos.length;
}

function deleteFoto(foto){
    var photoId=foto.getAttribute("data-id");
    foto.remove();
    var photo=document.querySelector("#photosId option[data-id='"+photoId+"']");
    photo.remove();
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
    newInput.setAttribute("onchange","preVisual(event)");
    newInput.setAttribute("multiple","");
    document.querySelector("#add").append(newInput);
    nAdd+=1;
}

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
        for((i+3);(i+3)<countInputs;i++){
            nInputs[i+3].setAttribute("name","addNewPhoto-"+(i)+"[]");
        }
    }
}


const btnEnviar=document.querySelector("#enviar");

let showMessage=(status, message)=>{
    btnEnviar.disabled=false;
    console.log(message);
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
                showMessage("error",response);
            }
            else{
                console.log(response);
            }
        }
    )
}