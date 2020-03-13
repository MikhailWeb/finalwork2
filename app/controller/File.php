<?php
namespace App\Controller;

use Base\Controller;

class File extends Controller
{
    public function userfiles()
    {
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            $user = new \App\Model\User();
            $user->getById((int)$_SESSION['user_id']);

            if (!empty($_FILES['file'])) {
                $file = new \App\Model\File([
                    'user_id' => $user->getId(),
                    'filename' => $_FILES['file']['name'],
                    'size' => $_FILES['file']['size']
                ]);
                $file->save();
            }

            $files = \App\Model\File::getFilesByUserId($user->getId());

            $this->view->render('file/list.phtml', ['title' => 'User file list', 'files' => $files, 'avatar' => $user->getAvatar()]);
        }
    }

    public function updateAvatar()
    {
        $user = new \App\Model\User();
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            $user->updateUserAvatar((int)$_SESSION['user_id'], $_POST['isAvatar']);
        }
        $this->redirect('http://mvc/www/user/profile');
    }

    public function read()
    {
        $id = $_GET['file_id'];
        $file = (new \App\Model\File())->getById($id);
        $data = file_get_contents('upload/files/user/' . $file->name);
        header('Content-type: image/jpeg');
        echo $data;
    }
}
