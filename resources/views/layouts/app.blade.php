<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <div class="sidebar">
            <div class="sidevar-content">
                <a href="{{ url('/') }}">
                    <p class="sidebar-title">{{ config('app.name', 'Laravel') }}</h4>
                </a>
                
                <p class="sidebar-menu-title">MENU</p>            
                <h4 class="sidebar-menu"><a href="{{route('item.index')}}">部材一覧</a></h4>
                <h4 class="sidebar-menu"><a href="{{route('purchase.index')}}">発注一覧</a></h4>
                <h4 class="sidebar-menu"><a href="{{route('receipt.index')}}">入庫一覧</a></h4>
                <h4 class="sidebar-menu"><a href="{{route('allocate.index')}}">割当一覧</a></h4>
                <h4 class="sidebar-menu"><a href="{{route('item.create')}}">部材新規登録</a></h4>
                @guest
                    <h4 class="sidebar-menu">                           
                        <a href="{{ route('login') }}">{{ __('ログイン') }}</a>
                    </h4>
                    @if (Route::has('register'))
                        <h4 class="sidebar-menu">
                            <a href="{{ route('register') }}">{{ __('新規登録') }}</a>
                        </h4>   
                    @endif
                @else                               
                    <p class="user-name">{{ Auth::user()->name }}</p>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <h4 class="sidebar-menu">{{ __('ログアウト') }}</h4>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>                     
                @endguest        
            </div>
        </div>
        <main>
            <div class="container main-content">
                <div class="row">
                
                        
                    <div class="col-md-12">
                        <!-- エラーメッセージ・フラッシュメッセージ -->
                        @if (Session::has('message'))
                        <div class="alert alert-success text-center">
                            {{ session('message') }}
                        </div>
                        @endif
                        @if (Session::has('alert'))
                        <div class="alert alert-danger text-center">
                            {{ session('alert') }}
                        </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
