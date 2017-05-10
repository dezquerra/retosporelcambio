<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<title> Agradecimientos. Retos por el cambio </title>
	<meta name="description" content="Descubre a todos los que han hecho posible Retos por el cambio" />
	<meta name="keywords" content="Retos por el cambio, agradecimientos" />
	<meta name="robots" content="index,follow" />
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-offset-1 col-sm-10">
					<h1>Agradecimientos</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-offset-2 col-sm-8">
					<p class='text-justify'>En todos los proyectos hay siempre mucho que agradecer. En un proyecto como <strong>Retos por el Cambio</strong> todavía más. Por supuesto, el agradecimiento
					más entusiasta va para todos aquellos que formáis parte de <strong>Retos por el Cambio</strong> y que emprendéis pequeñas acciones cada día para hacer 
					de este un mundo mejor.</p>
					<?php
					if (isset($sayThanks) && $sayThanks)
					{
						echo "También estamos muy agradecidos a los que aparecen a continuación por su contribución al proyecto y a la página.<br/><br/>";
						echo "<dl class='dl-horizontal'>";
						foreach($thanks->result() as $thank)
						{
							echo "<dt>".$thank->name."</dt>";
							echo "<dd>".$thank->reason."</dd>";
						}
						echo "</dl>";
					}
					?>
			</div>
		</div>
	</div>
</body>
</html>