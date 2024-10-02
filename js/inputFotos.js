var count=0;
var nAdd=1;
window.addEventListener("load",()=>{
    document.querySelector("#addPhoto").addEventListener("click",clickAdd);
    input=document.querySelector('#addNewPhoto');
    input.addEventListener("change",()=>{
        if ((count+input.files.length)<=5 && input.files.length>0) {
            if (formatoFoto(input.files)) {
                addFotos(input.files);
                if (count<5) {
                    input.removeAttribute("id");
                    nuevoInput();
                }
            } else {
                alert("Error de formato");
                input.files=null;
            }
        } else {
            alert("Error. Máximo 5 fotos");
        }
    });
});