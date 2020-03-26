<?php
namespace App\Controller;

use Base\Controller;

class File extends Controller
{
    public function userfiles()
    {
        if (!empty($_SESSION['user_id'])) {
            $user = new \App\Model\User();
            $userData = $user->getOne((int)$_SESSION['user_id']);

            if (!empty($_FILES['file'])) {
                $file = new \App\Model\File([
                    'user_id' => $userData['id'],
                    'filename' => $_FILES['file']['name'],
                    'size' => $_FILES['file']['size']
                ]);
                $file->upload();
            }

            $files = \App\Model\File::getFilesByUserId($userData['id']);

            $this->view->render('file/list.phtml', ['title' => 'User file list', 'files' => $files, 'avatar' => $userData['avatar']]);
        }
    }

    public function updateAvatar()
    {
        $user = new \App\Model\User();
        if (!empty($_SESSION['user_id'])) {
            $user::where('id', (int)$_SESSION['user_id'])->update(['avatar' => $_POST['isAvatar']]);
        }
        $this->redirect('/www/user/profile');
    }

}
