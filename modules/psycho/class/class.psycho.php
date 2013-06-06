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

}
