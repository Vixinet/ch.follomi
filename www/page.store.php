<?php

	$currentCat = isset($_GET['cat']) ? $_GET['cat'] : -1 ;
	
	if(isset($_GET['action'])) {
		switch($_GET['action']) {
			case 'deleteitem' :
				if(isset($_GET['id'])) {
					$sql -> query('DELETE FROM store WHERE id=' . intval($_GET['id']));
				}
			break;
			
			case 'deletecat' :
				if(isset($_GET['id'])) {
					$sql -> query('DELETE FROM storecats WHERE id=' . intval($_GET['id']));
				}
			break;
			
			case 'additem' :
				if(isset($_POST['submit']) && !empty($_POST['label'])) {
					$label = $_POST['label'];
					$text = isset($_POST['text']) ? $_POST['text'] : '';
					$price = isset($_POST['price']) ? $_POST['price'] : 0;
					$sold = isset($_POST['sold']) ? $_POST['sold'] : 0;
					$new = isset($_POST['new']) ? $_POST['new'] : 0;
					$visible = isset($_POST['visible']) ? $_POST['visible'] : 1;
					$pos = isset($_POST['pos']) ? $_POST['pos'] : 1;
					
					$sql -> query("INSERT INTO store (label, parent, text, price, sold, new, visible, pos) VALUES ('$label', $currentCat, '$text', $price, $sold, $new, $visible, $pos)");
				}
			break;
			
			case 'addcat' :
				if(isset($_POST['submit']) && !empty($_POST['label'])) {
					$label = $_POST['label'];
					$parent = $_POST['parent'];
					$sql -> query("INSERT INTO storecats (label, parent) VALUES ('$label', $parent)");
				}
			break;
			
			case 'edititem' :
				if(isset($_POST['submit']) && !empty($_POST['label'])) {
					$id = intval($_POST['id']);
					$label = $_POST['label'];
					$text = $_POST['text'];
					$price = $_POST['price'];
					$sold = $_POST['sold'];
					$new = intval($_POST['new']);
					$visible = intval($_POST['visible']);
					$pos = intval($_POST['pos']);
					$sql -> query("UPDATE store SET pos=$pos, label='$label', text='$text', price=$price, sold=$sold, new=$new, visible=$visible WHERE id=$id");
				}
			break;
			
			case 'editcat' :
				if(isset($_POST['submit']) && !empty($_POST['label'])) {
					$id = intval($_POST['id']);
					$label = $_POST['label'];
					$type = intval($_POST['type']);
					$pos = intval($_POST['pos']);
					$sql -> query("UPDATE storecats SET label='$label', type=$type, pos=$pos WHERE id=$id");
				}
			break;
		}
	}
	
	if($currentCat == -1) {
		$title = 'BOUTIQUE';
	} else {
		$categorie = $sql -> queryFetch("SELECT label, parent FROM storecats WHERE id=$currentCat");
		$title  = $categorie[0];
		$parent = $categorie[1];
	}

	echo '<h2>' . $title . '</h2>';
		
	$categories = $sql -> query("SELECT * FROM storecats WHERE parent=$currentCat and (type = " . $config['summer'] . " or type = 2) ORDER BY pos");
	$categoriesTotal = $sql -> num_rows();
	if($categoriesTotal == 0) {
		$items = $sql -> query("SELECT * FROM store WHERE parent=$currentCat ORDER BY pos");
		$itemsTotal = $sql -> num_rows();
	}
	
	if($categoriesTotal > 0) {
		if($editing) {
			echo getCategorieAdd();
		}
		
		echo '<table class="storecat" id="data">';
		
		$count = 0;
		while($row = $categories -> fetch_assoc()) {
			if($count%4 == 0) {
				echo '<tr>';
			}
	
			echo getCategorie($row);
			
			if($count%4 == 3) {
				echo '</tr>';
			} else {	
				echo '<td class="space"> </td>';
			}
			
			$count++;
		}
		
		if($count%4 != 0) {
			$pos = $count % 4;
			$colsRest  = 4 - $pos; // On calcule les cells vides
			$colsRest += 3 - $pos; // On rajoute les cells d'espacement
			
			echo '	<td class="categorie" colspan="' . $colsRest . '"> </td>';
		}
		
		echo '	</tr>';
		echo '</table>';
	
	} elseif($itemsTotal > 0) {
		echo '<table class="store" id="data">';
		
		$count = 0;
		while($row = $items -> fetch_assoc()) {
			if($count%2 == 0) {
				echo '<tr>';
			}
			
			if($row['visible'] or $editing) {
				echo '<td>' . getItem($row) . '</td>';
			} else {
				$count--;
			}
			
			if($count%2 == 1) {
				echo '</tr>';
			} else {
				echo '<td class="space"></td>';
			}

			$count++;
		}
		
		if($count%2 == 1) {
			if($editing) {
				echo '	<td>' . getItemAdd() . '</td>';
			} else {
				echo '	<td></td>';	
			}
			
			echo '</tr>';
		} else {
			if($editing) {
				echo '<tr>';
				echo '	<td>' . getItemAdd() . '</td>';
				echo '	<td></td>';
				echo '</tr>';
			}
		}
		
		echo '</table>';
	} else {
		if($editing) {
			echo '<table align="center" id="data">';
			echo '	<tr>';
			echo '		<td>' . getCategorieAdd() . '</td>';
			echo '		<td> - ou - <br/><br/></td>';
			echo '		<td>' . getItemAddSlim() . '</td>';
			echo '	</tr>';
			echo '</table>';	
		} else {
			echo '<p class="center">Aucun article</p>';
		}
	}
	
	if(isset($parent)) {
		echo '<p class="center"><a href="index.php?p=store&cat=' . $parent . '">Retour</a></p>';
	}
	
	function getCategorie($row) {
		global $editing, $currentCat;
		
		$img = file_exists('data/store/categories/categorie' . $row['id'] . '.jpg') 
		     ? 'data/store/categories/categorie' . $row['id'] . '.jpg' 
		     : 'data/store/categories/_nothing.jpg';
		
		if($editing && isset($_GET['id']) and isset($_GET['action']) and $_GET['action'] == 'editcat' and $_GET['id'] == $row['id']) {
			$str  = '<td class="categorie">';
			$str .= '	<form method="post" action="index.php?p=store&amp;cat=' . $currentCat . '&amp;action=editcat#data">';
			$str .= '		<input type="hidden" name="id" value="' . $row['id'] . '"/>';
			$str .= '		<input type="text" name="label" value="' . $row['label'] . '" class="admin label"/>';
			$str .= '		<input type="submit" name="submit" value="" class="buttonsave" />';
			$str .= '		<br/>';
			$str .= '		<a href="index.php?p=store&id=' . $row['id'] . '"><img class="thumb" src="' . $img . '" /></a>';
			$str .= '		<select name="type">';
			$str .= '			<option value="0"' . ($row['type'] == 0 ? ' selected="true"' : '') . '>Hiver</option>';
			$str .= '			<option value="1"' . ($row['type'] == 1 ? ' selected="true"' : '') . '>&Eacute;t&eacute;</option>';
			$str .= '			<option value="2"' . ($row['type'] == 2 ? ' selected="true"' : '') . '>Annuel</option>';
			$str .= '		</select>';
			$str .= '		&#160;&#160;&#160;';
			$str .= '		<input type="text" name="pos" value="' . $row['pos'] . '" class="" style="width:50px;"/>';
			$str .= '	</form>';
			$str .= '</td>';	
		} else {
			$str  = '<td class="categorie">';
			$str .= '	<a href="index.php?p=store&cat=' . $row['id'] . '#data">';
			$str .= 		$row['label'];
			$str .=	'	</a>';
			if($editing) {
				$str .= '		&#160;&#160;<a target="_blank" href="tool.upload.php?&w=200&amp;h=133&amp;p=data/store/categories/&amp;f=categorie'.$row['id'].'"><img src="images/icon-image.png" style="position:relative;top:3px;" /></a>';
				$str .= '		&#160;&#160;<a href="index.php?p=store&amp;cat=' . $currentCat . '&amp;action=editcat&id=' . $row['id'] . '#data"><img src="images/icon-edit.png" style="position:relative;top:3px;"/></a>';
				$str .= '		&#160;&#160;<a href="index.php?p=store&amp;cat=' . $currentCat . '&amp;action=deletecat&id=' . $row['id'] . '#data"><img src="images/icon-delete.png"  style="position:relative;top:3px;"/></a>';
			}
			$str .= '	<br/><br/>';
			$str .= '	<a href="index.php?p=store&cat=' . $row['id'] . '"><img class="thumb" src="' . $img . '" /></a>';
			$str .= '</td>';
		}
		
		return $str;
	}
	
	function getCategorieAdd() {
		global $currentCat;
		
		$str  = '<form method="post" action="index.php?p=store&amp;cat=' . $currentCat . '&amp;action=addcat#data">';
		$str .= '	<table class="storecatadd" align="center" border="1">';
		$str .=	'		<tr>';
		$str .=	'			<th>Ajouter une cat&eacute;gorie</th>';
		$str .=	'		</tr>';
		$str .= '		<tr>';
		$str .= '			<td>';
		$str .= '				<input type="hidden" name="parent" value="' . $currentCat . '" />';
		$str .= '				<input type="text" name="label" class="admin" style="width:175px;"/>&#160;&#160;';
		$str .= '				<input type="submit" name="submit" value="" class="buttonadd" />';
		$str .= '			</td>';
		$str .= '		</tr>';
		$str .= '	</table>';
		$str .= '</form>';
		$str .= '<br/><br/>';
		
		return $str;
	}
	
	function getItem($row) {
		global $editing, $currentCat;
		
		if($editing && isset($_GET['id']) and isset($_GET['action']) and $_GET['action'] == 'edititem' and $_GET['id'] == $row['id']) {
			$img = file_exists('data/store/item'.$row['id'].'.thumb.jpg') ? 'data/store/item'.$row['id'].'.thumb.jpg' : 'data/store/_nothing.jpg';
				
			$str  = '<form method="post" action="index.php?p=store&amp;cat=' . $currentCat . '&amp;action=edititem#data">';
			$str .= '	<input type="hidden" name="id" value="' . $row['id'] . '"/>';
			$str .= '	<table class="item">';
			$str .= '		<tr>';
			$str .= '			<td rowspan="3" class="image center">';
			$str .= '				<img src="' . $img . '"/>';
			$str .= '				<select name="new">';
			$str .= '					<option value="0"' . ($row['new'] == 0 ? ' selected="true"' : '' ) . '></option>';
			$str .= '					<option value="1"' . ($row['new'] == 1 ? ' selected="true"' : '' ) . '>Nouveau</option>';
			$str .= '				</select>';
			$str .= '				<select name="visible">';
			$str .= '					<option value="0"' . ($row['visible'] == 0 ? ' selected="true"' : '' ) . '></option>';
			$str .= '					<option value="1"' . ($row['visible'] == 1 ? ' selected="true"' : '' ) . '>Visible</option>';
			$str .= '				</select>';
			$str .= '				Position : <input type="text" name="pos" class="admin" value="' . $row['pos'] . '" style="width:40px;"/>';
			$str .= '			</td>';
			$str .= '			<th colspan="3"><input type="text" name="label" class="admin" value="' . $row['label'] . '"/></th>';
			$str .= '		</tr>';
			$str .= '		<tr>';
			$str .= '			<td class="description" colspan="3"><textarea name="text" class="tinymce">' . $row['text'] . '</textarea></td>';
			$str .= '		</tr>';
			$str .= '		<tr>';
			$str .= '			<td class="price">Prix CHF : <input type="text" name="price" value="' . $row['price'] . '" class="admin"  style="width:40px"/></td>';
			$str .= '			<td class="price">Solde CHF : <input type="text" name="sold" value="' . $row['sold'] . '" class="admin"  style="width:40px"/></td>';
			$str .= '	      <td class="toolbar">';
			$str .= '				<input type="submit" name="submit" value="" class="buttonsave" />';
			$str .= '			</td>';
			$str .= '		</tr>';
			$str .= '	</table>';
			$str .= '</form>';			
		} else {
			$colspan = $editing ? 2 : 1;
			$str  = '<table class="item">';
			$str .= '	<tr>';
			if(file_exists('data/store/item' . $row['id'] . '.thumb.jpg') ) {
				$str .= '		<td rowspan="3" class="image center">';
				$str .= '			<a href="data/store/item' . $row['id'] . '.jpg" rel="prettyPhoto">';
				$str .= '				<img src="data/store/item' . $row['id'] . '.thumb.jpg" alt="' . $row['label'] . '"/>';
				$str .= '			</a>';
				if($row['new'] == 1) {
 					$str .= '<strong>Nouveaut&eacute;</strong>';
				}
				$str .= '		</td>';	
			} else {
				$str .= '		<td rowspan="3" class="image center">';
				$str .= '		<img src="data/store/_nothing.jpg"/>';
				if($row['new'] == 1) {
 					$str .= '<strong>Nouveaut&eacute;</strong>';
				}
				$str .= '		</td>';
			}
			$str .= '		<th colspan="' . $colspan . '">' . $row['label'] . '</th>';
			$str .= '	</tr>';
			$str .= '	<tr>';
			$str .= '		<td class="description" colspan="' . $colspan . '">' . $row['text'] . '</td>';
			$str .= '	</tr>';
			$str .= '	<tr>';
			if($row['sold'] > 0) {
				$str .= '		<td class="price"><span class="through">Prix CHF ' . $row['price'] . '</span> &#160;&#160;&#160;&#160;&#160;&#160;Action CHF ' . $row['sold'] . '</td>';
			} else {
				$str .= '		<td class="price">Prix CHF ' . $row['price'] . '</td>';
			}
			if($editing) {
				$str .= '      <td class="toolbar">';
				$str .= '   	 	<a target="_blank" href="tool.upload.php?&w=150&amp;h=155&amp;p=data/store/&amp;f=item'.$row['id'].'"><img src="images/icon-image.png" /></a>';
				$str .= '			&#160;&#160;<a href="index.php?p=store&amp;cat=' . $currentCat . '&amp;action=edititem&id=' . $row['id'] . '#data"><img src="images/icon-edit.png"/></a>';
				$str .= '			&#160;&#160;<a href="index.php?p=store&amp;cat=' . $currentCat . '&amp;action=deleteitem&id=' . $row['id'] . '#data"><img src="images/icon-delete.png"/></a>';
				$str .= '		</td>';
			}
			$str .= '	</tr>';
			$str .= '</table>';
		}
		
		return $str;
	}
	
	function getItemAddSlim() {
		global $currentCat;
		
		$str  = '<form method="post" action="index.php?p=store&amp;cat=' . $currentCat . '&amp;action=additem#data">';
		$str .= '	<table class="storecatadd" align="center" border="1">';
		$str .=	'		<tr>';
		$str .=	'			<th>Ajouter un article</th>';
		$str .=	'		</tr>';
		$str .= '		<tr>';
		$str .= '			<td>';
		$str .= '				<input type="hidden" name="parent" value="' . $currentCat . '" />';
		$str .= '				<input type="text" name="label" class="admin" style="width:175px;"/>&#160;&#160;';
		$str .= '				<input type="submit" name="submit" value="" class="buttonadd" />';
		$str .= '			</td>';
		$str .= '		</tr>';
		$str .= '	</table>';
		$str .= '</form>';
		$str .= '<br/><br/>';
		
		return $str;
	}
	
	function getItemAdd() {
		global $currentCat;
		
		$str  = '<form method="post" action="index.php?p=store&amp;cat=' . $currentCat . '&amp;action=additem#data">';
		$str .= '	<table class="item">';
		$str .= '		<tr>';
		$str .= '			<td rowspan="3" class="image center">';
		$str .= '				<img src="data/store/_nothing.jpg"/>';
		$str .= '				<select name="new">';
		$str .= '					<option value="0"></option>';
		$str .= '					<option value="1" selected="true">Nouveau</option>';
		$str .= '				</select>';
		$str .= '				<select name="visible">';
		$str .= '					<option value="0"></option>';
		$str .= '					<option value="1" selected="true">Visible</option>';
		$str .= '				</select>';
		$str .= '				Position : <input type="text" name="pos" class="admin" value="1" style="width:40px;"/>';
		$str .= '			</td>';	
		$str .= '			<th colspan="3"><input type="text" name="label" class="admin" value=""/></th>';
		$str .= '		</tr>';
		$str .= '		<tr>';
		$str .= '			<td class="description" colspan="3"><textarea name="text" class="tinymce"></textarea></td>';
		$str .= '		</tr>';
		$str .= '		<tr>';
		$str .= '			<td class="price">Prix CHF : <input type="text" name="price" value="0" class="admin"  style="width:40px"/></td>';
		$str .= '			<td class="price">Solde CHF : <input type="text" name="sold" value="0" class="admin"  style="width:40px"/></td>';
		$str .= '	      <td class="toolbar">';
		$str .= '				<input type="submit" name="submit" value="" class="buttonadd" />';
		$str .= '			</td>';
		$str .= '		</tr>';
		$str .= '	</table>';
		$str .= '</form>';
		
		return $str;
	}
?>