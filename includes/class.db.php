<?

class Tdb{

var $db;
var $rs;            //RecordSet
var $currentLine;   //ligne courante
var $type;             //type de la bdd

/**
* Construteur
**/
function Tdb($TConnect=null, $db_type='mysql'){
	
		if(is_null($TConnect)) {
			$TConnect=array(
				'host'=>DB_HOST
				,'user'=>DB_USER
				,'pass'=>DB_PASS
				,'db'=>DB_BASE
			);
		}
	
        $this->type=$db_type;
        $this->db = &ADONewConnection($db_type);
        $this->db->NConnect($TConnect['host'], $TConnect['user'], $TConnect['pass'], $TConnect['db']);
        $this->db->SetFetchMode(ADODB_FETCH_ASSOC);
        $this->currentLine=array();

        if(isset($_REQUEST['DEBUG'])){
        		print "MODE DEBUG : <br>";
                	$this->db->debug=true;
        }
        else {
             	$this->db->debug=false;
        }
}


function Get_DbType(){
        return $this->type;
}

function Get_Recordcount(){
        return $this->rs->RecordCount();
}

/**
* @Desc fonction  qui execute 1 requete SQL pass�e en param�tre
* @Param $query chaine de caract�re contenant la requ�te � executer
* @Return TRUE si la fonction s'est bien execut�e  sinon le code d'erreur avec le message
**/

function Execute ($query){
        $this->rs = $this->db->execute($query);
}

function SelectLimit ($query,$nbrow,$nrow){
        $this->rs = $this->db->selectlimit($query,$nbrow,$nrow);
}

function dbkeyexist($table,$value,$key){
        $fmtsql = "SELECT * FROM $table WHERE %s";
        if (is_array($value)){
                foreach ($value as $k => $v) {
                        $v=stripslashes($v);
                        if (is_array($key)){

                                $i=array_search($k , $key );
                                if ( $i !== FALSE) {
                                        $where[] = $key[$i]."='" . addslashes( $v ) . "'";
                                        continue;
                                }
                        } else {
                        if ( $k == $key) {
                                $where[] = "$k='" . addslashes( $v ) . "'";
                                continue;
                            }
                    }
                }
    } else {
        $value=stripslashes($value);
                $where = "$key='" . addslashes( $value ) . "'";
    }

        $sql = sprintf( $fmtsql,  implode(" AND ",$where) );
        $ret = $this->db->execute( $sql );
        if ($ret->recordcount() > 0)
                return true;
        else
                return false;
}

function dbupdate($table,$value,$key){
        $fmtsql = "UPDATE $table SET %s WHERE %s";
        foreach ($value as $k => $v) {
                $v=stripslashes($v);
                if (is_array($key)){
                        $i=array_search($k , $key );
                        if ( $i !== FALSE) {
                                $where[] = "$key[$i]='" . addslashes( $v ) . "'";
                            continue;
                        }
                } else {
                        if ( $k == $key) {
                                $where[] = "$k='" . addslashes( $v ) . "'";
                                continue;
                        }
                }

                if ($v == '') {
                        $val = 'NULL';
                } else {
                        $val = "'" .addslashes( $v ) . "'";
                }
                $tmp[] = "$k=$val";
        }
        $sql = sprintf( $fmtsql, implode( ",", $tmp ) , implode(" AND ",$where) );
        return $this->db->execute( $sql );
}

function dbinsert($table,$value){
        $fmtsql = "insert into $table ( %s ) values( %s ) ";
        foreach ($value as $k => $v) {
                $v=stripslashes($v);
                $fields[] = $k;
                $values[] = "'" . addslashes( $v ) . "'";
        }
        $sql = sprintf( $fmtsql, implode( ",", $fields ) ,  implode( ",", $values ) );

        if (!$this->db->execute( $sql )) {
                return false;
        }
        return true;
}

function dbdelete($table,$value,$key){
    if (is_array($value)){
            foreach ($value as $k => $v) {
           if (is_array($key)){
              $i=array_search($k , $key );
              if ( $i !== FALSE) {
                 $where[] = "$k='" . addslashes( $v ) . "'";
                 continue;
                 }
           }
           else {
              $v=stripslashes($v);
              if( $k == $key ) {
                 $where[] = "$key='" . addslashes( $v ) . "'";
                 continue;
                 }
              }
           }
    } else {
        $value=stripslashes($value);
                $where[] = "$key='" . addslashes( $value ) . "'";
    }

    $tmp=implode(" AND ",$where);
    $sql = sprintf( "DELETE FROM $table WHERE $tmp");


    return $this->db->execute( $sql);
}

function Get_line(){
        $this->currentLine= $this->rs->fetchrow();
        if (is_array($this->currentLine)){
          foreach ($this->currentLine as $key=>$val)
                $this->currentLine[$key]=stripslashes($val);
          return $this->currentLine;
        }else
          return FALSE;
}

// Cette fonction est elle utile ici ? EMO
function Get_lineHeader(){
   $ret=array();
   $this->currentLine= $this->rs->fields;

   if (is_array($this->currentLine)){
      foreach ($this->currentLine as $key=>$val)
         $ret= array_merge($ret,array("$key" => "0"));
      }

   return $ret;
}

/**
* @Desc fonction  qui retourne la valeur du champ $pField du recordset courant
* @Param $pField nom du champ qui doit �tre retourn�
* @Ret retourne la valeur du champ, faux si la fonction �choue
**/
function Get_field($pField){
        $ret=NULL;
        if (is_array($this->currentLine) && array_key_exists($pField,$this->currentLine))
                {$ret=$this->currentLine[$pField]; }
        return stripslashes($ret);
/*
        return stripslashes($this->rs->fields[$pField]);
*/
}

function close(){
    $this->db->close();
}
}

?>
