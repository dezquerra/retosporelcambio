<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<title> Usuario. Retos por el cambio </title>
	<meta name="robots" content="noindex,follow" />
</head>
<body>
	<script src="<?php echo base_url("js/base64.js")?>"></script>
	<script>
		function sharedChange(shared, sendTo)
		{
			if (shared == 1)
			{
				$('#shared').text('No');
			}
			else
			{
				$('#shared').text('Sí');
			}
			$.ajax({ url: sendTo });
		}
		
		function mailingChange(mailing, sendTo)
		{
			if (mailing == 1)
			{
				$('#mailing').text('No');
			}
			else
			{
				$('#mailing').text('Sí');
			}
			$.ajax({ url: sendTo });
		}
		
		function changeMail(sendTo)
		{
			var newMail = '';
			$(document).ready(function() {
				newMail = $('#newMail').val();
			});
			if (newMail == null || newMail == "")
			{
				return;
			}
			$('#mail').text(newMail);
			
			$.ajax({ url:sendTo, data:{'mail' : newMail} });
			$('#changeModal').modal('hide');
		}
		
		function changePassword(sendTo, userID)
		{
			var newPass = '';
			var verPass = '';
			$(document).ready(function() {
				newPass = $('#newPass').val();
				verPass = $('#verPass').val();
			});
			if (newPass == null || newPass == "" || newPass.localeCompare(verPass) != 0)
			{
				return;
			}
			
			newPass = Base64.encode(newPass);
			$.ajax({ url:sendTo, data:{'pass' : newPass, 'userID': userID} });
			$('#passwordModal').modal('hide');
		}
		
		function changeAvatar(sendTo, avatar)
		{
			$(document).ready(function(){
				$('#avatarImg').attr('src',avatar);
				$.ajax({ url: sendTo, data:{'avatar' : avatar} });				
			});
		}
	</script>
	<!-- Modal to change avatar -->
	<div class="modal fade" id="avatarModal" tabindex="-1" role="dialog" aria-labelledby="changeAvatarModal">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title">Escoge tu avatar</h3>
				</div>
				<div class="modal-body">
					<?php
						$avatarSendTo = site_url("Ajax/changeAvatar");
					?>
					<div class="row">
						<div class='col-sm-offset-1 col-sm-2'>
							<a onclick='changeAvatar("<?php echo $avatarSendTo?>","<?php echo base_url('images/avatar/executive.png')?>")' href='#'>
								<img width='50px' src='<?php echo base_url('images/avatar/executive.png')?>'>
							</a>
						</div>
						<div class='col-sm-2'>
							<a onclick='changeAvatar("<?php echo $avatarSendTo?>","<?php echo base_url('images/avatar/executive2.png')?>")' href='#'>
								<img width='50px' src='<?php echo base_url('images/avatar/executive2.png')?>'>
							</a>
						</div>
						<div class='col-sm-2'>
							<a onclick='changeAvatar("<?php echo $avatarSendTo?>","<?php echo base_url('images/avatar/executive3.png')?>")' href='#'>
								<img width='50px' src='<?php echo base_url('images/avatar/executive3.png')?>'>
							</a>
						</div>
						<div class='col-sm-2'>
							<a onclick='changeAvatar("<?php echo $avatarSendTo?>","<?php echo base_url('images/avatar/executive4.png')?>")' href='#'>
								<img width='50px' src='<?php echo base_url('images/avatar/executive4.png')?>'>
							</a>
						</div>
					</div>
					<div class="row">
						<div class='col-sm-offset-1 col-sm-2'>
							<a onclick='changeAvatar("<?php echo $avatarSendTo?>","<?php echo base_url('images/avatar/hipster1.png')?>")' href='#'>
								<img width='50px' src='<?php echo base_url('images/avatar/hipster1.png')?>'>
							</a>
						</div>
						<div class='col-sm-2'>
							<a onclick='changeAvatar("<?php echo $avatarSendTo?>","<?php echo base_url('images/avatar/hipster2.png')?>")' href='#'>
								<img width='50px' src='<?php echo base_url('images/avatar/hipster2.png')?>'>
							</a>
						</div>
						<div class='col-sm-2'>
							<a onclick='changeAvatar("<?php echo $avatarSendTo?>","<?php echo base_url('images/avatar/hipster3.png')?>")' href='#'>
								<img width='50px' src='<?php echo base_url('images/avatar/hipster3.png')?>'>
							</a>
						</div>
						<div class='col-sm-2'>
							<a onclick='changeAvatar("<?php echo $avatarSendTo?>","<?php echo base_url('images/avatar/hipster4.png')?>")' href='#'>
								<img width='50px' src='<?php echo base_url('images/avatar/hipster4.png')?>'>
							</a>
						</div>
					</div>
					<div class="row">
						<div class='col-sm-offset-1 col-sm-2'>
							<a onclick='changeAvatar("<?php echo $avatarSendTo?>","<?php echo base_url('images/avatar/informal1.png')?>")' href='#'>
								<img width='50px' src='<?php echo base_url('images/avatar/informal1.png')?>'>
							</a>
						</div>
						<div class='col-sm-2'>
							<a onclick='changeAvatar("<?php echo $avatarSendTo?>","<?php echo base_url('images/avatar/informal2.png')?>")' href='#'>
								<img width='50px' src='<?php echo base_url('images/avatar/informal2.png')?>'>
							</a>
						</div>
						<div class='col-sm-2'>
							<a onclick='changeAvatar("<?php echo $avatarSendTo?>","<?php echo base_url('images/avatar/informal3.png')?>")' href='#'>
								<img width='50px' src='<?php echo base_url('images/avatar/informal3.png')?>'>
							</a>
						</div>
						<div class='col-sm-2'>
							<a onclick='changeAvatar("<?php echo $avatarSendTo?>","<?php echo base_url('images/avatar/informal4.png')?>")' href='#'>
								<img width='50px' src='<?php echo base_url('images/avatar/informal4.png')?>'>
							</a>
						</div>
					</div>
					<div class="row">
						<div class='col-sm-offset-1 col-sm-2'>
							<a onclick='changeAvatar("<?php echo $avatarSendTo?>","<?php echo base_url('images/avatar/traje1.png')?>")' href='#'>
								<img width='50px' src='<?php echo base_url('images/avatar/traje1.png')?>'>
							</a>
						</div>
						<div class='col-sm-2'>
							<a onclick='changeAvatar("<?php echo $avatarSendTo?>","<?php echo base_url('images/avatar/traje2.png')?>")' href='#'>
								<img width='50px' src='<?php echo base_url('images/avatar/traje2.png')?>'>
							</a>
						</div>
						<div class='col-sm-2'>
							<a onclick='changeAvatar("<?php echo $avatarSendTo?>","<?php echo base_url('images/avatar/traje3.png')?>")' href='#'>
								<img width='50px' src='<?php echo base_url('images/avatar/traje3.png')?>'>
							</a>
						</div>
						<div class='col-sm-2'>
							<a onclick='changeAvatar("<?php echo $avatarSendTo?>","<?php echo base_url('images/avatar/traje4.png')?>")' href='#'>
								<img width='50px' src='<?php echo base_url('images/avatar/traje4.png')?>'>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- -->
	<!-- Modal to change mail -->
	<div class="modal fade" id="changeModal" tabindex="-1" role="dialog" aria-labelledby="changeMailModal">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title">Cambia el e-mail</h3>
				</div>
				<div class="modal-body">
					<form class="form-horitzontal" action="<?php echo site_url('User/login')?>" method="POST">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="mail">Mail</label>
							<div class="col-sm-10">
								<input id="newMail" class="form-control" type="text" name="mail" placeholder='<?php echo $info->mail?>' /><br/>
							</div>
						</div>
					</form>
				</div>
				<div class='row'>&nbsp;</div>
				<div class="modal-footer">
					<?php
					$composeUrl = 'Ajax/changeMail/';
					$sendto = site_url($composeUrl);
					?>
					<button class='btn btn-default' onclick='changeMail("<?php echo $sendto?>")'>Cambiar</button>					
				</div>
			</div>
		</div>
	</div>
	<!-- -->
	<!-- Modal to change password -->
	<div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModal">
		<!-- TODO: mostrar el modal más grande -->
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title">Cambia la contraseña</h3>
				</div>
				<div class="modal-body">
					<form class="form-horitzontal" method="POST">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="newPass">Contraseña</label>
							<div class="col-sm-10">
								<input id="newPass" class="form-control" type="password" name="newPass"/><br/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="verPass">Verifica la Contraseña</label>
							<div class="col-sm-10">
								<input id="verPass" class="form-control" type="password" name="verPass"/><br/>
							</div>
						</div>
					</form>
				</div>
				<div class='row'>&nbsp;</div>
				<div class="modal-footer">
					<?php
					$passwordUrl = 'Ajax/changePassword/';
					$sendto = site_url($passwordUrl);
					?>
					<button class='btn btn-default' onclick='changePassword("<?php echo $sendto?>", <?php echo $info->userID?>)'>Cambiar</button>					
				</div>
			</div>
		</div>
	</div>
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
							echo "<dt> Correo electrónico <a data-toggle='modal' data-target='#changeModal'><span class='glyphicon glyphicon-pencil'></span></a></dt><dd id='mail'>".$info->mail."</dd>";
							echo "<dt> Contraseña <a data-toggle='modal' data-target='#passwordModal'><span class='glyphicon glyphicon-pencil'></span></a></dt><dd>******</dd>";
							$composeUrl = 'Ajax/changeSharedStatus/'.$info->shared;
							$ajaxShareSrc = site_url($composeUrl);
							echo "<dt> Mostrar actividad <a onclick='sharedChange(".$info->shared.",\"".$ajaxShareSrc."\")'><span class='glyphicon glyphicon-pencil'></span></a></dt>";
							if ($info->shared != 0)
							{
								echo "<dd id='shared'>Sí</dd>";
							}
							else
							{
								echo "<dd id='shared'>No</dd>";
							}
							$composeUrl = 'Ajax/changeMailingStatus/'.$info->mailing;
							$ajaxMailSrc = site_url($composeUrl);
							echo "<dt> Recibir noticias <a onclick='mailingChange(".$info->mailing.",\"".$ajaxMailSrc."\")'><span class='glyphicon glyphicon-pencil'></span></a></dt>";
							if ($info->mailing != 0)
							{
								echo "<dd id='mailing'>Sí</dd>";
							}
							else
							{
								echo "<dd id='mailing'>No</dd>";
							}
						echo "</dl>";
						echo "<p class='text-center'><a href='".site_url("User/logout")."' class='btn btn-danger' role='button'>Desconexión</a>";
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
							//echo "</div>";
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
							//echo "</div>";
						}
				}
				?>
				</div>
				<div class="row">
					<div class='col-sm-offset-4 col-sm-3'>
					<?php
						$shareUrl = site_url("User/show/".$info->username);
					?>
					<a class='link' onclick='shareFunction("<?php echo site_url("Ajax/updateShareStats")?>","<?php echo $shareUrl ?>")'> Comparte tu perfil</a>
					</div>
				</div>				
				<div class="row">
					&nbsp;
				</div>
				<div class="row">
				<div class='col-sm-offset-2 col-sm-3 text-left'>
				<dl class='dl-horizontal'>
				<?php
					$src = 'Challenge/active/'.$info->userID;
					echo "<dt> <a href='".site_url($src)."'>Retos activos </a></dt><dd>".$currentChallenges."</dd>";
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