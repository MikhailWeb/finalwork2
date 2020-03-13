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

            if (!$user->login(trim($_POST['email']), $_POST['password'])) {
                $this->view->render('user/login.phtml', ['title' => 'User not found!']);
            } else {
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
            if ($_POST['password'] !== $_POST['password2']) {
                $data['title'] = 'User registration: passwords are not equal';
                $this->view->render('user/register.phtml', $data);
                die;
            }
            $user = new \App\Model\User();
            $user->setName(trim($_POST['name']));
            $user->setEmail(trim($_POST['email']));
            $dt = explode('.', trim($_POST['birthday']));
            $user->setBirthday($dt[2].'-'.$dt[1].'-'.$dt[0]);
            $user->setPassword($_POST['password']);
            $user->setAvatar(0);

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
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            $user = new \App\Model\User();
            $user->getById((int)$_SESSION['user_id']);

            $data['title'] = 'Hi, ' . $user->getName();
            $data['username'] = $user->getName();
            $data['email'] = $user->getEmail();
            $data['birthday'] = $user->getBirthday();
            $avatarURL = file_exists($_SERVER['DOCUMENT_ROOT'].$user->getAvatarUrl()) ? $user->getAvatarUrl() : '/www/upload/user/0/default.PNG';
            $data['avatar'] = $avatarURL;
            $this->view->render('user/profile.phtml', $data);
        } else {
            $this->view->render('user/login.phtml', ['title' => 'Login']);
        }

    }


}