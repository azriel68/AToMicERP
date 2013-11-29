<?php
/*
* @author eric.moleon@club-internet.fr 2003
* 
*/

Class TFormCore {
var $type_aff='FORM'; //Type d'affichage du formulaire (FORM / VIEW )


//
var $js_validation=''; 


var $trans=array("\""=>'&quot;');
 /**
  * constructeur de la classe form
  * 
  * @return Form
  * @param pMethod String
  * @param pAction String
  * @param pName String
  * @desc constructeur de la classe form
  */
  
function __construct($pAction=null,$pName=null,$pMethod="POST",$pTransfert=FALSE,$plus=""){
// Modifié par AA 16/09/2004
// Je ne veux pas de cr�ation de formulaire syst�matique	
	if (!empty($pName)) {
	    echo '<form method="'.$pMethod.'"' ;
	    if ($pTransfert)
	      echo ' ENCTYPE = "multipart/form-data"'; 
		if($plus)  echo " $plus ";
	    
		if($pAction=='auto')$pAction=$_SERVER['PHP_SELF'];
		
	    echo ' action="'.$pAction.'"';
	    echo ' id="'.$pName.'"';
	    echo ' name="'.$pName.'">';
	}
	
	// propriété de comparaison de string stricte si besoin!	
	$this->strict_string_compare = false;
}





/*
 * fonction qui permet de récupérer un champ texte
 * 
 * @param pLib : libellé
 * @param pName : Nom
 * @param pVal : Valeur
 * @param pTaille : Taille
 * 
 */
 
function texte($pLib,$pName,$pVal,$pTaille,$pTailleMax=0,$plus='',$class="text", $default=''){
  $lib="";
  $field="";
  if ($pLib!="")
    $lib   = "<label for=".$pName.">$pLib</label>";
  if ($pTailleMax==0) 
     $pTailleMax=$pTaille;
  if ($this->type_aff!='view'){
  	$field='<input class="'.$class.'" type="text" id="'.$pName.'" name="'
  	.$pName.'" value="'.strtr($pVal,$this->trans).'" size="'.$pTaille.'" maxlength="'
  	.$pTailleMax.'" '.$plus.'>'."\n";  
  
 }
  else
    $field = ($pVal=='')?$default:strtr($pVal,$this->trans)." \n ";
//    $field = $pVal;
  if ($lib != '')
    return $lib." ".$field;
  else
    return $field;
}


function calendrier($pLib,$pName,$pVal,$pTaille=12,$pTailleMax=10,$plus='',$class='text',$format='d/m/Y'){
  /* jquery datepicker requis */
  
  $id = strtr($pName,array('['=>'_', ']'=>'_'));
  
  
  if(empty($pVal)) {
  	$dateValue='';
  }
  elseif(strpos($pVal,'-')!==false || strpos($pVal,'/')!==false ) {
  		$dateValue = $pVal;
  }
  else {
  		$dateValue =  date($format,$pVal);
  }
  
  
  $lib="";
  $field="";
  if ($pLib!="")
    $lib   = "<b> $pLib </b>";
  if ($pTailleMax==0) 
     $pTailleMax=$pTaille;
  if ($this->type_aff!='view'){
    $field = '<input class="'.$class.' datepicker" TYPE="TEXT" id="'.$id.'" name="'.$pName.'" value="'.$dateValue.'" SIZE="'.$pTaille.'" MAXLENGTH="'.$pTailleMax.'" '.$plus.'> ';
  
    
    $field .= '<script type="text/javascript">
               $(function() {
  			        $( "#'.$id.'" ).datepicker({
  			        	 showAnim: ""
  			        	 ,constrainInput: true
  			        	 ,changeYear: true
  			        	 ,autoSize: false 
					});
  			    });
               </script>';
  }
  else {
  		$field = $dateValue;
  }
    


  if ($lib != '')
    return $lib." ".$field;
  else
    return $field;
}


/*
 * fonction qui permet de récupérer un textarea
 * 
 * @param pLib : libellé
 * @param pName : Nom
 * @param pVal : Valeur
 * @param pTaille : Taille
 * 
 */
function zonetexte($pLib,$pName,$pVal,$pTaille,$pHauteur=5,$plus='',$class='text',$pId=''){
  $lib="";
  $field="";
  
  if($pId==''){
	$pId = $pName;
  }
  
  if ($pLib!=""){
    $lib   = "<b> $pLib </b>";
  }
  
  if ($this->type_aff!='view'){
  	$field = "<textarea class='$class' name=\"$pName\" id=\"$pId\" cols=\"$pTaille\" rows=\"$pHauteur\" $plus>$pVal</textarea>\n";
  }
  else{
  	$field = $pVal;
  }
//    $field = $pVal;
  if ($lib != ''){
    return $lib." ".$field;
  }
  else{
    return $field;
  }
}



function fichier($pLib,$pName,$pVal,$pTaille,$pTailleMax=0,$plus='',$class='text',$id=''){
  $lib="";
  $field="";
  if ($pLib!="")
    $lib   = "<b> $pLib </b>";
  if ($pTailleMax==0) 
     $pTailleMax=$pTaille;
  
  if($id=='')$id=$pName;
  
  if ($this->type_aff!='VIEW')
    $field = "<INPUT id='$id' class='$class' TYPE='FILE' NAME='$pName' VALUE=\"$pVal\" SIZE='$pTaille' MAXLENGTH='$pTailleMax' $plus>\n ";
  else
    $field = "<INPUT id='$id' class='text_view' TYPE='TEXT' READONLY TABINDEX=-1 NAME='$pName' VALUE=\"$pVal\" SIZE='$pTaille' MAXLENGTH='$pTailleMax'>\n ";
//    $field = $pVal;
  if ($lib != '')
    return ''.$lib.' '.$field;
  else
    return $field;
}

function texteRO($pLib,$pName,$pVal,$pTaille,$pTailleMax=0, $plus=""){
  $lib="";
  $field="";
  if ($pLib!="")
    $lib   = "<b> $pLib </b>";
  if ($pTailleMax==0) 
     $pTailleMax=$pTaille;
  if ($this->type_aff!='view')
      $field = "<INPUT class='text_readonly' TYPE='TEXT' READONLY TABINDEX=-1 NAME='$pName' VALUE=\"".strtr($pVal,$this->trans)."\" SIZE='$pTaille' MAXLENGTH='$pTailleMax' $plus>\n ";
  else
    $field = ($pVal=='')?$default:strtr($pVal,$this->trans)." \n ";
//      $field = $pVal;
  if ($lib != '')
    return $lib." ".$field;
  else
    return $field;
}

function filetexteRO($pFile,$pLib,$pName,$pVal,$pTaille,$pTailleMax=0, $plus=""){
global $app;
  $lib="";
  $field="";
  if ($pLib!="")
    $lib   = "<b> $pLib </b>";
  if ($pTailleMax==0) 
     $pTailleMax=$pTaille;
  if ($this->type_aff!='VIEW'){
      $field = "<INPUT class='text_readonly' TYPE='TEXT' READONLY TABINDEX=-1 NAME='$pName' VALUE=\"$pVal\" SIZE='$pTaille' MAXLENGTH='$pTailleMax' $plus>\n ";
  }
  else if ($pVal=="") {
  		$field = "<b>Aucun fichier li�</b>";
           
  }
  else {
    	$field = "<a class=lienquit href=\"javascript:showPopup('../dlg/get_file.php','','$pFile',400,400);\">".$pVal."</a>";
  }
//      $field = $pVal;
  if ($lib != '')
    return $lib." ".$field;
  else
    return $field;
}

function memo($pLib,$pName,$pVal,$pLig,$pCol, $plus=""){
  $lib="";
  $field="";
  if ($pLib!="")
    $lib   = "<b> $pLib </b><br>";
  if ($this->type_aff!='VIEW')
      $field ="<TEXTAREA Class='text' NAME='$pName' ROWS='$pLig' COLS='$pCol' $plus>$pVal</TEXTAREA>\n";
  else
      $field ="<TEXTAREA Class='text_view' NAME='$pName' READONLY TABINDEX=-1 ROWS='$pLig' COLS='$pCol'>$pVal</TEXTAREA>\n";
//      $field = nl2br($pVal);

  if ($lib != '')
    return $lib." ".$field;
  else
    return $field;
}



function password($pLib,$pName,$pVal,$pTaille,$pTailleMax=0, $plus="" ,$class="text",$pId=""){
  $lib="";
  $field="";

  if($pId=="")$pId=$pName;
  
  if ($pLib!=""){
    $lib   = "<label for=".$pId.">$pLib</label>";
  }
  if ($pTailleMax==0) 
     $pTailleMax=$pTaille;
  $field = '<input class="'.$class.'" TYPE="PASSWORD" id="'.$pId.'" NAME="'.$pName.'" VALUE="'.$pVal.'" SIZE="'.$pTaille.'" MAXLENGTH="'.$pTailleMax.'"  '.$plus.' />';
  return $lib." ".$field;
}


function combo($pLib,$pName,$pListe,$pDefault,$pTaille=1,$onChange='',$plus='',$class='flat',$id='',$multiple='false'){
// AA : 16/09/2004
// Ajout du onChange

	if(empty($pListe)) return '[Liste de valeur manquante]';

	$lib="";
	$field="";
		
    if($id=='')$id=$pName;
    
	if ($pLib!="")
	  //$lib   = "<b> $pLib </b>";
	 $lib   = "<label for=".$id.">$pLib</label>";
	
	$field = '<SELECT NAME="'.$pName.'"';
	
	$field.=' id="'.$id.'"';
  
	if ($onChange!='') {
	  $field.=" onChange=\"".$onChange."\"";
	}
	if($class!=''){
		$field.=' class="'.$class.'"';
	}
	
	if($pTaille!='1'){
		$field.=' SIZE="'.$pTaille.'" ';
	}
	
	if($plus!=''){
		$field.=" ".$plus;
	}
	
	
	$field.=">\n";
	$field.="<!-- options -->";
  	
  	$field.=$this->_combo_option($pListe, $pDefault);
	
  $field .="</SELECT>";
 
  if ($this->type_aff =='view'){	  
    if (isset($pListe["$pDefault"])) $val=$pListe["$pDefault"]; else $val="";  
   // $field = "<INPUT class='text_view' TYPE='TEXT' READONLY TABINDEX=-1 NAME='$pName' VALUE=\"$val\" SIZE='$pTaille'>\n ";
    $field = $val;
  }
 
  if ($lib != '')
    return $lib." ".$field;
  else
    return $field;
}
private function _combo_option($Tab, $pDefault) {
 $field ='';		

  foreach($Tab as $val=>$libelle) {	 
  			
		if(is_array($libelle)) {
			
			$field .='<optgroup label="'.$val.'">';
			$field .= $this->_combo_option($libelle, $pDefault);
			$field .='</optgroup>';
		}	
		else {
	  		$seleted = false;
			if (
			(is_array($pDefault) && !in_array($val,$pDefault))
			|| (($val!=$pDefault && !$this->strict_string_compare) || ((string)$val!==(string)$pDefault && $this->strict_string_compare))
			){
		  	   $seleted=false;
			}
		  	else{
		  	  	$seleted=true;
			}
		
			 $field .= "<option value=\"$val\" ".($seleted ? 'SELECTED' : '').">".$libelle."</option>\n";
			
		}	
		
  }

	return $field; 		
}

/*
 * permet de récupérer un select avec le tableau passé en paramètre et la valeur par défaut cochée
 * 
 * @param $pLib Le libellé
 * @param $pname Le nom du paramètre
 * @param $pListe
 * @param $pDefault
 * @param $pTaille
 * @param $onChange
 * @param $plus
 *
 * @return Retourne le formulaire
 */
function comboOptGroup($pLib,$pName,$pListe,$pDefault,$pTaille=1,$onChange='',$plus='',$fct_determmine_group='',$val_def=0){

  $lib="";
  $field="";
  if ($pLib!="")
    $lib   = "<b> $pLib </b>";
  
  $field = "<SELECT NAME='$pName'";
  if ($onChange!='') {
      $field.=" onChange=\"$onChange\"";
  }
  if($plus!=''){
  		$field.=" ".$plus;
  }
  
  $field.=">\n";
  $label_group=false;
  $newlabel_group=false;
  while (list($val,$libelle) = each ($pListe))
  {
    //$val_def correspond � la valeur qui d�termine le label
    if($fct_determmine_group!=''){
      $newlabel_group = call_user_func($fct_determmine_group,$val,$val_def);   
    }
    if($newlabel_group !== false){
       if($label_group!==false) $field .= "</OPTGROUP>\n";
       $label_group = $newlabel_group;
       
       $field .= "<OPTGROUP label=\"$libelle\">\n";
    }else{
      if ($val!=$pDefault)
        $field .= "<OPTION VALUE=\"$val\">$libelle</OPTION>\n";
      else
        $field .= "<OPTION VALUE=\"$val\" SELECTED>$libelle</OPTION>\n";
  	}
  }
  if($label_group!==false) $field .= "</OPTGROUP>\n";
  $field .="</SELECT>";
 
  if ($this->type_aff =='VIEW'){
    if (array_key_exists($pDefault,$pListe)) $val=$pListe[$pDefault]; else $val="";  
    $field = "<INPUT class='text_view' TYPE='TEXT' READONLY TABINDEX=-1 NAME='$pName' VALUE=\"$val\" SIZE='$pTaille'>\n ";
  }
 
  if ($lib != '')
    return $lib." ".$field;
  else
    return $field;
}



/*
 * 
 * 
 * @param $pLib Le libellé
 * @param $pname Le nom du paramètre
 * @param $pListe
 * @param $pDefault
 *
 * @return Retourne le formulaire
 */
function checkbox($pLib,$pName,$pListe,$pDefault, $plus=""){
  $lib   = "<b> $pLib </b>";
  $field ="<TABLE class='form' BORDER=0><TR>\n";
  while (list ($val, $libelle) = each ($pListe))
  {
    $field .= "<TD>$libelle</TD>";
    if ($val == $pDefault) 
       $checked = "CHECKED";
    else 
       $checked = " ";
    $field .= "<TD><INPUT TYPE='CHECKBOX' NAME='$pName' VALUE=\"$val\" "
                  . " $checked $plus> </TD>\n";
  }
  $field .= "</TR></TABLE>";
  return $lib." ".$field;
}
		
	/*
	 * checkbox1 retourne une case à cocher
	 * 
	 * @param $pLib Le libellé
	 * @param $pname Le nom du paramètre
	 * @param $pVal
	 *
	 * @return Retourne le formulaire
	 */
	function checkbox1($pLib,$pName,$pVal,$checked=false,$plus='',$class='',$id='',$order='case_after'){
	  if($checked==true)$checkedVal="CHECKED";
	  else $checkedVal=" ";
	
	  if($id=='')$id = $pName;
	  
	  $field="";
	  
	  if ($this->type_aff =='view'){
				if($checked)$field='<span class="check">Oui</span>';
				else $field='<span class="no-check">Non</span>';
	  }
	  else {
	  		$field = "<INPUT TYPE='CHECKBOX' CLASS='$class' NAME='$pName' ID='$id' VALUE=\"$pVal\" $checkedVal $plus />\n";
	  }
	  if($order=='case_after')  return $pLib." ".$field;
	  else return $field.' '.$pLib;
	}
	
	function radio($pLib,$pName,$pListe,$pDefault, $plus="",$class='',$id=''){
	    $lib   = "<b> $pLib </b>";
	    $field ="<TABLE class='form' BORDER=0><TR>\n";
	    while (list ($val, $libelle) = each ($pListe)){
	        $field .= "<TD>$libelle</TD>";
	        if ($val == $pDefault){
	            $checked = "CHECKED";
	        }
			else{
	            $checked = " ";
			}
	        $field .= "<TD><INPUT TYPE='RADIO' NAME='$pName' VALUE=\"$val\" ". " $checked $plus> </TD>\n";
	    }
	    $field .= "</TR></TABLE>";
	    if ($this->type_aff =='VIEW'){
	      $field = $pListe[$pDefault];
		}  
	    return $lib." ".$field;
	}




	function radio1($pLib,$pName,$pVal,$pDefault, $plus=""){
	        $field="";
			
			if ($pVal == $pDefault) 
	            $checked = "CHECKED";
	        else 
	            $checked = " ";
			
			if ($this->type_aff =='VIEW'){
				if($checked!=" ")$field="<img src=\"../images/croix.gif\" border=0>";
			}
			else{
				$field = "<INPUT TYPE='RADIO' NAME='$pName' VALUE=\"$pVal\" $checked $plus>\n";
			
			}
			
			
			return $pLib." ".$field;
	}
	function end() {
		print $this->end_form();
	}
	function end_form(){
	    return "</FORM>\n";
	}

	

	function btImg($pLib,$pName,$pImg,$plus=""){
	    $field = "<INPUT TYPE='IMAGE' NAME='$pName' src=\"$pImg\" border='0' alt=\"$pLib\" $plus>\n";  
	    return $field;
	}
	
	function btsubmit($pLib,$pName,$plus="", $class='button'){
	    $field = "<INPUT class='".$class."' TYPE='SUBMIT' NAME='$pName' VALUE=\"$pLib\" $plus>\n";
	    return $field;
	}
	function bt($pLib,$pName,$plus=""){
	    $field = "<INPUT class='button' TYPE='BUTTON' NAME='$pName' VALUE='$pLib' $plus>\n";
	    return $field;
	}
	
	function btreset($pLib,$pName){
	    $field = "<INPUT class='button' TYPE='RESET' NAME='$pName' VALUE='$pLib'>\n";
	    return $field;
	}


}

