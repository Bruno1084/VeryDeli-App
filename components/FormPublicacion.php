    <form id="newPublicacion" method="post" action="../utils/ControlFormPublicacion.php">
        <div id="add">
            <select name="photosId[]" id="photosId" multiple hidden>
            </select>
            <h2 id="addPhoto">Cargar Foto</h2>
            <div id="photos"></div>
            <input type="file" accept="image/png, image/jpeg, image/jpg" name="addNewPhoto[]" id="addNewPhoto" onchange="preVisual(event)" multiple/>
        </div>
        <button type="submit" name="enviar" id="enviar">Enviar</button>
    </form>