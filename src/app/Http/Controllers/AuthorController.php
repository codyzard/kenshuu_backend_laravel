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
    }

    public function register()
    {
        if (Auth::check()) return redirect()->route('homes.home')->withErrors('ログインしました！');
        return view('authors.register');
    }

    public function register_process(Request $request)
    {
        $request->validate([
            'email' => 'required|min:6|max:255|email|unique:authors,email',
            'username' => 'required|min:6|max:255|unique:authors,username',
            'fullname' => 'required',
            'password' => 'required_with:cpassword|same:cpassword|min:6|max:100|',
            'cpassword' => 'min:6|max:100',
        ], [
            'email.required' => 'Eメールは空白がいけません',
            'email.min' => 'Eメールは最低6文字、最大255文字としてください！',
            'email.max' => 'Eメールは最低6文字、最大255文字としてください！',
            'email.email' => 'Eメールは無効でした！',
            'email.unique' => 'Eメールは存在しました！',
            'username.unique' => 'ユーザーネームは存在しました！',
            'username.required' => 'ユーザーネームは空白がいけません',
            'username.min' => 'ユーザーネームは最低6文字、最大255文字としてください！',
            'username.max' => 'ユーザーネームは最低6文字、最大255文字としてください！',
            'fullname.required' => 'フルネームは空白がいけません',
            'password.min' => 'パスワードは最低6文字、最大100文字としてください！',
            'password.max' => 'パスワードは最低6文字、最大100文字としてください！',
            'cpassword.min' => '確認パスワードは最低6文字、最大100文字としてください！',
            'cpassword.max' => '確認パスワードは最低6文字、最大100文字としてください！',
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

    public function login()
    {
        if (Auth::check()) return redirect()->route('homes.home')->withErrors('ログインしました！');
        return view('authors.login');
    }

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
     * check input is email or username
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

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect()->route('authors.login');
    }

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

    public function update_avatar(Request $request)
    {

    }
}
