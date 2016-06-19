<?php 
	// Author: Aurele Zannou http://inkauz.com/
	//Evite de renvoyer le formulaire lorsquon actualise apres une soumission
	session_start();
	if(!empty($_POST)){
	    $_SESSION['save'] = $_POST ;
	     
	    $currentFile = $_SERVER['PHP_SELF'] ;
	    if(!empty($_SERVER['QUERY_STRING']))
	        $currentFile .= '?' . $_SERVER['QUERY_STRING'] ;
	     
	    header('Location: ' . $currentFile);
	    exit;
	}
	if(isset($_SESSION['save'])){
	    $_POST = $_SESSION['save'];
	    unset($_SESSION['save']);
	}
	if(!empty($_POST['submit']) && !empty($_POST['entree']) && !empty($_POST['sortie']) && !empty($_POST['pause'])) {
		$e = $_POST['entree'];
		$s = $_POST['sortie'];
		$entree =  strtotime($e);
		$sortie = strtotime($s);
		$pause = $_POST['pause']; //ici pas de strtotime car on a deja le temps en seconde et la fonction strtotime converti le temps en seconde
		$ht = gmdate('H:i',$sortie - $entree-$pause); //gmdate comme date recoit le temps en seconde. ex: 1800 pour 30min
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Hours</title>
	<link href='http://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
	<style>
		body{
			background: #4c4646;
			color: #ffffff;
			font-family: 'Poiret One', cursive;
		}
		.hour{
			margin: 0 auto;
			margin-top: 50px;
			width: 400px;
			background: #dc5757;
			border-radius: 4px;
			box-shadow: 0px 0px 8px #2C2A2A;
			font-size: 24px;
		}
		.hour .form{
			padding: 30px;
		}
		.hour .reponse{
			margin-top: 20px;
			background: #DD8989;
			padding: 30px;
			border-radius: 2px;
		}
		h1,h2{
			margin: 0 auto;
			font-size: 28px;
			font-weight: normal;
		}
		form input,
		form select{
			width: 100px;
			height: 30px;
			border: none;
			border-radius: 2px;
			padding-left: 5px;
			font-size: 18px;
			color: #4c4646;
		}
		form label{
			display: block;
			margin-top: 5px;
		}
		form .submit{
			cursor: pointer;
		}
		form .submit:hover{
			background: #4c4646;
			color: #ffffff;
		}
        .transit{
            transition: all 0.2s ease-out;
            -webkit-transition: all 0.2s ease-out;
            -moz-transition: all 0.2s ease-out;
            -o-transition: all 0.2s ease-out;
        }
	</style>
</head>
<body>
	<div class="hour">
		<div class="form">
			<h2>Calcul ton temps passé au boulot moins ta pause</h2>
			<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
				<label for="entree">Heure d'entrée:</label>
				<input type="time" id="entree" name="entree" required/>
				<label for="sortie">Heure de sortie:</label>
				<input type="time" id="sortie" name="sortie" required/>
				<label for="pause">Pause:</label>
				<select name="pause" id="pause">
					<option value="1800">30 min</option> <!--On aurait pu faire value="00:30" mais 00:30 equivaut a 24h30  -->
					<option value="2700">45 min</option>
					<option value="3600">1 hr</option>
				</select>
				<input type="submit" class="submit transit" name="submit" id="submit" value=" Calcul "/> 
			</form>
		</div>
		<?php 
			if(isset($ht)){
				$p = $pause/60;
				echo "<div class=reponse>Entrée à: <span>{$e}</span> </br> pause de: <span>{$p} min</span> </br> Sortie à: <span>{$s}</span> </br> Nombre d'Heures: <span>{$ht}</span></div>";
			} 
		?>
	</div>
</body>
</html>