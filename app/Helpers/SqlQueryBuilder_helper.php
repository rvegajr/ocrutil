<?php

/**
 * SqlQueryBuilder Class
 * Generates simple SQL queries dynamically
 * Please report any bug
 * See documentation - http://www.phpclasses.org/browse/file/12314.html
 * 
 * @author David Regla Demaree <dreglad@gmail.com>
 */
if ((int)phpversion() < 5) die("Sorry, This class is written for PHP 5, maybe later I'll re-write it for PHP 4");
class SqlQueryBuilder {
	
	const VERSION = "1.3";
	/**
	 * Turns error messages on and off, usefull for debugging
	 *
	 * @var boolean
	 */
	private $showErrors = true;
	
	/**
	 * Holds the query type (select, insert, update, delete)
	 * it can take an extra value named "query" for
	 * returning arbitrary SQL Queries.
	 *
	 * @var string
	 */
	public $queryType = "SELECT"; // Default Query Type
	
	/**
	 * These hold the variables for building the query
	 *
	 * @var string
	 */
	protected $query;
	protected $table;
	protected $groupBy;
	protected $having;
	protected $orderBy;
	protected $limit;
	
	/**
	 * Columns and values arrays, dimensions must match
	 *
	 * @var array
	 */
	protected $columns = array(); 
	protected $values  = array();

	/**
	 * Constructor - Defines the query type
	 *
	 * @param string $queryType
	 */
	public function __construct($queryType) {
		$this->queryType = strtoupper($queryType);
	}
	
	/**
	 * Set the table to work on
	 *
	 * @param string $tableName
	 */
	public function setTable($tableName) {
		$this->table = $tableName;
	}
	
	/**
	 * Adds a column to the list
	 *
	 * @param unknown_type $colName
	 */
	public function addColumn($colName) {
		$this->columns[] = $colName;
	}
	
	/**
	 * Add a value to the list
	 *
	 * @param string $value
	 */
	public function addValue($value) {
		//$value = (get_magic_quotes_gpc()) ? $value : addslashes($value);
		//$this->values[] = "'".$value."'";
		$this->values[] = $value;
	}
	
	/**
	 * Add a value to the list
	 *
	 * @param string $$colName
	 * @param string $value
	 * @param string $$dataType
	 */
	public function add($colName, $value, $dataType='s') {
		$this->addColumn($colName);
		if (( $value == null ) || ( $value == "" )) {
			$this->addValue('NULL');
		} else if ( $dataType=='b' ) {
			$value = strtoupper(substr($value, 0, 1)); 
			$boolval = (($value=='Y') || ($value=='1') || ($value=='T'));
			//$this->addValue( ( $boolval ? chr(0x01) : chr(0x00) ) );
			$this->addValue( ( $boolval ? 1 : 0) );
		} else if ( $dataType=='n' ) {
			$value = str_replace(",", "", $value); 
			$value = str_replace("$", "", $value); 
			$value = str_replace("$", "", $value); 
			$this->addValue(esc($value));
		} else if ( $dataType=='pct' ) {
			$value = str_replace(",", "", $value); 
			$value = str_replace("$%", "", $value); 
			$this->addValue((esc($value)*0.01));
		} else if ( $dataType=='dt' ) {
			if ( strtoupper($value)=="NOW()" ) {
				$this->addValue($value);
			} else {
				$this->addValue("'".date( 'Y-m-d H:i:s', _strtotime($value))."'");
			}
		} else if ((is_numeric($value)) || (( strtoupper($value)=="NOW()" ))){
			$this->addValue($value);
		} else if (is_numeric($value)) {
			$this->addValue("'".esc($value)."'");
		} else {
			$this->addValue("'".esc($value)."'");
		}
	}
	
