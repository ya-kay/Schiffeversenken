<?php
require_once(dirname($_SERVER['DOCUMENT_ROOT']) . "/www/php/connect.php");

class Game{
    public $player1;
    public $player2;

    public $x = 0;

    public function __construct(){
        $this->x = 1;
    }

    public function areAllShipsPlaced(){
        return false;
    }

    public function checkPlacedShips($ships){
        //Schiffpositionen sind im Array $ships gespeichert
        //for($i=0;$i<count($ships);$i++){
        //    echo $ships[$i] . " - ";
        //}

        //return true/false;
    }
}
?>
