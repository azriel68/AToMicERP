<?

class TObjetStd{
     
	function TObjetStd(){
		$this->table=''; /* table contenant les données */
		$this->id=0; /* clef primaire */
		$this->dt_cre=time();
		$this->dt_maj=time();
		$this->TChamps=array(); /* tableau contenant la déclaration de variables */
		$this->TNoSaveVars=array(); /* tableau des variables à charger mais pas à sauvegarder */
		$this->TList=array(); /* tableau permettant la conturction d'une liste */ 
	}
	function set_table($nom_table){
    	$this->table=$nom_table;
    }
	function add_champs($nom, $infos=""){
    
	    if($nom!=""){
	        $var = explode(",", $nom);
	        $nb=count($var);
	        for ($i=0; $i<$nb ; $i++) {
	        	$this->TChamps[trim($var[$i])] = strtolower($infos);
	        } // for
    	}
    
  	}
  function get_table(){
    return $this->table;
  }
	function get_champs(){
    return $this->TChamps;
  }
	function _get_field_list(){
    $r="";
    foreach ($this->TChamps as $nom_champ=>$info) {
    	$r.=$nom_champ.",";    	
    }
    return $r;
  }
  function _set_vars_by_db(&$db){
  
    foreach ($this->TChamps as $nom_champ=>$info) {
      if($this->_is_date($info)){
        $this->{$nom_champ} = strtotime($db->Get_field($nom_champ));
      }
      elseif($this->_is_tableau($info)){
        $this->{$nom_champ} = unserialize($db->Get_field($nom_champ));
      }
      elseif($this->_is_int($info)){
        $this->{$nom_champ} = (int)$db->Get_field($nom_champ);
      }
			elseif($this->_is_float($info)){
				$this->{$nom_champ} = floatval($db->Get_field($nom_champ));
			} 
      else{
        $this->{$nom_champ} = $db->Get_field($nom_champ);
      }
    	
    }
  
  }
  function _no_save_vars($lst_chp) {
  		if($lst_chp!=""){
  			$this->TNoSaveVars=array();
				$var = explode(",", $lst_chp);
        $nb=count($var);
        for ($i=0; $i<$nb ; $i++) {
        	$this->TNoSaveVars[trim($var[$i])]=true;
        } // for
      }
  }
  function init_vars_by_db(&$db) {
  	$db->Execute("SHOW COLUMNS FROM ".$this->get_table()."");
	while($db->Get_line()) {
		$nom = strtolower($db->Get_field('Field'));
		$type_my = $db->Get_field('Type');
		
		if(strpos($type_my,'int(')!==false) $type='type=entier;';
		else if(strpos($type_my,'date')!==false) $type='type=date;';		
		else $type='type=chaine;';		
		
		$this->add_champs($nom, $type);		
	}
	
	
	$this->_init_vars();
  }
  function _init_vars($lst_chp=""){
      
      if($lst_chp!=""){
        $var = explode(",", $lst_chp);
        $nb=count($var);
        for ($i=0; $i<$nb ; $i++) {
        	$this->add_champs($var[$i]);
        } // for
      }
  
      $first = true;
  
      foreach ($this->TChamps as $nom_champ=>$info) {
      
          if($first) {
            $this->champs_indexe = $nom_champ;$first=false;
          }
      
          if($this->_is_date($info)){
            $this->{$nom_champ} = time();
          }
          elseif($this->_is_tableau($info)){
            $this->{$nom_champ} = array();
          }
          elseif($this->_is_int($info)){
            $this->{$nom_champ} = 0;
          }
          elseif($this->_is_float($info)) {
					$this->{$nom_champ} = 0.0;
					}
          else{
            $this->{$nom_champ} = "";
          }
      }  
  }
  
  function get_date($nom_champ,$format_date="d/m/Y") {
    return date($format_date, $this->{$nom_champ});
  }
  
  function set_date($nom_champ,$date){
  	
  	
  	if(strpos($date,'/')===false) $this->{$nom_champ} = strtotime($date);
  	else {
			list($d,$m,$y) = explode("/",$date);
			$this->{$nom_champ} = mktime(0,0,0,$m,$d,$y);
		}
		return $this->{$nom_champ};
	}
	
