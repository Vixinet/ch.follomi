<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>FitnessTouch - Manager</title>
		<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" /> 
		<link rel="stylesheet" type="text/css" href="style.css" media="all"/>
	</head>
	<body>
		<h1>FitnessTouch - manager</h1>
		<form method="post" action="index.php?a=login" class="login">
			<table>
				<tr>
					<th>LOGIN</th>
					<td><input type="text" name="user"></td>
				</tr>
				<tr>
					<th>PASSWORD</th>
					<td><input type="text" name="pass"></td>
				</tr>
				<tr>
					<th> </th>
					<td class="center"><input type="submit" value="CONNEXION"></td>
				</tr>
			</table>
			<?php
				if($err) {
					echo '<p class="error center">' . $err . '</p>';
				}
			?>
		</form>		
	</body>
</html>