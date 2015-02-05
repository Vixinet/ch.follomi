<div class="index">
	<?php
		if(!empty($config['txtbody']) or $editing) {
			if(!empty($config['txtbody']) and !$editing) {
				echo '<marquee scrollamount="' . $config['txtbodyspeed'] . '" scrolldelay="100" style="color:' . $config['txtbodycolor'] . ';font-size:' . $config['txtbodysize'] . 'px;" >';
				echo $config['txtbody'];
				echo '</marquee>';
			}
			
			if($editing) {
				echo '<form method="post" action="index.php?p=index&amp;action=edittxtbody" class="center">';
				echo '	<input type="text" name="txt" value="' . $config['txtbody'] . '" style="width:475px;" class="admin"/>';
				
				echo '			<select name="color">';
				echo '				<option value="red" ' . ($config['txtbodycolor'] == 'red' ? ' selected="true"' : '') . '>Rouge</option>';
				echo '				<option value="black" ' . ($config['txtbodycolor'] == 'black' ? ' selected="true"' : '') . '>Noir</option>';
				echo '				<option value="blue" ' . ($config['txtbodycolor'] == 'blue' ? ' selected="true"' : '') . '>Bleu</option>';
				echo '				<option value="green" ' . ($config['txtbodycolor'] == 'green' ? ' selected="true"' : '') . '>Vert</option>';
				echo '				<option value="gray" ' . ($config['txtbodycolor'] == 'gray' ? ' selected="true"' : '') . '>Gris</option>';
				echo '			</select>';
				
				echo '			<select name="size">';
				for($i = 12; $i < 21; $i++) {
					echo '			<option value="'.$i.'" ' . ($config['txtbodysize'] == $i ? ' selected="true"' : '') . '>'.$i.'px</option>';	
				}
				echo '			</select>';
				
				echo '			<select name="speed">';
				for($i = 1; $i < 11; $i++) {
					echo '			<option value="'.$i.'" ' . ($config['txtbodyspeed'] == $i ? ' selected="true"' : '') . '>'.$i.'</option>';	
				}
				echo '			</select>';
				
				echo '	<input type="submit" name="submit" value="" class="buttonsave" />';
				echo '	<br/><br/>';
				echo '</form>';
			}
		}
		
		function getCategories($parent) {
			global $sql;
			
			$out = Array();
			do {
				$row = $sql -> queryFetch("SELECT label, parent FROM storecats WHERE id=$parent");
				$out[] = $row[0];
				$parent = $row[1];
			} while($parent != -1);
			
			$out = array_reverse($out);
			
			$str = $out[0] . ' &gt; ';
			
			if(count($out) > 2) {
				$str .= ' ... &gt; ';
			}
			
			$str .= $out[count($out) - 1] . ' &gt; ';
			
			return $str;
		}
	?>
	
	<table class="firstline">
		<tr>
			<td class="video">
				<object type="application/x-shockwave-flash" data="http://www.follomi.ch/scripts/player_flv_mini.swf" width="345" height="292">
				     <param name="movie" value="http://www.follomi.ch/scripts/player_flv_mini.swf" />
				     <param name="FlashVars" value="flv=http://follomi.ch/data/config/movie.flv&amp;width=345&amp;height=292&amp;playercolor=000000" />
				</object>
			</td>
			<td class="space"> </td>
			<td class="offres">
				<h2>OFFRES EN MAGASIN</h2>
				<?php
					$products = $sql -> query("SELECT id, label, price, sold, parent FROM store WHERE sold > 0 LIMIT 4");
					if($sql -> num_rows() > 0) {
						echo '<table>';
						while($row = $products -> fetch_assoc()) {
							$i++;
							$img = file_exists('data/store/item' . $row['id'] . '.thumb.jpg') ? 'data/store/item' . $row['id'] . '.thumb.jpg' : 'data/store/_nothing.jpg';
							echo '<tr>';
							echo '	<td><img src="' . $img . '" /></td>';
							echo '	<td><a href="index.php?p=store&amp;cat=' . $row['parent'] . '#data">' . $row['label'] . '</a><br/>';
							echo '	<span style="text-decoration : line-through">CHF ' . $row['price'] . '</span><br/>';
							echo '	CHF ' . $row['sold'];
							echo '</td>';
							echo '</tr>';
						}
						echo '</table>';
					} else {
						echo '<p>Aucun produit pour l\'instant</p>';
					}
				?>
			</td>
		</tr>
		<tr>
			<td class="offres">
				<?php
					$products = $sql -> query("SELECT id, label, price, sold, parent FROM store WHERE sold > 0 LIMIT 4,100");
					if($sql -> num_rows() > 0) {
					echo '<table>';
						$i=0;
						while($row = $products -> fetch_assoc()) {
							$i++;
							if($i%2 == 1) {
								$img = file_exists('data/store/item' . $row['id'] . '.thumb.jpg') ? 'data/store/item' . $row['id'] . '.thumb.jpg' : 'data/store/_nothing.jpg';
								echo '<tr>';
								echo '	<td><img src="' . $img . '" /></td>';
								echo '	<td><a href="index.php?p=store&amp;cat=' . $row['parent'] . '#data">' . $row['label'] . '</a><br/>';
								echo '	<span style="text-decoration : line-through">CHF ' . $row['price'] . '</span><br/>';
								echo '	CHF ' . $row['sold'];
								echo '	</td>';
								echo '</tr>';
							}
						}
						echo '</table>';
					}
				?>
			</td>
			<td class="space"> </td>
			<td class="offres">
				<?php
					$products = $sql -> query("SELECT id, label, price, sold, parent FROM store WHERE sold > 0 LIMIT 4,100");
					if($sql -> num_rows() > 0) {
						echo '<table>';
						$i=0;
						while($row = $products -> fetch_assoc()) {
							$i++;
							if($i%2 == 0) {
								$img = file_exists('data/store/item' . $row['id'] . '.thumb.jpg') ? 'data/store/item' . $row['id'] . '.thumb.jpg' : 'data/store/_nothing.jpg';
								echo '<tr>';
								echo '	<td><img src="' . $img . '" /></td>';
								echo '	<td><a href="index.php?p=store&amp;cat=' . $row['parent'] . '#data">' . $row['label'] . '</a><br/>';
								echo '	<span style="text-decoration : line-through">CHF ' . $row['price'] . '</span><br/>';
								echo '	CHF ' . $row['sold'];
								echo '	</td>';
								echo '</tr>';
							}
						}
						echo '</table>';
					}
				?>
			</td>
		</tr>
	</table>

	<h2>NOUVEAUX PRODUITS</h2>
	<?php
		$products = $sql -> query("SELECT id, label, parent, price FROM store WHERE new=1");
		if($sql -> num_rows() > 0) {
			echo '<table class="newproducts">';
			
			$count = 0;
			while($row = $products -> fetch_assoc()) {
				if($count%3 == 0) {
					echo '<tr>';
				}
				$img = file_exists('data/store/item' . $row['id'] . '.thumb.jpg') ? 'data/store/item' . $row['id'] . '.thumb.jpg' : 'data/store/_nothing.jpg';
				
				echo '<td class="img">';
				echo '	<img src="' . $img . '" />';
				echo '</td>';
				echo '<td class="description">';
				echo '	<a  href="index.php?p=store&cat=' . $row['parent'] . '#data">' . $row['label'] . '</a><br>';
				echo '	CHF ' . $row['price'];
				echo '</td>';
				
				if($count%3 == 2) {
					echo '</tr>';
				} else {
					echo '<td class="space"> </td>';
				}
				
				$count++;
			}
			
			if($count%3 == 2) {
				echo '<td colspan="2"> </td>';
				echo '</tr>';
			} elseif($count%3 == 1) {
				echo '<td colspan="5"> </td>';
				echo '</tr>';
			} elseif($count%3 == 0) {
				echo '</tr>';
			}
			
			echo '</table>';
		} else {
			echo '<p>Aucun produit pour l\'instant</p>';
		}
	?>
