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
		<div class="col-sm-offset-1 col-sm-11 text-center hidden-xs">
				<ul class="nav nav-pills">
					<?php
					foreach ($tag as $tagInfo)
					{
						$src = "Challenge/index/".rawurlencode($tagInfo["name"]);
						echo "<li role='presentation' class=''><a href='".site_url($src)."'>".$tagInfo["name"]."<span class='badge'>".$tagInfo["numChallenges"]."</span></a></li>";  
					}
					?>
				</ul>
		</div>
	</div>
	<div class="row hidden-xs">
		&nbsp;
	</div>
	<div class="row">
	<div class="col-xs-offset-2 col-xs-8 col-sm-offset-1 col-sm-10 vcenter">
		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<?php
				$i = 0;
				for($i = 0; $i<$numChallenges; ++$i)
				{
					if ($i != 0)
					{
						echo "<li data-target='#carousel-example-generic' data-slide-to='".$i."'></li>"; 
					}else
					{
						echo "<li data-target='#carousel-example-generic' data-slide-to='0' class='active'></li>";
					}
				}
				?>
			</ol>

			<!-- Wrapper for slides -->
			<div class="carousel-inner" role="listbox">
				<?php
				$i = 0;
				foreach ($challenges->result() as $challenge)
				{
					if ($i != 0)
					{
						echo "<div class='item'>";
					}
					else
					{
						echo "<div class='item active'>";
						$i = $i+1;
					}
					echo "<div class='jumbotron'>";
						//echo "<div class='panel-body'>";
							echo "<div class='row'>";
								echo "<div class='col-sm-7'>";
									echo "<h4 class='visible-xs-inline text-right text-uppercase'>".$challenge->title."</h4>";
									echo "<h1 class='hidden-xs text-right text-uppercase'>".$challenge->title."</h1>";
									echo "<div class='row visible-xs-inline'></div>";
									echo "<div class='row'>";
										echo "<div class='col-xs-4 col-sm-offset-6 col-sm-2 text-right'>";
										if (!$inProgress[$challenge->challengeID])
										{
											$acceptSrc = "Challenge/accept/".$challenge->challengeID;
											echo "<a href='".site_url($acceptSrc)."' class='hidden-xs btn btn-default' role='button'>Aceptar Reto</a>";
											echo "<a href='".site_url($acceptSrc)."' class='visible-xs-inline btn btn-default small' role='button'>Aceptar Reto</a>";
											
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
										echo "</div>";
										echo "<div class='col-xs-1 col-sm-1'></div>";
										echo "<div class='col-xs-4 col-sm-2 text-left'>";
										echo "<a href='".site_url("Challenge/more/".$challenge->challengeID)."' class='hidden-xs btn btn-info' role='button'>Más Info</a>";
										echo "<a href='".site_url("Challenge/more/".$challenge->challengeID)."' class='visible-xs-inline btn btn-info small' role='button'>Más Info</a>";
										echo "</div>";
									echo "</div>";
								echo "</div>";
								echo "<div class='col-xs-1 col-sm-1'></div>";
								echo "<div class='row visible-xs-inline'>&nbsp;</div>";
								echo "<div class='hidden-xs col-sm-4'>";
									echo "<div class='row'>";
										if ($challenge->duration != 0)
										{
											echo "<strong>Duración:</strong> ". $challenge->duration. " días";
										}
										else
										{	
											echo "<strong>Duración:</strong> NA";
										}
									echo "</div>";
									echo "<div class='row'>";
										echo "<strong>Dificultad:</strong> ". $challenge->difficulty;
									echo "</div>";
									echo "<div class='row'>&nbsp;</div>";
									echo "<div class='row'>";
										foreach( $challengesTags[$challenge->challengeID]->result() as $challengeTag)
										{
											$src = "Challenge/index/".$challengeTag->name;
											$siteSrc = site_url($src);
											$img = base_url('images')."/".$challengeTag->img;
											echo "<a href='".$siteSrc."'><img src='".$img."' height='45px' width='45px' alt='".$challengeTag->name."' class='img-circle'></a>&nbsp;";
										}
									echo "</div>";
								echo "</div>";
							echo "</div>";
						//echo "</div>";
					echo "</div>";
				echo "</div>";
					
				}
				if ($i == 0)
				{
				?>
				<div class="item active">
					<div class="jumbotron">
						<div class="row">
							<div class='col-sm-offset-2 col-sm-8'>
								<h1 class='hidden-xs text-right text-uppercase'>No tienes retos activos</h1>
								<h4 class='visible-xs-inline text-right text-uppercase'>No tienes retos activos</h4>
							</div>
						</div>
						<div class='row visible-xs-inline'>&nbsp;</div>
						<div class="row">
							<div class='col-sm-offset-2 col-sm-8 text-center'>
								<a href='<?php echo site_url('Challenge')?>' class='btn btn-info' role='button'>Empieza uno ahora!</a>
							</div>
						</div>
					</div>
				</div>
				<?php	
				}
				?>
			</div>
			<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			 </a>
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