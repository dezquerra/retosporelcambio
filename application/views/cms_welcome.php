<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta name="robots" content="noindex,nofollow" />
</head>
<body>

<?php
	//This is done in order to activate pills from controllers
	$defaultClass = "tab-pane fade";
	$activeClass = "tab-pane fade in active";
	$challengeDivClass = $tagDivClass = $bibliographyDivClass = $filmographyDivClass = $badgeDivClass = $topicDivClass = $thanksDivClass = $defaultClass;
	$challengeLiClass = $tagLiClass = $bibliographyLiClass = $filmographyLiClass = $badgeLiClass = $topicLiClass = $thanksLiClass = '';
	
	if ($active == '')
	{
		$challengeDivClass = $activeClass;
		$challengeLiClass = 'active';
	}
	elseif ($active == 'tag')
	{
		$tagDivClass = $activeClass;
		$tagLiClass = 'active';
	}
	elseif ($active == 'bibliography')
	{
		$bibliographyDivClass = $activeClass;
		$bibliographyLiClass = 'active';
	}
	elseif ($active == 'filmography')
	{
		$filmographyDivClass = $activeClass;
		$filmographyLiClass = 'active';
	}
	elseif ($active == 'badge')
	{
		$badgeDivClass = $activeClass;
		$badgeLiClass = 'active';
	}
	elseif ($active == 'topic')
	{
		$topicDivClass = $activeClass;
		$topicLiClass = 'active';
	}
	elseif ($active == "thanks")
	{
		$thanksDivClass = $activeClass;
		$thanksLiClass = 'active';
	}
?>

