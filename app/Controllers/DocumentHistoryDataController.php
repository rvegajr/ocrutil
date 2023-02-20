<?php

namespace App\Controllers;

use DocumentHistory;
use PHPUnit\Util\Exception;

class DocumentHistoryDataController extends BaseApiController
{
    public function index()
    {
        $data = $this->data;
    
        $isLoggedIn = true;// auth()->loggedIn();
        if (!$isLoggedIn) {
            return $this->response->setStatusCode(401, 'Unauthorized');
        }

        try {
            $DocumentHistory = new DocumentHistory();
            if ( isset($_REQUEST['oper'] ) ) {
                switch ($_REQUEST['oper']) {
                    case "edit":
                        $DocumentHistory->Update($_REQUEST['id'], $_REQUEST);
                        if ( isset($DocumentHistory->error) ) return $this->return_error( $DocumentHistory->error, 400 );
                        return $this->return_ok( "Delete successful", 200 );
                        exit;
                    case "add":
                        $Id = $DocumentHistory->Insert($_REQUEST);
                        if ( isset($DocumentHistory->error) ) return $this->return_error( $DocumentHistory->error, 400 );
                        return $this->return_ok( "Insert successful, Id=".$Id, 201 );
                        exit;
                    case "del":
                        $DocumentHistory->Delete($_REQUEST['id']);
                        if ( isset($DocumentHistory->error) ) return $this->return_error( $DocumentHistory->error, 400 );
                        return $this->return_ok( "Delete successful", 204 );
                        exit;
                }
            } else {
                $i=0;
                $ret=JQGridData($DocumentHistory);
                $response=$ret['response'];
                if (is_array($ret['result']) || is_object($ret['result'])) {
                    foreach($ret['result'] as $row) {
                        $response->rows[$i]['id']=$row['id'];
                        $response->rows[$i]['cell']=$row;
                        $i++;
                    }
                }
                return $this->echo_json_encode($response);
            }
        } catch (Exception $e) {
            return $this->return_exception($e);
        }
    }


    // get single product
    public function show($id = null)
    {
        $DocumentHistory = new DocumentHistory();
        $data = $DocumentHistory->SelectById($id);
        if($data){
            return $this->echo_json_encode($data);
        }else{
            return $this->failNotFound('No Data Found with id '.$id);
        }
    }

    // create a product
    public function create()
    {
        $DocumentHistory = new DocumentHistory();
        $data = $DocumentHistory->Insert($this->request->getJSON());
        return $this->return_ok( $data, 201 );
    }

    // update product
    public function update($id = null)
    {
        $DocumentHistory = new DocumentHistory();
        $DocumentHistory->Update($id, $this->request->getJSON());
        return $this->return_ok( 'Data Updated', 201 );
    }

    // delete product
    public function delete($id = null)
    {
        $DocumentHistory = new DocumentHistory();
        $data = $DocumentHistory->SelectById($id);
        if($data){
            $DocumentHistory->Delete($id);
            return $this->return_ok( 'Data Deleted', 204 );
        }else{
            return $this->failNotFound('No Data Found with id '.$id);
        }

    }
}