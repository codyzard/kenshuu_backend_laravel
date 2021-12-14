@extends('layouts.application')

@section('content')
    <div class="wrap-article">
        <?php if (!empty($_SESSION['messages'])) : ?>
        <div class="flash flash--success">
            <?php foreach ($_SESSION['messages'] as $mess) : ?>
            <p class="message"><?php Helper::print_filtered($mess); ?></p>
            <?php endforeach ?>
            <?php unset($_SESSION['messages']); ?>
        </div>
        <?php endif ?>
        <div class="article">
            <div class="article-header">
                <h3 class="article__title">{{ $article->title }}</h3>
                <div class="sub-info">
                    <time class="article__time"><img src="{{ asset('assets/image/icon.png') }}"
                            class="clock-icon clock-icon--medium" alt="time-stamp" />{{ $article->created_at }}</time>
                    <p class="article__author">筆者: <a href="#">{{ $article->author->fullname }}</a></p>
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
        <div class="control">
            <a class="btn btn--warning btn--radius" href="#">変更</a>
            <a class="btn btn--danger btn--radius" onclick="return confirm('Are you sure?')" href="#">削除</a>
        </div>
    </div>
@endsection
