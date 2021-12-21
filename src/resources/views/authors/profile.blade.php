@extends('layouts.application')

@section('content')

    <div class="profile">
        <div class="main-profile">
            @if (Session::has('message'))
                <div class="flash flash--success">
                    <p class="message">{{ Session::get('message') }}</p>
                </div>
            @endif
            @if ($errors->any())
                <div class="flash flash--danger">
                    @foreach ($errors->all() as $error)
                        <p class="message">{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <label for="{{ Auth::user()->id === $author->id ? 'profile-change' : '' }}"
                class="profile__avatar {{ Auth::user()->id === $author->id ? 'change-avatar' : '' }}">
                <img src="{{ asset('assets/image/authors/' . ($author->avatar && file_exists(public_path('assets/image/authors/' . $author->avatar)) ? $author->avatar : '../default-avatar.png')) }}"
                    alt="avatar">
                <form method="POST" enctype="multipart/form-data" action="javascript:void(0)" id="form-avatar">
                    @csrf
                    <input name="update_avatar" type="file" class="form-control" id="profile-change" hidden>
                </form>
                <!-- will use for change avatar by Ajax-->
                <p class="tooltip">アバターを変更する？</p>
            </label>
            <p class="profile__name">{{ $author->fullname }}</p>
            <p class="profile__contribution">
                <span class="profile__contribution__title">記事の数</span>
                <span class="profile__contribution__number">{{ $author->articles()->count() }}</span>
            </p>
        </div>
        <div class="sub-profile">
            <p class="profile__address">Eメール: <span>{{ $author->email ?: 'N/A' }}</span></p>
            <p class="profile__address">ユーザーネーム: <span>{{ $author->username ?: 'N/A' }}</span></p>
            <p class="profile__address">住所: <span>{{ $author->address ?: 'N/A' }}</span></p>
            <p class="profile__birthday">生年月日: <span>{{ $author->birthday ?: 'N/A' }}</span></p>
            <p class="profile__phone">電話番号: <span>{{ $author->phone ?: 'N/A' }}</span></p>
        </div>
        @if ($author->id == Auth::user()->id)
            <div class="profile__control">
                <a class="btn btn--warning btn--radius"
                    href="{{ route('authors.edit_password', $author->id) }}">パスワードを変更</a>
                <a class="btn btn--info btn--radius"
                    href="{{ route('authors.edit_profile', $author->id) }}">プロフィールを変更</a>
            </div>
        @endif
    </div>

@endsection
