<?php
	
	require('../../inc.php');
	
	$get = isset($_REQUEST['get'])?$_REQUEST['get']:'';
	$put = isset($_REQUEST['put'])?$_REQUEST['put']:'';
	
	_get($get);
	_put($put);

	function _get($case) {
		switch ($case) {
			case 'all_events':
				__out(_get_all_events($_REQUEST['dt_deb'],$_REQUEST['dt_fin']));			
				break;
			case 'event':
				__out(_get_event($_REQUEST['id_event']));			
				break;
		}
		
	}
	
	function _put($case) {
		
		switch ($case) {
			case 'add_event':
				__out(_add_event($_REQUEST['TEvent_data']));
				break;
			case 'del_event':
				__out(_del_event($_REQUEST['id_event']));
				break;
			case 'update_event':
				__out(_update_event($_REQUEST['id_event']), $_REQUEST['TEvent_data']);
				break;
		}
	}
	
	/*
	 * Récupération de l'ensemble des évènements pour le mois en cours
	 * 
	 * return TEvents_data 
	 * 			array{
	 * 				[id_event] {
	 * 					[champ1] => valchamp1
	 * 					[champ2] => valchamp2
	 * 					...
	 * 				}
	 * 				...
	 * 			}
	 */
	function _get_all_events($dt_deb, $dt_fin){
		
		global $user;
		$db = new TPDOdb;
		$event = new TEvent;
		$TChamps = $event->get_champs();
		$sql = "SELECT id,";
		
		foreach($TChamps as $cle=>$champ){
			$sql .= " ".$cle.",";
		}
		$sql = substr($sql,0,strlen($sql)-1);
		
		$sql .= " FROM ".DB_PREFIX."event
				 WHERE dt_deb >= '".$dt_deb."' AND dt_fin <= '".$dt_fin."'
				  AND id_entity = ".$user->id_entity."
				 ORDER BY dt_deb ASC";
				  
		$db->Execute($sql);
		$TEvents_data = array();
		While($db->Get_line()){
			foreach($TChamps as $cle=>$champ){
				$TEvents_data[$db->Get_field('id')][$cle] = (substr($cle, 0,2) == 'dt') ? date_format(new DateTime($db->Get_field($cle)),"U") : $db->Get_field($cle) ;
			}
		}
		return $TEvents_data;
	}
	
	/*
	 * Récupération d'un event spécifique
	 * 
	 * return TEvent_data => ok
	 * 		       0 	  => erreur
	 */
	function _get_event($id_event){
		
		$db = new TPDOdb;
		$event = new TEvent;
		
		if($event->load($db,$id_event)){
			$TChamps = $event->get_champs();
			
			foreach($TChamps as $champ){
				$TEvent_data[$champ] = $event->$champ;
			}
			$db->close();
			
			return $TEvent_data;
		}
		else{
			return 0;
		}
	}
	
	/*
	 * Ajout d'un event
	 * 
	 * return 0 = erreur
	 * 		  1 = ok
	 */
	function _add_event($TEvent_data){
		global $user;
		$db = new TPDOdb;
		$event = new TEvent;
		echo $TEvent_data['bgcolor']." ".$TEvent_data['txtcolor'];
		
		$event->id_entity = $user->id_entity;
		$event->id_status = $TEvent_data['status'];
		$event->label = $TEvent_data['label'];
		$event->note = $TEvent_data['note'];
		$event->dt_deb = $TEvent_data['dt_deb'];
		$event->dt_fin = $TEvent_data['dt_fin'];
		$event->id_planning = $TEvent_data['id_planning'];
		$event->bgcolor = $TEvent_data['bgcolor'];
		$event->txtcolor = $TEvent_data['txtcolor'];
		
		$id_event = $event->save($db);
		$db->close();
		
		return ($id_event > 0) ? 1 : 0;
	}
	
	/*
	 * Suppression d'un event spécifique
	 * 
	 * return 0 = erreur
	 * 		  1 = ok
	 */
	function _del_event($id_event){
		$db = new TPDOdb;
		$event = new TEvent;
		
		if($event->load($db,$id_event)){
			$event->delete($db);
			$db->close();
			
			return 1;
		}
		else{
			return 0;
		}
	}
	
	/*
	 * MAJ d'un event spécifique
	 * 
	 * return 0 = erreur
	 * 		  1 = ok
	 */
	function _update_event($id_event,$TEvent_data){
		global $user;
		$db = new TPDOdb;
		$event = new TEvent;
		
		if($event->load($db,$id_event)){
			$event->id_entity = $user->id_entity;
			$event->id_status = $TEvent_data['status'];
			$event->label = $TEvent_data['label'];
			$event->note = $TEvent_data['note'];
			$event->dt_deb = $TEvent_data['dt_deb'];
			$event->dt_fin = $TEvent_data['dt_fin'];
			$event->id_planning = $TEvent_data['id_planning'];
			
			$id_event = $event->save($db);
			$db->close();
			
			return ($id_event > 0) ? 1 : 0;
		}
		else{
			return 0;
		}
	}