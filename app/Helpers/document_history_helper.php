<?php

class DocumentHistory implements IJQGridDataSource {
	var $error = null;
	var $TABLE_NAME='document_history';
	/**
	 * Constructor 
	 */
	public function __construct() {
	}

	public function Update($id, $REQUEST) {
		$this->error=null;
        $item = ocrutil::Updatedocument_historyObject($REQUEST);
		return true;
	}
	
	/**
	 * Deletes a Vendor by ID
	 *
	 * @var int $id
	 * @return True of successful,  false if failed
	 */
	public function Delete($id) {
        return ocrutil::Deletedocument_historyObject($id);
	}
	
	public function Insert($REQUEST) {
		$this->error=null;
        return ocrutil::CreateUpdatedocument_historyObject($REQUEST);
		$id=DB::identityId();
		return $id;
	}

    public function SelectById($id) {
        return ocrutil::Retrievedocument_historyObject($id);
    }

    public function dfCount() {
		$this->error=null;
		$sql='SELECT COUNT(*) FROM '.$this->TABLE_NAME.' WHERE id>1';
        $cn=DB::cxn();
		$query = mysqli_query(DB::cxn(),$sql);
		if(mysqli_error(DB::cxn())){
			$this->error=mysqli_error(DB::cxn());
			return -1;
		}
		$row = mysqli_fetch_row($query);
		if(mysqli_num_rows($query)){
			return (int)$row[0];
		}
		return -1;
	}
	
	public function dfQuery($sidx, $sord, $start, $limit) {
		$this->error=null;
		$sql="SELECT * FROM ".$this->TABLE_NAME." WHERE id>1 ORDER BY $sidx $sord LIMIT $start , $limit";
		/*
		 *
		*/
		$query = mysqli_query(DB::cxn(),$sql);
		if(mysqli_error(DB::cxn())){
			$this->error=mysqli_error(DB::cxn());
			return null;
		}
		if ( mysqli_num_rows($query)==0 ) {
			return array();
		} else {
			return mysqli_fetch_rowsarr($query);
		}
	}
	/* (non-PHPdoc)
	 * @see IJQGridDataSource::Count()
	*/
	public function Count($where = '') {
		return $this->dfCount();
	}
	
	/* (non-PHPdoc)
	 * @see IJQGridDataSource::Query()
	*/
	public function Query($sidx, $sord, $start, $limit, $where = '') {
		return $this->dfQuery($sidx, $sord, $start, $limit);
	}
	
	/* (non-PHPdoc)
	 * @see IJQGridDataSource::LastError()
	*/
	public function LastError() {
		return $this->error;
	}
	
}
