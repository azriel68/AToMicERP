<?php

class TPsycho extends TContact {
	
	function __construct() {
		parent::set_table(DB_PREFIX.'psycho');

		parent::add_champs('id_contact,id_event','type=entier; index;');
		
		parent::add_champs('trust,openness,responsiveness,communication,thinking,organization,personality,efficiency,investment','type=entier;');
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
			
		
		
		TAtomic::initExtraFields($this);

		parent::start();
		parent::_init_vars();
	}
	
	function loadByContact(&$db, $id_contact) {
		
		return $this->loadBy($db, $id_contact, 'id_contact');
		
	}
	
	static function hook($className, $pageName, &$TParameters) {
		
		ob_start();
		
		if($className=='TContact' && $pageName=='contact/contact') {
			/*
			 * Ajout de champs dans le template contact
			 */
			 $contact = & $TParameters['object'];
			 
			 $db=new TPDOdb;
			 
			 $psycho=new TPsycho;
			 $psycho->loadByContact($db, $contact->id);
			 $psycho->id_contact =  $contact->id;
			 
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
			 
			 if($TParameters['action']=='save') {
			 	
				foreach ($TMood as $name => $limits) {
						
					if(!empty($_REQUEST[$name])) $psycho->{$name} = $_REQUEST[$name];
					 
				}
				
				$psycho->save($db);
			 }
			 
			 $JScategories = ''; $JSvalues='';
			 foreach($TMood as $name=>$limits) {
			 	if(!empty($JScategories))$JScategories.=',';
			 	 $JScategories.="'".__tr($name)."'";
				
				 if(!empty($JSvalues))$JSvalues.=',';
				 $JSvalues .= $psycho->{$name};
			 }
			 
			 ?><table id="psycho-hook-add" style="display:none;"><?
			 
			 $first=true;$TPsychoValue=array();
			 foreach($TMood as $name=>$limits) {
			 	
				 
				
				 ?><tr><?
				 
				 	
				 	?><td><?=__tr($name) ?></td>
				 	<td class="psycho-slider">
				 		<span id="<?=$name ?>-min-bound" style="width:150px; display:inline-block; text-align:right;"><?=$limits[0]?></span>
				 		<div rel="<?=$name ?>" init-value="<?=$psycho->{$name}?>" class="slider" style="background-color: #333;display:inline-block; width:200px; margin:0 20px;"></div>
				 		<span id="<?=$name ?>-max-bound"><?=$limits[1] ?></span>
				 		<input type="hidden" name="<?=$name ?>" id="<?=$name ?>" value="<?=$psycho->{$name}?>" />
				 		</td><?
				 		
				 	if($first) {
				 		
						?><td rowspan="<?=count($TMood) ?>" align="center">
			 			<div id="psycho-profile">
			 				<script type="text/javascript" src="<?=HTTP.'modules/psycho/js/showSpider.php?values='.urlencode($JSvalues).'&categories='.urlencode($JScategories) ?>"></script>
			 			</div>
			 			</td><?
					 	$first=false;	
				 	}	
				 	
				 ?></tr><?
			 }

/*
		 		?><td colspan="3">
		 			<div id="psycho-profile">
		 				<script type="text/javascript" src="<?=HTTP.'modules/psycho/js/showSpider.php?values='.urlencode($JSvalues).'&categories='.urlencode($JScategories) ?>"></script>
		 			</div>
		 		</td><?
	*/			 		
				 		


			 ?></table><?
			 
			?><script language="javascript">
				$('#contact').append( $('#psycho-hook-add').children() );
				
				 $(".psycho-slider > div.slider").slider({
				 	 value:3
					 ,min: 1
					 ,max: 5
					 ,animate: "fast"
					 ,handle: '#myhandle'
					 ,slide: function( event, ui ) {
					 	var val = ui.value;
					 	$('#'+$(this).attr('rel')).val( val  );
					 	sliderBoundFont( $(this).attr('rel'), val );
					 }
					 ,create: function( event, ui ) {
					 	var val = $(this).attr('init-value');
					 	$(this).slider('value', val);
					 	sliderBoundFont( $(this).attr('rel'), val );					 	
					 }
				 });
				
				<?
				
				if($TParameters['action']!='edit') {
					?>$(".psycho-slider > div.slider").slider({ disabled: true });<?
				}
				
				?>
				
				function sliderBoundFont(name, val) {
					
					$('#'+name+'-max-bound').css('font-size', (100-((3-val)*5))+'%' );
					$('#'+name+'-min-bound').css('font-size', (100+((3-val)*5))+'%' );
					
				}
				
				
				
			</script>
			
			<?
		}
		
		
		$db->close();
		
		return ob_get_clean();
		
	}

	
}
