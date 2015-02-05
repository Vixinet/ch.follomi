<?php
	if(isset($_GET['id'])) { 
		$id = $_GET['id'];
?>
  	<div id="activities"></div>
	<script type="text/javascript">
		var so = new SWFObject("scripts/polaroid.swf", "polaroid", "100%", "600px", "8", "#FFFFFF");
		so.addVariable("xmlURL","data/activities/album<?php echo $id ?>/_data.xml");
		so.write("activities");
	</script>
<?php 
	} else { 
?>
	<table width="100%">
		<tr>
			<td align="center">
				<a href="index.php?p=activities&id=1"><strong>Allalin</strong></a><br/><br/>
				<a href="index.php?p=activities&id=1"><img src="data/activities/album1/_thumb.jpg" style="width:200px"/></a><br/><br/><br/><br/>
			</td>
			<td align="center">
				<a href="index.php?p=activities&id=2"><strong>Couronne de Br&eacute;ona</strong></a><br/><br/>
				<a href="index.php?p=activities&id=2"><img src="data/activities/album2/_thumb.jpg" style="width:200px"/></a><br/><br/><br/><br/>
			</td>
			<td align="center"> </td>
			<td align="center"> </td>
		</tr>
	</table>
<?php 
	} 
?>