<!DOCTYPE html>
<html lang="<?php echo $language; ?>">
    <head>
        <meta charset="UTF-8">
        <title>Définition du mot</title>
    </head>
    <body>
        <?php
            require('header.php');
            echo "<p>".$_SESSION['joueur1']." renseigne un mot à faire deviner à ".$_SESSION['joueur2']."<p>";
        ?>

        <form action="" method="POST">
            <label for="mot"> Mot </label>
            <input type="text" id="mot" name="mot">

            <label for="nbCoup"> Nombre de coups possibles </label>
            <input type="number" id="nbCoup" name="nbCoup">

            <input type="submit" value="send">
        </form>

        <?php
            $_SESSION['mot']="";
            $_SESSION['nbLettre']=0;

            if(isset($_POST['mot']) && !empty($_POST['mot']) && 
            isset($_POST['nbCoup']) && !empty($_POST['nbCoup']) && 
            is_numeric($_POST['nbCoup'])){
        //--------------------------------------------
                $servername = 'sql928.main-hosting.eu';
                $username = 'u578660070_open';
                $password = 'Admin123/';

                //On essaie de se connecter
                try{
                    $conn = new PDO("mysql:host=$servername;dbname=u578660070_open", $username, $password);
                    //On définit le mode d'erreur de PDO sur Exception
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $mot = mb_strtolower($_POST['mot'], 'UTF-8');
                    // préparer et exécuter la requête SQL
                    $sql = "SELECT * FROM lexique WHERE ortho = :mot";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute(array(':mot' => $mot));

                    // récupérer les résultats de la requête
                    $resultat = $stmt->fetchAll();

                    // vérifier si le mot est présent dans la table
                    if (count($resultat) > 0) {
                        $_SESSION['nbCoup'] = abs($_POST['nbCoup']);
                        $_SESSION['actualisation']=0;
                        $_SESSION['nbCoupEsseye']=0;
                        $_SESSION['listeLettre']=array("");
                        $_SESSION['mot'] = formatMot($_POST['mot']);
                        $_SESSION['jeu'] = creationJeu($_POST['mot']);
                        header('Location:jeu.php');
                        exit(0);
                        
                    } else {
                        echo "Le mot n'existe pas dans le dictionnaire";
                    }
                }

                /*On capture les exceptions si une exception est lancée et on affiche
                *les informations */
                catch(PDOException $e){
                echo "Erreur : " . $e->getMessage();
                }

        //--------------------------------------------


                
            }
            else{
                echo "<p> Saisir un mot et un nombre de coups corrects<p>";
            }

            function formatMot($mot){
                $array = mb_str_split(mb_strtoupper($mot), 1, 'UTF-8');
                return $array;
            } 

            function creationJeu($mot) {
                $resultat = array();
                foreach (mb_str_split($mot, 1, 'UTF-8') as $lettre) {
                    if ($lettre == "-") {
                        $resultat[] = "-";
                    } 
                    elseif ($lettre == "'"){
                        $resultat[] = "'";
                    }
                    elseif (ctype_alpha($lettre) || preg_match('/[^\x00-\x7F]/u', $lettre)) {
                        $resultat[] = "_";
                    }
                    elseif ($lettre==" ") {
                        $resultat[] = " ";
                    }
                }
                return $resultat;
            }
        ?>
    </body>
</html>