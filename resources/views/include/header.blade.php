<nav class="navbar navbar-default navbar-static-top d-flex d-sm-none">
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top d-block" style="background-color: rgba(0,0,0,0.7)!important;">
        <a class="navbar-brand" href="javascript:void(0)">{{$cms['name']}}</a>
        <div class="burger">
            <input type="checkbox" />
            <span class="burger-line"></span>
            <span class="burger-line"></span>
            <span class="burger-line"></span>
            <span class="burger-line"></span>
            <span id="burger_menu">
                <nav>
                    @foreach ($pages as $page)
                        @if (isset($page['type']) && $page['type'] != 2)
                            @if (!empty($page['Child']))
                                <a href="{{$page['url'] ?? '/'}}" data-toggle="collapse" data-target="#page_b_{{$page['id']}}">{{$page['name'] ?? "unknown"}} <i class="fas fa-caret-down"></i></a>
                                <div id="page_b_{{$page['id']}}" class="collapse">
                                    @foreach ($page['Child'] as $sub_page)
                                    <a href="{{$sub_page['url'] ?? '/'}}">{{$sub_page['name'] ?? "unknown"}}</a>
                                    @endforeach
                                </div>
                            @else
                                <a href="{{ $page['url'] ?? '/' }}">{{$page['name'] ?? "unknown"}}</a>
                            @endif
                        @endif
                    @endforeach
                </nav>
            </span>
        </div>
    </nav>
</nav>

<div class="facebook">
    <div id="fb-root"></div>
    <div class="fb-like"
    data-href="https://www.your-domain.com/your-page.html"
    data-share="true"
    data-layout="button"
    data-action="like"
    data-show-faces="true">
</div>
</div>

<div class="col">
    <div class="logo">
        <img src="{{ asset('img/cms/'.$cms['logo']) }}" alt="banner">
    </div>
</div>

<div class="toolbar">
    <div class="fav_bar">
        <a href="javascript:void(0)" data-toggle="modal" data-target=".favorite-modal" data-amount="0" class="">
            <i class="fas fa-star"></i>
        </a>
    </div>
    <div class="cart_bar">
        <a href="javascript:void(0)" data-toggle="modal" data-target=".cart-modal" data-amount="0" class="">
            <i class="fas fa-shopping-cart"></i>
        </a>
    </div>
    <div class="lang_bar">
        @foreach ($languages as $lang)
            @if ($lang['status'] == 1)
                <img src="{{ asset('img/flags/'.$lang['flag']) }}" alt="{{ $lang['name'] }}" data-id="{{ $lang['id'] }}" class="language_choose">
            @endif
        @endforeach
    </div>
</div>

<div class="menu d-none d-sm-block">
    <ul>
        @foreach ($pages as $page)
            @if (isset($page['type']) && $page['type'] != 2)
                @if (!empty($page['Child']))
                    <li data-target="page_b_{{$page['id']}}"><a href="{{$page['url'] ?? '/'}}">{{ $page['name'] ?? "unknown" }} <i class="fas fa-caret-down"></i></a>
                        <ul id="page_b_{{$page['id']}}">
                            @foreach ($page['Child'] as $sub_page)
                            <li><a href="{{ $sub_page['url'] ?? '/'}}">{{$sub_page['name'] ?? "unknown"}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li><a href="{{ $page['url'] ?? '/'}}">{{$page['name'] ?? "unknown"}}</a></li>
                @endif
            @endif
        @endforeach
    </ul>
</div>
