<?php

namespace App\Models;

use App\Helper\Helper;
use Exception;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        return $this->hasMany('App\Models\Article');
    }

    /**
     * Creating new author
     *
     * @param  string $email
     * @param  string $username
     * @param  string $fullname
     * @param  string $avatar
     * @param  string $password
     * @return bool
     */
    public function create()
    {
        // Begin transaction
        DB::beginTransaction();
        try {
            if ($this->save()) {
                // Save avatar if avatar exists
                if ($this->avatar) {
                    $this->insert_avatar($this->id, $this->avatar);
                }
                // Save transaction
                DB::commit();
                return Author::findOrFail($this->id);
            }

            // Roll back transaction
            DB::rollBack();
            return false;
        } catch (Exception $e) {
            // Roll back transaction
            DB::rollBack();
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * Storing new profile's avatar
     *
     * @param  int $author_id
     * @param  file $avatar
     * @return void
     */
    public function insert_avatar($author_id, $avatar)
    {
        try {
            $location = public_path(self::PUBLIC_IMAGE_AUTHOR_PATH);
            $image_name = Helper::store_image($avatar, $location);
            $filename[] = $image_name;
            return Author::findOrFail($author_id)->update([
                'avatar' => $image_name,
            ]);
        } catch (Exception $e) {
            Helper::remove_image_from_storage($filename, $location);
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * Updating new profile's avatar
     *
     * @param  int $author_id
     * @param  file $avatar
     * @return $author|false
     */
    public function update_avatar($author_id, $avatar)
    {
        //Prevent initial author avatar_src: ""
        if (!empty(Author::findOrFail($author_id, ['avatar'])->avatar)) {
            $old_avatar[] = Author::findOrFail($author_id, ['avatar'])->avatar;
            Helper::remove_image_from_storage($old_avatar, public_path(self::PUBLIC_IMAGE_AUTHOR_PATH));
        }

        // Save avatar
        $is_sucess = $this->insert_avatar($author_id, $avatar);
        if ($is_sucess) {
            return Author::findOrFail($author_id, ['avatar']);
        }

        return false;
    }

    /**
     * Updating new profile
     *
     * @param  int $id
     * @param  string $fullname
     * @param  string $address
     * @param  string $birthday
     * @param  string $phone
     * @return bool
     */
    public function update_profile($id, $fullname, $address, $birthday, $phone)
    {
        return Author::findOrFail($id)->update([
            'fullname' => $fullname,
            'address' => $address,
            'birthday' => $birthday,
            'phone' => $phone,
        ]);
    }

    /**
     * Updating new password
     *
     * @param  string $old_password
     * @param  string $new_password
     * @return bool
     */
    public function update_password($old_password, $new_password)
    {
        // Find author base on email if exists
        $author = Author::where('email', Auth::user()->email)->first();

        //check if author exists and old password matched
        if ($author && Hash::check($old_password, $author->password)) {
            $author->password = bcrypt($new_password);
            $author->save();
            return true;
        }

        return false;
    }
}
