@extends('layouts.application')

@section('content')
    <div class="wrap-article">
        @if (Session::has('message'))
            <div class="flash flash--success">
                <p class="message">{{ Session::get('message') }}</p>
            </div>
        @endif
        <div class="article">
            <div class="article-header">
                <h3 class="article__title">{{ $article->title }}</h3>
                <div class="sub-info">
                    <time class="article__time"><img src="{{ asset('assets/image/icon.png') }}"
                            class="clock-icon clock-icon--medium" alt="time-stamp" />{{ $article->created_at }}</time>
                    <p class="article__author">筆者: <a
                            href="{{ route('authors.profile', $article->author->id) }}">{{ $article->author->fullname }}</a>
                    </p>
                    <p class="article__view">ページビュー: {{ $article->page_view }}</p>
                </div>
            </div>
            <div class="article-main">
                <?php if (!empty($article->images)) : ?>
                <?php foreach ($article->images as $img) : ?>
                <div class="article__image"><img src="{{ asset("assets/image/articles/$img->src") }}" alt="article-image">
                </div>
                <?php endforeach ?>
                <?php endif ?>
                <p class="article__content">{{ $article->content }}</p>
            </div>
        </div>
        @if (Auth::check() && Auth::user()->id == $article->author_id)
            <div class="control">
                <a class="btn btn--warning btn--radius" href="{{ route('articles.edit', $article->id) }}">変更</a>
                <form action="{{ route('articles.delete', $article->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure?')"><a
                            class="btn btn--danger btn--radius">削除</a></button>
                </form>
            </div>
        @endif
    </div>
@endsection
