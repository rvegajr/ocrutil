<?php

class DB {
    private static $mysqli;
    private static $dieOnError=true;
    private static $LastError=null;
    private static $LastResultSet=null;
    private static $LastAffectedRows=0;
    private static $LastIdentityId=0;
    private function __construct(){} //no instantiation

    static function cxn() {
        $db = \Config\Database::connect();
        self::$mysqli = $db->mysqli;
        if( !self::$mysqli ) {
            self::$mysqli = new mysqli($db->hostname,$db->username,$db->password,$db->database,$db->port);
            self::$mysqli = $db->mysqli;
            if (mysqli_connect_errno()) {
        		WriteLog("Can't connect to MySQL Server. Errorcode: ".mysqli_connect_error());
            	exit("Can't connect to MySQL Server. Errorcode: ".mysqli_connect_error());
            }
        }
        return self::$mysqli;
    }
    static function clear() {
		do {
    		$result = self::$mysqli->store_result();
		    if(is_object($result)) {
        		$result->free_result();
    		}
		} while(self::$mysqli->next_result());
    }
    static function affectedRows() {
    	//return self::$LastAffectedRows;
    	return self::$mysqli->affected_rows;
    }
    static function identityId() {
    	//return self::$LastIdentityId;
    	return self::$mysqli->insert_id;
    }
    static function query($sql, $AutoClear=false) {
    	self::$LastError=null;
    	self::$LastAffectedRows=0;
    	self::$LastIdentityId=0;
    	$isInsert=(startsWith(strtoupper(trim($sql)), 'INSERT'));
    	$isUpdate=(startsWith(strtoupper(trim($sql)), 'UPDATE'));
    	$isDelete=(startsWith(strtoupper(trim($sql)), 'DELETE'));
    	$InsUpd=false;
    	IF (($isInsert) || ($isUpdate) || ($isDelete)) {
    		$InsUpd=true;
    	}
    	self::$LastResultSet = mysqli_query( self::cxn(),$sql);
    	if(mysqli_error( self::cxn())){
    		if (DB::$dieOnError) {
    			die('DB ERROR: '.mysqli_error( self::cxn() ).'  $sql='.$sql);
    		} else {
    			self::$LastError=mysqli_error( self::cxn() );
    		}
    		return null;
    	}
    	if ( $isInsert || $isUpdate || $isDelete ) {
    		self::$LastIdentityId=($isInsert ? self::identityId() : 0);
    		self::$LastAffectedRows=self::affectedRows();
    	    if ($AutoClear) self::clear();
    		return self::$LastAffectedRows;
    	} else {
    	    if ($AutoClear)	self::clear();
    		return self::$LastResultSet;
    	}    	
    }
    
    static function pquery($sql, $parms, $AutoClear=false) {
    	$sql=str_replace('\?', '%$Q%', $sql);
    	foreach($parms as $parm) {
    		$subject=' '.$sql.' ';
    		$sql=str_replace_once('?', escq($parm), $subject);
    	}
    	$sql=str_replace('%$Q%', '?', $sql);
    	return self::query($sql, $AutoClear);
    }
    
    static function pqueryScaler($sql, $parms) {
        if ($result = self::pquery($sql, $parms)) {
    		$row = mysqli_fetch_row($result);
    		$ret=$row[0];
    		mysqli_free_result($result);
    		return $ret; 
		} else {
			return null;
		}
    }

    static function queryScaler($sql) {
    	if ($result = self::query($sql)) {
    		$row = mysqli_fetch_row($result);
    		$ret=$row[0];
    		mysqli_free_result($result);
    		return $ret;
    	} else {
    		return null;
    	}
    }

	static function execMultiQuery($sql) {
		self::$LastError=null;
		$results = array();
		if (self::cxn()->multi_query($sql)) {
			if(mysqli_error( self::cxn())){
				if (DB::$dieOnError) {
					die('DB ERROR: '.mysqli_error( self::cxn() ).'  $sql='.$sql);
				} else {
					self::$LastError=mysqli_error( self::cxn() );
				}
				return null;
			}
			
			do {
				// Create the records array
				$records = array();
				
				// Lets work with the first result set
				if ($result = self::cxn()->use_result()) {
					// Loop the first result set, reading the records into an array
					while ($row = $result->fetch_array(MYSQLI_BOTH)) {
						$records[] = $row;
					}
					
					// Close the record set
					$result->close();
				}
				
				// Add this record set into the results array
				$results[] = $records;
			} while ((self::cxn()->more_results()) && (self::cxn()->next_result()));
		}
		return $results;
	}
	
    static function execProc($sql) {
    	self::$LastError=null;
		$results = array();
		if (self::cxn()->multi_query($sql)) {
			if(mysqli_error( self::cxn())){
				if (DB::$dieOnError) {
					die('DB ERROR: '.mysqli_error( self::cxn() ).'  $sql='.$sql);
				} else {
					self::$LastError=mysqli_error( self::cxn() );
				}
				return null;
			}
				
			do {
				// Create the records array
				$records = array();
 
				// Lets work with the first result set
				if ($result = self::cxn()->use_result()) {
				// Loop the first result set, reading the records into an array
					while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
						$records[] = $row;
					}
 
					// Close the record set
					$result->close();
				}
 
				// Add this record set into the results array
				$results[] = $records;
			} while ((self::cxn()->more_results()) && (self::cxn()->next_result()));
		}
		return $results;
    }
    
    static function selectedDB() {
    	if ($result = mysqli_query(self::$mysqli, "SELECT DATABASE()")) {
    		$row = mysqli_fetch_row($result);
    		$selectedDB= $row[0];
    		mysqli_free_result($result);
    		return $selectedDB; 
		}    	
    }
    static function setSafeUpdateOption($isSafe) {
    	$val=($isSafe ? '1' : '0');
    	$result = mysqli_query(self::$mysqli, "SET sql_safe_updates=".$val);
    	if (mysqli_connect_errno()) {
        		WriteLog("Failed on SET sql_safe_updates. Errorcode: ".mysqli_connect_error());
            	exit("Failed on SET sql_safe_updates. Errorcode: ".mysqli_connect_error());
        }
        return true;
    	
    }
    
}

if (!function_exists('esc')) {
    /**
     * And abbreviated form of mysqli_real_escape_string
     *
     * @var string $valToEscape - The Value to Escape
     * @return the value escape
     */
    function esc($valToEscape) {
        return mysqli_real_escape_string(DB::cxn(), $valToEscape);
    }
}

if (!function_exists('escq')) {
    /**
     * And abbreviated form of mysqli_real_escape_string while adding outer quotes
     *
     * @var string $valToEscape - The Value to Escape
     * @return the value escape
     */
    function escq($valToEscape) {
        return '\''.mysqli_real_escape_string(DB::cxn(), $valToEscape).'\'';
    }
}

if (!function_exists('str_replace_once')) {
    function str_replace_once($str_pattern, $str_replacement, $string){

        if (strpos($string, $str_pattern) !== false){
            $occurrence = strpos($string, $str_pattern);
            return substr_replace($string, $str_replacement, strpos($string, $str_pattern), strlen($str_pattern));
        }

        return $string;
    }
}

