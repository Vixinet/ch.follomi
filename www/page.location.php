<?php

	if(isset($_GET['action'])) {
		switch($_GET['action']) {
			case 'delete' :
				if(isset($_GET['id'])) {
					$sql -> query('DELETE FROM locations WHERE id=' . intval($_GET['id']));
				}
			break;
			
			case 'add' :
				if(isset($_POST['submit']) && !empty($_POST['label'])) {
					$label  = $_POST['label'];
					$summer = $_POST['summer'];
					$day1 = intval($_POST['day1']);
					$day2 = intval($_POST['day2']);
					$day3 = intval($_POST['day3']);
					$day4 = intval($_POST['day4']);
					$day5 = intval($_POST['day5']);
					$day6 = intval($_POST['day6']);
					$day7 = intval($_POST['day7']);
					$more = intval($_POST['more']);
					$sql -> query("INSERT INTO locations (label, day1, day2, day3, day4, day5, day6, day7, more, summer) VALUES ('$label', $day1, $day2, $day3, $day4, $day5, $day6, $day7, $more, $summer)");
				}
			break;
			
			case 'edit' :
				if(isset($_POST['submit']) && !empty($_POST['label'])) {
					$id   = intval($_POST['id']);
					$label  = $_POST['label'];
					$day1 = intval($_POST['day1']);
					$day2 = intval($_POST['day2']);
					$day3 = intval($_POST['day3']);
					$day4 = intval($_POST['day4']);
					$day5 = intval($_POST['day5']);
					$day6 = intval($_POST['day6']);
					$day7 = intval($_POST['day7']);
					$more = intval($_POST['more']);
					$sql -> query("UPDATE locations SET label='$label', day1=$day1, day2=$day2, day3=$day3, day4=$day4, day5=$day5, day6=$day6, day7=$day7, more=$more WHERE id=$id");
				}
			break;
		}
	}
?>
<h2 id="location1">LOCATION &Eacute;T&Eacute;</h2>
<table class="location">
	<thead>
		<tr>
			<th class="label">Articles</th>
			<th>1 jour</th>
			<th>2 jours</th>
			<th>3 jours</th>
			<th>4 jours</th>
			<th>5 jours</th>
			<th>6 jours</th>
			<th>7 jours</th>
			<th>Sup.</th>
			<?php
				if($editing) {
					echo '<th>Actions</th>';
				}
			?>
		</tr>
	</thead>
	<tbody>
		<?php
			$res = $sql -> query('SELECT * FROM locations WHERE summer=1');
			$count = 0;
			$class = '';
			while($row = $res -> fetch_assoc()) {
				$id = $row['id'];
				if($editing && isset($_GET['id']) and isset($_GET['action']) and $_GET['action'] == 'edit' and $_GET['id'] == $id) {
					echo '<form method="post" action="index.php?p=location&amp;action=edit#location1">';
					echo '  <input type="hidden" name="id" value="' . $id . '"/>';
					echo '  <tr class="' . $class . '">';
					echo '    <td class="label"><input type="text" name="label" value="' . $row['label'] . '" class="admin"/></td>';
					echo '    <td><input type="text" name="day1" value="' . $row['day1'] . '" class="admin right"/></td>';
					echo '    <td><input type="text" name="day2" value="' . $row['day2'] . '" class="admin right"/></td>';
					echo '    <td><input type="text" name="day3" value="' . $row['day3'] . '" class="admin right"/></td>';
					echo '    <td><input type="text" name="day4" value="' . $row['day4'] . '" class="admin right"/></td>';
					echo '    <td><input type="text" name="day5" value="' . $row['day5'] . '" class="admin right"/></td>';
					echo '    <td><input type="text" name="day6" value="' . $row['day6'] . '" class="admin right"/></td>';
					echo '    <td><input type="text" name="day7" value="' . $row['day7'] . '" class="admin right"/></td>';
					echo '    <td><input type="text" name="more" value="' . $row['more'] . '" class="admin right"/></td>';
					echo '    <td class="center"><input type="submit" name="submit" value="" class="buttonsave" /></td>';
					echo '  </tr>';
					echo '</form>';
				} else {
					echo '<tr class="' . $class . '">';
					echo '  <td class="label">' . $row['label'] . '</td>';
					echo '  <td>' . $row['day1'] . '.-</td>';
					echo '  <td>' . $row['day2'] . '.-</td>';
					echo '  <td>' . $row['day3'] . '.-</td>';
					echo '  <td>' . $row['day4'] . '.-</td>';
					echo '  <td>' . $row['day5'] . '.-</td>';
					echo '  <td>' . $row['day6'] . '.-</td>';
					echo '  <td>' . $row['day7'] . '.-</td>';
					echo '  <td>' . $row['more'] . '.-</td>';
					if($editing) {
						echo '  <td class="center">';
						echo '    <a href="index.php?p=location&amp;action=edit&id=' . $id . '#location1"><img src="images/icon-edit.png" /></a>';
						echo '    <a href="index.php?p=location&amp;action=delete&id=' . $id . '#location1"><img src="images/icon-delete.png" /></a>';
						echo '  </td>';
					}
					echo '</tr>';
				}
				$count++;
				$class = ($count % 2 == 1) ? 'pair' : '';
			}
			
			if($editing) {
				echo '<form method="post" action="index.php?p=location&amp;action=add#location1">';
				echo '  <input type="hidden" name="summer" value="1"/>';
				echo '  <tr class="' . $class . '">';
				echo '    <td class="label"><input type="text" name="label" value="" class="admin"/></td>';
				echo '    <td><input type="text" name="day1" value="" class="admin right"/></td>';
				echo '    <td><input type="text" name="day2" value="" class="admin right"/></td>';
				echo '    <td><input type="text" name="day3" value="" class="admin right"/></td>';
				echo '    <td><input type="text" name="day4" value="" class="admin right"/></td>';
				echo '    <td><input type="text" name="day5" value="" class="admin right"/></td>';
				echo '    <td><input type="text" name="day6" value="" class="admin right"/></td>';
				echo '    <td><input type="text" name="day7" value="" class="admin right"/></td>';
				echo '    <td><input type="text" name="more" value="" class="admin right"/></td>';
				echo '    <td class="center"><input type="submit" name="submit" value="" class="buttonadd" /></td>';
				echo '  </tr>';
				echo '</form>';
			}
		?>
	</tbody>
