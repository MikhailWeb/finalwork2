<?php
namespace App\Model;

use Base\Db;
use Base\Model;

class File extends Model
{
    protected $id;
    protected $data;
    protected $idField = 'id';
    protected static $table = 'files';

    public function __get($name)
    {
        return $this->get($name);
    }

    public function save()
    {
        parent::save();
        $path = $_SERVER['DOCUMENT_ROOT'].'/www/upload/user/' . $_SESSION['user_id'] . '/';
        if (!file_exists($path)) {
            mkdir($path);
        }
        move_uploaded_file($_FILES['file']['tmp_name'], $path.$_FILES['file']['name']);
    }

    public static function getFilesByUserId(int $userId)
    {
        $db = Db::getInstance();
        $table = static::$table;
        $select = "SELECT * FROM $table WHERE user_id = $userId ORDER BY id DESC LIMIT 1000";
        $data = $db->fetchAll($select, __METHOD__);

        if(!$data) {
            return  [];
        }

        $result = [];
        foreach ($data as $elem) {
            $model = new static();
            $model->data = $elem;
            $model->setId($elem['id']);
            $result[] = $model;
        }

        return $result;
    }
}