	/**
	 * Add a value to the list
	 *
	 * @param string $$colName
	 * @param string $value
	 */
	public function addFieldDateTime($colName, $value) {
		try {
			$phpdate = _strtotime( $value );
			$mysqldate = date( 'Y-m-d H:i:s', $phpdate );
			$this->addColumn($colName);
			$this->addValue("'".$mysqldate."'");
		} catch (Exception $e) {
			echo 'Caught exception in addFieldDateTime(): ',  $e->getMessage(), "\n";
		}
	}
	
	/**
	 * These methods set the query clauses
	 */
	public function setWhereID($Id) {
		$this->where = 'id='.esc($Id);	
	}
	public function setWhere($where) {
		$this->where = $where;	
	}
	public function setGroupBy($groupBy) {
		$this->groupBy = $groupBy;
	}
	public function setHaving($having) {
		$this->having = $having;
	}
	public function setOrderBy($orderBy) {
		$this->orderBy = $orderBy;
	}
	public function setQuery($query) {
		$this->query = $query;
	}
	public function setLimit($limit) {
		$this->limit = $limit;
	}
	
	public function showErrors($showErrors) {
		$this->showErrors = ($showErrors)? true:false; 
	}
	
	/**
	 *
	 *  Decides what to do in case of error and hanldes it
	 *
	 * @param string $message
	 * @return boolean
	 */
	private function error($message) {
		if ($this->showErrors) {
			print "<font size='10' face='arial' color='red'>\n";
			print "<p>SQLQueryBuilder v" . self::VERSION . "</p>";
			print "</font>";
			print "<font size='8' face='arial' color='blue>\n";
			print "<p>$message</p>";
			print "</font>";
		}
		return false;
	}
	
	/**
	 * Generates and returns query as a string
	 * 
	 * @return string
	 */
	public function buildQuery() {
		if (empty($this->table) and ($this->queryType != "QUERY")) return $this->error("Error - No table selected");
		
		$sqlString = "";
		switch ($this->queryType) {
			case "SELECT":
				$sqlString.= "SELECT ";
				$sqlString.= implode(", ", $this->columns);
				$sqlString.=" FROM {$this->table}";
				
				if ($this->where)   $sqlString.= " WHERE $this->where";
				if ($this->groupBy) $sqlString.= " GROUP BY $this->groupBy";
				if ($this->having)  $sqlString.= " HAVING $this->having";
				if ($this->orderBy) $sqlString.= " ORDER BY $this->orderBy";
				if ($this->limit)   $sqlString.= " LIMIT $this->limit";
				
				break;
			case "INSERT":
				if (count($this->columns) != count($this->values)) return $this->error("Error - Column list doesn't match the value list");
				$sqlString.= "INSERT INTO {$this->table} ";
				
				$sqlString.= "(";
				$sqlString.= implode(", ", $this->columns);
				$sqlString.= ") ";
				
				$sqlString.= "VALUES";
				
				$sqlString.= " (";
				$sqlString.= implode(", ", $this->values);
				$sqlString.= ")";
				break;
			case "UPDATE":
				if (count($this->columns) != count($this->values)) return $this->error("Error - Column list doesn't match the value list");
				$sqlString.= "UPDATE {$this->table} SET ";
				
				$noColumns = count($this->columns);
				for ($i=0;$i<$noColumns;$i++) {
					$sqlString.= "{$this->columns[$i]} = {$this->values[$i]}";
					if ($i < $noColumns-1) $sqlString.= ", ";
				}
				
				
				if ($this->where) $sqlString.= " WHERE $this->where";
				if ($this->limit) $sqlString.= " LIMIT $this->limit";
				break;
			case "DELETE":
				$sqlString.= "DELETE FROM {$this->table} ";
				
				if ($this->where) $sqlString.= "WHERE $this->where";
				break;
			case "QUERY":
				if (!$this->query) $this->error("Warning - There's no SQL");
				$sqlString.= $this->query;
			
		}
		
		$sqlString.=";";
		return $sqlString;
	}
}
