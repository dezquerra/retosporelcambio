<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title> Login. Retos por el cambio </title>
	<meta name="description" content="Accede a tu cuenta de retos por el cambio" />
	<meta name="keywords" content="Retos por el cambio, login, usuario, cuenta" />
	<meta name="robots" content="index,follow" />
</head>
<body>
<script>
	function recoverPassword(sendTo)
	{
		var mail = '';
		$(document).ready(function() {
			mail = $('#mail').val();
		});
		if (mail == null || mail == "")
		{
			return;
		}
		
		window.location.href = sendTo + mail;
		$('#changeModal').modal('hide');
	}
</script>
<div class="container-fluid">
<!-- Modal to recover password -->
<div class="modal fade" id="changeModal" tabindex="-1" role="dialog" aria-labelledby="changeModal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title">Danos tu correo</h3>
			</div>
			<div class="modal-body">
				<form class="form-horitzontal" action="<?php echo site_url('User/recover')?>" method="POST">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="mail">Mail</label>
						<div class="col-sm-10">
							<input id="mail" class="form-control" type="text" name="mail"/><br/>
						</div>
					</div>
				</form>
			</div>
			<div class='row'>&nbsp;</div>
			<div class="modal-footer">
				<?php 
				$sendto = site_url('User/recover')."/";
				?>
				<button class='btn btn-default' onclick='recoverPassword("<?php echo $sendto?>")'>Recuperar Contraseña</button>					
			</div>
		</div>
	</div>
</div>
<!-- -->

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
		<div class="alert alert-warning alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<?php echo $mssg; ?>
		</div>
	<?php
	}
	?>
	<div class="row">
		<div class="col-sm-offset-2 col-sm-8">
			<h1>Login</h1>
		</div>
	</div>
	<div class="row">
	<div class="col-sm-offset-2 col-sm-8">
	<form class="form-horitzontal" action="<?php echo site_url('User/login')?>" method="POST">
		<div class="form-group">
			<label class="col-sm-2 control-label" for="username">Nombre de usuario</label>
			<div class="col-sm-10">
				<input class="form-control" type="text" name="username"/><br/>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="password">Contraseña</label>
			<div class="col-sm-10">
				<input class="form-control" type="password" name="password"/><br/>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-default">Login</button>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				No tienes cuenta?  <a href="<?php echo site_url("User/register")?>" class="">Registrate</a>
				<?php 
				$src = site_url('User/recover')."/";
				?>
				<br/><a data-toggle='modal' data-target='#changeModal' href=''>Recuperar contraseña</a>
			</div>
		</div>
	</form>
	</div>
	</div>
</div>

</body>
</html>