<?php
namespace App\Model;

use Base\Model;

class File extends Model
{
    protected $table = 'files';
    protected $fillable = ['filename','user_id','size'];

    public function upload()
    {
        $path = $_SERVER['DOCUMENT_ROOT'].UPLOAD_DIR . $_SESSION['user_id'] . '/';
        if (!file_exists($path)) {
            mkdir($path);
        }

        if (!empty($_FILES) && move_uploaded_file($_FILES['file']['tmp_name'], $path.$_FILES['file']['name'])) {
            $file = new File(['filename' => $_FILES['file']['name'], 'user_id' => $_SESSION['user_id'], 'size' => $_FILES['file']['size']]);
            $file->save();
        } else {
            throw new FileException('Не удалось загрузить файл.');
        }
    }

    public static function getFilesByUserId(int $userId, string $sort = 'desc')
    {
        if(!empty($userId)){
            $files = self::where('user_id', $userId)->orderBy('filename', $sort)->get();
        } else {
            $files = self::orderBy('filename', $sort)->get();
        }
        return $files;

    }

    public static function getFileById(int $id)
    {
       $file = self::where('id', $id)->get()[0]->getAttributes();
       return $file;

    }

}

class FileException extends \Exception
{

}