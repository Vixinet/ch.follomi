<table>
	<tr>
		<td class="text">
			<h2>&Agrave; PROPOS</h2>
			<img src="images/aboutfollomi.jpg" />
			<p>
				Jean-Louis Kottelat professeur de ski, grand passionn&eacute; de nature 
				et de montagne d&eacute;cide en 1986 d ouvrir son propre magasin pour 
				pouvoir faire partager sa passion de toujours.
			</p>
			<p>
				Afin de reproduire au mieux l ambiance montagne, en plus de la bonne 
				humeur, il fait construire &agrave; l int&eacute;rieur du magasin, un mur d escalade 
				de 7 m&egrave;tres de haut mis &agrave; la disposition de la client&egrave;le pour tester le 
				mat&eacute;riel de grimpe tels que chaussons, harnais et m&eacute;thodes d assurage.
			</p>
			<p>
				Jean-Louis et toute son &eacute;quipe sont &agrave; votre disposition pour vous 
				conseiller afin de trouver le meilleur confort ainsi que la plus 
				grande s&eacute;curit&eacute; pour toutes vos sorties alpines &eacute;t&eacute; comme hiver!
			</p>
		</td>
		<td class="maps">
			<h2>LOCALISATION</h2>
			<iframe width="100%" height="220" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.fr/maps/ms?ie=UTF8&amp;hl=fr&amp;om=1&amp;msid=117500801196097509208.00000111e5e6f5283321a&amp;msa=0&amp;ll=46.232481,7.367041&amp;spn=0.005306,0.010321&amp;output=embed"></iframe>
		</td>
	</tr>
</table>

<?php
	if(isset($_GET['action'])) {
		switch($_GET['action']) {
			case 'delete' :
				if(isset($_GET['id'])) {
					$sql -> query('DELETE FROM team WHERE id=' . intval($_GET['id']));
				}
			break;
			
			case 'add' :
				if(isset($_POST['submit']) && !empty($_POST['fname'])) {
					$fname = $_POST['fname'];
					$sql -> query("INSERT INTO team (fname) VALUES ('$fname')");
				}
			break;
			
			case 'edit' :
				if(isset($_POST['submit']) && !empty($_POST['fname'])) {
					$id = intval($_POST['id']);
					$fname = $_POST['fname'];
					$sql -> query("UPDATE team SET fname='$fname' WHERE id=$id");
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
			$str  = '<form method="post" action="index.php?p=about&amp;action=edit#data">';
			$str .= '<input type="hidden" name="id" value="' . $id . '"/>';
			$str .= '<table>';
			$str .= '  <tr>';
			$str .= '    <td class="image" rowspan="2"><img src="' . $img . '"></td>';
			$str .= '    <td class="infos">';
			$str .= '	    <strong>Pr&eacute;nom</strong><br/>';
			$str .= '		<input type="text" class="admin" name="fname" value="' . $row['fname'] .'" />';
			$str .= '		</td>';
			$str .= '	</tr>';
			$str .= '	<tr>';
			$str .= '		<td class="edittoolbar">';
			$str .= '			<input type="submit" name="submit" value="" class="buttonsave" />';
			$str .= '		</td>';
			$str .= '	</tr>';
			$str .= '</table>';
			$str .= '</form>';
		} else {
			$str  = '<table>';
			$str .= '  <tr>';
			$str .= '    <td class="image" rowspan="' . ($editing ? 2 : 1). '"><img src="' . $img . '"></td>';
			$str .= '    <td class="infos">';
			$str .= '	    <strong>Pr&eacute;nom</strong><br/>';
			$str .= $row['fname'];
			$str .= '    </td>';
			$str .= '  </tr>';
			if($editing) {
				$str .= '	<tr>';
				$str .= '		<td class="edittoolbar">';
				$str .= '			<a target="_blank" href="tool.upload.php?&w=150&amp;h=200&amp;p=data/team/&amp;f=team'.$id.'"><img src="images/icon-image.png" /></a>';
				$str .= '   		<a href="index.php?p=about&amp;action=edit&id=' . $id . '#data"><img src="images/icon-edit.png" /></a>';
				$str .= '   		<a href="index.php?p=about&amp;action=delete&id=' . $id . '#data"><img src="images/icon-delete.png" /></a>';
				$str .= '		</td>';
				$str .= '	</tr>';
			}
			
			$str .= '</table>';
		}
		
		
		return $str;
	}
	
	function getItemAdd() {
		$str  = '<form method="post" action="index.php?p=about&amp;action=add#data">';
		$str .= '<table>';
		$str .= '  <tr>';
		$str .= '    <td class="image" rowspan="2"><img src="data/team/_nothing.jpg"></td>';
		$str .= '    <td class="infos">';
		$str .= '	    <strong>Pr&eacute;nom</strong><br/>';
		$str .= '		<input type="text" class="admin" name="fname" value="" />';
		$str .= '		</td>';
		$str .= '	</tr>';
		$str .= '	<tr>';
		$str .= '		<td class="edittoolbar">';
		$str .= '			<input type="submit" name="submit" value="" class="buttonadd" />';
		$str .= '		</td>';
		$str .= '	</tr>';
		$str .= '</table>';
		$str .= '</form>';
		return $str;
	}
?>

<h2>TEAM FOLLOMI</h2>
<table class="team" id="data">
	<?php
		$res = $sql -> query('SELECT * FROM team ORDER BY id ASC');
		$count = 0;
		while($row = $res -> fetch_assoc()) {
			if($count % 3 == 0) {
				echo '<tr>';
			}
			
			echo '  <td>' . getItem($row) . '</td>';
			
			if($count % 3 == 2)  {
				echo '</tr>';
			}
			
			$count++;
		}

		switch($count % 3) {
			case 0 :
				if($editing) {
					echo '<tr>';
					echo '	<td>' . ($editing ? getItemAdd() : ' ') . '</td>';
					echo '	<td> </td>';
					echo '	<td> </td>';
					echo '</tr>';
				}
			break;
			
			case 1 :
				echo '	<td>' . ($editing ? getItemAdd() : ' ') . '</td>';
				echo '	<td> </td>';
				echo '</tr>';
			break;
			
			case 2 : 
				echo '	<td>' . ($editing ? getItemAdd() : ' ') . '</td>';
				echo '</tr>';
			break;
			
			default :
		}
	?>
</table>