<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<title> Documentación. Retos por el cambio </title>
	<meta name="description" content="Aprende más sobre economía y sostenibilidad gracias a Retos por el Cambio" />
	<?php
	$keywords = "Retos por el cambio, aprende, documentación";
	if($flag == "book")
	{
		$keywords .= ", bibliografía, libros, artículos";
	}
	else
	{
		$keywords .= ", filmografía, películas, videos";
	}
	?>
	<meta name="keywords" content="<?php echo $keywords?>" />
	<meta name="robots" content="index,follow" />
</head>
<body>
<script>
	function manageDownload(sendTo, linkLocation, id)
	{
		$.ajax({ url: sendTo, data:{ 'id': id} });
		window.open(linkLocation, '_blank');
	}
</script>
<div class="container-fluid">
<?php

echo "<div class='row'>";
	echo "<div class='col-sm-offset-2 col-sm-8'>";
		if ($availableDocuments)
		{
			foreach ($documents->result() as $document)
			{
				echo "<div class='panel panel-default'>";
					echo "<div class='panel-heading'>";
						echo $document->name;
					echo "</div>";
					echo "<div class='panel-body'>";
						echo "<div class='row'>";
							echo "<div class='col-sm-8'>";
									echo "<dl class='dl-horizontal'>";
										if($flag == 'book')
										{
											echo "<dt>Autor:</dt>";
											echo "<dd>".$document->author."</dd>";
											echo "<dt>Páginas:</dt>";
											echo "<dd>".$document->pages."</dd>";
											echo "<dt>Argumento:</dt>";
											echo "<dd>".$document->description."</dd>";
										}
										else
										{
											echo "<dt>Año:</dt>";
											echo "<dd>".$document->year."</dd>";
											echo "<dt>Duración:</dt>";
											echo "<dd>".$document->duration." minutos</dd>";
											echo "<dt>Argumento:</dt>";
											echo "<dd>".$document->description."</dd>";
										}
									echo "</dl>";
							echo "</div>";
							echo "<div class='col-sm-1'></div>";
							echo "<div class='col-sm-4 text-center'>";
								$id = ($flag=="book") ? $document->bibliographyID : $document->filmographyID;
								$sendTo = ($flag=="book") ? site_url('Ajax/addBookDownload') : site_url('Ajax/addFilmDownload');
								echo "<div class='row'>&nbsp;</div><a onclick='manageDownload(\"".$sendTo."\",\"".$document->location."\",\"".$id."\")' class='btn btn-info'>Descargar</a>";
							echo "</div>";
						echo "</div>";
					echo "</div>";
				echo "</div>";
			}
		}
		else
		{
			//TODO: contact with us
			echo "<br/><p class='text-justify'>No hay documentos que cumplan los requisitos. ¿Alguna idea? Ponte en contacto con nosotros</p>";
		}
	echo "</div>";
echo "</div>";
?>
</body>
</html>