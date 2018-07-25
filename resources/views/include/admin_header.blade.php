<nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top" style="background-color: rgba(0,0,0,0.7)!important;height: 45px;">
    <a class="navbar-brand" href="/">{{$cms['name']}}</a>
    <div class="burger">
        <input type="checkbox" />
        <span class="burger-line"></span>
        <span class="burger-line"></span>
        <span class="burger-line"></span>
        <span class="burger-line"></span>
        <span id="burger_menu">
            <nav>
                @foreach ($pages as $page)
                    @if (isset($page['type']) && $page['type'] == 2)
                        <a href="{{$page['url'] ?? '/'}}" data-toggle="collapse" data-target="#page_b_{{$page['id']}}">{{$page['name'] ?? "unknown"}}</a>
                        @if (!empty($page['Child']))
                            <div id="page_b_{{$page['id']}}" class="collapse">
                                @foreach ($page['Child'] as $sub_page)
                                    <a href="{{$sub_page['url'] ?? '/'}}">{{$sub_page['name'] ?? "unknown"}}</a>
                                @endforeach
                            </div>
                        @endif
                    @endif
                @endforeach
            </nav>
        </span>
    </div>
</nav>
