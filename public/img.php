<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>imgBB</title>
</head>
<body>
    <style>
        #addNewPhoto{
            display:none;
        }
        #photos{
            display:flex;
            width:auto;
            height:20vh;
            border: solid 0.1vh black;
        }
    </style>
    <form id="newPublicacion">
        <div id="add">
            <select name="photosId[]" id="photosId" multiple hidden>
            </select>
            <h2 id="addPhoto">Cargar Foto</h2>
            <div id="photos"></div>
            <input type="file" accept="image/png, image/jpeg, image/jpg" name="addNewPhoto[]" id="addNewPhoto" onchange="preVisual(event)" multiple/>
        </div>
        <button type="submit" name="enviar" id="enviar">Enviar</button>
    </form>
    <script src="./inputFotos.js"></script>
</body>
</html>