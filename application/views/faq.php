<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<title> Preguntas frequentes. Retos por el cambio </title>
	<meta name="description" content="Resuelve tus dudas sobre retos por el cambio." />
	<meta name="keywords" content="Retos por el cambio, faq, preguntas frequentes" />
	<meta name="robots" content="index,follow" />
</head>
<body>
	<div class="container-fluid">
		<a name='retosporelcambio'/>
		<div class="row">
			<div class="col-sm-offset-1 col-sm-10">
					<h1>PREGUNTAS FRECUENTES</h1>
			</div>
		</div>
		<div class="row">
		&nbsp; <!-- Just for adjuntment positioning -->
		</div>
		<div class="row">
			<div class="col-sm-offset-2 col-sm-8">
					<dl>
					<?php
					foreach ($ifaq->result() as $iquestions)
					{
						echo "<dd><h2 class='faq'><a href='#".$iquestions->faqID."'>".$iquestions->question."</a></h2></dd>";
					}
					?>
					</dl>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-offset-1 col-sm-10">
				<h1> POR CURIOSIDAD... </h1>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-offset-2 col-sm-8">				
					<dl>
					<?php
					foreach ($faq->result() as $questions)
					{
						echo "<dd><h2 class='faq'><a href='#".$iquestions->faqID."'>".$questions->question."</a></h2></dd>";
					}
					?>
					</dl>	
			</div>
		</div>
		<?php
		foreach($ifaq->result() as $iquestion)
		{
			echo "<a name='".$iquestion->faqID."'/>";
			echo "<div class='row'>";
				echo "<div class='col-sm-offset-1 col-sm-10'>";
						echo "<h2>".$iquestion->question."</h2>";
				echo "</div>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-offset-2 col-sm-8 text-justify'>";
					echo $iquestion->answer;	
				echo "</div>";
			echo "</div>";			
		}
		foreach($faq->result() as $question)
		{
			echo "<a name='".$question->faqID."'/>";
			echo "<div class='row'>";
				echo "<div class='col-sm-offset-1 col-sm-10'>";
						echo "<h2 class='faq'>".$question->question."</h2>";
				echo "</div>";
			echo "</div>";
			echo "<div class='row'>";
				echo "<div class='col-sm-offset-2 col-sm-8 text-justify'>";
					echo "<p class='reverseC'>".$question->answer."</p>";	
				echo "</div>";
			echo "</div>";			
		}
		?>
	</div>
</body>
</html>