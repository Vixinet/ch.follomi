<?php

	require_login();
	
	if(isset($_GET['action'])) {
		switch($_GET['action']) {
			case 'delete' :
				if(isset($_GET['id'])) {
					$sql -> query('DELETE FROM users WHERE id=' . intval($_GET['id']));
				}
			break;
			
			case 'add' :
				if(isset($_POST['submit']) && !empty($_POST['user']) && !empty($_POST['pass'])) {
					$user  = $_POST['user'];
					$pass  = $_POST['pass'];
					$lname = $_POST['lname'];
					$fname = $_POST['fname'];			
					$sql -> query("INSERT INTO users (user, pass, lname, fname) VALUES ('$user', '$pass', '$lname', '$fname')");
				}
			break;
			
			case 'edit' :
				if(isset($_POST['submit']) && !empty($_POST['user']) && !empty($_POST['pass'])) {
					$id = intval($_POST['id']);
					$user  = $_POST['user'];
					$pass  = $_POST['pass'];
					$lname = $_POST['lname'];
					$fname = $_POST['fname'];
					$sql -> query("UPDATE users SET user='$user', pass='$pass', lname='$lname', fname='$fname' WHERE id=$id");
				}
			break;
		}
	}
	
	function getItem($row) {
		global $editing;
		$id    = $row['id'];
		$img = 'data/team/team' . $id . '.thumb.jpg';
		
		if(!file_exists($img)) {
			$img = 'data/team/_nothing.jpg';
		}
		
		if($editing && isset($_GET['id']) and isset($_GET['action']) and $_GET['action'] == 'edit' and $_GET['id'] == $id) {
			$str  = '<form method="post" action="index.php?p=admin.users&amp;action=edit#data">';

			$str .= '	<td>';
			$str .= '		<input type="hidden" name="id" value="' . $id . '" />';
			$str .= '		<input type="text" class="admin" name="user" value="' . $row['user'] . '" />';
			$str .= '	</td>';
			$str .= '	<td><input type="text" class="admin" name="pass" value="' . $row['pass'] . '" /></td>';
			$str .= '	<td><input type="text" class="admin" name="fname" value="' . $row['fname'] . '" /></td>';
			$str .= '	<td><input type="text" class="admin" name="lname" value="' . $row['lname'] . '" /></td>';
			$str .= '	<td class="edittoolbar center">';
			$str .= '		<input type="submit" name="submit" value="" class="buttonsave" />';
			$str .= '	</td>';
			$str .= '</form>';
		} else {
			$str  = '<td>' . $row['user'] . '</td>';
			$str .= '<td>' . $row['pass'] . '</td>';
			$str .= '<td>' . $row['fname'] . '</td>';
			$str .= '<td>' . $row['lname'] . '</td>';
			if($editing) {
				$str .= '<td class="edittoolbar center">';
				$str .= '	<a href="index.php?p=admin.users&amp;action=edit&id=' . $id . '#data"><img src="images/icon-edit.png" /></a>';
				$str .= '	<a href="index.php?p=admin.users&amp;action=delete&id=' . $id . '#data"><img src="images/icon-delete.png" /></a>';
				$str .= '</td>';
			}
		}
		
		
		return $str;
	}
	
	function getItemAdd() {
		$str  = '<form method="post" action="index.php?p=admin.users&amp;action=add#data">';
		$str .= '	<td><input type="text" class="admin" name="user" value="" /></td>';
		$str .= '	<td><input type="text" class="admin" name="pass" value="" /></td>';
		$str .= '	<td><input type="text" class="admin" name="fname" value="" /></td>';
		$str .= '	<td><input type="text" class="admin" name="lname" value="" /></td>';
		$str .= '	<td class="edittoolbar center">';
		$str .= '		<input type="submit" name="submit" value="" class="buttonadd" />';
		$str .= '	</td>';
		$str .= '</from>';
		
		return $str;
	}
?>

<h2>GESTION UTILISATEURS</h2>
<table class="adminusers" id="data">
	<tr>
		<th style="width:225px;">Nom d'utilisateur</th>
		<th style="width:225px;">Mot de passe</th>
		<th style="width:225px;">Pr&eacute;nom</th>
		<th style="width:225px;">Nom</th>
		<?php
			if($editing) {
				echo '<th style="width:60px;">Actions</th>';
			}
		?>
	</tr>
	<?php
		$res = $sql -> query('SELECT * FROM users ORDER BY id ASC');
		$count = 0;
		while($row = $res -> fetch_assoc()) {
			echo '<tr>';
			echo getItem($row);
			echo '</tr>';
		}
		
		if($editing) {	
			echo '<tr>';
			echo getItemAdd();
			echo '</tr>';
		}
	?>
</table>