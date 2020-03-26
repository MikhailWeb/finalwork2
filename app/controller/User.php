<?php
namespace App\Controller;

use Base\Controller;

class User extends Controller
{

    public function login()
    {
        $requireFields = ['email', 'password'];

        if (!empty($_POST)) {
            foreach ($requireFields as $rfields) {
                $data['title'] = 'Login';
                if ($this->isFieldEmpty($_POST[$rfields])) {
                    $data['title'] = 'Login: ' . $rfields . ' is empty!';
                    $this->view->render('user/login.phtml', $data);
                    die;
                } else {
                    $data[$rfields] = trim($_POST[$rfields]);
                }
            }
            $user = new \App\Model\User();

            $auth = $user->login($data['email'], $data['password']);
            if (empty($auth)) {
                $this->view->render('user/login.phtml', ['title' => 'User not found!']);
            } else {
                $_SESSION['user_id'] = $auth->id;
                $this->redirect('/www/user/profile');
            }
        } else {
            if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
                $this->redirect('/www/user/profile');
            } else {
                $this->view->render('user/login.phtml', ['title' => 'Login']);
            }
        }

    }

    public function logout()
    {
        session_destroy();
        header('Location: /www/index');
    }

    public function register()
    {
        $requireFields = ['name', 'email', 'birthday', 'password', 'password2'];

        if (!empty($_POST)) {
            foreach ($requireFields as $rfields) {
                $data['title'] = 'User registration';
                if ($this->isFieldEmpty($_POST[$rfields])) {
                    $data['title'] = 'User registration: ' . $rfields . ' is empty!';
                    $this->view->render('user/register.phtml', $data);
                    die;
                } else {
                    $data[$rfields] = trim($_POST[$rfields]);
                }
            }
            $user = new \App\Model\User();
            $user->username = trim($_POST['name']);
            if ($user->checkUnique('email', trim($_POST['email']), 0) == false) {
                $data['title'] = 'User registration: email ' . $_POST['email'] . ' used';
                $this->view->render('user/register.phtml', $data);
                die;
            } else {
                $user->email = trim($_POST['email']);
            }

            $dt = explode('.', trim($_POST['birthday']));
            $user->birthday = ($dt[2].'-'.$dt[1].'-'.$dt[0]);

            if ($_POST['password'] !== $_POST['password2']) {
                $data['title'] = 'User registration: passwords are not equal';
                $this->view->render('user/register.phtml', $data);
                die;
            } else {
                $user->password = sha1($_POST['password']);
            }
            $user->avatar = 0;

            if (!$user->save()) {
                $this->view->render('user/register.phtml', ['title' => 'Registration error']);
            } else {
                $this->view->render('user/login.phtml', ['title' => 'Registration succesfull! Congratulaition! Login please']);
            }
        } else {
            $this->view->render('user/register.phtml', ['title' => 'User registration']);
        }
    }

    public function profile()
    {
        if (!empty($_SESSION['user_id'])) {
            $user = new \App\Model\User();
            $userData = $user->getOne($_SESSION['user_id']);
            if (!empty($userData)) {
                $data['title'] = 'Hi, ' . $userData['username'];
                $data['username'] = $userData['username'];
                $data['email'] = $userData['email'];
                $bday = explode('-', $userData['birthday']);
                $data['birthday'] = $bday[2] . '.' . $bday[1] . '.' . $bday[0];
                $avatar = $user->getAvatarUrl($userData['avatar']);
                $data['avatar'] = file_exists($_SERVER['DOCUMENT_ROOT'] . UPLOAD_DIR . $avatar) ? UPLOAD_DIR . $avatar : UPLOAD_DIR . '0/default.PNG';

                $this->view->render('user/profile.phtml', $data);
            }
        } else {
            $this->view->render('user/login.phtml', ['title' => 'Login']);
        }

    }
}