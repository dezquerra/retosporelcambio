<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<title> Usuario. Retos por el cambio </title>
	<meta name="robots" content="noindex,follow" />
	<!-- This is for FB -->
	<meta property="og:type"               content="article" />
	<meta property="og:title"              content="<?php echo $info->username?>. Retos por el Cambio" />
	<meta property="og:description"        content="Echale un vistazo al perfil de usuario de <?php echo $info->username?>" />
	<meta property="og:image"              content="<?php echo $info->avatar?>" />
</head>
<body>
	<!-- -->
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-2">
				<div class="thumbnail">
					<a data-toggle='modal' data-target='#avatarModal'><img id='avatarImg' src="<?php echo $info->avatar?>"></a>
					<div class="caption">
						<?php
						echo "<h3 class='text-center'>".$info->username."</h3>";
						echo "<dl>";
							echo "<dt> Miembro desde </dt><dd>".date('d/m/Y', strtotime($info->created))."</dd>";
							echo "<dt> Correo electrónico <dd id='mail'>???@???.???</dd>";
						?>
					</div>
				</div>
			</div>
			<div class="col-sm-10">
				<div class="row">
				<?php
				$i = 0;
				foreach ($badges->result() as $badge)
				{
						if (($i % 6) == 0)
						{
							echo "<div class='row'>";
							echo "<div class='col-sm-1'>&nbsp;</div>";
						}
						echo "<div class='col-sm-2'>";
							echo "<div class='thumbnail text-center'>";
								$imgsrc = $badge->img.$badge->lvl.".png";
								echo "<img src='".$imgsrc."' alt='".$badge->name."' class='img-circle'>";
								echo "<div class='caption'>";
									echo "<h3>".$badge->name." <br><small class='orangeT'>Nivel ".$badge->lvl."</small></h3>";
								echo "</div>";
							echo "</div>";
						echo "</div>";
						$i++;
						if (($i % 6) == 5)
						{
							$i++;
							echo "</div>";
						}
				}
				foreach ($unwonBadges->result() as $badge)
				{
						if (($i % 6) == 0)
						{
							echo "<div class='row'>";
							echo "<div class='col-sm-1'>&nbsp;</div>";
						}
						echo "<div class='col-sm-2'>";
							echo "<div class='thumbnail text-center'>";
								$imgsrc = $badge->img."0.png";
								echo "<img src='".$imgsrc."' alt='".$badge->name."' class='img-circle'>";
								echo "<div class='caption'>";
									echo "<h3>".$badge->name."<br><small class='orangeT'>Bloqueada</small></h3>";
								echo "</div>";
							echo "</div>";
						echo "</div>";
						$i++;
						if (($i % 6) == 5)
						{
							$i++;
							echo "</div>";
						}
				}
				?>
				</div>
				<div class="row">
				&nbsp;
				</div>				
				<div class="row">
					&nbsp;
				</div>
				<div class="row">
				<div class='col-sm-offset-2 col-sm-3 text-left'>
				<dl class='dl-horizontal'>
				<?php
					$src = 'Challenge/active/'.$info->userID;
					echo "<dt> Retos activos </dt><dd>".$currentChallenges."</dd>";
					echo "<dt> Retos terminados </dt><dd>".$finishedChallenges."</dd>";
				?>
				</dl>
				</div>
				<div class='col-sm-3 text-left'>
				<dl class='dl-horizontal'>
				<?php
					echo "<dt> Retos únicos </dt><dd>".$finishedDistinctChallenges."</dd>";
					echo "<dt> Logros conseguidos </dt><dd>".$numberOfBadges." (".$badgesAchieved."%)</dd>";
				?>
				</dl>
				</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>