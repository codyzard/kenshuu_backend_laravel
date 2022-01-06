<header class="header">
    <div class="header-container">
        <div class="header-small-container">
            <a class="logo" href="/">
                <img class="logo__frame" src="{{ asset('assets/image/Frame.png') }}" alt="logo" />
                <h1 class="logo__text">
                    プレスリリース・ニュースリリース配信サービスのPR TIMES
                </h1>
            </a>
            <ul class="release">
                <li class="release__item release__item--media">
                    <a href="#">プレスリリースを受信</a>
                </li>
                <li class="release__item release__item--company">
                    <a href="#">配信を依頼</a>
                </li>
                @if (Auth::check())
                    <li class="release__item release__item--logged">
                        <a href="#" class="disabled">管理画面</a>
                        <ul class="profile-manager">
                            <li class="profile-manager__item"><a class="disabled"
                                    href="{{ route('authors.profile', Auth::user()->id) }}">プロフィール</a></li>
                            <li class="profile-manager__item"><a class="disabled"
                                    href="{{ route('authors.logout') }}">ログアウト</a></li>
                        </ul>
                    </li>
                @else
                    <li class="release__item release__item--login">
                        <a href="{{ route('authors.login') }}" class="disabled">ログイン</a>
                    </li>
                @endif
            </ul>
            <div class="search-box">
                <input type="text" placeholder="キーワードで検索" class="input--radius" />
                <button class="btn btn--light-blue input--radius">
                    <img src="{{ asset('assets/image/search.png') }}" alt="search-button" />
                </button>
            </div>
        </div>
        <div class="main-header">
            <ul class="services">
                <li
                    class="
                  services__item
                  services__item--active-item
                  services__item--press-release
                ">
                    <a href="#">プレスリリース</a>
                </li>
                <li class="services__item services__item--ranking">
                    <a href="#">ランキング</a>
                </li>
                <li class="services__item services__item--tv">
                    <a href="#" class="disabled">TV</a>
                </li>
            </ul>
        </div>
    </div>
</header>
