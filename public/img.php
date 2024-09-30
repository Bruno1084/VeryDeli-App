<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>imgBB</title>
</head>
<body>
    <?php
        $apiKey="b9a4cf5a03920383d33b750bae0914a0";
        $imgUpload="https://api.imgbb.com/1/upload";
    ?>
    <style>
        .addNewPhoto{
            display:none;
        }
        #photos{
            display:flex;
            width:auto;
            height:20vh;
            border: solid 0.1vh black;
        }
    </style>
    <form method="post" action="eje.php" accept="image/png, image/jpg, image/jpeg" enctype="multipart/form-data">
        <div id="add">
            <h2 id="addPhoto">Cargar Foto</h2>
            <div id="photos"></div>
            <input type="file" class="addNewPhoto" name="addNewPhoto-0[]" id="addNewPhoto" multiple/>
        </div>
        <button type="submit" name="enviar" id="enviar">Enviar</button>
    </form>
    <script src="./functions.js"></script>
    <script src="./inputFotos.js"></script>
</body>
</html>