<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<title>
		<?php
			echo $username. "ha conseguido la medalla ". $badge->name;
		?>
	</title>
	<!-- This is for FB -->
	<meta property="og:url"					content="<?php echo site_url("User/show/".$username) ?>" />
	<meta property="og:type"               content="article" />
	<meta property="og:description"        content="Felicitale! Esta medalla es una recompensa a su compromiso social y ecológico!" />
	<?php
		$img = $badge->img.$badge->lvl.".png";
	?>
	<meta property="og:image"				content="<?php $img ?>"/>
	<!-- -->
	<meta name="robots" content="noindex,nofollow">
</head>
<body>
	<div class="container-fluid">
		<div class='row'>
			<div class='col-sm-offset-2 col-sm-8'>
				<h2> Felicita a <?php echo $username?></h2>
				<?php echo $username?> Ha conseguido la medalla <?php echo $badge->name ?> a nivel <?php echo $badge->lvl ?>. Este es un reconocimiento a su continuo esfuerzo y a su compromiso sostenible.
			</div>
		</div>
	</div>
</body>
</html>