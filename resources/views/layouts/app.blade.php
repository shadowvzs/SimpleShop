<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $page['meta_title'] ?? $page['name'] ?? '' }}</title>
        <link href="{{ asset('css/app.css?='.time()) }}" rel="stylesheet">
        <link href="{{ asset('css/default.css?='.time()) }}" rel="stylesheet">
        <link href="{{ asset('css/common.css?='.time()) }}" rel="stylesheet">
        <meta name="description" content="{{ $page['meta_description'] ?? '' }}">
        <meta name="keywords" content="{{ $page['meta_keyword'] ?? '' }}">
        <meta http-equiv="content-type" content="text/html;charset=UTF-8">
        <meta property="og:url"           content="{{ $_SERVER['REQUEST_URI'] }}" />
        <meta property="og:type"          content="website" />
        <meta property="og:title"         content="{{ $page['meta_title'] ?? '' }}" />
        <meta property="og:description"   content="{{ $page['meta_description'] ?? '' }}" />
        <meta property="og:image"         content="{{ asset('img/cms/'.$cms['logo']) }}" />
        <script src="{{ asset('js/jquery.js') }}"></script>
        <script src="{{ asset('js/elevatezoom.js') }}"></script>
        <script src="{{ asset('js/notify.js') }}"></script>
    </head>
    <body>
        <div id="app">
            @if ($cms['place']->top)
                <div class='top-left-deco deco'>
                    <img src="{{ asset('img/cms/'.$cms['decoration'])}}" alt="top-left deco">
                </div>
            @endif
            @if ($cms['place']->right)
                <div class='top-right-deco deco'>
                    <img src="{{ asset('img/cms/'.$cms['decoration'])}}" alt="top-right deco">
                </div>
            @endif
            <header>
                @include('include.header')
            </header>

          	<div class="container-fluid body" style="position: relative;">
          		@include('include.status')
                @if (!empty($slides))
                    @include('include.slide', ['slides' => $slides])
                @endif
            	@yield('content')

          	</div>
        </div>
        <footer>
            @include('include.footer')
        </footer>
        <br><br><br><br>
        @if ($cms['place']->bottom)
            <div class='bottom-right-deco deco'>
                <img src="{{ asset('img/cms/'.$cms['decoration'])}}" alt="bottom-right deco">
            </div>
        @endif
        @if ($cms['place']->left)
            <div class='bottom-left-deco deco'>
                <img src="{{ asset('img/cms/'.$cms['decoration'])}}" alt="bottom-left deco">
            </div>
        @endif
        <div class="modal fade favorite-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ trans('default.favorite_list') }}</h5>
                    </div>
                    <div class="modal-body">
                        @include('include.favorite')
                    </div>
                </div>
            </div>
        </div>

		<div class="modal fade cart-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ trans('default.cart_list') }}</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        @include('include.cart')
                    </div>
                </div>
            </div>
        </div>
		
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/custom.js?t='.time()) }}"></script>
	    <script src="{{ asset('js/notify.js') }}"></script>
	
        <script>
              (function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
    </body>
</html>
