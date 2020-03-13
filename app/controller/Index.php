<?php
namespace App\Controller;

use Base\Controller;

class Index extends Controller
{
    public function index()
    {
        //session_start();
        if (empty($_SESSION['user_id'])) {
            header('Location: http://mvc/www/user/login');
        } else {
            header('Location: http://mvc/www/user/profile');
        }

    }
}
