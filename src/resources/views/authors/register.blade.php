@extends('layouts.application')

@section('content')

    <div class="session">
        <div class="register">
            @if ($errors->any())
                <div class="flash flash--danger">
                    @foreach ($errors->all() as $error)
                        <p class="message">{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <h3>ユーザーレジスター</h3>
            <form action="{{route('authors.register_process')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <input type="email" name="email" id="email" class="form-control" placeholder="メールアドレス" required />
                    <i class="far fa-envelope fa-lg"></i>
                </div>
                <div class="form-group">
                    <input type="text" name="username" id="username" class="form-control" placeholder="ユーザーネーム" required />
                    <i class="fas fa-user"></i>
                </div>
                <div class="form-group">
                    <input type="text" name="fullname" id="fullname" class="form-control" placeholder="名前" required />
                    <i class="fas fa-signature"></i>
                </div>
                <div class="form-group">
                    <input type="file" name="profile-avatar" id="profile-avatar" class="form-control"
                        title="Choose profile image" />
                    <i class="fas fa-id-card"></i>
                </div>
                <div class="form-group">
                    <input type="password" name="password" id="password" class="form-control hidden-text"
                        placeholder="パスワード" required />
                    <i class="fas fa-lock fa-lg"></i>
                    <span class="show-hide-pw">表示</span>
                </div>
                <div class="form-group">
                    <input type="password" name="cpassword" id="cpassword" class="form-control hidden-text"
                        placeholder="パスワード コンファーム" required />
                    <i class="far fa-check-circle"></i>
                    <span class="show-hide-pw">表示</span>
                </div>
                <input type="submit" id="submit-register" value="レジスター" class="btn btn-submit" />
            </form>
            <p class="description">
                アカウントをお持ちでない方で、PR TIMESでプレスリリース配信・掲載を希望される方は、”お申し込み”ボタンから企業登録申請を行ってください。
            </p>
        </div>
    </div>

@endsection
