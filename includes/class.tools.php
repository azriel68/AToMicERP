<?php
 
class Tools{
	
	static function getUrl($filepath, $type='url') {
		$pos = strpos($filepath,'?'); //parameters ?
		if($pos!==false) $file = substr($filepath,0, $pos);
		else $file = $filepath;
		
		if(is_file(ROOT.'modules/'.$file)) {
			
			return HTTP.'modules/'.$filepath;
		}
		else {
			return 'fileNotFound';
		}
	}
	
	static function summarize($texte, $nb=5, $asString=true) {

		//print_r($TWord);
		$TSentence=array();
		Tools::_sum_get_sentence_with_date($TSentence, $texte);
		
		$TWord = Tools::_sum_get_words($texte, $nb);
		Tools::_sum_get_sentence($TSentence, $texte, $TWord);
		//print_r($TSentence);
		
		ksort($TSentence);
		$TSentence = array_slice($TSentence,0,$nb);
		
		
		if($asString) return implode(' ', $TSentence);
		else return $TSentence;
	}
	static function _sum_get_sentence(&$TSentence, $texte, $TWord) {
		
		
	
		foreach($TWord as $word) {
			
			$mot = $word['mot'];
			$s_texte=strtr($texte,array(
				"\n"=>"."
				,'?'=>"."
				,'!'=>"."
				,'"'=>"."
				
			));
			
			$pos = strpos($s_texte, $mot);
			if($pos!==false) {
				
				$sub_texte = substr($s_texte,0,$pos);
				$pos_start = strrpos($sub_texte, '.');
				if($pos_start===false)$pos_start=0;
				else $pos_start++;
				
				$pos_end =strpos($s_texte, '.', $pos);
				if($pos_end===false)$pos_end=strlen($texte);

				//print "($pos) $pos_start -> $pos_end. <br>";
				
				$sentence = trim(substr($s_texte, $pos_start, $pos_end-$pos_start));
				//print  "$mot ($sub_texte) ".$sentence.'<br>';
				if(Tools::_sum_add_sentence($TSentence, $sentence, $pos_start)) {
					$texte = substr($texte,0,$pos_start).' '.substr($texte,$pos_end)	;				
				}
				
			}
			else{
				/*print "$mot non trouvé ?";*/
			}
			
		}
		
	
	}
	
	static function _sum_add_sentence(&$TSentence, $sentence,$pos_start) {
		
		if(empty($sentence)) return false;
		
		foreach($TSentence as &$s) {
			$meta_s1  = metaphone($s);
			$meta_s2  = metaphone($sentence);
			
			$score = strcasecmp($meta_s1,$meta_s2);
			//print "$score ($s ($meta_s1)=== $sentence($meta_s2))<br>";
			if(abs($score)<1) return false;
		}
		
		$TSentence[$pos_start] = $sentence;
		
		return true;
	}
	static function _sum_get_sentence_with_date(&$TSentence, $texte) {
		$KeyDate=explode(',','janvier,février,mars,avril,mai,jui,juillet,août,septembre,octobre,novembre,décembre');
		$s_texte=strtr($texte,array(
				"\n"=>"."
				,'?'=>"."
				,'!'=>"."
				,'"'=>"."
				
			));
			
		foreach($KeyDate as $motDate) {
			
			$pos = strpos($s_texte, $motDate);
			if($pos!==false) {
				
				$sub_texte = substr($s_texte,0,$pos);
				$pos_start = strrpos($sub_texte, '.');
				if($pos_start===false)$pos_start=0;
				else $pos_start++;
				
				$pos_end =strpos($s_texte, '.', $pos);
				if($pos_end===false)$pos_end=strlen($texte);

				$sentence = trim(substr($s_texte, $pos_start, $pos_end-$pos_start));
				Tools::_sum_add_sentence($TSentence, $sentence, $pos_start);
				
			}	
			
		}	
			
		
		
	}
	static function _sum_get_words($texte,$nbWord) {
		
		$texte = strtr($texte,array(
			"\n"=>" "
			,','=>" "
			,'.'=>" "
			,'?'=>" "
			,'!'=>" "
		));
		
		$Tab = explode(' ',$texte);
		
		$TMotCollect = array();
		foreach($Tab as $k=>$mot) {
			if(strlen($mot)>4) {
				@$TMotCollect[$mot]+= (1000 - $k);	
			}
		}
		
		$TMot=array(); $i=0;
		foreach($TMotCollect as $mot=>$nb) {
			$TMot[$nb] = array('mot'=>$mot, 'position'=>$i);
			$i++;			
		}
		
		krsort($TMot);
		usort($TMot, 'Tools::sortByPosition');
		//print_r($TMot);
		return array_slice($TMot,0,$nbWord);
	}
	
	static function odt2text($filename) {
	    return Tools::readZippedXML($filename, "content.xml");
	}
	
	static function docx2text($filename) {
	    return Tools::readZippedXML($filename, "word/document.xml");
	}
	
