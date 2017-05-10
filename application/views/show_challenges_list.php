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
		<div class="hidden-xs col-sm-12 text-center">
				<ul class="nav nav-pills">
					<?php
					foreach ($tag as $tagInfo)
					{
						$src = "Challenge/challengesList/".rawurlencode($tagInfo["name"]);
						echo "<li role='presentation' class='text-uppercase'><a href='".site_url($src)."'>".$tagInfo["name"]."<span class='badge'>".$tagInfo["numChallenges"]."</span></a></li>";  
					}
					?>
				</ul>
		</div>
	</div>
	<div class="row">
		&nbsp;
	</div>
	<div class='row'>
		&nbsp;
	</div>
	<div class="row">
		<div class='col-xs-6 col-sm-offset-2 col-sm-4 text-center'>
		<?php
			if (isset($userID))
			{
				$activeSrc = 'Challenge/active/'.$userID;
				echo "<a href='".site_url($activeSrc)."'>Ver los retos activos </a>";
			}
			else
			{
				$registerSrc = site_url("User/register");
				$loginSrc = site_url("User/login");
				echo "<a href=''>Acepta tu primer reto</a> o <a href=''>logueate!</a>";
			}
			?>
		</div>
		<div class='col-xs-6 col-sm-4'>
		<a href='<?php echo site_url('Challenge') ?>'>
		Ver los retos como carrusel
		</s>
		</div>
	</div>
	<div class="row">
		&nbsp;
	</div>
	<div class='row'>
		&nbsp;
	</div>
	<div class="row">
	<div class="col-sm-offset-2 col-sm-8">
		<dl class='dl-horizontal'>
		<?php
				foreach ($challenges->result() as $challenge)
				{
					$moreInfoSrc = "Challenge/more/".$challenge->challengeID;
					echo "<a href='".site_url($moreInfoSrc)."'>";

						echo "<dt style='text-align:left; width:250px'>".$challenge->title."</dt><dd class='text-right'>";
						foreach( $challengesTags[$challenge->challengeID]->result() as $challengeTag)
						{
							$src = "Challenge/challengesList/".$challengeTag->name;
							$siteSrc = site_url($src);
							$img = base_url('images')."/".$challengeTag->img;
							echo "<a href='".$siteSrc."'><img width='45px' src='".$img."' alt='".$challengeTag->name."' class=' img-resposive img-circle'></a>&nbsp;";
						}
						if (!$inProgress[$challenge->challengeID])
						{
							$acceptSrc = "Challenge/accept/".$challenge->challengeID;
							echo "<a href='".site_url($acceptSrc)."' class='btn btn-default' role='button'>Aceptar Reto</a>";
							
						}
						else
						{
							if($challenge->duration != 0)
							{
								echo "<a href='#' class='btn btn-default disabled' role='button'>En marcha <span class='badge'>".$completed[$challenge->challengeID]."%</span></a>";
							}
							else
							{
								$finishSrc = "Challenge/finish/".$challenge->challengeID;
								echo "<a href='".site_url($finishSrc)."' class='btn btn-default' role='button'>Terminar Reto</a>";
							}
						}
					echo "</dd></a><br/>";
				}
		?>
		</dl>
	</div>
	</div>
</div>

</body>
</html>