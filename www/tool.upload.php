<?php
	$state = isset($_GET['state']) ? $_GET['state'] : '';
	
	$width  = $_GET['w'];
	$height = $_GET['h'];
	$path   = $_GET['p'];
	$file   = $_GET['f'];
	$ext    = 'jpg';
	$sImage = $path . $file . '.' . $ext;
	$sTemp  = $path . $file . '.thumb.temp.' . $ext;
	$sThumb = $path . $file . '.thumb.' . $ext;
	
	$params = '';
	foreach($_GET as $k => $v) {
		if(!empty($params)) {
			$params .= '&amp;';	
		}
		if($k != 'state') {
			$params .= $k . '=' . $v;	
		}
	}
		
	switch($state) {
		case 'upload' :
			// enregistrmeent de l'image par default
			if(!move_uploaded_file($_FILES['oImg']['tmp_name'], $sImage)) {
			    echo "There was an error uploading the file, please try again!";
				die();
			}
			
			// définit l'opération à mettre à disposition
			$stateimg = '';
			
			// Enregistrement du thumb
			$base = @imagecreatefromjpeg($sImage);
			
			$iW = imagesx($base);
			$iH = imagesy($base);
			
			$newH = $newW = 0;
			
			if($iW < $width or $iH < $height) {
				echo 'trop petite';
				exit;
			} else {
				$newH = $width * $iH / $iW;
				$newW = $height * $iW / $iH;
				if($newH >= $height) {
					$newW = $width;
				} else {
					$newH = $height;
				}

				$temp = imagecreatetruecolor($newW, $newH);
				imagecopyresized($temp, $base, 0, 0, 0, 0, $newW, $newH, $iW, $iH);

				imagejpeg($temp, $sTemp, 100);
				imagedestroy($temp);
			}
			
			imagedestroy($base);
		break;
		case 'resize' :
			$top  = $_POST['top'];
			$left = $_POST['left'];
			
			$base = @imagecreatefromjpeg($sTemp);
			
			$thumb = imagecreatetruecolor($width, $height);
			imagecopyresized($thumb, $base, 0, 0, $left, $top, $width, $height, $width, $height);

			imagejpeg($thumb, $sThumb, 100);
			imagedestroy($thumb);
			imagedestroy($base);
			
			// remove($sTemp);
		break;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>Follomi</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
		
		<script type="text/javascript" src="scripts/jquery-1.3.2.min.js"> </script>
		<script type="text/javascript" src="scripts/ElementBBox.js"> </script>
		
		<style>
			* {
				font-family : Arial;
			}
			
			html {
			background : url('images/bg-body.jpg') top left repeat;
			}
			
			body {
				background : #fff;
				border : 1px solid #666;
				margin : 10px;
				padding : 10px;
				text-align : center;
			}
			
			h1 {
				font-size : 16px;
			}
			
			p {
				font-size : 12px;
			}
		</style>
	</head>
	<body>
		<?php
			switch($state) {
				case 'upload' :
		?>
		
			<script type="text/javascript">
				document.onkeydown = function(e) {
					movezone(e);
				}
				
				function movezone(e) {
					if (!e) {
						e = window.event;
					}
					
					var keystroke = e.keyCode || e.which;
					
					var zone  = document.getElementById('zone');
					var sTop  = zone.style.top;
					var sLeft = zone.style.left;

					var top   = sTop.indexOf('px')  > -1 ? parseInt(sTop.substring(0, sTop.length-2))   : parseInt(sTop);
					var left  = sLeft.indexOf('px') > -1 ? parseInt(sLeft.substring(0, sLeft.length-2)) : parseInt(sLeft);

					switch(keystroke) 
					{
						case 37 : // left
							if(left > 0) {
								zone.style.left = (left - 1) + 'px';
							}
						break;
						case 39 : // right
							if(left < <?php echo $newW - $width; ?>) {
								zone.style.left = (left + 1) + 'px';
							}
						break;
						case 38 : // top
							if(top > 0) {
								zone.style.top = (top - 1) + 'px';
							}
						break;
						case 40 : // right
							if(top < <?php echo $newH - $height; ?>) {
								zone.style.top = (top + 1) + 'px';
							}
						break;
					}
					
					document.getElementById('top').value  = top;
					document.getElementById('left').value = left;
				}
			</script>
			<h1>D&eacute;coupe</h1>
			<table>
				<tr>
					<td style="background:url('<?php echo $sTemp; ?>') top left no-repeat; width:<?php echo $newW; ?>px; height:<?php echo $newH; ?>px;padding:0px;vertical-align:top;">
						<div id="zone" style="width:<?php echo $width-2; ?>px;height:<?php echo $height-2; ?>px;border:1px solid red;position:relative;left:0px;top:0px;"> </div>
					</td>
				</tr>
			</table>
			
			<form method="post" id="form" action="tool.upload.php?state=resize&amp;<?php echo $params ?>">
				<input type="hidden" value="0" name="top" id="top"/>
				<input type="hidden" value="0" name="left" id="left"/>
				<input type="submit" value="D&eacute;couper"/>
			</form>
		<?php
				break;	
				case 'resize' :
		?>
			<h1>Op&eacute;ration r&eacute;ussie</h1>
			<img src="<?php echo $sThumb . '?' . mt_rand(); ?>"/><br/><br/>
			<input type="button" value="Fermer" onclick="window.close()"/>
		<?php
				break;
				default : 
		?>
		
			<form enctype="multipart/form-data" method="post" action="tool.upload.php?state=upload&amp;<?php echo $params ?>">
				<h1>Assistant d'ajout d'image</h1>
				<p>
					Cet assistant vous permet d'ajouter une image via cette interface.

					Il permet aussi de la redimensionner si l'on a besoin d'une pr&eacute;visualisation.
				</p>
			
				<input type="file" name="oImg" /><br /><br/>
				<input type="submit" value="Charger" />
				<input type="button" value="Fermer" onclick="window.close()"/>
			</form>
		
		<?php		
				break;
			}
		?>
	</body>
</html>