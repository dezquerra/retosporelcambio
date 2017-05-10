<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<title> <?php echo $challenge->title ?> </title>
	<?php
		$description = "Empieza el cambio, acepta el reto ".$challenge->title;
	?>
	<meta name="description" content="<?php echo $description?> " />
	<meta name="keywords" content="Retos por el cambio, retos, rutinas, sostenibilidad, ecología, medioambiente, aceptar" />
	<meta name="robots" content="index,follow" />
<!-- Facebook content -->
	<?php
		$fbURL = "Challenge/more/".$challenge->challengeID;
	?>
	<meta property="og:url"                content="<?php echo site_url($fbURL)?>" />
	<meta property="og:type"               content="article" />
	<meta property="og:title"              content="He aceptado el reto <?php echo $challenge->title ?>". />
	<meta property="og:description"        content="Te animas a hacer lo mismo?" />
	<meta property="og:image"				content="<?php echo base_url("images/facebook_p.png")?>"/>
<!-- End of facebook content -->
</head>
<body>
<script>
	function manageDownload(sendTo, linkLocation, id)
	{
		$.ajax({ url: sendTo, data:{ 'id': id} });
		window.open(linkLocation, '_blank');
	}
</script>
<?php
	//Default vars
	$MAX_INFO_PER_PAGE = 3;
	//Print Lateral Buttons for challenges
	$buttons = "<div class='col-xs-3 col-sm-4 text-center'>";
	if (isset($inProgress) && $inProgress)
	{
		if (!isset($userFinished))
		{
			if ($progress > 50)
			{
				$buttons .= "<br/><p> Ya casi lo tienes, llevas ".$lapsed." días.<br/>";
			}
			else
			{
				$buttons .= "<br/><p> Ya aceptaste este reto, llevas ".$lapsed." días.<br/>";
			}
			$buttons .= "<div class='progress'>";
			$buttons .= "<div class='progress-bar' role='progressbar' aria-valuenow='".$progress."' aria-valuemin='0' aria-valuemax='100' style='min-width: 2em; width: ".$progress."%;'>";
			$buttons .= $progress."%";
			$buttons .=	"</div>";
			$buttons .= "</div>";
			if ($progress > 50)
			{
				$buttons .= "Tan sólo te quedan ".$remaining." días. Ánimo!</p><br/>"; 
			}
			else
			{
				$buttons .= "Todavía te quedan ".$remaining." días. Ánimo!</p><br/>"; 
			}			
		}
		else
		{
			$finishSrc = "Challenge/finish/".$challenge->challengeID;
			$buttons .= "<br/><a href='".site_url($finishSrc)."' class='btn btn-success' role='button'>Terminar Reto</a><br/><br/><br/>";
		}
	}
	else
	{
		$acceptSrc = "Challenge/accept/".$challenge->challengeID;
		$buttons .= "<br class='hidden-xs'/><a href='".site_url($acceptSrc)."' class='btn btn-default hidden-xs' role='button'>Aceptar Reto</a><br class='hidden-xs'/><br class='hidden-xs'/><br class='hidden-xs'/>";
		$buttons .= "<br class='visible-xs-inline'/><a href='".site_url($acceptSrc)."' class='btn btn-default visible-xs-inline' role='button'>Aceptar</a><br class='visible-xs-inline'/><br class='visible-xs-inline'/><br class='visible-xs-inline'/>";
	}
	$buttons .= "<a href='".site_url("Challenge")."' class='btn btn-info' role='button'>Volver</a>";
	$buttons .= "</div>";
?>
<div id="container-fluid">
<?php
	if (isset($error))
	{
?>
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<?php echo $error; ?>
		</div>		
<?php
	}
	if (isset($mssg))	
	{
?>
		<div class="alert alert-success alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<?php echo $mssg; ?>
		</div>
<?php
	}
