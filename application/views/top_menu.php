<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href='https://fonts.googleapis.com/css?family=Sue+Ellen+Francisco' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Dosis:300' rel='stylesheet' type='text/css'>
	<link href="<?php echo base_url("css/bootstrap.min.css")?>" rel="stylesheet">
	<link href="<?php echo base_url("css/personalGeneric.css")?>" rel="stylesheet">
	<link rel="icon" type="image/png" href="<?php echo base_url('images/favicon.png')?>">
	
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<!-- facebook share -->
	<div id="fb-root"></div>
	<script>
	window.fbAsyncInit = function() {
		FB.init({
		  appId      : '1741922236081226',
		  xfbml      : true,
		  version    : 'v2.6'
		});
	};

	(function(d, s, id){
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) {return;}
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
	
	function shareFunctionOpinion(sendTo, toShare)
	{
		$.ajax({ url: sendTo });
		var fb_url = 'http://www.facebook.com/sharer.php?u=' + toShare;
		window.open(fb_url,'Compartelo en Facebook!', 'toolbar=0, status=0, width=650, height=450');
		$('#opinion').submit();
	}
	
	function shareFunction(sendTo, toShare)
	{
		$.ajax({ url: sendTo });
		var fb_url = 'http://www.facebook.com/sharer.php?u=' + toShare;
		window.open(fb_url,'Compartelo en Facebook!', 'toolbar=0, status=0, width=650, height=450');
	}
	
	//GOOGLE ANALYTICS
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-78066754-1', 'auto');
	ga('send', 'pageview');

	</script>
</head>
<body>
	<!-- modal for finish challenges -->
	<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header bg-success">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Enhorabuena!</h4>
				</div>
				<div class="modal-body">
					<p class="text-justify">
					<?php
						if (isset($succesChallenge))
						{
							echo "<p class='hidden-xs text-success'>Has completado el reto <strong>".$succesChallenge->title."</strong></br></p>";
							echo $succesChallenge->finalmssg;
						}
					?>
					</p>
					<div class="row">
						<div class="col-sm-offset-1 col-sm-10">
							<form id="opinion" class="form-horizontal" method="POST" action="<?php echo site_url("Frontend/opinion")?>">
								<div class="form-group">
								<textarea name="opinion" class="form-control" placeholder="Deja tu opinión"></textarea>
								</div>
								<input type="hidden" name="challengeID" value="<?php echo $succesChallenge->challengeID;?>">
								<input type="hidden" name="started" value="<?php echo $succesChallenge->started;?>">
							</form>
						</div>
					</div>
				</div>
				<div class="modal-footer bg-success">
					<!-- TODO: give values to buttons and share correctly on facebook -->
					<button onclick="$('#opinion').submit();" type="button" class="btn btn-default">Comentar</button>
					<?php
						$internalUrl = "Challenge/more/".$succesChallenge->challengeID;
						$url = site_url($internalUrl);
						if (isset($username))
						{
							$fb = "Challenge/finished/".$succesChallenge->challengeID."/".$username;
						}
						else
						{
							$fb = "Challenge/finished/".$succesChallenge->challengeID."/nadie";
						}
						$FBurl = site_url($fb);
					?>
					<button type="button" onclick="shareFunctionOpinion('<?php echo site_url("Ajax/updateShareStats")?>','<?php echo $FBurl ?>')" class="btn btn-info">Compartir en FB</button>
				</div>
			</div>
		</div>
	</div>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<!-- FIXME: not load from internet --> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url("js/bootstrap.min.js")?>"></script>	
	<script src="<?php echo base_url("js/bootstrap-notify.min.js")?>"></script>

<?php
if (isset($succesChallenge))
{	
?>
	<script type="text/javascript">
		$('#successModal').modal('show');
	</script>
<?php
}
?>

<?php
if (isset($newBadges))
{
		echo "<script>";
		foreach($newBadges as $badge)
		{
			$imgSrc = $badge["img"].$badge["lvl"]."_small.png";
			echo "$.notify({";
				echo "icon: '".$imgSrc."',";
				echo "title: '<strong>Felicidades!</strong><br/>',";
				echo "message: ' Has conseguido el logro ".$badge["name"]." nivel ".$badge["lvl"]."'";
			echo "},{";
				echo "icon_type: 'image',";
				echo "type: 'success',";
				echo "offset: 50";
			echo "});";
		}
		echo "</script>";
}
?>	
<script>
	function addBadge(sendTo, linkLocation, id)
	{
		$.ajax({ url: sendTo, data:{ 'id': id}, success: function(result){
			if (result == 1)
			{
				$.notify({
					icon: 'http://retosporelcambio.es/images/logros/aldia1_small.png',
					title: '<strong>Felicidades!</strong><br/>',
					message: ' Has conseguido el logro Al dia!',
				},{
					icon_type: 'image',
					type: 'success',
					offset: 50
				});				
			}
		}});
		window.open(linkLocation, '_blank');
	}
</script>
	
	<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="<?php echo site_url();?>"> <img  style='margin-top:-12px;' width='130px' src='<?php echo base_url('images/logo.png')?>'/></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <?php
		//TODO: consider all posible administrators
		if (isset($username) && $username == "dezk")
		{
		?>
		<li><a href="<?php echo site_url('Cms')?>">CMS</a></li>
		<li><a href="<?php echo site_url('Cms/statistics')?>">Estadísticas</a></li>
		<?php
		}
		?>
		<li><a href="<?php echo site_url('Challenge')?>">Retos</a></li>
		<li class='hidden-xs'><a href="<?php echo site_url('Filmography')?>">Filmografía</a></li>
		<li class='hidden-xs'><a href="<?php echo site_url('Bibliography')?>">Bibliografía</a></li>
		<?php 
		if (isset($userID))
		{
			$AjaxSrc = site_url("Ajax/blogBadge");
		?>
			<li><a href='#' onclick='addBadge("<?php echo $AjaxSrc?>","<?php echo base_url('blog')?>",<?php echo $userID ?>)'>Blog</a></li>
		<?php		
		}
		else
		{	
		?>
			<li><a href='<?php echo base_url('blog')?>'>Blog</a></li>
		<?php
		}
		if (isset($username))
		{
			echo "<li><a href='".site_url('User')."'>".$username."</a></li>";
		}
		else
		{
		?>
		<li><a href="<?php echo site_url('User/login')?>">Area de usuario</a></li>
		<?php
		}
		?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

</div>
<div class="wrapper">
</body>
</html>