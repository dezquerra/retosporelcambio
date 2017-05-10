<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<title>
		<?php
			echo $username. " Ha terminado el reto ". $challenge->title;
		?>
	</title>
	<!-- This is for FB -->
	<meta property="og:type"               content="article" />
	<meta property="og:description"        content="Dale la enhorabuena! Su logro nos beneficia a todos. Se el siguiente en sumarte al cambio!" />
	<meta property="og:image"				content="<?php echo base_url("images/main/challenge.png")?>"/>
	<!-- -->
	<meta name="robots" content="noindex,nofollow">
</head>
<body>
	<div class="container-fluid">
		<div class='row'>
			<div class='col-sm-offset-2 col-sm-8'>
				<h2> Felicita a <?php echo $username?></h2>
				<?php echo $username?> Ha conseguido terminar el reto <a href='<?php site_url('Challenge/more/'.$challenge->challengeID)?>'><?php echo $challenge->title?></a>. Su esfuerzo nos beneficia a todos. Gracias por sumarte al cambio!
			</div>
			<div class='row'>
				<div class='col-sm-offset-2 col-sm-8 text-center'>
					<a href='<?php echo site_url("User/show/".$username)?>'> Echale un vistazo al perfil de <?php echo $username ?> </a>
				</div>
			</div>
			</div>
		</div>
	</div>
</body>
</html>