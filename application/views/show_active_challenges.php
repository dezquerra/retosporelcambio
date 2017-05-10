<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<title> Retos. Retos por el cambio </title>
	<meta name="description" content="Acepta un reto y empieza a cambiar tus rutinas para hacerlas sostenibles." />
	<meta name="keywords" content="Retos por el cambio, retos, rutinas, sostenibilidad, ecología, medioambiente" />
	<meta name="robots" content="index,follow" />
</head>
<body>
<div class="container-fluid">
	<div class="row">
	<div class="col-xs-offset-2 col-xs-8 col-sm-offset-1 col-sm-10 vcenter">
				<?php
				$i = 0;
				foreach ($challenges->result() as $challenge)
				{
					if ($i == 0)
					{
						echo "<div class='row'>";
					}
					if ($i > 0 && $i%3 == 0)
					{
						echo "<div class='row'>&nbsp</div>";
						echo "<div class='row'>";
					}
					echo "<div class='text-center col-sm-4'>";
						echo "<div class='row'>";
							echo "<div class='col-sm-offset-1 col-sm-10'>";
							echo "<h3>".$challenge->title."</h3>";
							foreach( $challengesTags[$challenge->challengeID]->result() as $challengeTag)
							{
								$src = "Challenge/index/".$challengeTag->name;
								$siteSrc = site_url($src);
								$img = base_url('images')."/".$challengeTag->img;
								echo "<a href='".$siteSrc."'><img src='".$img."' height='45px' width='45px' alt='".$challengeTag->name."' class='img-circle'></a>&nbsp;";
							}
							echo "</div>";
						echo "</div>";
						echo "<div class='row'>&nbsp;</div>";
						echo "<div class='row'>";
							echo "<div class='col-sm-offset-2 col-xs-offset-1 col-xs-4 col-sm-4 text-right'>";
							if($challenge->duration != 0)
							{
								echo "<a href='#' class='hidden-xs btn btn-default disabled' role='button'>En marcha <span class='badge'>".$completed[$challenge->challengeID]."%</span></a>";
								echo "<a href='#' class='visible-xs-inline btn btn-default disabled' role='button'>".$completed[$challenge->challengeID]."% Completado</a>";
							}
							else
							{
								$finishSrc = "Challenge/finish/".$challenge->challengeID;
								echo "<a href='".site_url($finishSrc)."' class='btn btn-default' role='button'>Terminar Reto</a>";
							}
							echo "</div>";
							echo "<div class='col-xs-1 col-sm-1'>&nbsp;</div>";
							echo "<div class='col-xs-4 col-sm-4 text-left'>";
							echo "<a href='".site_url("Challenge/more/".$challenge->challengeID)."' class='hidden-xs btn btn-info' role='button'>Más Info</a>";
							echo "<a href='".site_url("Challenge/more/".$challenge->challengeID)."' class='visible-xs-inline btn btn-info small' role='button'>Más Info</a>";
							echo "</div>";
						echo "</div>";
					echo "</div>";
					if ($i%3 == 2 && $i > 0)
					{
						echo "</div>";
					}
					$i++;
				}
				if($i%3 != 0)
				{
					echo "</div>";
				}
				echo "<div class='row'>&nbsp;</div>";
				?>
		</div>
		</div>
	</div>
	<div class="row">
		<div class='col-xs-6 col-sm-offset-2 col-sm-4 text-center'>
		<?php
			if (isset($userID))
			{
				if (!isset($activeFlag))
				{
					$activeSrc = 'Challenge/active/'.$userID;
					echo "<a href='".site_url($activeSrc)."'>Ver los retos activos </a>";					
				}
				else
				{
					echo "<a href='".site_url('Challenge')."'>Ver todos los retos </a>";
				}
			}
			else
			{
				$registerSrc = site_url("User/register");
				$loginSrc = site_url("User/login");
				echo "<a href='".$registerSrc."'>Acepta tu primer reto</a> o <a href='".$loginSrc."'>logueate!</a>";
			}
			?>
		</div>
		<div class='col-xs-6 col-sm-4'>
		<a href='<?php echo site_url('Challenge/challengesList') ?>'>
		Ver todos los retos como lista
		</s>
		</div>
	</div>
</div>

</body>
</html>