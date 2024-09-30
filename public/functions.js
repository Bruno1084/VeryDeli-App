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
function addFotos(btn){
    var i;
    for(i=1;i<=btn.files.length;i++){
        var codifPhoto=URL.createObjectURL(btn.files[i-1]);
        document.querySelector("#photos").innerHTML+='<img name="fotoUsuario_'+(nAdd-1)+'_'+(i-1)+'" id="fotoUsuario-'+(i+count)+'" src="'+codifPhoto+'" alt="userPhoto" onclick="deleteFoto(this);">';
    }
    count+=btn.files.length;
}
function deleteFoto(foto){
    foto.remove();
    count-=1;
    if(count==4){
        document.querySelector("#addPhoto").addEventListener("click",clickAdd);
    }
    actualizarInputs();
}
function nuevoInput(){
    var aux=document.createElement('input');
    aux.setAttribute("type","file");
    aux.setAttribute("class","addNewPhoto");
    aux.setAttribute("name","addNewPhoto-"+nAdd+"[]");
    aux.setAttribute("id","addNewPhoto");
    aux.setAttribute("multiple","");
    document.querySelector("#add").append(aux);
    nAdd+=1;
}

function actualizarInputs(){
    var fotos=document.querySelector("#photos").children;
    var i=0;
    while(i<nAdd-1){
        if(!Array.from(fotos).some(foto =>foto.name.includes("_"+i+"_")))break;
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