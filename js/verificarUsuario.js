var countDoc=0;
var countBol=0;
window.addEventListener("load",()=>{
    document.querySelector("#addPhotoDoc").addEventListener("click",clickAddDoc);
    document.querySelector("#addPhotoDoc").setAttribute("onchange","preVisualDoc(event)");

    document.querySelector("#addPhotoBol").addEventListener("click",clickAddBol);
    document.querySelector("#addPhotoBol").setAttribute("onchange","preVisualBol(event)");
});

var clickAddDoc=function(){
    if(countDoc==2){
        document.querySelector("#addPhotoDoc").removeEventListener("click",clickAddDoc);
    }
    else{
        document.querySelector('#addNewPhotoDoc').click();
    }
}
var clickAddBol=function(){
    if(countBol==2){
        document.querySelector("#addPhotoBol").removeEventListener("click",clickAddBol);
    }
    else{
        document.querySelector('#addNewPhotoBol').click();
    }
}

async function preVisualDoc(e){
    var input=e.target;
    var fotos=input.files;
    const imagenesFeedBack = document.querySelector('#invalid-photosDoc');
    if ((countDoc+fotos.length)<=2 && fotos.length>0) {
        if (formatoFotoVerif(fotos)) {
            await addFotosDoc(fotos);
        } else {
        input.classList.add('is-invalid');
        imagenesFeedBack.textContent = "Error de formato";
        imagenesFeedBack.setAttribute("style","display:block");
        }
    } else if(fotos.length>2||(countDoc+fotos.length)>2){
        input.classList.add('is-invalid');
        imagenesFeedBack.textContent = "Error. Máximo 2 fotos";
        imagenesFeedBack.setAttribute("style","display:block");
        }
};
async function preVisualBol(e){
    var input=e.target;
    var fotos=input.files;
    const imagenesFeedBack = document.querySelector('#invalid-photosBol');
    if ((countBol+fotos.length)<=2 && fotos.length>0) {
        if (formatoFotoVerif(fotos)) {
            await addFotosBol(fotos);
        } else {
        input.classList.add('is-invalid');
        imagenesFeedBack.textContent = "Error de formato";
        imagenesFeedBack.setAttribute("style","display:block");
        }
    } else if(fotos.length>2||(countBol+fotos.length)>2){
        input.classList.add('is-invalid');
        imagenesFeedBack.textContent = "Error. Máximo 2 fotos";
        imagenesFeedBack.setAttribute("style","display:block");
        }
};

function formatoFotoVerif(fotos){
    var formatSuportPhoto=["image/png","image/jpeg","image/jpg"];
    for(var i=0;i<fotos.length;i++){
        if(!formatSuportPhoto.includes(fotos[i].type)) return false;
    };
    return true;
}

