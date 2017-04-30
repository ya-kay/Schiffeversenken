<!doctype html>
<html>
    <head>
        <title>Schiffeversenken - Gegner finden</title>
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
                    <h3 class="panel-title">Bestehender Partie beitreten</h3>
                </div>
                <div class="panel-body">
                    <?php
                    $q = mysql_query("
                        SELECT
                            game.id,
                            user.username
                        FROM
                            game,
                            user
                        WHERE
                            game.player1 = user.id
                        AND
                            game.player2 IS NULL
                        AND
                            game.player1 != '" . $user->id . "'
                    ");
                    if(mysql_num_rows($q) > 0){
                        echo '<div class="list-group">';
                        while($a = mysql_fetch_array($q)){
                            echo '<a href="index.php?joinMatch=' . $a[0] . '"><button type="button" class="list-group-item">#' . $a[0] . ' vs. ' . $a[1] . '</button></a>';
                        }
                        echo '</div>';
                    } else {
                        echo 'Keine aktiven Spiele vorhanden!';
                    }
                    ?>
                </div>
            </div>

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Partie selbst starten</h3>
                </div>
                <div class="panel-body">
                    <div class="list-group">
                        <a href="index.php?createPCMatch=true"><button type="button" class="list-group-item">Spiel gegen Computer starten</button></a>
                        <a href="index.php?createRealMatch=true"><button type="button" class="list-group-item">Spiel gegen echten gegner starten</button></a>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </body>
</html>
