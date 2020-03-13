<?php
namespace App\Controller;

use Base\Controller;

class Admin extends Controller
{

    public function userlist()
    {
        $where = '';
        $orderField = $_GET['order_field'] ?? 'id';
        $order = $_GET['order'] ?? 'ASC';
        $users = [];
        $list = \App\Model\User::getList($where, ' ORDER BY ' . $orderField . ' ' . $order);

        for ($u = 0; $u < sizeof($list); $u++) {
           $users[$u]['id'] = $list[$u]->getId();
           $users[$u]['avatar'] = file_exists($_SERVER['DOCUMENT_ROOT'].$list[$u]->getAvatarUrl()) ? $list[$u]->getAvatarUrl() : '/www/upload/user/0/default.PNG';
           $users[$u]['name'] = $list[$u]->getName();
           $users[$u]['birthday'] = (\DateTime::createFromFormat('Y-m-d', $list[$u]->getBirthday()))->format('d.m.Y');
           $date1 = new \DateTime($list[$u]->getBirthday());
           $date2 = new \DateTime(date("Y-m-d"));
           $interval = $date2->diff($date1);
           $users[$u]['age'] = $interval->format('%y');
           $users[$u]['adult'] = ((int)$users[$u]['age'] < 18) ? 'no' : 'yes';

        }
        $this->view->render('admin/list.phtml', ['title' => 'User list', 'users' => $users]);
    }

}
