<?php
include("php/connect.php");
include("php/user.php");
include("php/game.php");

$user = new User();
if(!$user->logged_in){
    if(isset($_POST['username']) && isset($_POST['password'])){
        if(isset($_POST['login'])){
            if($user->login($_POST['username'], $_POST['password']) == "success"){
                header("Location: /index.php");
            } else {
                echo "Anmeldung fehlgeschlagen";
            }
        } else if(isset($_POST['reg'])){
            echo User::registrieren($_POST['username'], $_POST['password'], $_POST['password']);
        }
    }
    include("include/login.php");
} else {
    if(gameExists()){
        $game = getGame();
        if(!$game->areAllShipsPlaced()){
            include("include/placeShips.php");
        } else {
            if(!$game->isGameOverConfirmed()){
                include("include/gameOver.php");
            } else {
                include("include/game.php");
            }
        }
    } elseif(isset($_GET['joinMatch'])) {
        //todo: Einer Partie mit bereits 2 Spieler darf man nicht beitreten (durch Ändern der URL möglich)
        mysql_query("
            UPDATE
                game
            SET
                player2 = '" . $user->id . "'
            WHERE
                id = '" . $_GET['joinMatch'] . "'
        ");
        header("Location: /index.php");
    } elseif(isset($_GET['createPCMatch'])) {

    } elseif(isset($_GET['createRealMatch'])) {

    } else {
        //include("include/findOpponent.php");
    }
}

function gameExists(){
    //prüft, ob eine noch nicht beendete Partie in der Datenbank gespeichert ist.
    $user = new User();
    $q = mysql_query("
        SELECT
            id
        FROM
            game
        WHERE
            (player1 = '" . $user->id . "' AND gameOverConfirmedByPlayer1 IS NULL)
        OR
            (player2 = '" . $user->id . "' AND gameOverConfirmedByPlayer2 IS NULL)
    ");
    return mysql_num_rows($q) == 1;
}
function getGame(){
    //lädt Daten aus Datenbank, die als PHP-Objekt returned werden.
    $g = new Game();
    return $g;
}
?>
