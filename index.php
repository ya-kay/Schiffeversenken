<?php
if(!isset($_COOKIE['user'])){
    if(isset($_POST['username'])){
        setcookie("user", $_POST['username'], time() + (60 * 60 * 24 * 365));
        header("Location: index.php");
    } else {
        include("include/login.php");
    }
} else {
    if(gameExists()){
        $game = getGameInfos();
        if(!$game->areShipsPlaced()){
            include("include/placeShips.php");
        } else {
            if(!$game->isGameOverConfirmed()){
                include("include/gameOver.php");
            } else {
                include("include/game.php");
            }
        }
    } else {
        include("include/findOpponent.php");
    }
}

function gameExists(){
    //prüft, ob eine noch nicht beendete Partie in der Datenbank gespeichert ist.
    return false;
}
function getGameInfos(){
    //lädt [JSON] Daten aus Datenbank, die als PHP-Objekt returned werden.
    return null;
}
?>
