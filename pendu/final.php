<!DOCTYPE html>
<html lang="<?php echo $language; ?>">
    <head>
        <meta charset="UTF-8">
        <title>Fin du Jeu</title>
    </head>
    <body>
        <?php
            require('header.php');
            if(isset($_SESSION['gagne'])){
                if ($_SESSION['gagne']==true){
                    echo "<p>Bravo ! Quelle performance !</p>";
                }
                else{
                    echo "<p>Dommage... Tu as perdu... !</p>";
                    echo "<img src=./img/8.png>";
                }
            }



            try {
                $servername = 'sql928.main-hosting.eu';
                $username = 'u578660070_open';
                $password = 'Admin123/';
                
                //On essaie de se connecter
                try{
                    $conn = new PDO("mysql:host=$servername;dbname=u578660070_open", $username, $password);
                    //On définit le mode d'erreur de PDO sur Exception
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }
                
                /*On capture les exceptions si une exception est lancée et on affiche
                 *les informations relatives à celle-ci*/
                catch(PDOException $e){
                    echo "Erreur : " . $e->getMessage();
                }

                $motMystere ="";
                foreach ($_SESSION['mot'] as $caractere){
                    $motMystere = $motMystere.$caractere;
                }
            
                $sql = "INSERT INTO PARTIES_PENDU (JOUEUR_1, JOUEUR_2, NB_COUP, VICTOIRE, MOT_MYSTERE)
                VALUES (:JOUEUR_1, :JOUEUR_2, :NB_COUP, :VICTOIRE, :MOT_MYSTERE)";
                $stmt = $conn->prepare($sql);
            
                $stmt->bindParam(':JOUEUR_1', $_SESSION['joueur1']);
                $stmt->bindParam(':JOUEUR_2', $_SESSION['joueur2']);
                $stmt->bindParam(':NB_COUP', $_SESSION['nbCoupEsseye']);
                $stmt->bindParam(':VICTOIRE', $_SESSION['gagne']);
                $stmt->bindParam(':MOT_MYSTERE', $motMystere);
            
                $stmt->execute();
            
            } catch (PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
            }

            $conn = null;
            if(isset($_SESSION)) {
                session_unset(); 
                session_destroy();
            }
        ?>
        <a href="./index.php"> Une Nouvelle Partie ? </p>
    </body>
</html>