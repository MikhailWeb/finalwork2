<?php
namespace App\Model;

use Illuminate\Database\QueryException;
use Base\Model;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['username', 'birthday', 'email', 'password', 'avatar'];

    public function create($userData)
    {
        $user = new self();
        $user->email = $userData['email'];
        $user->password = sha1($userData['password']);
        $user->username = $userData['name'];
        $dt = explode('.', $userData['birthday']);
        $user->birthday = $dt[2].'-'.$dt[1].'-'.$dt[0];
        try{
            $user->save();
            return $user;
        } catch (QueryException $exception){
            throw new UserException($exception->getMessage());
        }
    }

    public function getOne($id)
    {
        $user = self::where('id', $id)->get()[0]->getAttributes();
        return $user;
    }

    public function login($login, $password)
    {
        return  self::where([['email', '=', $login], ['password', '=' , sha1($password)]])->get()[0];
    }

    public function getAvatarUrl($id)
    {
        if ($id == 0) {
            return '0/default.PNG';
        } else {
            $avatar = File::getFileById($id);
            return $avatar['user_id'] . '/' . $avatar['filename'];
        }
    }

    public function checkUnique(string $field, string $value, int $id)
    {
        if ($id == 0) {
            $count = self::where($field, $value)->count();
        } else {
            $count = self::where('id', '<>', $id)->where($field, '=', $value)->count();
        }

        if ($count > 0) {
            return false;
        } else {
            return true;
        }
    }
}

class UserException extends \Exception
{

}