<!DOCTYPE html>
<html lang="<?php echo $language; ?>">
	<head>
		<meta charset="UTF-8">
		<title>Le Jeu du Pendu - Liste des parties</title>
	</head>
	<body>
		<p>Le Jeu du Pendu</p>
		<a href="./new-partie.php">Nouvelle partie</a><br>

		<?php
			if(session_status() == PHP_SESSION_ACTIVE){
				session_destroy();
			}
			$servername = 'sql928.main-hosting.eu';
			$username = 'u578660070_open';
			$password = 'Admin123/';

			//On essaie de se connecter
			try{
				$conn = new PDO("mysql:host=$servername;dbname=u578660070_open", $username, $password);
				//On définit le mode d'erreur de PDO sur Exception
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "SELECT * FROM PARTIES_PENDU";
				$stmt = $conn->query($sql);

				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					echo "<div class=parties>";
					echo "<p>Partie n° : ".$row['ID_PARTIE']." ";
					echo ($row['VICTOIRE']==true)?"gagnée":"perdu";
					echo "<br>";
					echo "Joueur 1 : ".$row['JOUEUR_1'] . "<br>";
					echo "Joueur 2 : " . $row['JOUEUR_2'] . "<br>";
					echo "Nombre d'erreur(s) : " . $row['NB_COUP'] . "<br>";
					echo "Mot mystère : " . $row['MOT_MYSTERE'] . "<br></p>" ;
					echo "</div>";
				}
			}

			/*On capture les exceptions si une exception est lancée et on affiche
			*les informations relatives à celle-ci*/
			catch(PDOException $e){
			echo "Erreur : " . $e->getMessage();
			}
			$conn = null;
		?>
	</body>
</html>