@extends('themes::layout')
@php
    $menu = \Ophim\Core\Models\Menu::getTree();
    $tops = Cache::remember('site.movies.tops', setting('site_cache_ttl', 5 * 60), function () {
        $lists = preg_split('/[\n\r]+/', get_theme_option('hotest'));
        $data = [];
        foreach ($lists as $list) {
            if (trim($list)) {
                $list = explode('|', $list);
                [$label, $relation, $field, $val, $sortKey, $alg, $limit, $template] = array_merge($list, ['Phim hot', '', 'type', 'series', 'view_total', 'desc', 4, 'top_thumb']);
                try {
                    $data[] = [
                        'label' => $label,
                        'template' => $template,
                        'data' => \Ophim\Core\Models\Movie::when($relation, function ($query) use ($relation, $field, $val) {
                            $query->whereHas($relation, function ($rel) use ($field, $val) {
                                $rel->where($field, $val);
                            });
                        })
                            ->when(!$relation, function ($query) use ($field, $val) {
                                $query->where($field, $val);
                            })
                            ->orderBy($sortKey, $alg)
                            ->limit($limit)
                            ->get(),
                    ];
                } catch (\Exception $e) {
                    # code
                }
            }
        }

        return $data;
    });
@endphp

@push('header')
    <link href="{{ asset('/themes/bcco/css/bootstrap.css') }}" rel="stylesheet">
    <link href="/themes/bcco/css/all.css" rel="preload" media="all" as="style" onload="this.onload=null;this.rel=&#039;stylesheet&#039;">
    <link href="/themes/bcco/css/custom.css" rel="preload" media="all" as="style" onload="this.onload=null;this.rel=&#039;stylesheet&#039;">
@endpush

@section('body')
    <nav id="main-mobile-nav"></nav>
    <div class="page-wrapper">
        @include('themes::themebcco.inc.header')
        <main>
            @yield('slider_recommended')
            <div class="container">
                <div class="row">
                    <div class="col-lg-8" id="playlists">
                        @yield('content')
                    </div>
                    <div class="col-lg-4 mt-3">
                        @include('themes::themebcco.inc.aside')
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection

@section('footer')
    {!! get_theme_option('footer') !!}

    <script src="{{ asset('/themes/bcco/js/jquery.min.js') }}"></script>
    <script>
        jQuery(function($) {
            jQuery(document).pjax("#p0 a", {
                "push": true,
                "replace": false,
                "timeout": 1000,
                "scrollTo": false,
                "container": "#p0"
            });
            jQuery(document).off("submit", "#p0 form[data-pjax]").on("submit", "#p0 form[data-pjax]", function(
                event) {
                jQuery.pjax.submit(event, {
                    "push": true,
                    "replace": false,
                    "timeout": 1000,
                    "scrollTo": false,
                    "container": "#p0"
                });
            });
        });
    </script>
    <script src="{{ asset('/themes/bcco/js/yii.js') }}"></script>
    <script src="{{ asset('/themes/bcco/js/jquery.pjax.js') }}"></script>
    <script src="{{ asset('/themes/bcco/js/all-dist.js') }}"></script>
    <script>
        function lazyload() {
            $(".lazy").lazyload().removeClass("lazy");
        }

        $(document).ajaxStop(function() {
            setTimeout(lazyload, 500);
        });
        $(window).load(function() {
            lazyload();
        });

    </script>
    <script>
        $('body').on('click', '#overlay .overlay_content .cls_ov', function() {
            $(this).closest('#overlay').hide();
        });
    </script>
    <script>
        window.lazyLoadOptions = {
            elements_selector: "img[data-lazy-src],.rocket-lazyload",
            data_src: "lazy-src",
            data_srcset: "lazy-srcset",
            data_sizes: "lazy-sizes",
            class_loading: "lazyloading",
            class_loaded: "lazyloaded",
            threshold: 300,
            callback_loaded: function(element) {
                if (element.tagName === "IFRAME" && element.dataset.rocketLazyload == "fitvidscompatible") {
                    if (element.classList.contains("lazyloaded")) {
                        if (typeof window.jQuery != "undefined") {
                            if (jQuery.fn.fitVids) {
                                jQuery(element).parent().fitVids();
                            }
                        }
                    }
                }
            }
        };
        window.addEventListener('LazyLoad::Initialized', function(e) {
            var lazyLoadInstance = e.detail.instance;

            if (window.MutationObserver) {
                var observer = new MutationObserver(function(mutations) {
                    var image_count = 0;
                    var iframe_count = 0;
                    var rocketlazy_count = 0;

                    mutations.forEach(function(mutation) {
                        for (i = 0; i < mutation.addedNodes.length; i++) {
                            if (typeof mutation.addedNodes[i].getElementsByTagName !== 'function') {
                                return;
                            }

                            if (typeof mutation.addedNodes[i].getElementsByClassName !==
                                'function') {
                                return;
                            }

                            images = mutation.addedNodes[i].getElementsByTagName('img');
                            is_image = mutation.addedNodes[i].tagName == "IMG";
                            iframes = mutation.addedNodes[i].getElementsByTagName('iframe');
                            is_iframe = mutation.addedNodes[i].tagName == "IFRAME";
                            rocket_lazy = mutation.addedNodes[i].getElementsByClassName(
                                'rocket-lazyload');

                            image_count += images.length;
                            iframe_count += iframes.length;
                            rocketlazy_count += rocket_lazy.length;

                            if (is_image) {
                                image_count += 1;
                            }

                            if (is_iframe) {
                                iframe_count += 1;
                            }
                        }
                    });

                    if (image_count > 0 || iframe_count > 0 || rocketlazy_count > 0) {
                        lazyLoadInstance.update();
                    }
                });

                var b = document.getElementsByTagName("body")[0];
                var config = {
                    childList: true,
                    subtree: true
                };

                observer.observe(b, config);
            }
        }, false);
    </script>
    <script src="/themes/bcco/js/lazyload.min.js"></script>
    <div id="overlay"></div>


    {!! setting('site_scripts_google_analytics') !!}
@endsection
