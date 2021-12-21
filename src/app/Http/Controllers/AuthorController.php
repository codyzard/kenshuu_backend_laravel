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
        if ($author_id && $request->hasFile('update_avatar')) {
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
    public function edit_profile($id)
    {
        $author = Auth::user();
        if ($author && $author->id == $id) {
            return view('authors.update_profile', [
                'author' => $author,
            ]);
        }
        return redirect()->route('notfounds.not_found');
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
        ], [
            'fullname.required' => 'フルネームは空白がいけません！',
            'address.required' => '住所は空白がいけません！',
            'birthday.required' => '生年月日は空白がいけません！',
            'phone.required' => '電話番号は空白がいけません！',
            'phone.min' => '電話番号は最低10文字、最大14文字としてください！',
            'phone.max' => '電話番号は最低10文字、最大14文字としてください！',
        ]);
        $fullname = $request->fullname;
        $address = $request->address;
        $birthday = $request->birthday;
        $phone = $request->phone;
        if (Author::where('phone', $phone)->count() > 0) {
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
    public function edit_password($id)
    {
        $author = Auth::user();
        if ($author && $author->id == $id) {
            return view('authors.update_password', [
                'author' => $author,
            ]);
        }
        return redirect()->route('notfounds.not_found');
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
            ], [
                'old_password.required' => 'オールドパスワードは空白がいけません！',
                'new_password.required' => '新しいパスワードは空白がいけません！',
                'cnew_password.required' => 'パスワード確認は空白がいけません！',
                'new_password.same' => '新しいパスワードとパスワード確認は同じでなければなりません！',
                'min' => 'パスワードは最低10文字、最大14文字としてください！',
                'max' => 'パスワードは最低10文字、最大14文字としてください！',
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
