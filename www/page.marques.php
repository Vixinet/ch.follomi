<?php
	if(isset($_GET['action'])) {
		switch($_GET['action']) {
			case 'delete' :
				if(isset($_GET['id'])) {
					$sql -> query('DELETE FROM marques WHERE id=' . intval($_GET['id']));
				}
			break;
			
			case 'add' :
				if(isset($_POST['submit'])) {
					$sql -> query("INSERT INTO marques (first) VALUES (0)");
				}
			break;
			
			case 'edit' :
				$id = intval($_GET['id']);
				$first = intval($_GET['first']);
				$sql -> query("UPDATE marques SET first=$first WHERE id=$id");
			break;
		}
	}
	
	function getItem($row) {
		global $editing;
		$id    = $row['id'];
		$img = 'data/marques/marque' . $id . '.thumb.jpg';
		
		if(!file_exists($img)) {
			$img = 'data/marques/_nothing.jpg';
		}
		
		$str  = '<div>';
		if($editing) {
			$str .= '<a target="_blank" href="tool.upload.php?&w=85&amp;h=85&amp;p=data/marques/&amp;f=marque'.$id.'"><img src="images/icon-image.png" /></a>';
			$str .= '<a href="index.php?p=marques&amp;action=edit&id=' . $id . '&first=' . ($row['first'] == 0 ? 1 : 0) . '#data"><img src="images/icon-' . ($row['first'] == 0 ? 'top' : 'bottom') . '.png"/></a> ';
			$str .= '<a href="index.php?p=marques&amp;action=delete&id=' . $id . '#data"><img src="images/icon-delete.png" /></a>';
			$str .= '<br/>';
		}
		$str .= '	<img src="' . $img . '" />';
		$str .= '</div>';
		
		return $str;
	}
	
	function getItemAdd() {
		$str  = '<div>';
		$str .= '<form method="post" action="index.php?p=marques&action=add">';
		$str .= '	<input type="submit" name="submit" value="" class="buttonadd" />';
		$str .= '	<br/>';
		$str .= '	<img src="data/marques/_nothing.jpg" />';
		$str .= '</form>';
		$str .= '</div>';
		
		return $str;
	}
?>

<div class="marques" id="data">
	<?php
		$res = $sql -> query('SELECT * FROM marques WHERE first=1 ORDER BY id ASC');
		while($row = $res -> fetch_assoc()) {
			echo getItem($row);
		}
		
		if($editing) {
			echo '<div style="clear:both;float:none;"><br/><br/></div>';	
		}
		
		$res = $sql -> query('SELECT * FROM marques WHERE first=0 ORDER BY id ASC');
		while($row = $res -> fetch_assoc()) {
			echo getItem($row);
		}
		
		if($editing) {
			echo getItemAdd();	
		}
	?>
	<div style="clear:both;float:none;"> </div>
</div>	
