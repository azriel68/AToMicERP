<?php
	
	require('../../inc.php');
	
	$get = isset($_REQUEST['get'])?$_REQUEST['get']:'';
	$put = isset($_REQUEST['put'])?$_REQUEST['put']:'';
	
	_get($get);
	_put($put);

	function _get($case) {
		switch ($case) {
			case 'all_events':
				__out(_get_all_events($_REQUEST['planning'],$_REQUEST['dt_deb'],$_REQUEST['dt_fin']));			
				break;
			case 'get_event':
				__out(_get_event($_REQUEST['id_event']));			
				break;
			case 'all_users':
				__out(_get_all_users());
				break;
			case 'gel_all_user_rights':
				__out(_gel_all_user_rights($_REQUEST['planning']));
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
				__out(_update_event($_REQUEST['id_event'], $_REQUEST['TEvent_data']));
				break;
			case 'update_date_event':
				__out(_update_event($_REQUEST['id_event'], $_REQUEST['TEvent_data'], $_REQUEST['only_date']));
				break;
			case 'add_user_right':
				__out(_add_user_rights($_REQUEST['tag'],$_REQUEST['type'],$_REQUEST['planning']));
				break;
			case 'del_user_right':
				__out(_del_user_rights($_REQUEST['right']));
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
	function _get_all_events($id_planning,$dt_deb, $dt_fin){
		
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
				  AND id_planning = ".$id_planning."
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
			
			foreach($TChamps as $cle=>$champ){
				$TEvent_data[$cle] = $event->$cle;
			}
			$TEvent_data['id'] = $event->id;
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
		
		return ($id_event > 0) ? $id_event : 0;
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
	function _update_event($id_event,$TEvent_data,$only_date=false){
		global $user;
		$db = new TPDOdb;
		$event = new TEvent;
		//echo $TEvent_data['date']; exit;
		if($event->load($db,$id_event)){
			if($only_date){
				$diff_dates = __diff_date($event->dt_deb, $event->dt_fin*1000);
				$event->dt_deb = date_format(date_modify(new DateTime(date("Y-m-d H:i:s",$event->dt_deb)),__diff_date($event->dt_deb,$TEvent_data['date'])),"U");
				$event->dt_fin = date_format(date_modify(new DateTime(date("Y-m-d H:i:s",$event->dt_deb)),$diff_dates),"U");
			}
			else{
				$event->dt_deb = $TEvent_data['dt_deb'];
				$event->dt_fin = $TEvent_data['dt_fin'];
				$event->id_entity = $user->id_entity;
				$event->id_status = $TEvent_data['status'];
				$event->label = $TEvent_data['label'];
				$event->note = $TEvent_data['note'];
				$event->id_planning = $TEvent_data['id_planning'];
				$event->bgcolor = $TEvent_data['bgcolor'];
				$event->txtcolor = $TEvent_data['txtcolor'];
			}
			
			$id_event = $event->save($db);
			$db->close();
			
			return $id_event;
		}
		else{
			return 0;
		}
	}
	
	function __diff_date($date1,$date2){
		$date1 = new DateTime(date("Y-m-d",$date1));
		$date2 = new DateTime(date("Y-m-d",$date2/1000));
		$interval = $date1->diff($date2);
		return $interval->format('%R%a days');
	}
	
	
	/*
	 * Retourne la liste utilisateurs
	 * return tab[]
	 */
	function _get_all_users(){
		global $user;
		$sql = "SELECT u.id, u.login FROM ".DB_PREFIX."contact u 
				LEFT JOIN ".DB_PREFIX."contact_to_object cto ON (u.id = cto.id_contact)
				LEFT JOIN ".DB_PREFIX."company c ON (c.id = cto.id_object AND cto.objectType = 'company')
				LEFT JOIN ".DB_PREFIX."group_user gu ON (u.id = gu.id_user)
				LEFT JOIN ".DB_PREFIX."group_entity ge ON (ge.id_group = gu.id_group)
						WHERE ge.id_entity IN (".$user->getEntity().")";
		
		$db = new TPDOdb;
		$db->Execute($sql);
		$TUsers = array();
		while($db->Get_line())
			$TUsers[] = $db->Get_field('id').".".$db->Get_field('login');
		
		return $TUsers;
	}
	
	/*
	 * Ajoute un droit utilisateur sur un planning
	 */
	function _add_user_rights($id_tag,$type,$id_planning){
		global $user;
				
		$db = new TPDOdb;
		$right = new TPlanningRights;
		
		$right->id_entity= $user->getEntity();
		$right->id_planning= $id_planning;
		
		switch ($type) {
			case 'admin':
				$right->reader = 1;
				$right->writer = 1;
				$right->admin = 1;
				$type = 'admintags';
				break;
			case 'modifieur':
				$right->reader = 1;
				$right->writer = 1;
				$right->admin = 0;
				$type = 'modtags';
				break;
			case 'lecteur':
				$right->reader = 1;
				$right->writer = 0;
				$right->admin = 0;
				$type = 'lectags';
				break;
		}
		
		$right->id_user = $id_tag;
		
		$id_right = __right_exist($id_tag,$id_planning);
		if($id_right!= "error")
			return array('type' => $type, 'id_right' => $id_right);
		
		$right->save($db);
		if($right->id>0)
			return $tab = array('type' => $type, 'id_right' => $right->id);
		else
			return "error";
		
	}
	
	/*
	 * Vérifie si un droit utilisateur a déjà été renseigner pour le planning passé en paramètre
	 */
	 
	 function __right_exist($id_tag,$id_planning){
	 	$db = new TPDOdb;
		$db->Execute("SELECT id FROM ".DB_PREFIX."planning_rights WHERE id_user = ".$id_tag." AND id_planning = ".$id_planning);
		if($db->Get_line())
			return $db->Get_field('id');
		else
			return TRUE;
	 }
	
	/*
	 * Supprime un droit utilisateur
	 */
	
	function _del_user_rights($id_right){
		global $user;
		
		$db = new TPDOdb;
		$right = new TPlanningRights;
		
		if($right->load($db,$id_right))
			$right->delete($db);
		else
			return "error";
	}
	
	
	/*
	 * Supprime un droit utilisateur
	 */
	
	function _gel_all_user_rights($id_planning){
		global $user;
		
		$db = new TPDOdb;
		
		$sql = "SELECT u.login, pr.reader, pr.writer, pr.admin
				FROM ".DB_PREFIX."planning_rights pr LEFT JOIN ".DB_PREFIX."contact u ON (u.id = pr.id_user)
				WHERE id_planning = ".$id_planning;
		
		$db->Execute($sql);
		
		while($db->Get_line()){
			$TPlanning_rights[$db->Get_field('login')] = array('reader' => $db->Get_field('reader'), 'writer' => $db->Get_field('writer'), 'admin' => $db->Get_field('admin'));
		}
		
		return $TPlanning_rights;
	}
	
	
	
	