<!DOCTYPE html>
<html lang="<?php echo $language; ?>">
    <head>
        <meta charset="UTF-8">
        <title>Le Pendu</title>
    </head>
    <body>
        <p>Le Jeu<p>
        <form action="" method="POST">
            <label for="lettre"> Lettre </label>
            <input type="text" id="lettre" name="lettre" maxlength="1" autofocus="autofocus">

            <input type="submit" value="send">
        </form>
        <?php
            //Démarre la session.
            require('header.php');

            echo "<p> Nombre de coup restant : ".($_SESSION['nbCoupEsseye'])."/".$_SESSION['nbCoup']."</p>";
            if (isset($_POST['lettre']) && !empty($_POST['lettre'])) {
                testLettre(majusculeSansAccents($_POST['lettre']));
            }
            afficheJeu();
            afficheLettreTest();
            afficheImg();
            verifGagne();
            
            
//Les fonctions : - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -           
            function majusculeSansAccents($str) {
                $str = mb_strtoupper($str, 'UTF-8'); // Convertir en majuscules
                $str = str_replace(
                    array('À','Â','Ä','Ç','È','É','Ê','Ë','Î','Ï','Ô','Ö','Ù','Û','Ü'),
                    array('A','A','A','C','E','E','E','E','I','I','O','O','U','U','U'),
                    $str
                ); // Supprimer les accents
                return $str;
            }

            function afficheJeu(){
                echo "<p>";
                for ($i=0; $i<count($_SESSION['jeu']); $i++){
                    if($_SESSION['jeu'][$i] == " "){
                        echo "&emsp;";
                    }
                    else{
                        echo " ".$_SESSION['jeu'][$i];
                    }
                }
                echo "</p>";
            }

            function testLettre ($lettre){
                $succes=0;
                for($i=0; $i<count($_SESSION['jeu']); $i++){
                    if (majusculeSansAccents($_SESSION['mot'][$i])==$lettre){
                        $_SESSION['jeu'][$i]=mb_strtoupper($_SESSION['mot'][$i]);
                        $succes+=1;
                    }
                }
                if ($succes < 1) {
                    $_SESSION['nbCoupEsseye'] += 1;
                }
            }

            function verifGagne (){
                if ($_SESSION['nbCoupEsseye']>=$_SESSION['nbCoup']){
                    $_SESSION['gagne']=false;
                    header('Location:final.php');
                }
                if ($_SESSION['mot']==$_SESSION['jeu']){
                    $_SESSION['gagne']=true;
                header('Location:final.php');
                }
            }

            function afficheLettreTest (){
                if (isset($_POST['lettre'])){
                    if(!in_array(majusculeSansAccents($_POST['lettre']), $_SESSION['listeLettre'])){
                        $_SESSION['listeLettre'][]=majusculeSansAccents($_POST['lettre']);
                    }
                }
                echo "<p>";
                foreach ($_SESSION['listeLettre'] as $valeur){
                    echo $valeur." ";
                }
                echo "</p>";
            }

            function afficheImg (){
                $var = intdiv(8, $_SESSION['nbCoup']);
                $nImg = $var+$_SESSION['nbCoupEsseye'];
                if ($_SESSION['nbCoupEsseye']==0){
                    echo "<img src=./img/1.png>";
                }
                else{
                    echo "<img src=./img/$nImg.png>";
                }
            }
        ?>
    </body>
</html>