[tpl.header;htmlconv=no]
<script language="JavaScript">
	var tier = new TTier;
	<?
	/* appel de chargement des données */
	
		if(isset($_REQUEST['id'])) {
			?>tier.get(<?=$_SESSION['UId'] ?>, <?=$_REQUEST['id'] ?>);<?
		}
	?>	
	
</script>
<table class="tableForm" border="1">
	<tr>
		<td>Nom</td>
		<td>[tier.nom]</td>
	</tr>
</table>
[tpl.buttons;htmlconv=no]
[tpl.footer;htmlconv=no]