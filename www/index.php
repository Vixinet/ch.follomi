<?php

	// On ouvre une session
	session_start();
	
	include_once('class.SQLi.php');
	
	include_once('lang.fr.php');
	
	// On choisit le fuseau horaire
	date_default_timezone_set("Europe/Zurich");
	
	// On ouvre une connexion vers la DB
	$sql = new SQLi('vixinet.ch', 'ufollomi', '39248204', 'follomi');
//	$sql = new SQLi('127.0.0.1', 'root', '39248204', 'follomi');
	
	// Variable pour savoir si l'on a reçu un httprequest
	$isPOST = $_SERVER['REQUEST_METHOD'] == 'POST';
	
	// On prend le nom de la page demandée
	$page = isset($_GET['p']) ? $_GET['p'] : 'index';
	
	// On construit le nom de la page
	$file = 'page.' . $page . '.php';
	
	// Variable qui contient les erreurs ou infos :
	$err = '';
	$info = '';
	
	// On filtre les params POST
	foreach($_POST as $k => $v) {
		$_POST[$k] = $sql -> escape($v);
	}
	
	// On filtre les params GET
	foreach($_GET as $k => $v) {
		$_GET[$k] = $sql -> escape($v);
	}
	
	// On controle si l'on a reçu une request de connexion
	if($page == 'login' and !isset($_SESSION['id'])) {
		if(isset($_POST['user']) and isset($_POST['pass'])) {
			// Si c'est le cas on va le connecter
			$u = $_POST['user'];
			$p = $_POST['pass'];
			$r = $sql -> queryFetch("SELECT id, fname, lname FROM users WHERE user='$u' && pass='$p'");
			if($sql -> num_rows() == 1) {
				$_SESSION['id']      = $r[0];
				$_SESSION['user']    = $u;
				$_SESSION['fname']   = $r[1];
				$_SESSION['lname']   = $r[2];
				$_SESSION['editing'] = false;
				header('Location: index.php?p=index');
			} else {
				$err = "Ce compte n'existe pas.";
			}
			$sql -> rClose();
		}
	}
	
	// On controle si l'on a reçu une request de déconnexion
	if(isset($_SESSION['id']) and $page == 'logout') {
		$_SESSION = array();
		session_destroy();
		header('Location: index.php?p=index');
	}
	
	// On regarde si l'on passe en editing mode
	if(isset($_SESSION['id']) and isset($_GET['editing'])) {
		$_SESSION['editing'] = !$_SESSION['editing'];
	}
	
	// on définit $editing pour faciliter les test
	$editing = isset($_SESSION['id']) && $_SESSION['editing'] ? true : false;
	
	function require_login() {
		// Si l'utilisateur n'est pas connecté on lui demande de se connecter
		if(!isset($_SESSION['id'])) {
			header("Location: page.login.php");
		}
	}
	
	// configuration du site
	if($editing) {
		if(isset($_POST['submit']) && isset($_GET['action'])) {
			switch($_GET['action']) {
				case 'edittxtheader' :
					$txt = $_POST['txt'];
					$ts  = $_POST['size'];
					$tc  = $_POST['color'];
					$sql -> query("UPDATE config SET txtheader='$txt', txtheadersize=$ts, txtheadercolor='$tc'");
				break;
				case 'edittxtbody' :
					$txt = $_POST['txt'];
					$ts  = $_POST['size'];
					$tc  = $_POST['color'];
					$tsp  = $_POST['speed'];
					$sql -> query("UPDATE config SET txtbody='$txt', txtbodysize=$ts, txtbodycolor='$tc', txtbodyspeed=$tsp");
				break;
				case 'edittxtevents' :
					$txt = $_POST['txt'];
					$ts  = $_POST['size'];
					$tc  = $_POST['color'];
					$sql -> query("UPDATE config SET txtevents='$txt', txteventssize=$ts, txteventscolor='$tc'");
				break;
				case 'editevent' :
					$id = intval($_POST['id']);
					$sql -> query("UPDATE config SET event=$id");
				break;
				case 'm4pdf' :
					$txt = $_POST['txt'];
					$sql -> query("UPDATE config SET m4pdf='$txt'");
				break;
				case 'm4txtleft' :
					$txt = $_POST['txt'];
					$sql -> query("UPDATE config SET m4txtleft='$txt'");
				break;
				case 'm4txtright' :
					$txt = $_POST['txt'];
					$sql -> query("UPDATE config SET m4txtright='$txt'");
				break;
			}
		}
	}
	
	// cas spécial étant donné que l'on a pas de formulaire mais un lien !
	if($editing  && isset($_GET['action']) && $_GET['action'] == 'editsummer' && isset($_GET['summer'])) {
		$summer = intval($_GET['summer']);
		$sql -> query("UPDATE config SET summer=$summer");
	}
	
	// Configuration du site
	$row = $sql -> queryFetch('SELECT summer, txtheader, txtbody, event, m4pdf, txtheadersize, txtheadercolor, txtbodysize, txtbodycolor, m4txtleft, m4txtright, txtevents, txteventssize, txteventscolor, txtbodyspeed FROM config');
	$config['summer'] = $row[0];
	$config['txtheader'] = $row[1];
	$config['txtbody'] = $row[2];
	$config['event'] = $row[3];
	$config['m4pdf'] = $row[4];
	$config['txtheadersize'] = $row[5];
	$config['txtheadercolor'] = $row[6];
	$config['txtbodysize'] = $row[7];
	$config['txtbodycolor'] = $row[8];
	$config['txtbodyspeed'] = $row[14];
	$config['m4txtleft'] = $row[9];
	$config['m4txtright'] = $row[10];
	$config['txtevents'] = $row[11];
	$config['txteventssize'] = $row[12];
	$config['txteventscolor'] = $row[13];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>Follomi</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
		
		<link rel="stylesheet" type="text/css" media="all" href="css/style.css" />
		<link rel="stylesheet" type="text/css" media="all" href="css/prettyPhoto.css" />
		
		<script type="text/javascript" src="scripts/swfobject.js"> </script>
		<script type="text/javascript" src="scripts/jquery-1.3.2.min.js"> </script>
		<script type="text/javascript" src="scripts/jquery.prettyPhoto.js"> </script>
		<script type="text/javascript" src="scripts/tiny_mce/jquery.tinymce.js"> </script>

		<script type="text/javascript">
			
			<?php if($editing) { ?>
				$(function() {
					$('textarea.tinymce').tinymce({
						script_url : 'scripts/tiny_mce/tiny_mce.js',
						theme : "advanced",
						plugins : "safari,style,directionality,xhtmlxtras",
						theme_advanced_buttons1 : "bold,italic,underline,|,justifyleft,justifyfull,|,bullist,numlist,|,link,unlink",
						theme_advanced_buttons2 : "",
						theme_advanced_buttons3 : "",
						theme_advanced_buttons4 : "",
						width : "100%"
					});
				});	
			<?php } ?>
			
			$(document).ready(function(){$("a[rel^='prettyPhoto']").prettyPhoto({theme: 'light_rounded'});});
		</script>
	</head>
	<body>
		<div class="marginheadertop"> </div>
		
		
		<div class="header">
			<div class="content" style="background-image:url('data/config/logo<?php echo intval($config['summer']); ?>.thumb.jpg');">
				<?php
					if(!empty($config['txtheader']) or $editing) {
						if(!empty($config['txtheader']) and !$editing) {
							echo '<div class="infobar">';
							echo '	<p style="color:'.$config['txtheadercolor'].';font-size:'.$config['txtheadersize'].'px;">' . $config['txtheader'] . '</p>';
							echo '</div>';
						}

						if($editing) {
							echo '<div class="infobar">';
							echo '	<p>';
							echo '		<form method="post" action="index.php?p=' . $page . '&amp;action=edittxtheader" class="center">';
							echo '			<input type="text" name="txt" value="' . $config['txtheader'] . '" style="width:800px;" class="admin"/>';

							echo '			<select name="color">';
							echo '				<option value="red" ' . ($config['txtheadercolor'] == 'red' ? ' selected="true"' : '') . '>Rouge</option>';
							echo '				<option value="black" ' . ($config['txtheadercolor'] == 'black' ? ' selected="true"' : '') . '>Noir</option>';
							echo '				<option value="blue" ' . ($config['txtheadercolor'] == 'blue' ? ' selected="true"' : '') . '>Bleu</option>';
							echo '				<option value="green" ' . ($config['txtheadercolor'] == 'green' ? ' selected="true"' : '') . '>Vert</option>';
							echo '				<option value="gray" ' . ($config['txtheadercolor'] == 'gray' ? ' selected="true"' : '') . '>Gris</option>';
							echo '			</select>';

							echo '			<select name="size">';
							for($i = 12; $i < 21; $i++) {
								echo '			<option value="'.$i.'" ' . ($config['txtheadersize'] == $i ? ' selected="true"' : '') . '>'.$i.'px</option>';	
							}
							echo '			</select>';
							
							echo '			<input type="submit" name="submit" value="" class="buttonsave" />';
							echo '		</form>';
							echo '	</p>';
							echo '</div>';
						}
					}
				?>
				
				<img id="logo" src="images/logo.png" />
				
				<?php if(isset($_SESSION['id'])) { ?>
				<div class="admintoolbar">
					<?php if($editing) { ?>
					<a href="index.php?p=admin.config"><img src="images/icon-images.png" alt="Changer la banni&egrave;re"/></a>
					&#160;&#160;
					<a href="index.php?p=admin.users"><img src="images/icon-users.png" alt="Utilisateurs"/></a>
					&#160;&#160;
					<?php } ?>
					<a href="index.php?p=<?php echo $page; ?>&amp;editing" class="editingmode<?php echo $editing; ?>"><img src="images/icon-editing.png" alt="Edit mode"/></a>
					&#160;&#160;
					<a href="index.php?p=logout"><img src="images/icon-logout.png" alt="Sortir"/></a>
				</div>
				<?php } ?>
			</div>
		</div>
		
		<div class="menu">
			<div class="content">
			<ul class="scroll">
				<li <?php if($page=='index') echo 'class="actif"';?>><a href="index.php?p=index">ACCUEIL<br/><span class="subtitle">Index du site</span></a></li>
				<li <?php if($page=='about') echo 'class="actif"';?>><a href="index.php?p=about">&Agrave; PROPOS<br/><span class="subtitle">Follomi</span></a></li>
				<li <?php if($page=='services') echo 'class="actif"';?>><a href="index.php?p=services">SERVICES<br/><span class="subtitle">Que faisons-nous?</span></a></li>
				<li <?php if($page=='location') echo 'class="actif"';?>><a href="index.php?p=location">LOCATION<br/><span class="subtitle">Pr&ecirc;t de mat&eacute;riel</span></a></li>
				<li <?php if($page=='marques') echo 'class="actif"';?>><a href="index.php?p=marques">MARQUES<br/><span class="subtitle">Nos labels</span></a></li>
				<li <?php if($page=='store') echo 'class="actif"';?>><a href="index.php?p=store">BOUTIQUE<br/><span class="subtitle">Notre magasin</span></a></li>
				<li <?php if($page=='events') echo 'class="actif"';?>><a href="index.php?p=events">&Eacute;V&Eacute;NEMENTS<br/><span class="subtitle">Votre actualit&eacute;</span></a></li>
				<li <?php if($page=='activities') echo 'class="actif"';?>><a href="index.php?p=activities">SORTIES<br/><span class="subtitle">Nos albums</span></a></li>
			</ul>
			</div>
		</div>
		
		<div class="marginbodytop"> </div>
			
		<div class="body">
			<div class="content">
				<?php
					// On controle l'existance de la page
					if(!file_exists($file)) {
						$file = 'page.index.php';
					}
					include_once($file);
				?>
			</div>
		</div>
		
		<div class="marginbodybottom"> </div>
		
		<div class="footer">
			<div class="content">
				<p>
					<a href="index.php?p=index">Accueil</a> -
					<a href="index.php?p=about">&Agrave; propos</a> -
					<a href="index.php?p=services">Services</a> -
					<a href="index.php?p=location">Location</a> -
					<a href="index.php?p=marques">Marques</a> -
					<a href="index.php?p=store">Boutique</a> -
					<a href="index.php?p=events">&Eacute;v&eacute;nements</a> -
					<a href="index.php?p=activities">Sorties</a> -
					<a href="index.php?p=m4">Catalogue M4</a>
					<?php if(!isset($_SESSION['id'])) { ?>
					- <a href="index.php?p=login"><img src="images/icon-login.png" alt="Manage"/></a>
					<?php } ?>
				</p>
				<p>
					&copy; Follomi Sports - all rights reserved
				</p>
			</div>
		</div>
	</body>
</html>