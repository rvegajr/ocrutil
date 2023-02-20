<?php
namespace App\Controllers;

use App\Helpers\Companies;
use Config\Auth;
use PharIo\Manifest\Library;

class ExceptionQueueController extends BaseController
{
    public function index()
    {
        //$isLoggedIn = auth()->loggedIn();
        $isLoggedIn=true;
        if (!$isLoggedIn) {
            return redirect()->to("login");
        } else {
            $user = auth()->user();
            $this->data['url']="";
            return render('exception_queue', $this->data);
        }
    }
}