  function _is_date($info){
    $pos = strpos($info,"type=date;");
    if($pos===false)return false;
    else return true;
  }
  function _is_tableau($info){
    $pos = strpos($info,"type=tableau;");
    if($pos===false)return false;
    else return true;
  }
  
  function _is_int($info){
    $pos = strpos($info,"type=entier;");
    if($pos===false)return false;
    else return true;
  }
  function _is_float($info){
		$pos = strpos($info,"type=float;");
		if($pos===false) return false;
		else return true;
	}
  function _set_save_query(&$query){
    foreach ($this->TChamps as $nom_champ=>$info) {
    
     // /* modification des dates au format fran�ais vers un format anglais
     // (format d'enregistrement des dates dans la base)
     
     	if(isset($this->TNoSaveVars[$nom_champ])) {
				null; // ne pas sauvegarder ce champs 
			}
      elseif(!strcmp($nom_champ,'idx')) {
        $query[$nom_champ] = ctype_alpha($this->{$this->champs_indexe}[0])?$this->{$this->champs_indexe}[0]:'0'; 
      }
      else if($this->_is_date($info)){
        $query[$nom_champ] = date("Y-m-d H:i:s",$this->{$nom_champ});
      }
      else if($this->_is_tableau($info)){
        $query[$nom_champ] = serialize($this->{$nom_champ});
      }
      else{
        $query[$nom_champ] = $this->{$nom_champ};
      }
      
    	
    }
  }
  
  function start(){
  
     $this->id = 0; // le champ id est toujours def   
     $this->dt_cre=time(); // ces champs dates aussi
	 $this->dt_maj=time();
  }
  
