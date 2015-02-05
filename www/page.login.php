<form method="post" action="index.php?p=login">
	<div class="login">
		<table>
			<?php if(isset($err)) { ?>
			<tr>
				<td class="error" colspan="3"><?php echo $err; ?>	</td>
			</tr>
			<?php } ?>
			<tr>
				<td>Nom d'utilisateur</td>
				<td><input type="text" name="user"/></td>
				<td><?php getHelp(0); ?></td>
			</tr>
			<tr>
				<td>Mot de passe</td>
				<td><input type="password" name="pass"/></td>
				<td><?php getHelp(1); ?></td>
			</tr>
			<tr>
				<td> </td>
				<td class="center"><input type="submit" value="CONNECTER" /></td>
				<td> </td>
			</tr>
		</table>
	</div>
</form>