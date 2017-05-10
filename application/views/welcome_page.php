<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<title> Retos por el cambio </title>
	<meta name="description" content="Acepta retos por un mundo mejor y más sostenible!" />
	<meta name="keywords" content="Retos por el cambio, sostenibilidad, ecología, comunidad, medioambiente" />
	<meta name="robots" content="index,follow" />
</head>
<body>
	<div class="container-fluid">
		<div class="row">
		&nbsp;
		</div>
		<div class='row'>
			<div class=col-sm-offset-4 col-sm-6 text-center">
				<img src='<?php echo base_url('images/logo.png')?>'/>
			</div>
		</div>
		<div class='row'>
		&nbsp;
		</div>
		<div class="row">
			<div class='col-sm-offset-2 col-sm-4'>
				<!-- TODO: put real image urls here -->
				<a href='<?php echo site_url('Challenge')?>'>
				<div class='thumbnail text-center'>
					<div class="row">
					&nbsp;
					</div>
					<img width='120px' src="<?php echo base_url("images/main/challenge.png")?>" alt="Retos">
					<div class="caption">
						<h2 class="text-center">Retos</h2>
						<p>Acepta el desafío. Emprende retos que pueden llevar a un gran cambio con un pequeño esfuerzo. ¿Te atreves?</p><br/>
					</div>
				</div>
				</a>
			</div>
			<div class='col-sm-4'>
				<div class='thumbnail text-center'>
					<div class="row">
					&nbsp;
					</div>
					<div class='row'>
						<a href='<?php echo site_url('Bibliography')?>'>
						<div class="col-sm-6">
							<img width='120px' src="<?php echo base_url("images/main/book.png")?>" alt="Documentación">
						</div>
						</a>
						<a href='<?php echo site_url('Filmography')?>'>
						<div class="col-sm-6">
							<img width='120px' src="<?php echo base_url("images/main/video.png")?>" alt="Documentación">
						</div>
						</a>
					</div>
					<div class="caption">
						<h2 class="text-center">Documentos</h2>
						<p>¿Quieres hacer más y no sabes por dónde empezar? ¿Necesitas ayuda para poder superar los pequeños desafíos que te has impuesto? ¡Este es el lugar!</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>