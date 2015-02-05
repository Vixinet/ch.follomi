<?php

	if(!empty($config['txtevents']) or $editing) {
		if(!empty($config['txtevents']) and !$editing) {
			echo '<p style="color:' . $config['txteventscolor'] . ';font-size:' . $config['txteventssize'] . 'px;" >';
			echo $config['txtevents'];
			echo '</p>';
		}
		
		if($editing) {
			echo '<form method="post" action="index.php?p=events&amp;action=edittxtevents" class="center">';
			echo '	<input type="text" name="txt" value="' . $config['txtevents'] . '" style="width:800px;" class="admin"/>';
			
			echo '			<select name="color">';
			echo '				<option value="red" ' . ($config['txteventscolor'] == 'red' ? ' selected="true"' : '') . '>Rouge</option>';
			echo '				<option value="black" ' . ($config['txteventscolor'] == 'black' ? ' selected="true"' : '') . '>Noir</option>';
			echo '				<option value="blue" ' . ($config['txteventscolor'] == 'blue' ? ' selected="true"' : '') . '>Bleu</option>';
			echo '				<option value="green" ' . ($config['txteventscolor'] == 'green' ? ' selected="true"' : '') . '>Vert</option>';
			echo '				<option value="gray" ' . ($config['txteventscolor'] == 'gray' ? ' selected="true"' : '') . '>Gris</option>';
			echo '			</select>';
			
			echo '			<select name="size">';
			for($i = 12; $i < 21; $i++) {
				echo '			<option value="'.$i.'" ' . ($config['txteventssize'] == $i ? ' selected="true"' : '') . '>'.$i.'px</option>';	
			}
			echo '			</select>';
			echo '	<input type="submit" name="submit" value="" class="buttonsave" />';
			echo '	<br/><br/>';
			echo '</form>';
		}
	}
	
	if(isset($_GET['action'])) {
		switch($_GET['action']) {
			case 'delete' :
				if(isset($_GET['id'])) {
					$sql -> query('DELETE FROM events WHERE id=' . intval($_GET['id']));
				}
			break;
			
			case 'add' :
				if(isset($_POST['submit']) && !empty($_POST['title'])) {
					$title = $_POST['title'];
					$description = $_POST['description'];
					$sql -> query("INSERT INTO events (title, description, visible) VALUES ('$title', '$description', 1)");
				}
			break;
			
			case 'edit' :
				if(isset($_POST['submit']) && !empty($_POST['title'])) {
					$id = intval($_POST['id']);
					$title  = $_POST['title'];
					$description = $_POST['description'];
					$visible = $_POST['visible'];
					$pos = intval($_POST['pos']);
					$sql -> query("UPDATE events SET title='$title', description='$description', pos=$pos, visible=$visible WHERE id=$id");
				}
			break;
		}
	}
	
	function getEvent($row) {
		global $editing;
		$id    = $row['id'];
		$img   = 'data/events/event' . $id . '.jpg';
		$thumb = 'data/events/event' . $id . '.thumb.jpg';
		$none  = 'data/events/_nothing.jpg';
		
		if($editing && isset($_GET['id']) and isset($_GET['action']) and $_GET['action'] == 'edit' and $_GET['id'] == $id) {
			$str  = '<form method="post" action="index.php?p=events&amp;action=edit#data">';
			$str .= '<input type="hidden" name="id" value="' . $id . '"/>';
			$str .= '<h1><input type="text" name="title" value="' . $row['title'] . '" class="admin" /></h1>';
			$str .= '<table class="event">';
			$str .= '	<tr>';
			$str .= '		<td class="image" rowspan="2">';
			if(file_exists($img) and file_exists($thumb)) {
				$str .= '			<a href="' . $img . '" rel="prettyPhoto">';
				$str .= '				<img src="' . $thumb . '" alt="' . $row['title'] . '" />';
				$str .= '			</a>';
			} else {
				$str .= '			<img src="' . $none . '" />';	
			}
			$str .= '			<br/><br/>';
			$str .= '			<select name="visible">';
			$str .= '				<option value="0"' . ($row['visible'] == 0 ? ' selected="true"' : '' ) . '></option>';
			$str .= '				<option value="1"' . ($row['visible'] == 1 ? ' selected="true"' : '' ) . '>Visible</option>';
			$str .= '			</select>';
			$str .= '			<input type="text" name="pos" value="' . $row['pos'] . '" class="" style="width:50px;"/>';
			$str .= '		</td>';
			$str .= '		<td class="text"><textarea class="tinymce" name="description">' . $row['description'] . '</textarea></td>';
			$str .= '	</tr>';
			$str .= '	<tr>';
			$str .= '	  <td class="edittoolbar">';
			$str .= '    	<input type="submit" name="submit" value="" class="buttonsave" />';
			$str .= '	  </td>';
			$str .= '	</tr>';
			$str .= '</table>';
			$str .= '</form>';
		} else {
			$str  = '';
			$str .= '<h1>' . $row['title'] . '</h1>';
			$str .= '<table class="event">';
			$str .= '	<tr>';
			$str .= '		<td class="image" rowspan="' . ($editing ? 2 : 1). '">';
			if(file_exists($img) and file_exists($thumb)) {
				$str .= '			<a href="' . $img . '" rel="prettyPhoto">';
				$str .= '				<img src="' . $thumb . '" alt="' . $row['title'] . '" />';
				
				if(!$editing) {
					$str .= '<br/>[AGRANDIR]';
				}
				
				$str .= '			</a>';
			} else {
				$str .= '			<img src="' . $none . '" />';	
			}
			$str .= '		</td>';
			$str .= '		<td class="text">' . $row['description'] . '</td>';
			$str .= '	</tr>';
			
			if($editing) {
				$str .= '	<tr>';
				$str .= '	  <td class="edittoolbar">';
				$str .= '   	 <a target="_blank" href="tool.upload.php?&w=200&amp;h=280&amp;p=data/events/&amp;f=event'.$id.'"><img src="images/icon-image.png" /></a>';
				$str .= '   	 <a href="index.php?p=events&amp;action=edit&id=' . $id . '#data"><img src="images/icon-edit.png" /></a>';
				$str .= '   	 <a href="index.php?p=events&amp;action=delete&id=' . $id . '#data"><img src="images/icon-delete.png" /></a>';
				$str .= '	  </td>';
				$str .= '	</tr>';
			}
			
			$str .= '</table>';
		}
		
		
		return $str;
	}
	
	function getEventAdd() {
		$str  = '<form method="post" action="index.php?p=events&amp;action=add#data">';
		$str .= '<h1><input type="text" name="title" value="" class="admin" /></h1>';
		$str .= '<table class="event">';
		$str .= '	<tr>';
		$str .= '		<td class="image" rowspan="2">';
		$str .= '			<img src="data/events/_nothing.jpg" />';
		$str .= '		</td>';
		$str .= '		<td class="text"><textarea class="tinymce" name="description"></textarea></td>';
		$str .= '	</tr>';
		$str .= '	<tr>';
		$str .= '	  <td class="edittoolbar">';
		$str .= '    	<input type="submit" name="submit" value="" class="buttonadd" />';
		$str .= '	  </td>';
		$str .= '	</tr>';
		$str .= '</table>';
		$str .= '</form>';
		return $str;
	}
?>

<table class="events" id="data">
	<?php
		$res = $sql -> query('SELECT * FROM events ORDER BY pos ASC');
		while($row = $res -> fetch_assoc()) {
			if($row['visible'] or $editing) {
				echo '<tr>';			
				echo '  <td id="event' . $row['id'] . '">' . getEvent($row) . '</td>';
				echo '</tr>';
			}
		}
		echo '<tr>';
		echo '  <td>' . (($editing) ? getEventAdd() : ' ') . '</td>';
		echo '</tr>';
	?>
</table>