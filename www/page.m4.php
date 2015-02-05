<table class="m4">
	<tr>
		<td class="left">
			<h2>MONTAGNE 4</h2>
			<?php
			if(!empty($config['m4txtleft']) or $editing) {
				if(!empty($config['m4txtleft']) and !$editing) {
					echo str_replace("\'", "'", $config['m4txtleft']);
				}

				if($editing) {
					echo '<form method="post" action="index.php?p=m4&amp;action=m4txtleft" class="center">';
					echo '	<textarea class="tinymce" rows="10" name="txt">' . str_replace("\'", "'", $config['m4txtleft']) . '</textarea>';
					echo '	<br/>';
					echo '	<input type="submit" name="submit" value="" class="buttonsave" />&#160;&#160;&#160;';
					echo '	<a target="_blank" href="tool.upload.php?&w=300&amp;h=197&amp;p=data/config/&amp;f=m4"><img src="images/icon-image.png" style="position:relative;top:3px;" /></a>';
					echo '</form>';
				}
			}
			?>
			<p>
				<img src="data/config/m4.thumb.jpg" />
			</p>
			<p>
				Vous pouvez trouver ce catalogue au format papier au magasin ou directement sur internet.
			</p>
			
			<p>
				Liens :
			</p>
			<ul>
				<li><a href="http://www.montagne4.ch/">Site M4</a></li>
				<li><a href="http://www.montagne4.ch/index.php?page=7&index=0">Catalogue M4</a></li>
				<?php
					if(!empty($config['m4pdf'])) {
						echo '<li><a target="blank" href="' . $config['m4pdf'] . '">Catalogue en ligne</a></li>';
					}
				?>
			</ul>
		</td>
		<td class="space"> </td>
		<td>
			<h2>PREFACE</h2>
			<?php
			if(!empty($config['m4txtright']) or $editing) {
				if(!empty($config['m4txtright']) and !$editing) {
					echo str_replace("\'", "'", $config['m4txtright']);
				}

				if($editing) {
					echo '<form method="post" action="index.php?p=m4&amp;action=m4txtright" class="center">';
					echo '	<textarea class="tinymce" rows="30" name="txt">' . str_replace("\'", "'", $config['m4txtright']) . '</textarea>';
					echo '	<br/>';
					echo '	<input type="submit" name="submit" value="" class="buttonsave" />';
					echo '</form>';
				}
			}
			?>
		</td>
	</tr>
	<tr>
		<td class="pdf" colspan="3">
			<?php
				if($editing) {
					echo '<br/><br/>';
					echo '<form method="post" action="index.php?p=m4&amp;action=m4pdf">';
					echo '	<strong>URL PDF : </strong> ';
					echo '	<input type="text" name="txt" value="' . $config['m4pdf'] . '" style="width:873px;" class="admin"/>';
					echo '	<input type="submit" name="submit" value="" class="buttonsave" />';
					echo '</form>';
				}
			?>
		</td>
	</tr>
</table>
