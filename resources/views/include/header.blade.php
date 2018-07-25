<nav class="navbar navbar-default navbar-static-top d-flex">
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top d-block" style="background-color: rgba(0,0,0,0.80)!important;height: 55px;">
        <div style="position:relative; width: 100%; max-width: 1200px;left: 50%;transform: translateX(-50%);">
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


            <div class="toolbar float-right">
                @if (count($available_lang) > 1)
                <div class="lang_bar">
                    @foreach ($available_lang as $lang)
                        @if ($lang['status'] == 1)
                            <img src="{{ asset('img/flags/'.$lang['flag']) }}" alt="{{ $lang['name'] }}" data-id="{{ $lang['id'] }}" class="language_choose">
                        @endif
                    @endforeach
                </div>
                @endif

                <div class="burger">
                    <input type="checkbox" />
                    <span class="burger-line"></span>
                    <span class="burger-line"></span>
                    <span class="burger-line"></span>
                    <span class="burger-line"></span>
                    <span id="burger_menu">
                        <nav>
                            @foreach ($pages as $page)
                                @if (isset($page['type']) && $page['type'] != 2 && $page['status'] == 1)
                                    @if (!empty($page['Child']))
                                        <a href="{{$page['url'] ?? '/'}}" data-toggle="collapse" data-target="#page_b_{{$page['id']}}">{{$page['name'] ?? "unknown"}} <i class="fas fa-caret-down"></i></a>
                                        <div id="page_b_{{$page['id']}}" class="collapse">
                                            @foreach ($page['Child'] as $sub_page)
                                                @if  ($sub_page['status'] == 1)
                                                    <a href="{{$sub_page['url'] ?? '/'}}">{{$sub_page['name'] ?? "unknown"}}</a>
                                                @endif
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
            </div>
        <div>
    </nav>
</nav>

<div class="logo row">
    <div class="col-12 col-sm-8">
        <a href="/">
            <img src="{{ asset('img/cms/'.$cms['logo']) }}" alt="banner">
        </a>
    </div>
    <div class="col-12 col-sm-4 d-flex justify-content-end align-content-center">
        <div class="phone">
            <img src="{{ asset('img/icons/phone.gif') }}" alt="banner">
            +91 213456789
        </div>

        <div class="cart-line">
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
        </div>
    </div>
</div>


