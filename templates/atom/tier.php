[tpl.header;htmlconv=no]
<script language="JavaScript">
	var tier = new TTier;
	tier.get(UId, idTier);
</script>

<form name="formTier" action="#">
<table class="tableForm" border="1">
	<tr>
		<td>Nom</td>
		<td>[tier.nom;htmlconv=no]</td>
	</tr>
	<tr>
		<td>Adresse</td>
		<td>[tier.adresse;htmlconv=no]</td>
	</tr>
	<tr>
		<td>Code postal</td>
		<td>[tier.cp;htmlconv=no]</td>
	</tr>
	<tr>
		<td>Ville</td>
		<td>[tier.ville;htmlconv=no]</td>
	</tr>
	<tr>
		<td>Date de création</td>
		<td>[tier.dt_cre;htmlconv=no]</td>
	</tr>
</table>

[tpl.buttons;htmlconv=no]
</form>
[tpl.footer;htmlconv=no]