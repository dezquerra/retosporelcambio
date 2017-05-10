<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<title> Regístrate. Retos por el cambio </title>
	<meta name="description" content="Crea una cuenta en Retos por el cambio" />
	<meta name="keywords" content="Retos por el cambio, regístrate, cuenta" />
	<meta name="robots" content="index,follow" />
</head>
<body>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-offset-2 col-sm-8">
			<h1>Regístrate</h1>
		</div>
	</div>
	<div class="row">
	<div class="col-sm-offset-2 col-sm-8">
		<form class="form-horitzontal" action="<?php echo site_url('User/register')?>" method="POST">
			<div class="form-group">
				<label class="col-sm-2 control-label" for="username">Nombre de usuario</label>
				<div class="col-sm-10">
					<input class="form-control" type="text" name="username" value=""/><br/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="password">Contraseña</label>
				<div class="col-sm-10">
					<input class="form-control" type="password" name="password"/><br/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="second_password">Repetir Contraseña</label>
				<div class="col-sm-10">
					<input class="form-control" type="password" name="second_password"/><br/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="username">e-mail</label>
				<div class="col-sm-10">
					<input class="form-control" type="text" name="mail" value=""/><br/>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input class="btn btn-default" type="submit" value="Registrarse"/>
				</div>
			</div>
		</form>
	</div>
	</div>
</div>
</body>
</html>