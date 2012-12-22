[tpl.header;htmlconv=no]
<form name="formTier" action="<?=$_SERVER['PHP_SELF'] ?>">
<table class="tableForm" border="1">
	<tr>
		<td>Nom</td>
		<td><input type="text" name="nom" value="[tier.nom;htmlconv=no]" /> </td>
	</tr>
	<tr>
		<td>Adresse</td>
		<td><textarea name="adresse">[tier.adresse;htmlconv=no]</textarea></td>
	</tr>
	<tr>
		<td>Code postal</td>
		<td><input type="text" name="nom" value="[tier.cp;htmlconv=no]" /></td>
	</tr>
	<tr>
		<td>Ville</td>
		<td><input type="text" name="nom" value="[tier.ville;htmlconv=no]" /></td>
	</tr>
	<tr>
		<td>Date de création</td>
		<td><input type="text" theme-type="date" name="dt_cre" value="[tier.dt_cre;htmlconv=no]" /></td>
	</tr>
</table>
[tpl.buttons;htmlconv=no]
</form>
[tpl.footer;htmlconv=no]