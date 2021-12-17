<?php

namespace App;

use App\Helper\Helper;
use Exception;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class Author extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username', 'email', 'fullname', 'password',
        'avatar', 'address', 'birthday', 'phone'
    ];

    const PUBLIC_IMAGE_AUTHOR_PATH = '/assets/image/authors/';
    /**
     * author has many articles
     *
     * @return hasMany #1-n associate
     */
    public function articles()
    {
        return $this->hasMany('App\Article');
    }

    public function create($email, $username, $fullname, $avatar, $password)
    {
        DB::beginTransaction();
        try {
            $author = new Author();
            $author->email = $email;
            $author->username = $username;
            $author->fullname = $fullname;
            $author->password = bcrypt($password);
            if ($author->save()) {
                if ($avatar && $this->insert_avatar($author->id, $avatar)) {
                    DB::commit();
                    return Author::find($author->id);
                }
            }
            DB::rollBack();
            return false;
        } catch (Exception $e) {
            DB::rollBack();
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    public function insert_avatar($author_id, $avatar)
    {
        try {
            $location = public_path(self::PUBLIC_IMAGE_AUTHOR_PATH);
            $image_name = Helper::store_image($avatar, $location);
            $filename[] = $image_name;
            return Author::find($author_id)->update([
                'avatar' => $image_name,
            ]);
        } catch (Exception $e) {
            Helper::remove_image_from_storage($filename, $location);
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }
}