async function addFotosDoc(fotos){
    var photosId=document.querySelector("#photosIdDoc");
    var imgOk=0;
    for(var i=1;i<=fotos.length;i++){
        var tmpImg=null;
        img=new Image();
        img.src=await file_promiseVerif(fotos[i-1]);
        tmpImg=document.querySelector("#photosIdDoc option[value='"+(img.src.split(',')[1])+"']");
        if(tmpImg==null){
            img.setAttribute('data-id', "fotoUsuarioDoc_"+(countDoc+imgOk));
            img.alt = "userPhotoDoc";
            img.setAttribute("title","Eliminar");
            img.setAttribute("class","img-fluid");
            img.onclick = (e) => deleteFotoDoc(e.target);
            document.querySelector("#photosDoc").appendChild(img);
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
    if(imgOk>0){
        nuevoInputDoc();
    }
    countDoc+=imgOk;
}
async function addFotosBol(fotos){
    var photosId=document.querySelector("#photosIdBol");
    var imgOk=0;
    for(var i=1;i<=fotos.length;i++){
        var tmpImg=null;
        img=new Image();
        img.src=await file_promiseVerif(fotos[i-1]);
        tmpImg=document.querySelector("#photosIdBol option[value='"+(img.src.split(',')[1])+"']");
        if(tmpImg==null){
            img.setAttribute('data-id', "fotoUsuarioBol_"+(countBol+imgOk));
            img.alt = "userPhotoBol";
            img.setAttribute("title","Eliminar");
            img.setAttribute("class","img-fluid");
            img.onclick = (e) => deleteFotoBol(e.target);
            document.querySelector("#photosBol").appendChild(img);
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
    if(imgOk>0){
        nuevoInputBol();
    }
    countBol+=imgOk;
}

let file_promiseVerif=(foto)=>{
    return new Promise((resolve,reject)=>{
        let reader=new FileReader();
        reader.onload=()=>{
            resolve(reader.result);
        }
        reader.readAsDataURL(foto);
    })
}

function deleteFotoDoc(foto){
    var photoId=foto.getAttribute("data-id");
    foto.remove();
    var photo=document.querySelector("#photosIdDoc option[data-id='"+photoId+"']");
    photo.remove();
    var type=document.querySelector("#photosIdDoc option[data-id='"+photoId+"']");
    type.remove();
    actualizarFotosDoc(Number(photoId.split("_")[1]));
    countDoc-=1;
    if(countDoc<2){
        document.querySelector("#addPhotoDoc").addEventListener("click",clickAdd);
    }
}
function deleteFotoBol(foto){
    var photoId=foto.getAttribute("data-id");
    foto.remove();
    var photo=document.querySelector("#photosIdBol option[data-id='"+photoId+"']");
    photo.remove();
    var type=document.querySelector("#photosIdBol option[data-id='"+photoId+"']");
    type.remove();
    actualizarFotosBol(Number(photoId.split("_")[1]));
    countBol-=1;
    if(countBol<2){
        document.querySelector("#addPhotoBol").addEventListener("click",clickAdd);
    }
}

function actualizarFotosDoc(i){
    var photosId=document.querySelector("#photosIdDoc");
    var photos=document.querySelector("#photosDoc").childNodes;
    for(var j=(i*2);j<photosId.length;j+=2){
        photosId[j].setAttribute("data-id","fotoUsuarioDoc_"+i);
        photosId[j+1].setAttribute("data-id","fotoUsuarioDoc_"+i);
        photos[i].setAttribute("data-id","fotoUsuarioDoc_"+i);
        i+=1;
    }
}
function actualizarFotosBol(i){
    var photosId=document.querySelector("#photosIdBol");
    var photos=document.querySelector("#photosBol").childNodes;
    for(var j=(i*2);j<photosId.length;j+=2){
        photosId[j].setAttribute("data-id","fotoUsuarioBol_"+i);
        photosId[j+1].setAttribute("data-id","fotoUsuarioBol_"+i);
        photos[i].setAttribute("data-id","fotoUsuarioBol_"+i);
        i+=1;
    }
}
function nuevoInputDoc(){
    var firstChild=document.querySelector("#addNewPhotoDoc");
    var newInput=document.createElement('input');
    newInput.setAttribute("type","file");
    newInput.setAttribute("accept","image/png, image/jpeg, image/jpg");
    newInput.setAttribute("name","addNewPhotoDoc[]");
    newInput.setAttribute("id","addNewPhotoDoc");
    newInput.setAttribute("onchange","preVisualDoc(event)");
    newInput.setAttribute("multiple","");
    document.querySelector("#addDoc").insertBefore(newInput,firstChild);
    firstChild.remove();
}
function nuevoInputBol(){
    var firstChild=document.querySelector("#addNewPhotoBol");
    var newInput=document.createElement('input');
    newInput.setAttribute("type","file");
    newInput.setAttribute("accept","image/png, image/jpeg, image/jpg");
    newInput.setAttribute("name","addNewPhotoBol[]");
    newInput.setAttribute("id","addNewPhotoBol");
    newInput.setAttribute("onchange","preVisualBol(event)");
    newInput.setAttribute("multiple","");
    document.querySelector("#addBol").insertBefore(newInput,firstChild);
    firstChild.remove();
}


