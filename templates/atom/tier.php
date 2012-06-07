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
[buttons;no_conv]
[footer;no_conv]