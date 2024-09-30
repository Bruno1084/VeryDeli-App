var count=0;
var nAdd=1;
window.addEventListener("load",()=>{
    document.querySelector("#addPhoto").addEventListener("click",clickAdd);
    document.querySelector("#addPhoto").addEventListener("click",()=>{
        var btn=document.querySelector('#addNewPhoto');
        btn.addEventListener("change",()=>{
            if((count+btn.files.length)<=5){
                if(formatoFoto(btn.files)){
                    addFotos(btn);
                    btn.removeAttribute("id");
                    nuevoInput();
                }
                else{
                    alert("Error de formato");
                }
            }
            else{
                alert("Error. Maximo 5 fotos");
            }
        });
    });
});