<li class="articles__item">
    <a href="{{ route('articles.show', $article->id) }}" class="articles__link">
        <div class="articles__cover">
            <img src="{{ asset('assets/image/articles/' . ($article->thumbnail_id ? $article->src : 'text-only.png')) }}"
                alt="article-image" />
        </div>
        <p class="articles__content">
            {{ $article->title }}
        </p>
    </a>
    <div class="articles__stamp">
        <p class="articles__time">
            <img src="{{ asset('assets/image/icon.png') }}" class="clock-icon clock-icon--small" alt="time-stamp" />
            {{ $article->created_at }}
        </p>
        <a href="#" class="articles__company-release">{{ $article->fullname }}</a>
    </div>
</li>