	static function readZippedXML($archiveFile, $dataFile) {
	    // Create new ZIP archive
	    $zip = new ZipArchive;
	
	    // Open received archive file
	    if (true === $zip->open($archiveFile)) {
	        // If done, search for the data file in the archive
	        if (($index = $zip->locateName($dataFile)) !== false) {
	            // If found, read it to the string
	            $data = $zip->getFromIndex($index);
	            // Close archive file
	            $zip->close();
	            // Load XML from a string
	            // Skip errors and warnings
	            $xml = DOMDocument::loadXML($data, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
	            // Return data without XML formatting tags
	            return strip_tags($xml->saveXML());
	        }
	        $zip->close();
	    }
	
	    // In case of failure return empty string
	    return '';
	}
	
	static function pre($t, $all=false){
	  if($all) {
	  	print '<pre>'. print_r($t, true) .'</pre>';
	  }	
	  else {
	  	var_dump($t);
	  }
	  
	}
	
	static function string2num($s) {
		return (double)strtr($s,array(
			','=>'.'
			,' '=>''
		));
		
	}
	
	static function get_time($date) {
		$std=new TObjetStd;
		$std->set_date('dt_date', $date);
		
		return $std->dt_date;
	}
	
	static function showTime($time) {
		
		if($time==0) {
			return '';
		}
		
		$time_ref = strtotime('2013-01-01 00:00:00');
		
		if($time<86400) {
			return date('H:i', $time + $time_ref); 	
		}
		else {
			
			return date('z\j H\h i\m', $time  + $time_ref);
		}
		
		
			
	}
	
}	



class TInsertSQL {
	
	static function getFileContent($file, $gz=false) {
		
		$f1 = TInsertSQL::_fopen($file, $gz); 
	
		print "Lecture du fichier..."; flush();
		$db=new TPDOdb;
		
		if($f1===false) { exit("Erreur d'ouverture du fichier"); }
		
		$ligne="";
		
		while(!TInsertSQL::_feof($f1, $gz)){
			
			$ligne.= TInsertSQL::_fgets($f1, $gz)."\n";
	
	    }
			
		TInsertSQL::_fclose($f1, $gz);
			
		return $ligne;
		
	}
	
	static function insertSQL(&$db, $sql, $tag='INSERT INTO' ) {
		
		
		$buffer = explode("\n",$sql);
		$cpt=0;$ligne='';
		foreach ($buffer as $ligne_partiel) {
		  
				if($ligne_partiel!='' && (strcmp(substr($ligne_partiel,0,2),'--'))){
			
				$ligne.=$ligne_partiel."\n";
				$var =TInsertSQL::_get_sql_expression($ligne, $tag);

					if(count($var)>1){
					
						$nb=count($var);
						for($i = 0; $i < $nb-1; $i++){
							
						
									$sql=$var[$i];
									
									$db->Execute($sql);// print '<strong>Echec SQL : </strong>'.$sql.'<br /><br />';		
									if($cpt==1000){
										$cpt=0;
											print $sql."<br>";
									}
							
						} // for
					
						$ligne = $var[$nb-1];
					}
				
				
				}
				$cpt++;
		}
		
		$db->Execute($ligne);		
		print "($ligne) Fin";
		
	}
	
	static function _get_sql_expression($ligne,$tag) {
	/* Recherche les expression SQL et les retourne dans un tableau */
		$end = false;
		$Tab=array();
		
		$pos_deb=0;
		while(!$end) {
				$pos_fin = strpos($ligne, $tag, $pos_deb+1);
				if($pos_fin===false)$pos_fin = strpos($ligne, 'ALTER TABLE', $pos_deb+1);
				if($pos_fin===false)$pos_fin = strpos($ligne, 'DROP TABLE', $pos_deb+1);
				if($pos_fin===false)$pos_fin = strpos($ligne, 'CREATE TABLE', $pos_deb+1);
				if($pos_fin===false)$pos_fin = strpos($ligne, 'REPLACE INTO', $pos_deb+1);
	
				if($pos_fin===false) {
						$end=true;
						$Tab[]=substr($ligne, $pos_deb);
				}
				else {
				
					$Tab[]=substr($ligne, $pos_deb,$pos_fin-$pos_deb); 
					$pos_deb = $pos_fin;
				}
				
			
		}
											
		return $Tab;
	}
	static function _fclose(&$f1, $gz=false) {
	
		if($gz) {
			return gzclose($f1);;
		}
		else {
			return fclose($f1);
		}	
		
	}
	static function _fgets(&$f1, $gz=false) {
		
		if($gz) {
			return gzgets($f1);
		}
		else {
			return fgets($f1);
		}	
		
	}		
	static function _feof(&$f1, $gz=false) {
		
		if($gz) {
			return gzeof($f1);
		}
		else {
			return feof($f1);
		}	
		
	}		
			
	static function _fopen($file, $gz=false) {
		
		if($gz) {
			return gzopen($file ,'r');
		}
		else {
			return fopen($file, 'r');
		}	
	}	
	
	
	
} 
