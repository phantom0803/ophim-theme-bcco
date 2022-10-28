@php
    $logo = setting('site_logo', '');
    $brand = setting('site_brand', '');
    $title = isset($title) ? $title : setting('site_homepage_title', '');
@endphp

<header class="header">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="/">
                @if ($logo)
                    {!! $logo !!}
                @else
                    {!! $brand !!}
                @endif
            </a>
            <button id="mobile-nav-toggler" class="hamburger hamburger--collapse" type="button"><span
                    class="hamburger-box"><span class="hamburger-inner"></span></span></button>
            <div class="navbar-collapse justify-content-between" id="main-nav">
                <ul class="navbar-nav" id="main-menu">
                    @foreach ($menu as $item)
                        @if (count($item['children']))
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false" href="{{ $item['link'] }}" title="{{ $item['name'] }}">{{ $item['name'] }}</a>
                                <ul class="dropdown-menu col-2">
                                    @foreach ($item['children'] as $children)
                                        <li>
                                            <a class="dropdown-item" href="{{ $children['link'] }}" title="{{ $children['name'] }}">{{ $children['name'] }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li class="nav-item ">
                                <a class="nav-link" href="{{ $item['link'] }}" title="{{$item['name']}}">{{$item['name']}}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
                <ul class="navbar-nav extra-nav">
                    <li class="nav-item">
                        <form class="general-search" role="search" method="get" action="/">
                            <input type="text" placeholder="Tìm kiếm phim..." autocomplete="off"
                                name="search" class="search_input" value="{{ request('search') }}">
                            <span id="general-search-close" class="fa fa-search toggle-search" data-t="desktop"></span>
                        </form>
                        <div id="nav_search_result"></div>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="mobile-search d-lg-none">
            <form class="general-search" role="search" method="get" action="/">
                <input type="text"
                    placeholder="Tìm kiếm phim..." name="search" class="search_input_2"
                    value="{{ request('search') }}">
                    <span id="general-search-close" class="fa fa-search toggle-search"
                    data-t="mobile"></span>
            </form>
        </div>
    </div>
</header>
