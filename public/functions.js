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
}