</div>

<div class="menucontact">
	<h2>CONTACTS</h2>
	<p>
		<img src="images/logofollomi.png" class="logofollomi" />
		<strong>Follomi sports</strong><br/>
		Rue du Scex 45<br/>
		CH - 1950 Sion<br/>
		Tel. 027 323 34 71<br/>
		Fax. 027 323 67 51<br/>
		<a href="mailto:info@follomi.ch">info@follomi.ch</a><br/>
		<a href="index.php?p=about">Nous situer</a><br/>
		<a href="http://www.meteosuisse.ch/web/fr/meteo/previsions_en_detail.html">Bulletin m&eacute;t&eacute;o</a><br/>
		<a href="http://www.slf.ch/index_FR">Bulletin avalanche</a><br/><br/>
	</p>
	
	<h2>HORAIRES</h2>
	<table class="horaires">
		<tr>
			<td width="c1">Dim - Lun</td>
			<td width="c2">:</td>
			<td class="c3">Ferm&eacute;</td>
		</tr>
		<tr>
			<td>Mar - Ven</td>
			<td>:</td>
			<td class="c3">08h30 - 18h30</td>
		</tr>
		<tr>
			<td>Samedi</td>
			<td>:</td>
			<td class="c3">08h30 - 17h00</td>
		</tr>
		<tr>
			<td>Veille de f&ecirc;te</td>
			<td>:</td>
			<td class="c3">Fermeture 17h00</td>
		</tr>
	</table>
	<br/>
	
	<?php
		if($config['event'] != -1 or $editing) {
			echo '<h2>&Eacute;V&Eacute;NEMENT</h2>';
			if($config['event'] != -1) {
				echo '<div class="center">';
				echo '	<div class="hover">';
				echo '		<a href="index.php?p=events#event' . $config['event'] . '"><img src="data/events/event' . $config['event'] . '.thumb.jpg"/></a>';
				echo '	</div>';
				echo '</div>';
			}
			
			if($editing) {
				echo '<form method="post" action="index.php?p=page.index.php&amp;action=editevent" class="center">';
				echo '	<select name="id">';
				echo '		<option value="-1">- Aucun -</option>';
				
				$res = $sql -> query('SELECT * FROM events ORDER BY id DESC');
				while($row = $res -> fetch_assoc()) {
					echo '	<option value="' . $row['id'] . '">' . (strlen($row['title']) < 20 ? $row['title'] : substr($row['title'], 0, 20) . ' ...') . '</option>';
				}
				
				echo '	</select>';
				echo '	&#160;';
				echo '	<input type="submit" name="submit" value="" class="buttonsave" />';
				echo '	<br/><br/>';
				echo '</form>';
			}
		}
	?>
	
	<h2>LABELS QUALIT&Eacute;</h2>
	<p class="center">
		<img src="images/label-exped.jpg" /><br/>
		<img src="images/label-dynafit.jpg" /><br/>
	</p>
	
	<h2>NOTRE CATALOGUE</h2>
	<div class="hover">
		<a href="index.php?p=m4"><img src="images/m4.jpg" /></a>
	</div>
</div>

<div style="clear:both;"></div>