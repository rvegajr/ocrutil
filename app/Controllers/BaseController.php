<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use \RedBeanPHP\R as R;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['common', 'database', 'functions', 'actions'];
    protected $session = null;
    protected $CurrentUser = null;
    protected $data = array();
    protected $urlenv = 'local';

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        $url = strtolower((isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
        $this->urlenv='prod';
        if ((str_contains($url, ':8889')) || (str_contains($url, ':8890'))) {
            $this->urlenv = 'local';
        } else if (str_contains($url, 'dev')) {
            $this->urlenv = 'dev';
        }
        $user = auth()->user();
        $this->user = $user;
        if ($user != null) {
            if (str_ends_with(get_class($user), "User")) {
                $this->CurrentUser = $user->username;
            } else {
                $this->CurrentUser = $user;
            }
        }
        $this->data['username']="Developer";

        $this->helpers = array_merge($this->helpers, ['auth', 'setting', 'render', 'SqlQueryBuilder', 'ocrutildb']);

        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
        $this->session = session();
        $this->afterInitController();
        $this->data['urlenv']=$this->urlenv;
        $this->data['is_admin']='Y';
    }

    protected function afterInitController() {

    }
}
