<?php

namespace App\Controllers;

use ExceptionQueue;
use PHPUnit\Util\Exception;

class ExceptionQueueDataController extends BaseApiController
{
    public function index()
    {
        $data = $this->data;

        $isLoggedIn = true;// auth()->loggedIn();
        if (!$isLoggedIn) {
            return $this->response->setStatusCode(401, 'Unauthorized');
        }

        try {
            $ExceptionQueue = new ExceptionQueue();
            if ( isset($_REQUEST['oper'] ) ) {
                switch ($_REQUEST['oper']) {
                    case "edit":
                        $ExceptionQueue->Update($_REQUEST['id'], $_REQUEST);
                        if ( isset($ExceptionQueue->error) ) return $this->return_error( $ExceptionQueue->error, 400 );
                        return $this->return_ok( "Delete successful", 200 );
                        exit;
                    case "add":
                        $Id = $ExceptionQueue->Insert($_REQUEST);
                        if ( isset($ExceptionQueue->error) ) return $this->return_error( $ExceptionQueue->error, 400 );
                        return $this->return_ok( "Insert successful, Id=".$Id, 201 );
                        exit;
                    case "del":
                        $ExceptionQueue->Delete($_REQUEST['id']);
                        if ( isset($ExceptionQueue->error) ) return $this->return_error( $ExceptionQueue->error, 400 );
                        return $this->return_ok( "Delete successful", 204 );
                        exit;
                }
            } else {
                $i=0;
                $ret=JQGridData($ExceptionQueue);
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
        $ExceptionQueue = new ExceptionQueue();
        $data = $ExceptionQueue->SelectById($id);
        if($data){
            return $this->echo_json_encode($data);
        }else{
            return $this->failNotFound('No Data Found with id '.$id);
        }
    }

    // create a product
    public function create()
    {
        $ExceptionQueue = new ExceptionQueue();
        $data = $ExceptionQueue->Insert($this->request->getJSON());
        return $this->return_ok( $data, 201 );
    }

    // update product
    public function update($id = null)
    {
        $ExceptionQueue = new ExceptionQueue();
        $ExceptionQueue->Update($id, $this->request->getJSON());
        return $this->return_ok( 'Data Updated', 201 );
    }

    // delete product
    public function delete($id = null)
    {
        $ExceptionQueue = new ExceptionQueue();
        $data = $ExceptionQueue->SelectById($id);
        if($data){
            $ExceptionQueue->Delete($id);
            return $this->return_ok( 'Data Deleted', 204 );
        }else{
            return $this->failNotFound('No Data Found with id '.$id);
        }

    }
}