</table>

<p>Les prix sont indiqu&eacute;s en Francs Suisse (CHF)</p>

<h2 id="location2">LOCATION HIVER</h2>
<table class="location">
	<thead>
		<tr>
			<th class="label">Articles</th>
			<th>1 jour</th>
			<th>2 jours</th>
			<th>3 jours</th>
			<th>4 jours</th>
			<th>5 jours</th>
			<th>6 jours</th>
			<th>7 jours</th>
			<th>Sup.</th>
			<?php
				if($editing) {
					echo '<th>Actions</th>';
				}
			?>
		</tr>
	</thead>
	<tbody>
		<?php
			$res = $sql -> query('SELECT * FROM locations WHERE summer=0');
			$count = 0;
			$class = '';
			while($row = $res -> fetch_assoc()) {
				$id = $row['id'];
				if($editing && isset($_GET['id']) and isset($_GET['action']) and $_GET['action'] == 'edit' and $_GET['id'] == $id) {
					echo '<form method="post" action="index.php?p=location&amp;action=edit#location2">';
					echo '  <input type="hidden" name="id" value="' . $id . '"/>';
					echo '  <tr class="' . $class . '">';
					echo '    <td class="label"><input type="text" name="label" value="' . $row['label'] . '" class="admin"/></td>';
					echo '    <td><input type="text" name="day1" value="' . $row['day1'] . '" class="admin right"/></td>';
					echo '    <td><input type="text" name="day2" value="' . $row['day2'] . '" class="admin right"/></td>';
					echo '    <td><input type="text" name="day3" value="' . $row['day3'] . '" class="admin right"/></td>';
					echo '    <td><input type="text" name="day4" value="' . $row['day4'] . '" class="admin right"/></td>';
					echo '    <td><input type="text" name="day5" value="' . $row['day5'] . '" class="admin right"/></td>';
					echo '    <td><input type="text" name="day6" value="' . $row['day6'] . '" class="admin right"/></td>';
					echo '    <td><input type="text" name="day7" value="' . $row['day7'] . '" class="admin right"/></td>';
					echo '    <td><input type="text" name="more" value="' . $row['more'] . '" class="admin right"/></td>';
					echo '    <td class="center"><input type="submit" name="submit" value="" class="buttonsave" /></td>';
					echo '  </tr>';
					echo '</form>';
				} else {
					echo '<tr class="' . $class . '">';
					echo '  <td class="label">' . $row['label'] . '</td>';
					echo '  <td>' . $row['day1'] . '.-</td>';
					echo '  <td>' . $row['day2'] . '.-</td>';
					echo '  <td>' . $row['day3'] . '.-</td>';
					echo '  <td>' . $row['day4'] . '.-</td>';
					echo '  <td>' . $row['day5'] . '.-</td>';
					echo '  <td>' . $row['day6'] . '.-</td>';
					echo '  <td>' . $row['day7'] . '.-</td>';
					echo '  <td>' . $row['more'] . '.-</td>';
					if($editing) {
						echo '  <td class="center">';
						echo '    <a href="index.php?p=location&amp;action=edit&id=' . $id . '#location2"><img src="images/icon-edit.png" /></a>';
						echo '    <a href="index.php?p=location&amp;action=delete&id=' . $id . '#location2"><img src="images/icon-delete.png" /></a>';
						echo '  </td>';
					}
					echo '</tr>';
				}
				$count++;
				$class = ($count % 2 == 1) ? 'pair' : '';
			}
			
			if($editing) {
				echo '<form method="post" action="index.php?p=location&amp;action=add#location2">';
				echo '  <input type="hidden" name="summer" value="0"/>';
				echo '  <tr class="' . $class . '">';
				echo '    <td class="label"><input type="text" name="label" value="" class="admin"/></td>';
				echo '    <td><input type="text" name="day1" value="" class="admin right"/></td>';
				echo '    <td><input type="text" name="day2" value="" class="admin right"/></td>';
				echo '    <td><input type="text" name="day3" value="" class="admin right"/></td>';
				echo '    <td><input type="text" name="day4" value="" class="admin right"/></td>';
				echo '    <td><input type="text" name="day5" value="" class="admin right"/></td>';
				echo '    <td><input type="text" name="day6" value="" class="admin right"/></td>';
				echo '    <td><input type="text" name="day7" value="" class="admin right"/></td>';
				echo '    <td><input type="text" name="more" value="" class="admin right"/></td>';
				echo '    <td class="center"><input type="submit" name="submit" value="" class="buttonadd" /></td>';
				echo '  </tr>';
				echo '</form>';
			}
		?>
	</tbody>
</table>
<p>Les prix sont indiqu&eacute;s en Francs Suisse (CHF)</p>