@extends('layouts.application')

@section('content')
    <div class="post-article">
        <h1 class="post-article__heading">投稿</h1>
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
        <form class="form" action="{{ route('articles.create') }}" method="POST" enctype="multipart/form-data">
            {{-- CSRF --}}
            @csrf
            <div class="form-group">
                <label for="">タイトル</label>
                <textarea name="title" id="title" cols="50" rows="3" placeholder="タイトルをつけて。。。" required></textarea>
            </div>
            <div class="form-group">
                <label for="">イメージ</label>
                <input type="file" accept="image/png, image/jpeg" name="images[]" id="images" multiple>
            </div>
            <div class="form-group">
                <label for="">サムネイル</label>
                <div class="images-choosen">
                </div>
            </div>
            <div class="form-group">
                <label for="">コンテンツ</label>
                <textarea name="content" id="content" cols="50" rows="10" placeholder="何か書いて。。。" required></textarea>
            </div>
            <div class="form-group">
                <label for="">カテゴライズ</label>
                <select name="categories[]" id="categories" multiple required>
                    <option value="" disabled>Select your option</option>
                    <?php foreach ($categories as $c) : ?>
                    <option value="{{ $c->id }}">{{ $c->category_name }}</option>
                    <?php endforeach ?>
                </select>
            </div>
            <button type="submit" class="btn btn--primary btn--large">投稿</button>
        </form>
    </div>

@endsection
