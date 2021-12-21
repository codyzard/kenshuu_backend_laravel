<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Author;

class AuthorController extends Controller
{

    private $authorModel;

    public function __construct()
    {
        $this->authorModel = new Author();
        $this->middleware('author_authenticate')->only([
            'update_avatar',
            'edit_profile',
            'update_profile',
            'edit_password',
            'update_password',
        ]);
        $this->middleware('author_authorize')->only([
            'edit_profile',
            'update_profile',
            'edit_password',
            'update_password',
        ]);
    }

    /**
     * Rendering register form
     *
     * @return view
     */
    public function register()
    {
        if (Auth::check()) return redirect()->route('homes.home')->withErrors('ログインしました！');
        return view('authors.register');
    }

    /**
     * Register process
     *
     * @param  mixed $request
     * @return view
     */
    public function register_process(Request $request)
    {
        $request->validate([
            'email' => 'required|min:6|max:255|email|unique:authors,email',
            'username' => 'required|min:6|max:255|unique:authors,username',
            'fullname' => 'required',
            'password' => 'required_with:cpassword|same:cpassword|min:6|max:100|',
            'cpassword' => 'min:6|max:100',
        ]);

        $email = $request->email;
        $username = $request->username;
        $fullname = $request->fullname;
        $avatar = null;
        $password = $request->password;
        if ($request->hasFile('profile-avatar')) {
            $avatar = $request->file('profile-avatar');
        }
        $new_author = $this->authorModel->create($email, $username, $fullname, $avatar, $password);
        if ($new_author) {
            Auth::login($new_author);
            return redirect()->route('homes.home')->with('message', 'アカウントを登録することは成功しました！');
        }
        return redirect()->route('authors.register')->withErrors('アカウントを登録することができませんでした！');
    }

    /**
     * Rendering login form
     *
     * @return void
     */
    public function login()
    {
        if (Auth::check()) return redirect()->route('homes.home')->withErrors('ログインしました！');
        return view('authors.login');
    }

    /**
     * Login process
     *
     * @param  mixed $request
     * @return view
     */
    public function login_process(Request $request)
    {
        $request->validate([
            'email_or_username' => 'required|min:6|max:255',
            'password' => 'required|min:6|max:100',
        ], [
            'email_or_username.required' => 'Eメール又はユーザーネームは空白がいけません',
            'email_or_username.min' => 'Eメール又はユーザーネームは最低6文字、最大255文字としてください！',
            'email_or_username.max' => 'Eメール又はユーザーネームは最低6文字、最大255文字としてください！',
            'password.required' => 'パスワードは空白がいけません',
            'password.min' => 'パスワードは最低6文字、最大100文字としてください！',
            'password.min' => 'パスワードは最低6文字、最大100文字としてください！',
        ]);

        $credentials = $this->credentials_process($request);
        if (Auth::attempt($credentials)) {
            return redirect()->route('homes.home')->with('message', 'ログインしました！');
        }

        return redirect()->route("authors.login")->withErrors('Eメール(ユーザーネーム)又はパスワードは妥当しませんでした！');
    }

    /**
     * Checking input is email or username
     *
     * @param  mixed $request
     * @return array
     */
    public function credentials_process(Request $request)
    {
        $field = filter_var($request->email_or_username, FILTER_VALIDATE_EMAIL) ?
            'email'
            :
            'username';
        return [
            $field => $request->email_or_username,
            'password' => $request->password,
        ];
    }

    /**
     * Destroying session
     *
     * @return view
     */
    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect()->route('authors.login');
    }

    /**
     * Rendering profile
     *
     * @param  int $id
     * @return void
     */
    public function profile($id)
    {
        $author = Author::find($id);
        if ($author) {
            return view('authors.profile', [
                'author' => Author::find($id),
            ]);
        }
        return redirect()->route('notfounds.not_found');
    }

    /**
     * Updating profile's avatar
     *
     * @param  mixed $request
     * @return void
     */
    public function update_avatar(Request $request)
    {
        $author_id = $request->author_id;
        if ($author_id && $request->hasFile('update_avatar') && Auth::user()->id == $author_id) {
            $image_src = $this->authorModel->update_avatar($author_id, $request->file('update_avatar'));
            return response()->json([
                'image_src' => $image_src->avatar,
            ]);
        }
    }

    /**
     * Rendering profile's edit form
     *
     * @param  int $id
     * @return void
     */
    public function edit_profile()
    {
        return view('authors.update_profile', [
            'author' => Auth::user(),
        ]);
    }

    /**
     * Updating profile
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function update_profile(Request $request, $id)
    {
        $request->validate([
            'fullname' => 'required',
            'address' => 'required',
            'birthday' => 'required',
            'phone' => 'required|min:10|max:14',
        ]);
        $fullname = $request->fullname;
        $address = $request->address;
        $birthday = $request->birthday;
        $phone = $request->phone;
        // Check phone number existed but if user's phone number is 0123456789, 0123456789 saved again will be accept
        if (Author::where('phone', $phone)->count() > 0 && Author::where('phone', $phone)->first()->id != $id) {
            return redirect()->route('authors.edit_profile', $id)->withErrors('電話番号は存在しました！');
        }
        $is_success = $this->authorModel->update_profile($id, $fullname, $address, $birthday, $phone);
        if ($is_success) {
            return redirect()->route('authors.profile', $id)->with('message', 'プロフィールを変更することは成功でした！');
        }
        return redirect()->route('authors.edit_profile', $id)->withErrors('プロフィールを変更することは失敗でした！');
    }

    /**
     * Rendering password's edit form
     *
     * @param  mixed $id
     * @return void
     */
    public function edit_password()
    {
        return view('authors.update_password', [
            'author' => Auth::user(),
        ]);
    }

    /**
     * Updating password
     *
     * @param  mixed $request
     * @return void
     */
    public function update_password(Request $request)
    {
        if (Auth::user()) {
            $request->validate([
                'old_password' => 'required|min:6|max:100',
                'new_password' => 'required_with:cnew_password|same:cnew_password|min:6|max:100|',
                'cnew_password' => 'required|min:6|max:100',
            ]);
            $old_password = $request->old_password;
            $new_password = $request->new_password;
            $is_success = $this->authorModel->update_password($old_password, $new_password);
            if ($is_success) {
                return redirect()->route('authors.profile', Auth::user()->id)->with('message', 'パスワードを変更することは成功でした！');
            }
            return redirect()->back()->withErrors('オールドパスワードは間違いました！');
        }
        return redirect()->route('notfounds.not_found');
    }
}
