[header;no_conv]
<script language="JavaScript">
	var tier = new TTier;
	<?
	/* appel de chargement des données */
	
		if(isset($_REQUEST['id'])) {
			?>tier.get(<?=$_SESSION['UId'] ?>, <?=$_REQUEST['id'] ?>);<?
		}
	?>	
	
</script>
<table class="tableForm">
	<tr>
		<td>Nom</td>
		<td>[tier.nom]</td>
	</tr>
</table>
<input type="button" class="valider" value="Valider" name="bt_valid" />
<input type="button" class="valider" value="Valider" name="bt_valid" />
[footer;no_conv]