?>
	<div class="row">
		<div class="col-xs-offset-1 col-xs-10 col-sm-offset-1 col-sm-10">
			<h1 class='text-uppercase'> <?php echo $challenge->title?> </h1>
		</div>
	</div>
	<div class="row">
	&nbsp;
	</div>
	<div class="col-xs-12 col-sm-offset-1 col-sm-10">
		<div id="navbar-example">
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active small visible-xs-inline"><a href="#info" aria-controls="info" role="tab" data-toggle="tab">Descripción</a></li>
				<li role="presentation" class="active hidden-xs"><a href="#info" aria-controls="info" role="tab" data-toggle="tab">Descripción</a></li>
				
				<li role="presentation" class='visible-xs-inline small'><a href="#books" aria-controls="books" role="tab" data-toggle="tab">Libros</a></li>
				<li role="presentation" class='hidden-xs'><a href="#books" aria-controls="books" role="tab" data-toggle="tab">Libros Relacionados</a></li>
				
				<li role="presentation" class='visible-xs-inline small'><a href="#films" aria-controls="films" role="tab" data-toggle="tab">Videos</a></li>
				<li role="presentation" class='hidden-xs'><a href="#films" aria-controls="films" role="tab" data-toggle="tab">Videos Relacionados</a></li>
				
				<li role="presentation" class='visible-xs-inline small'><a href="#opinions" aria-controls="opinions" role="tab" data-toggle="tab">Opiniones</a></li>
				<li role="presentation" class='hidden-xs'><a href="#opinions" aria-controls="opinions" role="tab" data-toggle="tab">Opiniones de otros usuarios</a></li>
			</ul>
		</div>
		<div class="row">
		&nbsp;
		</div>
		<div class="row">
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="info">
					<?php
					echo "<div class='row'>";
						echo "<div class='col-xs-offset-1 col-xs-8 col-sm-offset-1 col-sm-7'>";
							echo "<dl class='dl-horizontal'>";
							echo "<dt>Descripción: </dt><dd class='text-justify'>".$challenge->description."</dd>";
							echo "</dl>";
							echo "<div class='row'>";
								echo "<div class='col-sm-5'>";
									echo "<dl class='dl-horizontal'>";
										if ($challenge->duration != 0)
										{
											echo "<dt>Duración: </dt><dd>".$challenge->duration." días </dd>";
										}
										else
										{
											echo "<dt>Duración: </dt><dd> Terminar manualmente </dd>";
										}
										echo "<dt>Dificultad: </dt><dd>".$challenge->difficulty."</dd>";
									echo "</dl>";
								echo "</div>";
								echo "<div class='col-sm-7'>";
									echo "<dl class='dl-horizontal'>";
									echo "<dt>Eco-puntos: </dt><dd>".$challenge->points."</dd>";
									echo "<dt style='margin-top:10px'>Tags: </dt><dd>";
									foreach( $tags->result() as $tag)
									{
										$src = "Challenge/index/".$tag->name;
										$siteSrc = site_url($src);
										$img = base_url('images')."/".$tag->img;
										echo "<a href='".$siteSrc."'><img width='45px' height='45px' src='".$img."' alt='".$tag->name."' class=' img-resposive img-circle'></a>&nbsp;";
									}
									echo "</dd>";
									echo "</dl>";
								echo "</div>";
							echo "</div>";
						echo "</div>";
						echo $buttons;
					echo "</div>";
					?>
				</div>
				<div role="tabpanel" class="tab-pane" id="books">
					<?php
					echo "<div class='row'>";
						echo "<div class='col-xs-offset-1 col-xs-8 col-sm-offset-1 col-sm-7'>";
							if ($availableBibliography)
							{
								foreach ($bibliography->result() as $book)
								{
									echo "<div class='panel panel-default'>";
										echo "<div class='panel-heading'>";
											echo $book->name;
										echo "</div>";
										echo "<div class='panel-body'>";
											echo "<div class='row'>";
												echo "<div class='col-sm-6'>";
														echo "<dl class='dl-horizontal'>";
															echo "<dt>Autor:</dt>";
															echo "<dd>".$book->author."</dd>";
															echo "<dt>Páginas:</dt>";
															echo "<dd>".$book->pages."</dd>";
														echo "</dl>";
												echo "</div>";
												echo "<div class='col-sm-1'></div>";
												echo "<div class='col-sm-4 text-center'>";
													$id = $book->bibliographyID;
													$sendTo = site_url('Ajax/addBookDownload');
													echo "<a onclick='manageDownload(\"".$sendTo."\",\"".$book->location."\",\"".$id."\")' class='btn btn-info'>Descargar</a>";
												echo "</div>";
											echo "</div>";
										echo "</div>";
									echo "</div>";
								}
							}
							else
							{
								//TODO: contact with us
								echo "<br/><p class='text-justify'>No hay bibliografía relacionada. ¿Alguna idea? Ponte en contacto con nosotros</p>";
							}
						echo "</div>";
						echo $buttons;
					echo "</div>";
					?>
				</div>
				<div role="tabpanel" class="tab-pane" id="films">
				<?php
					echo "<div class='row'>";
						echo "<div class='col-xs-offset-1 col-xs-8 col-sm-offset-1 col-sm-7'>";
							if ($availableFilmography)
							{
								foreach ($filmography->result() as $film)
								{
									echo "<div class='panel panel-default'>";
										echo "<div class='panel-heading'>";
											echo $film->name;
										echo "</div>";
										echo "<div class='panel-body'>";
											echo "<div class='row'>";
												echo "<div class='col-sm-6'>";
														echo "<dl class='dl-horizontal'>";
															echo "<dt>Año:</dt>";
															echo "<dd>".$film->year."</dd>";
															echo "<dt>Duración:</dt>";
															echo "<dd>".$film->duration." minutos</dd>";
														echo "</dl>";
												echo "</div>";
												echo "<div class='col-sm-1'></div>";
												echo "<div class='col-sm-4 text-center'>";
													$id = $film->filmographyID;
													$sendTo = site_url('Ajax/addFilmDownload');
													echo "<a onclick='manageDownload(\"".$sendTo."\",\"".$film->location."\",\"".$id."\")' class='btn btn-info'>Descargar</a>";
												echo "</div>";
											echo "</div>";
										echo "</div>";
									echo "</div>";
								}
							}
							else
							{
								//TODO: contact with us
								echo "<br/><p class='text-justify'>No hay vídeos relacionados. ¿Alguna idea? Ponte en contacto con nosotros</p>";
							}
						echo "</div>";
						echo $buttons;
					echo "</div>";
					?>
				</div>
				<div role="tabpanel" class="tab-pane" id="opinions">
					<?php
					echo "<div class='row'>";
						echo "<div class='col-xs-offset-1 col-xs-8 col-sm-offset-1 col-sm-7'>";
							if ($availableOpinions)
							{
								echo "<dl class='dl-horizontal'>";
								foreach ($opinions->result() as $opinion)
								{
									echo "<dt>".$opinion->username."</dt>";
									echo "<dd>".$opinion->opinion."</dd>";
								}
								echo "</dl>";
							}
							else
							{
								echo "<br/><p class='text-justify'>Todavía no hay ningúna opinión sobre este reto. Sé el primero en dejar tu opinion!</p>";
							}
						echo "</div>";
						echo $buttons;
					echo "</div>";
					?>
				</div>
			  </div>
		</div>
	</div>
 </div>
</body>
</html>