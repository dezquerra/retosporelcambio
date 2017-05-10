<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
<div class="container-fluid">
<?php
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
				echo "<div class='thumbnail text-center'>";
					echo "<img src='".$topic['img']."' alt='".$topic['name']."'>";
					echo "<div class='caption'>";
						echo "<h8>".$topic['name']."</h8>";
					echo "</div>";
				echo "</div>";
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