<?php

namespace App\Controllers;

use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use http\Client\Request;
use Psr\Log\LoggerInterface;

abstract class BaseApiController extends BaseController
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;
    protected $format    = 'json';
    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['common', 'database', 'functions', 'exception_queue',
        'document_history', 'document_history_detail', 'archive_history', 'render'];
    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        $this->helpers = array_merge($this->helpers, ['auth', 'setting', 'actions']);

        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
    }

    /**
     * Shim function so I do not have to rewrite a bunch of legacy code.  But this will return a success status code as well
     * as the data encoded in JSON format
     * @param $dataToEncode
     * @return \CodeIgniter\HTTP\Response
     */
    public function echo_json_encode($dataToEncode, $statusCode=200) :\CodeIgniter\HTTP\Response {
        return $this->response
            ->setContentType('application/json')
            ->setStatusCode($statusCode) // Return status
            ->setBody(json_encode($dataToEncode));
    }

    public function respond($response, $statusCode=200) :\CodeIgniter\HTTP\Response {
        return $this->response
            ->setContentType('application/json')
            ->setStatusCode($statusCode) // Return status
            ->setBody(json_encode($response));
    }

    public function return_ok2($message, $statusCode=200, $newId=-1) :\CodeIgniter\HTTP\Response {
        $dataToEncode["message"] = $message;
        if ($newId>-1) $dataToEncode["new_id"] = $newId;
        $dataToEncode["code"] = $statusCode;

        return $this->response
            ->setContentType('application/json')
            ->setStatusCode($statusCode)
            ->setBody(json_encode($dataToEncode));
    }

    public function return_ok($dataToEncode, $statusCode=200) :\CodeIgniter\HTTP\Response {
        return $this->response
            ->setContentType('application/json')
            ->setStatusCode($statusCode)
            ->setBody(json_encode($dataToEncode));
    }

    public function return_file($filename, $statusCode=200) :\CodeIgniter\HTTP\Response {
        $dataToEncode["message"] = "File Generated";
        $dataToEncode["data"] = $filename;
        $dataToEncode["code"] = 0;

        return $this->response
            ->setContentType('application/json')
            ->setStatusCode($statusCode)
            ->setBody(json_encode($dataToEncode));
    }

    public function return_error($dataToEncode, $statusCode=400) :\CodeIgniter\HTTP\Response {
        log_message('error', "[ERROR] {$dataToEncode}");

        return $this->response
            ->setContentType('application/json')
            ->setStatusCode($statusCode)
            ->setBody(json_encode($dataToEncode));
    }

    public function return_exception($e, $statusCode=400, $ProcMessage='') :\CodeIgniter\HTTP\Response {
        log_message('error', "[ERROR] {$ProcMessage}", ['exception' => $e]);

        return $this->response
            ->setContentType('application/json')
            ->setStatusCode($statusCode)
            ->setBody(json_encode($ProcMessage));
    }

    public function failNotFound($e, $statusCode=400, $ProcMessage='') :\CodeIgniter\HTTP\Response {
        log_message('error', "[ERROR] {$ProcMessage}", ['exception' => $e]);

        return $this->response
            ->setContentType('application/json')
            ->setStatusCode($statusCode)
            ->setBody(json_encode($ProcMessage));
    }
    public function respondCreated($response, $statusCode=200) :\CodeIgniter\HTTP\Response {
        return $this->response
            ->setContentType('application/json')
            ->setStatusCode($statusCode)
            ->setBody(json_encode($ProcMessage));
    }



}