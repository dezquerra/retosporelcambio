<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<title> Colabora. Retos por el cambio </title>
	<meta name="description" content="Ayudanos a mejorar Retos por el Cambio" />
	<meta name="keywords" content="Retos por el cambio, mejoras, colabora, dona" />
	<meta name="robots" content="index,follow" />
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-offset-1 col-sm-10">
					<h1>Colabora con Retos por el Cambio</h1>
			</div>
		</div>
		<div class='row'>
			&nbsp;
		</div>
		<div class='col-sm-offset-2 col-sm-2'>
			<div class='panel panel-default blueBorder'>
			<div class='panel-body'>
				<img style='margin-left:15px' width='120px' src='<?php echo base_url('images/colabora/send.png')?>'>
				<h2  style='margin-top:-15px' class="text-center">Envíanos nuevos retos</h2>
				<p class='text-justify'>¿Se te ocurre alguna pequeña acción que podría suponer un cambio a mejor? <br/><br/><p class='text-center'><button class='btn btn-default' href='<?php echo site_url('Frontend/contact')?>'>Envianoslo</button></p></p>
			</div>
			</div>
		</div>
		<div class='col-sm-2'>
			<div class='panel panel-default blueBorder'>
			<div class='panel-body'>
				<img style='margin-left:15px' width='120px' src='<?php echo base_url('images/colabora/translate.png')?>'>
				<h2 style='margin-top:-15px' class="text-center">Traduce la página</h2>
				<p class='text-justify'>¿Sabes idiomas? Si te gustaría traducir la página a otros idiomas, podemos ayudarte. <br/><br/><p class='text-center'><button class='btn btn-default' href='<?php echo site_url('Frontend/contact')?>'>Pidenoslo</button></p></p>
			</div>
			</div>
		</div>
		<div class='col-sm-2'>
			<div class='panel panel-default blueBorder'>
			<div class='panel-body'>
				<img style='margin-left:15px' width='120px' src='<?php echo base_url('images/colabora/donate.png')?>'>
				<h3 style='margin-top:-10px' class="hidden-xs text-center">Ayúdanos económicamente</h3>
				<h2 style='margin-top:-10px' class="visible-xs-inline text-center">Ayúdanos económicamente</h2>

				<p class='text-justify'>Mantener una página web cuesta dinero, no porque cobremos, si no porque debemos pagar los servidores y dominios. Igual puedes ayudarnos a hacerlo más llevadero. <br/><br/><p class='text-center'><form class='text-center' action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="7AJYK5PSZ4LFJ">
<input type="submit" class='btn btn-default'  name="submit" value="Donar" alt="PayPal. La forma rápida y segura de pagar en Internet.">
</form></p></p>
			</div>
			</div>
		</div>
		<div class='col-sm-2'>
			<div class='panel panel-default blueBorder'>
			<div class='panel-body'>
				<img style='margin-left:15px' width='120px' src='<?php echo base_url('images/colabora/busines.png')?>'>
				<h2 style='margin-top:-15px' class="text-center">¿Tienes un negocio?</h2>
				<p class='text-justify'>Si tienes un negocio puedes hacer algo más que aceptar los retos. Ponte en contacto con nosotros y juntos iremos un paso más allá. <br/><br/><p class='text-center'><button class='btn btn-default' href='<?php echo site_url('Frontend/contact')?>'>Vale!</button></p></p>
			</div>
			</div>
		</div>
	</div>
</body>
</html>