<div class="menu d-flex">
    <div class="menu-left"></div>
    <div class="menu-container">
        <div class="d-flex flex-wrap menu-center">
            <div class="menu-col d-none d-sm-block col-sm-12 col-lg-8">
                <ul>
                    @foreach ($menus as $i => $page)
                        @if ($i > 0)
                            <li class="">
                                <span class="spacer1 d-none d-md-inline-block"> *** </span>
                                <span class="spacer2 d-none d-sm-inline-block d-md-none"> | </span>
                            </li>
                        @endif
                        <li>
                            <a href="{{ $page['url'] ?? '/'}}" class="{{ $page['id'] == $page_id ? 'selected' : '' }}">{{$page['name'] ?? "unknown"}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="search-col col-sm-12 col-lg-4">
                <a href="javascript:void(0)" class="show_filter btn px-2" data-toggle="collapse" data-target=".search_filter">
                    <i class="fas fa-angle-double-down"></i>
                </a>
                <input type="text" name="keyword">
                <a href="javascript:void(0)" class="search_link">
                    <i class="fas fa-search"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="menu-right"></div>
</div>
<div class="search_parent">
    <div class="search_filter collapse">
        <h2>Filters</h2>
        <input type="text" class="form-control" name="keyword" value="{{ $pagination['keyword'] ?? ''}}" placeholder="{{ __('default.prod_name') }}"><br>
        <select name="category" class="form-control">
            <option value=""> {{ __('default.any') }} {{ strtolower(__('default.category')) }} </option>
            @foreach ($categories as $category)
                <option value="{{ $category['slug'] ?? '' }}" {{ ($pagination['category'] ?? "") == ($category['slug'] ?? '') ? 'selected' : ''}}> {{ $category['name'] ?? 'Untitled' }} </option>
            @endforeach
        </select></br>
        <select name="color" class="form-control">
            <option value=""> {{ __('default.any') }} {{ strtolower(__('default.prod_color')) }} </option>
            @foreach ($available_colors as $color)
                <option value="{{ $color['slug'] ?? 'no_slug' }}" {{ ($pagination['color'] ?? "") == ($color['slug'] ?? false) ? 'selected' : ''}}> {{ $color['name'] ?? "??"}} </option>
            @endforeach
        </select></br>
        <select name="size" class="form-control">
            <option value=""> {{ __('default.any') }} {{ strtolower(__('default.prod_size')) }} </option>
            @foreach ($available_sizes as $size)
                <option value="{{ $size['name'] ?? '' }}" {{ ($pagination['size'] ?? "") == $size['name'] ? 'selected' : ''}}> {{ $size['name'] ?? "??"}} </option>
            @endforeach
        </select></br>
        <div class="d-flex flex-row">
            <input type="number" class="form-control w-50" name="min_price" value="{{ $pagination['min_price'] ?? '' }}" placeholder="{{ __('default.prod_min_price') }}">
            <input type="number" class="form-control w-50" name="max_price" value="{{ $pagination['max_price'] ?? '' }}" placeholder="{{ __('default.prod_max_price') }}">
        </div><br>
        <select name="sortby" class="form-control">
            @foreach ($orderby_list as $key => $orderby)
                <option value="{{ $orderby[0] }}" {{ (($pagination['orderby'] ?? "") == $orderby[0] || $key == 0) ? 'selected' : '' }}>{{ __($orderby[1]) }} {{ __($orderby[2]) }}</option>
            @endforeach
        </select>
        <input type="hidden" name="page_index" value="{{ $pagination['index'] ?? '' }}">
        <input type="hidden" name="page_limit" value="{{ $pagination['page_limit'] ?? '' }}">
        <button class="btn btn-info adv_search_button">{{ trans('default.search') }}</button>
    </div>
</div>

<script>

    $(document).ready(function() {
        //var e;

        var searchFilter = $('.search_filter');
        var searchFields = searchFilter.find('input, select');
        var searchIndexs = ['keyword','category','page_index', 'page_limit', 'color','size','min_price', 'max_price', 'sortby'];

        $('.search_link').click(function(){
            searchFields.each(function(){
                console.log($(this).attr("name"));
                $(this).val(($(this).attr("name") == "keyword") ? $('.search-col input').val() : '');
                console.log($(this).val());
            })
            sendSearchUrl();
        });


        $('.adv_search_button').click(sendSearchUrl)

        $('.pagination_link').click(function(e) {
            searchFilter.find('[name='+$(this).data('field')+']').val($(this).data('value'));
            sendSearchUrl();
            e.preventDefault();
        });

        $('.collection_orderby').change(function() {
            changeCategory($(this).val());
        });

        $('.collection_page_limit').change(function() {
            changeLimit($(this).val());
        });

        function changeLimit(limit=false) {
            var n;
            searchFields.each(function(){
                if ($(this).attr("name") == "page_limit") {
                    $(this).val(limit);
                }
            })
            sendSearchUrl();
        }

        function changeCategory(sortBy=false) {
            var n;
            searchFields.each(function(){
                if ($(this).attr("name") == "sortby") {
                    $(this).val(sortBy || '');
                }
            })
            sendSearchUrl();
        }

        function sendSearchUrl() {
            var data = [],
                fieldName,
                fieldValue,
                filterCode = 0,
                url = "/collection/all",
                index;
            searchFields.each(function(){
                fieldName = $(this).attr("name");
                fieldValue = $(this).val();
                if (fieldValue && fieldValue.trim().length > 0) {
                    index = searchIndexs.indexOf(fieldName);
                    if (fieldName == "page_index") {
                        fieldValue = "page_"+fieldValue;
                    }
                    data[index] = fieldValue;
                    filterCode += Math.pow(2, index);
                }
            });

            if (filterCode > 0) {
                url = "/search/"+filterCode+"/"+data.filter(function(i) { return i; }).join("/");
            }
            location.href = url;
        }
    });
</script>
