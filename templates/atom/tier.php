[tpl.header;htmlconv=no]
<div data-role="page" id="tier" data-title="Tier">
	<form name="formTier" action="[tpl.self]" method="post">
		
		
		
			<div class="ui-grid-a">
				<div class="ui-block-a"><strong>Nom</strong> et prénom</div>
				<div class="ui-block-b"><input type="text" name="nom" value="[tier.nom;htmlconv=no]" /></div>

				<div class="ui-block-a"><strong>Adresse</strong></div>
				<div class="ui-block-b"><textarea name="adresse">[tier.adresse;htmlconv=no]</textarea></div>

				<div class="ui-block-a"><strong>Code poste</strong></div>
				<div class="ui-block-b"><input type="text" name="nom" value="[tier.cp;htmlconv=no]" maxlength="5" size="6" /></div>

				<div class="ui-block-a"><strong>Ville</strong></div>
				<div class="ui-block-b"><input type="text" name="nom" value="[tier.ville;htmlconv=no]" /></div>

				<div class="ui-block-a">Date de création</div>
				<div class="ui-block-b">[tier.dt_cre;htmlconv=no]</div>

			</div>
		
	[tpl.buttons;htmlconv=no]
	</form>
</div>
[tpl.footer;htmlconv=no]