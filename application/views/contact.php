<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<title> Contacto. Retos por el cambio </title>
	<meta name="description" content="Contacta con retos por el cambio" />
	<meta name="keywords" content="Retos por el cambio, opinión, ayuda, colaboración, contacta" />
	<meta name="robots" content="index,follow" />
</head>
<body>
	<div class="container-fluid">
		<?php
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
			<div class="col-sm-offset-1 col-sm-10">
					<h1>Contacta con Retos por el Cambio</h1>
			</div>
		</div>
		<div class='row'>
			&nbsp;
		</div>
		<div class="col-sm-offset-2 col-sm-8">
		<form class="form-horitzontal" action="<?php echo site_url('Frontend/contact')?>" method="POST">
			<div class="form-group">
				<label class="col-sm-2 control-label" for="name">Nombre</label>
				<div class="col-sm-10">
					<input class="form-control" type="text" name="name"/><br/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="mail">Mail de contacto</label>
				<div class="col-sm-10">
					<input class="form-control" type="text" name="mail"/><br/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="message">Mensaje</label>
				<div class="col-sm-10">
					<textarea class='form-control' placeholder='Escribe lo que quieras contarnos' name='message'></textarea><br/>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-default">Enviar mensaje</button>
				</div>
			</div>
		</form>
		</div>
	</div>
</body>
</html>