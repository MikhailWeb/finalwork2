<?php
namespace App\Controller;

use Base\Controller;

class Admin extends Controller
{
    public function userlist()
    {
        $user = new \App\Model\User();
        $orderField = $_GET['order_field'] ?? 'birthday';
        $order = $_GET['order'] ?? 'ASC';
        $list = $user->orderBy($orderField, $order)->get();
        $users = []; $i = 0;
        foreach ($list as $item) {
            $users[$i]['id'] = $item->id;
            $avatar = $user->getAvatarUrl($item->avatar);
            $users[$i]['avatar'] = file_exists($_SERVER['DOCUMENT_ROOT'] . UPLOAD_DIR . $avatar) ? UPLOAD_DIR . $avatar : UPLOAD_DIR . '0/default.PNG';
            $users[$i]['name'] = $item->username;
            $users[$i]['email'] = $item->email;
            $users[$i]['birthday'] = (\DateTime::createFromFormat('Y-m-d', $item->birthday))->format('d.m.Y');
            $date1 = new \DateTime($item->birthday);
            $date2 = new \DateTime(date("Y-m-d"));
            $interval = $date2->diff($date1);
            $users[$i]['age'] = $interval->format('%y');
            $users[$i]['adult'] = ((int)($interval->format('%y')) < 18) ? 'no' : 'yes';
            $i++;
        }
        $this->view->render('admin/list.phtml', ['title' => 'User list', 'users' => $users]);
    }

    public function add_user()
    {
        $requireFields = ['name', 'email', 'birthday', 'password', 'password2'];

        if (!empty($_POST)) {
            $data['action'] = 'add_user';
            foreach ($requireFields as $rfields) {
                $data['title'] = 'Add User';
                if ($this->isFieldEmpty($_POST[$rfields])) {
                    $data['title'] = 'Add User: ' . $rfields . ' is empty!';
                    $this->view->render('admin/user.phtml', $data);
                    die;
                } else {
                    $data[$rfields] = trim($_POST[$rfields]);
                }
            }
            $user = new \App\Model\User();
            $user->username = trim($_POST['name']);
            if ($user->checkUnique('email', trim($_POST['email']), 0) == false) {
                $data['title'] = 'Add User: email ' . $_POST['email'] . ' used';
                $this->view->render('admin/user.phtml', $data);
                die;
            } else {
                $user->email = trim($_POST['email']);
            }

            $dt = explode('.', trim($_POST['birthday']));
            $user->birthday = ($dt[2].'-'.$dt[1].'-'.$dt[0]);

            if ($_POST['password'] !== $_POST['password2']) {
                $data['title'] = 'Add User: passwords are not equal';
                $this->view->render('admin/user.phtml', $data);
                die;
            } else {
                $user->password = sha1($_POST['password']);
            }
            $user->avatar = 0;

            if (!$user->save()) {
                $this->view->render('admin/user.phtml', ['title' => 'Add user error', 'action' => 'add_user']);
            } else {
                $this->redirect('/www/admin/userlist');
            }
        } else {
            $this->view->render('admin/user.phtml', ['title' => 'Add user', 'action' => 'add_user']);
        }
    }

    public function edit_user()
    {
        $requireFields = ['name', 'email', 'birthday', 'id'];

        if (!empty($_GET['id'])) {
            $user = new \App\Model\User();
            $userinfo = $user->getOne((int)$_GET['id']);
            $data['action'] = 'edit_user';
            $data['title'] = 'Edit User : ' . $userinfo['username'];
            $data['name'] = $userinfo['username'];
            $data['email'] = $userinfo['email'];
            $dt = explode('-', $userinfo['birthday']);
            $data['birthday'] = $dt[2] . '.' . $dt[1] . '.' . $dt[0];
            $data['password'] = '';
            $data['password2'] = '';
            $data['id'] = (int)$_GET['id'];
            $this->view->render('admin/user.phtml', $data);
        } else if (!empty($_POST)) {
            $data['title'] = 'Edit User';
            $data['action'] = 'edit_user';
            foreach ($requireFields as $rfields) {
                if ($this->isFieldEmpty($_POST[$rfields])) {
                    $data['title'] = 'Edit User: ' . $rfields . ' is empty!';
                    $this->view->render('admin/user.phtml', $data);
                    die;
                } else {
                    $data[$rfields] = trim($_POST[$rfields]);
                }
            }
            $arrParam = [];
            $user = new \App\Model\User();
            $arrParam['username'] = trim($_POST['name']);
            if ($user->checkUnique('email', $_POST['email'], (int)$_POST['id']) == false) {
                $data['title'] = 'Edit User error: email ' . $_POST['email'] . ' used';
                $this->view->render('admin/user.phtml', $data);
                die;
            } else {
                $arrParam['email'] = trim($_POST['email']);
            }

            $dt = explode('.', trim($_POST['birthday']));
            $arrParam['birthday'] = $dt[2].'-'.$dt[1].'-'.$dt[0];

            if (!empty($_POST['password'])) {
                if ($_POST['password'] !== $_POST['password2']) {
                    $data['title'] = 'Edit User: passwords are not equal';
                    $this->view->render('admin/user.phtml', $data);
                    die;
                } else {
                    $arrParam['password'] = sha1($_POST['password']);
                }
            }

            if (!$user::where('id', (int)$_POST['id'])->update($arrParam)) {
                $this->view->render('admin/user.phtml', ['title' => 'Edit user error', 'action' => 'edit_user']);
            } else {
                $this->redirect('/www/admin/userlist');
            }
        }
    }

}
