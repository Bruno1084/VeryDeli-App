<?php
function obtenerFoto($fYm,$userName=false){
    if($userName==false){
        if($fYm["foto"]==0 && $fYm["marco"]==0){
        return "<div class='defaultPicture'><img src='../assets/user.png' alt='user'></div>";
        }
        elseif($fYm["foto"]!=0 && $fYm["marco"]==0){
        return "<div class='defaultPicture'><img src='".$fYm["foto"]."' alt='user'></div>";
        }
        elseif($fYm["foto"]==0 && $fYm["marco"]!=0){
        return '<div class="profilePicture">
                <div class="fondoFoto"></div><img src="'.$fYm["marco"].'" class="decoFoto'.$fYm["marco"][(strlen($fYm["marco"])-5)].'">
                <div class="divFoto"><img src="../assets/user.png" alt="user"></div>
                </div>';
        }
        else{
        return '<div class="profilePicture">
                <div class="fondoFoto"></div><img src="'.$fYm["marco"].'" class="decoFoto'.$fYm["marco"][(strlen($fYm["marco"])-5)].'">
                <div class="divFoto"><img src="'.$fYm["foto"].'" alt="user"></div>
                </div>';
        }
    }
    else{
        if($fYm["foto"]==0 && $fYm["marco"]==0){
        return "<a href='/pages/miPerfil.php?user=".$userName."' class='defaultPicture'><img src='../assets/user.png' alt='user'></a>";
        }
        elseif($fYm["foto"]!=0 && $fYm["marco"]==0){
        return "<a href='/pages/miPerfil.php?user=".$userName."' class='defaultPicture'><img src='".$fYm["foto"]."' alt='user'></a>";
        }
        elseif($fYm["foto"]==0 && $fYm["marco"]!=0){
        return '<a href="/pages/miPerfil.php?user='.$userName.'" class="profilePicture">
                <div class="fondoFoto"></div><img src="'.$fYm["marco"].'" class="decoFoto'.$fYm["marco"][(strlen($fYm["marco"])-5)].'">
                <div class="divFoto"><img src="../assets/user.png" alt="user"></div>
                </a>';
        }
        else{
        return '<a href="/pages/miPerfil.php?user='.$userName.'" class="profilePicture">
                <div class="fondoFoto"></div><img src="'.$fYm["marco"].'" class="decoFoto'.$fYm["marco"][(strlen($fYm["marco"])-5)].'">
                <div class="divFoto"><img src="'.$fYm["foto"].'" alt="user"></div>
                </a>';
        }
    }
}
