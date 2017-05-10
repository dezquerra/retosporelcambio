<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<title> Documentos. Retos por el cambio </title>
	<meta name="description" content="Aprende más sobre sostenibilidad y ecología" />
	<meta name="keywords" content="Retos por el cambio, documentos, bibliografía, filmografía, sostenibilidad, ecología" />
	<meta name="robots" content="index,follow" />
</head>
<body>
<div class="container-fluid">
	<?php
	$sub_url = ($flag == 'films') ? site_url("Filmography/index/") : site_url("Bibliography/index/");
	$i = 0;
	foreach ($topics as $topic)
	{
			if (($i % 4) == 0)
			{
				echo "<div class='row'>";
				//echo "<div class='col-sm-1'>&nbsp;</div>";
				echo "<div class='col-sm-offset-1 col-sm-3'>";
			}
			else
			{
				echo "<div class='col-sm-3'>";
			}
				$src =  $sub_url."/".rawurlencode($topic['name']);
				echo "<a href='".$src."'>";
				echo "<div class='thumbnail text-center'>";
					if ($flag == 'films')
					{
						echo "<img src='".$topic['img']."g.png' alt='".$topic['name']."'>";
					}
					else
					{
						echo "<img src='".$topic['img'].".png' alt='".$topic['name']."'>";
					}
					//echo "<div class='caption'>";
						//echo "<h4>".$topic['name']."</h4>";
					//echo "</div>";
				echo "</div>";
				echo "</a>";
			echo "</div>";
			$i++;
			if (($i % 4) == 3)
			{
				$i++;
				//echo "</div>";
				echo "</div>";
			}
	}
	?>
</div>

</body>
</html>