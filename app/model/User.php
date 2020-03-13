<?php
namespace App\Model;

use Base\Db;
use Base\Model;

class User extends Model
{
    protected $id;
    protected $data;
    protected $idField = 'id';
    protected static $table = 'users';

    public function setName(string $name): self
    {
        $this->set('username', $name);
        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->set('email', $email);
        return $this;
    }

    public function setBirthday(string $date): self
    {
        $this->set('birthday', $date);
        return $this;
    }

    public function setAvatar(int $id): self
    {
        $this->set('avatar', $id);
        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->set('pass', sha1($password));
        return $this;
    }

    public function getName()
    {
        return $this->get('username');
    }

    public function getEmail()
    {
        return $this->get('email');
    }

    public function getBirthday()
    {
        return $this->get('birthday');
    }

    public function getPassword()
    {
        return $this->get('pass');
    }

    public function getAvatar()
    {
        return $this->get('avatar');
    }

    public function login(string $login, string $password)
    {
        $table = static::$table;
        $select = "SELECT id FROM $table WHERE email = :login and pass = :password";
        $userData = Db::getInstance()->fetchOne($select, __METHOD__, [':login' => $login, ':password' => sha1($password)]);

        if ($userData == false) {
            return false;
        } else {
            $_SESSION['user_id'] = $userData['id'];
            return true;
        }
    }

    public function getAvatarUrl()
    {
        $file = new File();
        $file->getById((int)$this->getAvatar());
        return '/www/upload/user/' . $this->getId() . '/' . $file->filename;
    }

    public function updateUserAvatar(int $userId, int $fileId)
    {
        $table = static::$table;
        $update = "UPDATE $table SET avatar = $fileId WHERE id = $userId";
        Db::getInstance()->exec($update, __METHOD__);
    }
}
