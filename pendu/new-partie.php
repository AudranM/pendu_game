<!DOCTYPE html>
<html lang="<?php echo $language; ?>">
    <head>
        <meta charset="UTF-8">
        <title>Nouvelle Partie</title>
    </head>
        <body>
            <form action="" method="POST">
                <label for="joueur1"> Joueur 1 </label>
                <input type="text" id="joueur1" name="joueur1">

                <label for="joueur2"> Joueur 2 </label>
                <input type="text" id="joueur2" name="joueur2">

                <input type="submit" value="send">
            </form>

            <?php
                require('header.php');
                if (isset($_POST['joueur1']) && isset($_POST['joueur2']) && !empty($_POST['joueur1']) && !empty($_POST['joueur2'])){
                    $_SESSION['joueur1'] = str_replace("<", " ", $_POST['joueur1']);
                    $_SESSION['joueur2'] = str_replace("<", " ", $_POST['joueur2']);
                    header('Location:def-mot.php');
                    exit(0);
                }
                else {
                    echo "<p> Renseigner un nom valide pour les deux joueurs</p>"; 
                }
            ?>
        </body>
</html>

