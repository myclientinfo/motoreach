<?php

/**
 * Jcrop image cropping plugin for jQuery
 * Example cropping script
 * @copyright 2008 Kelly Hallman
 * More info: http://deepliquid.com/content/Jcrop_Implementation_Theory.html
 */
require_once '../../include.php';
 
 
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	if($_POST['step']==1){
		$query = 'UPDATE cars SET `top` = "'.$_POST['y'].'", `left` = "'.$_POST['x'].'", `text` = "'.$_POST['text'].'" WHERE id = '.$_POST['id'];
		Site::runQuery($query);
		$location = $_SERVER['PHP_SELF'].'?id='.($_POST['id']<366?$_POST['id']+1:1);
		header('location: '.$location);
		die();
	} 
	
}

$car = Site::getCar($_GET['id']);
$image_relative = '/images/cars/'.$car['image'];
$location = $_SERVER['DOCUMENT_ROOT'].$image_relative;
?>
<html>
	<head>

		<script src="/js/jquery-1.4.2.min.js"></script>
		<script src="jquery.jcrop.min.js"></script>
		<link rel="stylesheet" href="jquery.jcrop.css" type="text/css" />
		
		<script language="Javascript">
			window.resizeTo(window.screen.availWidth, window.screen.availHeight);
			<?php 
			if($car['left']==''){
				$car['left'] = 100;
				$car['top'] = 100;
			} 
			$pos = array($car['left'], $car['top'], $car['left']+450, $car['top']+100);
			?>
			$(function(){
				$('#cropbox').Jcrop({
					setSelect: [ <?php echo implode(', ', $pos) ?> ],
					bgColor:     'red',
            		bgOpacity:   .4,
					allowResize: false,
					onSelect: updateCoords
				});

			});

			function updateCoords(c)
			{
				$('#x').val(c.x);
				$('#y').val(c.y);
				$('#w').val(c.w);
				$('#h').val(c.h);
			};

			function checkCoords()
			{
				if (parseInt($('#w').val())) return true;
				alert('Please select a crop region then press submit.');
				return false;
			};

		</script>

	</head>

	<body style="background-color: #ffca00;">

	<div id="outer">
	<div class="jcExample">
	<div class="article">
		<h2 style="font-family: verdana, arial, sans-serif; margin-bottom: 10px"><?php echo $car['image'] ?></h2>
		<!-- This is the image we're attaching Jcrop to -->
		<img src="<?php echo $image_relative ?>" id="cropbox" />

		<!-- This is the form that our event handler fills -->
		<form action="index.php" method="post" style="margin-top: 10px;">
			<input type="hidden" id="step" name="step" value="1" />
			<input type="hidden" id="id" name="id" value="<?php echo $_GET['id'] ?>" />
			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="w" name="w" />
			<input type="hidden" id="h" name="h" />
			<label for="text" style="font-family: verdana, arial, sans-serif;">Car Name: </label><input type="text" id="text" style="width: 300px;" name="text" value="<?php echo @$car['text']?>" /> 
			<input type="submit" value="Crop Image" />
		</form>

	</div>
	</div>
	</div>
	</body>

</html>

