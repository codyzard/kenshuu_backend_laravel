<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Author;
use App\Http\Requests\LoginAuthorRequest;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorPasswordRequest;
use App\Http\Requests\UpdateAuthorProfileRequest;

class AuthorController extends Controller
{

    private $authorModel;

    public function __construct(Author $author)
    {
        // Init model
        $this->authorModel = $author;
        // Add before_action authenticate when access, modify author profile
        $this->middleware('author_authenticate')->only([
            'update_avatar',
            'edit_profile',
            'update_profile',
            'edit_password',
            'update_password',
        ]);
        // Add before_action authorized when modify author profile
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
    public function register_process(StoreAuthorRequest $request)
    {
        // Assign request input to new authorModel object
        $this->authorModel->email = $request->email;
        $this->authorModel->username = $request->username;
        $this->authorModel->fullname = $request->fullname;
        $this->authorModel->password = bcrypt($request->password);

        // Process about avatar if avatar exist
        if ($request->hasFile('profile-avatar')) {
            $this->authorModel->avatar = $request->file('profile-avatar');
        }

        // create new author
        $new_author = $this->authorModel->create();
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
    public function login_process(LoginAuthorRequest $request)
    {
        //Assign author login data object
        $credentials = $this->credentials_process($request);
        $remember_check = $request->has('remember_me') ?: false;

        //Login successful if username(email) and password is authenticated
        if (Auth::attempt($credentials, $remember_check)) {
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
    public function credentials_process(LoginAuthorRequest $request)
    {
        // Check INPUT is email or not ?
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
     * @return view
     */
    public function profile($id)
    {
        // Find author base on $id if exists
        $author = Author::findOrFail($id);
        if ($author) {
            return view('authors.profile', [
                'author' => $author,
            ]);
        }
        return abort(404);
    }

    /**
     * Updating profile's avatar
     *
     * @param  mixed $request
     * @return json
     */
    public function update_avatar(Request $request)
    {
        // Assign author id from request
        $author_id = $request->author_id;

        // Update avatar if author exist && avatar posted exists
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
     * @return view
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
     * @return redirect
     */
    public function update_profile(UpdateAuthorProfileRequest $request, $id)
    {
        // Get author from database if existed
        $this->authorModel = Author::findOrFail($id);

        // Assign request input to authorModel existed
        $this->authorModel->fullname = $request->fullname;
        $this->authorModel->address = $request->address;
        $this->authorModel->birthday = $request->birthday;
        $this->authorModel->phone = $request->phone;

        // Check phone number existed but if user's phone number is 0123456789, 0123456789 saved again will be accept
        if (Author::where('phone', $this->authorModel->phone)->count() > 0 && Author::where('phone', $this->authorModel->phone)->first()->id != $id) {
            return redirect()->route('authors.edit_profile', $id)->withErrors('電話番号は存在しました！');
        }

        // Save new author's info into database
        if ($this->authorModel->save()) {
            return redirect()->route('authors.profile', $id)->with('message', 'プロフィールを変更することは成功でした！');
        }
        return redirect()->route('authors.edit_profile', $id)->withErrors('プロフィールを変更することは失敗でした！');
    }

    /**
     * Rendering password's edit form
     *
     * @param  mixed $id
     * @return redirect
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
     * @return redirect
     */
    public function update_password(UpdateAuthorPasswordRequest $request)
    {
        // Assign request input (password's)
        $old_password = $request->old_password;
        $new_password = $request->new_password;

        // Update new password
        $is_success = $this->authorModel->update_password($old_password, $new_password);
        if ($is_success) {
            return redirect()->route('authors.profile', Auth::user()->id)->with('message', 'パスワードを変更することは成功でした！');
        }

        return redirect()->back()->withErrors('オールドパスワードは間違いました！');
    }
}
