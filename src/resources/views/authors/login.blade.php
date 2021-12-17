@extends('layouts.application')

@section('content')

    <div class="session">
        <div class="login">
            @if ($errors->any())
                <div class="flash flash--danger">
                    @foreach ($errors->all() as $error)
                        <p class="message">{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <h3>ユーザーログイン</h3>
            <form action="{{ route('authors.login_process') }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="text" name="email_or_username" id="email_or_username" class="form-control"
                        placeholder="メールアドレス又はユーザーネーム" required />
                    <i class="far fa-envelope fa-lg"></i>
                </div>
                <div class="form-group">
                    <input type="password" name="password" id="password" class="form-control" placeholder="パスワード"
                        required />
                    <i class="fas fa-lock fa-lg"></i>
                    <span class="show-hide-pw">表示</span>
                </div>
                <a href="#" class="forgotten_password">パスワードをお忘れの方</a>
                <input type="submit" value="ログイン" class="btn btn-submit" />
                <div class="form-group">
                    <input type="checkbox" name="save_session" /><label></i>次回から自動的にログイン</label>
                </div>
                <a href="{{ route('authors.register') }}"><input type="button" value="お申し込み" class="btn btn-res" /></a>
            </form>
            <p class="description">
                アカウントをお持ちでない方で、PR
                TIMESでプレスリリース配信・掲載を希望される方は、”お申し込み”ボタンから企業登録申請を行ってください。
            </p>
        </div>
    </div>

@endsection