	function load(&$db,$id){
		if((int)$id==0) return false;
			
		$db->Execute("SELECT ".$this->_get_field_list()."dt_cre,dt_maj 
				FROM ".$this->get_table()." WHERE id=".$id);
		if($db->Get_line()) {
				$this->id=$id;
				
				$this->_set_vars_by_db($db);
		    
		    $this->dt_cre=strtotime($db->Get_field('dt_cre'));
				$this->dt_maj=strtotime($db->Get_field('dt_maj'));
				
				return true;		
		}
		else {
				return false;
		}
	}
	function save(&$db){
		
			if(isset($this->to_delete) && $this->to_delete==true) {
				$this->delete($db);			
			}
			else {
	      $query=array();
	      
	      $query['dt_cre']=date("Y-m-d H:i:s",$this->dt_cre);
				$query['dt_maj']=date("Y-m-d H:i:s");
				
				$this->_set_save_query($query);
				
				$key[0]='id';
				
				if($this->id==0){
					$this->get_newid($db);
					$query['id']=$this->id;
					$db->dbinsert($this->get_table(),$query);
				}
				else {
					$query['id']=$this->id;
					$db->dbupdate($this->get_table(),$query,$key);		
				}
			
			}
		
			
		
	}
	function delete(&$db){
		if($this->id!=0){
			$db->dbdelete($this->get_table(),array("id"=>$this->id),array(0=>'id'));
		}
	}
	function get_newid(&$db){
		$sql="SELECT max(id) as 'maxi' FROM ".$this->get_table();
		$db->Execute($sql);
		$db->Get_line();
		$this->id = (double)$db->Get_field('maxi')+1;
	}
	function get_dtcre(){
		return $this->get_date('dt_cre','d/m/Y');
	}
	function get_dtmaj(){
		return $this->get_date('dt_maj','d/m/Y');
	}
	function set_dtcre($date){
		$this->set_date('dt_cre', $date);	
			
	}
	function set_dtmaj($date){
		$this->set_date('dt_maj', $date);	
	}
	
	function get_tab() {
		$Tab=array();
		
		foreach ($this as $key=>$value) {
  		if($key=='TChamps' || is_array($value) ) null;
			else if(substr($key,0,3)=='dt_')$Tab[$key]=date('Y-m-d H:i:s',$value);
			else $Tab[$key]=$value;
    }
    
    return $Tab;
	}
	function set_values($Tab) {
	
		foreach ($Tab as $key=>$value) {
   		
   		 if($key[0]=='T') { // tableau non trait� automatiquement
					 null;
			 }
   		 else if(substr($key,0,3)=='dt_') {
					 $this->set_date($key, $value);
			 }
			 else if(isset($this->{$key})) {
			 		$this->{$key}=stripslashes($value);
			 }
			
    }
	
	}
	
	function get_i_tab_by_id($tab, $id) {
	// retourne i tab objet
		$Tab = &$this->{$tab};
		
		$nb=count($Tab);
		
	  for ($i=0; $i<$nb; $i++) {
	  		if($Tab[$i]->id==$id) return $i;
	  }
	
	
	}
	
	
	function liste($TList=array()) {
		
			if(!empty($TList)) $this->TList = $TList;
		
			$form=new TForm;
	
			echo "<p align=\"center\">";	
			echo $form->bt("Nouveeau",'bt_new','onClick="document.location.href=\''.$_SERVER['PHP_SELF'].'?action=NEW\'"');
			echo "</p>";
		 
			$listname = "list".$this->get_table();
			$lst = new Tlistview($listname);
			
		    $ordertype = isset($_REQUEST["orderTyp"])?$_REQUEST["orderTyp"]:"D";
		    $pagenumber = isset($_REQUEST["pageNumber"])?$_REQUEST["pageNumber"]:0;
		 	$ordercolumn = isset($_REQUEST["orderColumn"])?$_REQUEST["orderColumn"]:'Création' ;
		
			$lst->Set_nbLinesPerPage(30);
				
			$sql="SELECT id as 'ID', dt_cre as 'Création', dt_maj as 'Modification' 
			FROM ".$this->get_table();	
				
		 	$lst->Set_query($sql);
			$lst->Load_query($ordercolumn,$ordertype);
			$lst->Set_pagenumber($pagenumber);
			$lst->Set_Key("ID",'id');
			
			$lst->Set_columnType('Création', 'DATE');
			
			$lst->Set_OnClickAction('OpenForm',$_SERVER['PHP_SELF'].'?action=VIEW');
			 
			echo "<h1>Liste</h1>";
			
			echo $lst->Render(); 	
		 
		
		
	}
	
}

/*
 * Simple Standard Objet
 */
class TSSObjet extends TObjetStd {
	function TSSObjet(&$db, $table) {
		parent::set_table($table);
		
		parent::init_vars_by_db($db);
		
		parent::start();
	}
	
	function view_file_source() {
		$table = $this->get_table();
		
		$pos = strpos($table,'_');
		if($pos!==false) $objname = substr($table, $pos+1);
		else $objname = $table;
		
		$objname = 'T'.ucfirst(strtolower($objname));
		$TNot=array('id','dt_cre','dt_maj');
		
		$TChp = array();
		foreach($this->TChamps as $champs=>$type) {
			if(!in_array($champs, $TNot)) {
				if(!isset($TChp[$type]))$TChp[$type]='';
				if($TChp[$type]!='')$TChp[$type].=',';
				$TChp[$type].=$champs;
			}	
		}
		
		$cr= "\r\n";
		ob_start();
		
		print '<?'.$cr;
		print 'class '.$objname.' extends TObjetStd {'.$cr;
		print '	function '.$objname.'() { /* déclaration */'.$cr;
		print '		parent::set_table(\''.$table.'\');'.$cr;

		foreach($TChp as $type=>$champs) {
			print '		parent::add_champs(\''.$champs.'\',\''.$type.'\');'.$cr;				
		}

		print '		parent::start();'.$cr;
		print '		parent::_init_vars();'.$cr;
		print '	}';

		
		
		
		print '}'.$cr;
		print '?>'.$cr;		
		
		
		print '<pre>'.htmlentities(ob_get_clean()).'</pre>';
		
	}
	
}

?>
