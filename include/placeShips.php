<!doctype html>
<html>
    <head>
        <title>Schiffeversenken - Schiffe platzieren</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container center">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Schiffe platzieren</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered placeShips">
                        <tr>
                            <td class="bg-primary"></td>
                            <?php
                                for($i=0;$i<10;$i++){
                                    echo '<td class="bg-primary">' . chr(65 + $i) . '</td>';
                                }
                            ?>
                        </tr>
                        <?php
                            $i = 0;
                            while($i < 100){
                                if($i%10==0){
                                    echo '<tr>';
                                    echo '<td class="bg-primary">' . ($i/10 + 1) . '</td>';
                                }
                                echo '<td class="position" data-pos="' . $i . '" data-checked="false"></td>';
                                $i++;
                                if($i%10==0){
                                    echo '</tr>';
                                }
                            }
                        ?>
                </table>
                <button class="btn btn-primary btn-lg" id="checkShips">Prüfen</button> <button class="btn btn-primary btn-lg disabled">Absenden</button>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $("body").on('click','table.placeShips tr td[class=position][data-checked=false]', function() {
                    $(this).css("background-color", "#000000");
                    $(this).attr("data-checked", "true");
                });
                $("body").on('click','table.placeShips tr td[class=position][data-checked=true]', function() {
                    $(this).css("background-color", "#FFFFFF");
                    $(this).attr("data-checked", "false");
                });
                $("body").on('click','#checkShips', function(){
                    var ships = [];
                    for(var i = 0; i < 100; i++){
                        if($("td[data-pos='" + i).attr("data-checked") === "true"){
                            ships.push(i);
                        }
                    }
                    console.log(ships);
                    $.post("/index.php", {placedShips: ships});
                });
            });
        </script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </body>
</html>