<div id="container">
	<h1>Página de administración</h1>

	<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="<?php echo $challengeLiClass?>"><a href="#addChallenge" aria-controls="addChallenge" role="tab" data-toggle="tab">Añadir Reto</a></li>
    <li role="presentation" class="<?php echo $tagLiClass?>"><a href="#addTag" aria-controls="addTag" role="tab" data-toggle="tab">Añadir Tag</a></li>
    <li role="presentation" class="<?php echo $bibliographyLiClass?>"><a href="#addBibliography" aria-controls="addBibliography" role="tab" data-toggle="tab">Añadir Bibliografía</a></li>
    <li role="presentation" class="<?php echo $filmographyLiClass?>"><a href="#addFilmography" aria-controls="addFilmography" role="tab" data-toggle="tab">Añadir Filmografía</a></li>
	<li role="presentation" class="<?php echo $badgeLiClass?>"><a href="#addBadge" aria-controls="addBadge" role="tab" data-toggle="tab">Añadir Logro</a></li>
    <li role="presentation" class="<?php echo $topicLiClass?>"><a href="#addTopic" aria-controls="addTopic" role="tab" data-toggle="tab">Añadir Topic</a></li>
    <li role="presentation" class="<?php echo $thanksLiClass?>"><a href="#addThanks" aria-controls="addThanks" role="tab" data-toggle="tab">Añadir Agradecimientos</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="<?php echo $challengeDivClass?>" id="addChallenge">
		<div class="row">
			<div class="col-sm-offset-2 col-sm-8">
				<form class="form-horitzontal" action="<?php echo site_url('Challenge/add')?>" method="POST">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="title">Título</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="title"><br/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="description">Descripción</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="description"></textarea><br/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="final_msg">Mensaje final</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="final_msg"></textarea><br/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="duration">Duración mínima</label>
						<div class="col-sm-10">
							<input class="form-control" type="text" name="duration"/><br/>
						</div>
					</div>
					<div class="form-group">
						<label class="radio-inline col-sm-2 control-label" for="dificullty">Dificultad</label>
						<div class="col-sm-10">
							<input type="radio" name="dificullty" value="1" checked>1</input>
							<input type="radio" name="dificullty" value="2">2</input>
							<input type="radio" name="dificullty" value="3">3</input>
							<input type="radio" name="dificullty" value="4">4</input>
							<input type="radio" name="dificullty" value="5">5</input><br/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="points">EcoPuntos</label>
						<div class="col-sm-10">
							<input class="form-control" type="text" name="points"/><br/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="tags">Tags</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="tags"></textarea><br/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="topics">Topics</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="topics"></textarea><br/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="feedback"> Feedback
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="only"> Only once
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="continue" checked> Añadir Otro
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input class="btn btn-default" type="submit" value="Crear Reto"/>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
    <div role="tabpanel" class="<?php echo $tagDivClass?>" id="addTag">
		<!-- TODO: allow to upload files -->
		<div class="row">
			<div class="col-sm-offset-2 col-sm-8">
				<form class="form-horitzontal" action="<?php echo site_url('Tag/add')?>" method="POST">
				<div class="form-group">
					<label class="col-sm-2 control-label" for="name">Nombre del tag</label>
					<div class="col-sm-10">
						<input class="form-control" type="text" name="name"/><br/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="color">Color en hexadecimal</label>
					<div class="col-sm-10">
						<input class="form-control" type="text" name="color"/><br/>	
					</div>
				</div>
				<div class="form-group"> <!-- TODO: upload image file -->
					<label class="col-sm-2 control-label" for="image">Imagen</label>
					<div class="col-sm-10">
						<input class="form-control" type="text" name="image"/><br/>	
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="continue" checked> Añadir Otro
							</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<input class="btn btn-default" type="submit" value="Crear Tag"/>
					</div>
				</div>
			</form>
		</div>
		</div>
	</div>
    <div role="tabpanel" class="<?php echo $bibliographyDivClass?>" id="addBibliography">
		<div class="row">
			<div class="col-sm-offset-2 col-sm-8">
				<form class="form-horitzontal" action="<?php echo site_url('Bibliography/add')?>" method="POST">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="name">Nombre</label>
						<div class="col-sm-10">
							<input class="form-control" type="text" name="name"><br/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="pages">Páginas</label>
						<div class="col-sm-10">
							<input class="form-control" type="text" name="pages"/><br/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="author">Autor</label>
						<div class="col-sm-10">
							<input class="form-control" type="text" name="author"/><br/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="description">Descripción</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="description"></textarea><br/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="src">Fichero</label>
						<div class="col-sm-10">
							<input class="form-control" type="text" name="src"/><br/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="topic">Tema/s</label>
						<div class="col-sm-10">
							<input class="form-control" type="text" name="topic"/><br/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="tags">Tags</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="tags"></textarea><br/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="continue" checked> Añadir Otro
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input class="btn btn-default" type="submit" value="Añadir Bibliografía"/>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
    <div role="tabpanel" class="<?php echo $filmographyDivClass?>" id="addFilmography">
	<div class="row">
			<div class="col-sm-offset-2 col-sm-8">
				<form class="form-horitzontal" action="<?php echo site_url('Filmography/add')?>" method="POST">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="name">Nombre</label>
						<div class="col-sm-10">
							<input class="form-control" type="text" name="name"><br/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="duration">Duración</label>
						<div class="col-sm-10">
							<input class="form-control" type="text" name="duration"/><br/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="year">Año</label>
						<div class="col-sm-10">
							<input class="form-control" type="text" name="year"/><br/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="description">Descripción</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="description"></textarea><br/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="src">Fichero</label>
						<div class="col-sm-10">
							<input class="form-control" type="text" name="src"/><br/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="topic">Tema/s</label>
						<div class="col-sm-10">
							<input class="form-control" type="text" name="topic"/><br/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="tags">Tags</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="tags"></textarea><br/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="continue" checked> Añadir Otro
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input class="btn btn-default" type="submit" value="Añadir Bibliografía"/>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div role="tabpanel" class="<?php echo $badgeDivClass?>" id="addBadge">
		<!-- TODO: allow to upload files -->
		<div class="row">
			<div class="col-sm-offset-2 col-sm-8">
				<form class="form-horitzontal" action="<?php echo site_url('Badge/add')?>" method="POST">
				<div class="form-group">
					<label class="col-sm-2 control-label" for="name">Nombre del logro</label>
					<div class="col-sm-10">
						<input class="form-control" type="text" name="name"/><br/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="description">Descripción</label>
					<div class="col-sm-10">
						<input class="form-control" type="text" name="description"/><br/>	
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="maxlvl">Nivel máximo</label>
					<div class="col-sm-10">
						<input class="form-control" type="text" name="maxlvl"/><br/>
					</div>
				</div>
				<div class="form-group"> <!-- TODO: upload image file -->
					<label class="col-sm-2 control-label" for="src">Imagen</label>
					<div class="col-sm-10">
						<input class="form-control" type="text" name="src"/><br/>	
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="continue" checked> Añadir Otro
							</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<input class="btn btn-default" type="submit" value="Añadir Logro"/>
					</div>
				</div>
			</form>
		</div>
		</div>
	</div>
	<div role="tabpanel" class="<?php echo $topicDivClass?>" id="addTopic">
		<!-- TODO: allow to upload files -->
		<div class="row">
			<div class="col-sm-offset-2 col-sm-8">
				<form class="form-horitzontal" action="<?php echo site_url('Topic/add')?>" method="POST">
				<div class="form-group">
					<label class="col-sm-2 control-label" for="name">Nombre del tema</label>
					<div class="col-sm-10">
						<input class="form-control" type="text" name="name"/><br/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="color">Color en hexadecimal</label>
					<div class="col-sm-10">
						<input class="form-control" type="text" name="color"/><br/>	
					</div>
				</div>
				<div class="form-group"> <!-- TODO: upload image file -->
					<label class="col-sm-2 control-label" for="image">Imagen</label>
					<div class="col-sm-10">
						<input class="form-control" type="text" name="image"/><br/>	
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="continue" checked> Añadir Otro
							</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<input class="btn btn-default" type="submit" value="Crear Tema"/>
					</div>
				</div>
			</form>
		</div>
		</div>
	</div>
	<div role="tabpanel" class="<?php echo $thanksDivClass?>" id="addThanks">
		<div class="row">
			<div class="col-sm-offset-2 col-sm-8">
				<form class="form-horitzontal" action="<?php echo site_url('Cms/addThanks')?>" method="POST">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="name">Nombre</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="name"><br/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="reason">Motivo</label>
						<div class="col-sm-10">
							<textarea class="form-control" name="reason"></textarea><br/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<input class="btn btn-default" type="submit" value="Agradecer"/>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
  </div>

</div>
</body>
</html>