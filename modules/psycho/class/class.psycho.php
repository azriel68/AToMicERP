<?php

class TPsycho extends TContact {
	
	function __construct() {
		parent::set_table(DB_PREFIX.'psycho');

		parent::add_champs('id_contact,id_event','type=entier; index;');
		
		parent::add_champs('trust,openness,responsiveness,communication,thinking,organization,personality,efficiency,investment','type=entier;');
		
		
		
		TAtomic::initExtraFields($this);

		parent::start();
		parent::_init_vars();
	}
	
	static function hookLoad($className, $pageName, &$TParameters) {
		
		ob_start();
		
		if($className=='TContact' && $pageName=='contact/contact') {
			/*
			 * Ajout de champs dans le template contact
			 */
			 
			 /*
			* Anxious ... confident
			* Shy ... outgoing
			* Reluctant ... enthusiastic
			* Edge ... pleasant
			* Imaginative ... down to earth
			* Messy ... methodical
			* Sensitive .. debonair
			* Normal .. top
			* Normal .. top
			 */
			 $TMood=array(
			 	'trust'=>array('Anxious', 'confident')
			 	,'openness'=>array('Shy', 'outgoing')
			 	,'responsiveness'=>array('Reluctant', 'enthusiastic')
			 	,'communication'=>array('Edge', 'pleasant')
			 	,'thinking'=>array('Imaginative', 'down to earth')
			 	,'organization'=>array('Messy', 'methodical')
			 	,'personality'=>array('Sensitive', 'debonair')
			 	,'efficiency'=>array('Normal', 'top')
			 	,'investment'=>array('Normal', 'top')
			 );
			 
			
			 
			 ?><table id="psycho-hook-add" style="display:none;"><?
			 
			 foreach($TMood as $name=>$limits) {
				 ?><tr>
				 	<td><?=__tr($name) ?></td>
				 	<td colspan="2" class="psycho-slider">
				 		<span style="width:150px; display:inline-block; text-align:right;"><?=$limits[0]?></span>
				 		<div class="slider" style="display:inline-block; width:200px; margin:0 20px;"></div>
				 		<?=$limits[1] ?></td>
				 </tr><?
			 	
			 }
			 ?></table><?
			 
			?><script language="javascript">
				$('#contact').append( $('#psycho-hook-add').children() );
				
				 $(".psycho-slider > div.slider").slider({
				 	 value:3
					 ,min: 1
					 ,max: 5
					 ,slide: function( event, ui ) {
						$( "#amount" ).val( "$" + ui.value );
					 }
				 });
				
			</script><?
		}
		
		
		return ob_get_clean();
		
	}

	static function hookSave($className, $fileName, &$TParameters) {
		
		
		
	}

}
