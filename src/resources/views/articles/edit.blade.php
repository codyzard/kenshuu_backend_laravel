@extends('layouts.application')

@section('content')
    <div class="post-article">
        <h1 class="post-article__heading">変更</h1>
        @if ($errors->any())
            <div class="flash flash--danger">
                @foreach ($errors->all() as $error)
                    <p class="message">{{ $error }}</p>
                @endforeach
            </div>
        @endif
        <form class="form" action="{{ route('articles.update', $article_edit->id) }}" method="POST">
            @method('PATCH')
            @csrf
            <div class="form-group">
                <label for="">タイトル</label>
                <textarea name="title" id="title" cols="50" rows="3" placeholder="タイトルをつけて。。。"
                    required>{{ $article_edit->title }}</textarea>
            </div>
            <div class="form-group">
                <label for="">コンテンツ</label>
                <textarea name="content" id="content" cols="50" rows="10" placeholder="何か書いて。。。"
                    required>{{ $article_edit->content }}</textarea>
            </div>
            <button type="submit" class="btn btn--warning btn--large">変更</button>
        </form>
    </div>
@endsection
