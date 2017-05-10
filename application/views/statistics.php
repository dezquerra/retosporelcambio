<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="robots" content="noindex,nofollow" />
</head>
<body>
<script>
	function delete_comment(sendTo)
	{
		$.ajax({ url: sendTo});
	}
</script>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-offset-2 col-sm-8">
			<h1>Estadísticas</h1>
		</div>
	</div>
	<div class="row">
	<div class="col-sm-offset-2 col-sm-8">
		<dl class='dl-horizontal'>
			<dt>Usuarios registrados</dt>
			<dd><?php echo $registeredUsers?></dd>
			<dt>Retos en curso</dt>
			<dd><?php echo $currentChallenges?></dd>
			<dt>Retos en la página</dt>
			<dd><?php echo $allChallenges?></dd>
			<dt>Retos compartidos</dt>
			<dd><?php echo $sharedChallenges?></dd>
			<dt>Opiniones registradas</dt>
			<dd><?php echo $Opinions?></dd>
			<dt>Libros descargados</dt>
			<dd><?php echo $booksDownloads?></dd>
			<dt> Libros en la página</dt>
			<dd><?php echo $totalBooks?></dd>
			<dt>Videos Descargados</dt>
			<dd><?php echo $filmsDownloads?></dd>
			<dt>Vídeos en la página</dt>
			<dd><?php echo $totalFilms?></dd>
			<dt>Usuarios notificados hoy</dt>
			<dd><?php echo $sendedEmails?></dd>
			<dt>Top 1</dt>
			<dd><?php echo $top3[0]?></dd>
			<dt>Top 2</dt>
			<dd><?php echo $top3[1]?></dd>
			<dt>Top 3</dt>
			<dd><?php echo $top3[2]?></dd>
			
		</dl>
		<dl>
		<?php
			foreach ($ContactsInfo->result() as $contact)
			{
				echo "<dt>[".$contact->timestamp."] ".$contact->name." (".$contact->mail.")</dt>";
				echo "<dd>".$contact->mssg."<a onclick='delete_comment(\"".site_url("Ajax/deleteComment/".$contact->contactID)."\")'><br/>Borrar</a></dd>";
			}
		?>
		</dl>
	</div>
	</div>
</div>

</body>
</html>