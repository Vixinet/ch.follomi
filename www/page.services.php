<?php

	if(isset($_GET['action'])) {
		switch($_GET['action']) {
			case 'delete' :
				if(isset($_GET['id'])) {
					$sql -> query('DELETE FROM services WHERE id=' . intval($_GET['id']));
				}
			break;
			
			case 'add' :
				if(isset($_POST['submit']) && !empty($_POST['label'])) {
					$label = $_POST['label'];
					$info  = $_POST['info'];
					$type  = intval($_POST['type']);
					$sql -> query("INSERT INTO services (label, info, type) VALUES ('$label', '$info', $type)");
				}
			break;
			
			case 'edit' :
				if(isset($_POST['submit']) && !empty($_POST['label'])) {
					$id    = intval($_POST['id']);
					$label = $_POST['label'];
					$info  = $_POST['info'];
					$sql -> query("UPDATE services SET label='$label', info='$info' WHERE id=$id");
				}
			break;
		}
	}
?>
<h2>NOTRE DEVISE</h2>
<p>
	Les amateurs de ski ou d&#39;alpinisme ne l&#39;ignorent pas, 
	la s&eacute;curit&eacute; c&#39;est d&#39;abord un &eacute;quipement:
</p>
<ul>
	<li>s&ucirc;r</li>
	<li>bien entretenu</li>
	<li>adapt&eacute; aux qualit&eacute;s de celui qui l&#39;emploie</li>
</ul>
<p>
	L'&eacute;quipe Follomi est &agrave; votre disposition 
	pour vous conseiller afin de trouver le meilleur confort 
	ainsi que la plus grande s&eacute;curit&eacute; pour toutes vos sorties 
	alpines &eacute;t&eacute; comme hiver.
</p>

<h2>NOS SERVICES</h2>
<p>
	Notre magasin propose diff&eacute;rents services :
</p>
<ul>
	<li>Grand service de ski</li>
	<li>Petit service de ski</li>
	<li>Service de snowboard</li>
	<li>Service de ski de fond</li>
	<li>Fartage &agrave; chaud thermobag ( caisson sp&eacute;cial 12 heures)</li>
	<li>Montage des fixations</li>
	<li>R&eacute;encollage des peaux</li>
	<li>Aiguisage de tous les crampons</li>
	<li>Aiguisage de piolet</li>
	<li>Aiguisage des vis &agrave; glace</li>
	<li>Changement des sangles de crampons</li>
	<li>R&eacute;paration des b&acirc;tons t&eacute;l&eacute;scopiques (grand assortiment de pi&egrave;ces d&eacute;tach&eacute;es)</li>
	<li>Changement des piles et couvercles Suunto</li>
	<li>Thermoformage de chausson de rando ainsi que de semelles formthotics</li>
	<li>Adaptation de vos chaussures par d&eacute;formation sous presse</li>
	<li>Ressemelage des chaussures d&#39;escalade (semelles, demi semelles, tacons)</li>
	<li>Ressemelage des chaussures trekking et montagne</li>
</ul>

<table class="services" id="data">
	<tr>
		<td>
			<h2>Entretien et mise &agrave; jour GPS Garmin</h2>
			<table>
				<tbody>
					<?php
						$res = $sql -> query('SELECT * FROM services WHERE type=1');
						while($row = $res -> fetch_assoc()) {
							$id = $row['id'];
							if($editing && isset($_GET['id']) and isset($_GET['action']) and $_GET['action'] == 'edit' and $_GET['id'] == $id) {
								echo '<form method="post" action="index.php?p=services&amp;action=edit#data">';
								echo '  <input type="hidden" name="id" value="' . $id . '"/>';
								echo '  <tr>';
								echo '    <td class="label"><input type="text" name="label" value="' . $row['label'] . '" class="admin"/></td>';
								echo '    <td class="space">:</td>';
								echo '    <td><input type="text" name="info" value="' . $row['info'] . '" class="admin"/></td>';
								echo '    <td class="center"><input type="submit" name="submit" value="" class="buttonsave" /></td>';
								echo '  </tr>';
								echo '</form>';
							} else {
								echo '<tr>';
								echo '  <td class="label">' . $row['label'] . '</td>';
								echo '  <td class="space">:</td>';
								echo '  <td>' . $row['info'] . '</td>';
								if($editing) {
									echo '  <td class="center actions">';
									echo '    <a href="index.php?p=services&amp;action=edit&id=' . $id . '#data"><img src="images/icon-edit.png" /></a>';
									echo '    <a href="index.php?p=services&amp;action=delete&id=' . $id . '#data"><img src="images/icon-delete.png" /></a>';
									echo '  </td>';
								}
								echo '</tr>';
							}
						}

						if($editing) {
							echo '<form method="post" action="index.php?p=services&amp;action=add#data">';
							echo '  <input type="hidden" name="type" value="1"/>';
							echo '  <tr>';
							echo '    <td class="label"><input type="text" name="label" value="" class="admin"/></td>';
							echo '    <td class="space">:</td>';
							echo '    <td><input type="text" name="info" value="" class="admin"/></td>';
							echo '    <td class="center"><input type="submit" name="submit" value="" class="buttonadd" /></td>';
							echo '  </tr>';
							echo '</form>';
						}
					?>
				</tbody>
			</table>
		</td>

		<td>
			<h2>Entretien et mise &agrave; jour ARVA Mammut</h2>
			<table>
				<tbody>
					<?php
						$res = $sql -> query('SELECT * FROM services WHERE type=2');
						while($row = $res -> fetch_assoc()) {
							$id = $row['id'];
							if($editing && isset($_GET['id']) and isset($_GET['action']) and $_GET['action'] == 'edit' and $_GET['id'] == $id) {
								echo '<form method="post" action="index.php?p=services&amp;action=edit#data">';
								echo '  <input type="hidden" name="id" value="' . $id . '"/>';
								echo '  <tr>';
								echo '    <td class="label"><input type="text" name="label" value="' . $row['label'] . '" class="admin"/></td>';
								echo '    <td class="space">:</td>';
								echo '    <td><input type="text" name="info" value="' . $row['info'] . '"  class="admin"/></td>';
								echo '    <td class="center"><input type="submit" name="submit" value="" class="buttonsave" /></td>';
								echo '  </tr>';
								echo '</form>';
							} else {
								echo '<tr>';
								echo '  <td class="label">' . $row['label'] . '</td>';
								echo '  <td class="space">:</td>';
								echo '  <td>' . $row['info'] . '</td>';
								if($editing) {
									echo '  <td class="center actions">';
									echo '    <a href="index.php?p=services&amp;action=edit&id=' . $id . '#data"><img src="images/icon-edit.png" /></a>';
									echo '    <a href="index.php?p=services&amp;action=delete&id=' . $id . '#data"><img src="images/icon-delete.png" /></a>';
									echo '  </td>';
								}
								echo '</tr>';
							}
						}

						if($editing) {
							echo '<form method="post" action="index.php?p=services&amp;action=add#data">';
							echo '  <input type="hidden" name="type" value="2"/>';
							echo '  <tr>';
							echo '    <td class="label"><input type="text" name="label" value=""  class="admin"/></td>';
							echo '    <td class="space">:</td>';
							echo '    <td><input type="text" name="info" value="" class="admin"/></td>';
							echo '    <td class="center"><input type="submit" name="submit" value="" class="buttonadd" /></td>';
							echo '  </tr>';
							echo '</form>';
						}
					?>
				</tbody>
			</table>
		</td>
	</tr>
</table>