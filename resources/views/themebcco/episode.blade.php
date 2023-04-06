@extends('themes::themebcco.layout')

@push('header')
    <link href="{{ asset('/themes/bcco/css/episode.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="block mt-3 mb-3" itemscope itemtype="http://schema.org/Movie">
        <div class="block-body">
            @if ($currentMovie->notify && $currentMovie->notify != '')
                <div class="alert alert-info fade show" role="alert">
                    Thông báo: <span class="text-danger">{{ strip_tags($currentMovie->notify) }}</span>
                </div>
            @endif
            @if ($currentMovie->showtimes && $currentMovie->showtimes != '')
                <div class="alert alert-primary fade show" role="alert">
                    Lịch chiếu: <span class="text-info">{!! $currentMovie->showtimes !!}</span>
                </div>
            @endif
            <div class="watch-block">
                <div id="main-player">
                    <div class="loadingData"><span class="mess">Đang tải phim...</span></div>
                    <div id="playerLoaded"></div>
                </div>
                <div id="ploption" class="block-wrapper text-center">
                    @foreach ($currentMovie->episodes->where('slug', $episode->slug)->where('server', $episode->server) as $server)
                        <a data-id="{{ $server->id }}" data-link="{{ $server->link }}" data-type="{{ $server->type }}"
                            onclick="chooseStreamingServer(this)"
                            class="streaming-server btn-sv btn-hls btn btn-primary">VIP #{{ $loop->index + 1 }}</a>
                    @endforeach
                </div>

                <div class="rating-block">
                    <div class="box-rating" itemprop="aggregateRating" itemscope
                        itemtype="https://schema.org/AggregateRating">
                        <div id="star" data-score="{{ $currentMovie->getRatingStar() }}" style="cursor: pointer;">
                        </div>
                        <div>
                            <div id="div_average" style="line-height: 16px; margin: 0 5px; ">
                                <span id="hint"></span> ( <span class="average" id="average" itemprop="ratingValue">
                                    {{ $currentMovie->getRatingStar() }}</span>&nbsp;điểm
                                /&nbsp; <span id="rate_count"
                                    itemprop="ratingCount">{{ $currentMovie->getRatingCount() }}</span>
                                &nbsp;lượt)
                            </div>
                            <meta itemprop="bestRating" content="10" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="epi-list-all mb-3">
                @foreach ($currentMovie->episodes->sortBy([['server', 'asc']])->groupBy('server') as $server => $data)
                    <div class="epi-block">
                        <div class="epi-block-left">
                            <i class="fa fa-film"></i>{{ $server }}:
                        </div>
                        <div class="epi-block-right">
                            <div class="movie-eps-wrapper cscroller">
                                @foreach ($data->sortByDesc('name', SORT_NATURAL)->groupBy('name') as $name => $item)
                                    <a href="{{ $item->sortByDesc('type')->first()->getUrl() }}"
                                        class="movie-eps-item @if ($item->contains($episode)) btn-active @endif"
                                        title="{{ $name }}">{{ $name }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row">
                <div class="col-md-2 d-none d-sm-block pr-0">
                    <img class="movie-thumb img"
                        alt="{{ $currentMovie->name }} | {{ $currentMovie->origin_name }} ({{ $currentMovie->publish_year }})"
                        src="{{ $currentMovie->getThumbUrl() }}" itemprop="image">
                </div>
                <div class="col-md-10 col-12">
                    <div class="head">
                        <div class="c1">
                            <h1 class="title" itemprop="name">{{ $currentMovie->name }} Tập {{ $episode->name }}</h1>
                            <h2> {{ $currentMovie->origin_name }} ({{ $currentMovie->publish_year }})</h2>
                        </div>
                        <div class="meta-info">
                            @if ($currentMovie->content)
                                {!! mb_substr(strip_tags($currentMovie->content), 0, 290, 'utf-8') !!} ... <a class="btn-viewmore"
                                    href="{{ $currentMovie->getUrl() }}">Xem thêm</a>
                            @else
                                <p>Hãy xem phim để cảm nhận...</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="film-info-block mt-3">
                <div class="movie-detail-h3">Từ khóa:</div>
                <div class="tag-list">
                    @foreach ($currentMovie->tags as $tag)
                        <h3>
                            <strong>
                                <a href='{{ $tag->getUrl() }}' title='{{ $tag->name }}'
                                    rel='tag'>T{{ $tag->name }}</a>
                            </strong>
                        </h3>
                    @endforeach
                </div>
            </div>
            <div class="block-comment mt-3">
                <div class="title-hd">
                    <h2>Bình luận</h2>
                </div>
                <div style="color:red;font-weight:bold;padding:5px">Lưu ý các bạn không nên nhấp vào các
                    đường link ở phần bình luận, kẻ gian có thể đưa virut vào thiết bị hoặc hack mất
                    facebook của các bạn.
                </div>
                <div data-order-by="reverse_time" class="fb-comments" data-href="{{ $currentMovie->getUrl() }}"
                    data-width="100%" data-numposts="10"></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="/themes/bcco/player/js/p2p-media-loader-core.min.js"></script>
    <script src="/themes/bcco/player/js/p2p-media-loader-hlsjs.min.js"></script>

    <script src="/js/jwplayer-8.9.3.js"></script>
    <script src="/js/hls.min.js"></script>
    <script src="/js/jwplayer.hlsjs.min.js"></script>

    <script>
        var episode_id = {{ $episode->id }};
        const wrapper = document.getElementById('playerLoaded');
        const vastAds = "{{ Setting::get('jwplayer_advertising_file') }}";

        function chooseStreamingServer(el) {
            const type = el.dataset.type;
            const link = el.dataset.link.replace(/^http:\/\//i, 'https://');
            const id = el.dataset.id;

            const newUrl =
                location.protocol +
                "//" +
                location.host +
                location.pathname.replace(`-${episode_id}`, `-${id}`);

            history.pushState({
                path: newUrl
            }, "", newUrl);
            episode_id = id;


            Array.from(document.getElementsByClassName('streaming-server')).forEach(server => {
                server.classList.remove('btn-active');
            })
            el.classList.add('btn-active');

            renderPlayer(type, link, id);
        }

        function renderPlayer(type, link, id) {
            $('.loadingData').hide();
            if (type == 'embed') {
                if (vastAds) {
                    wrapper.innerHTML = `<div id="fake_jwplayer"></div>`;
                    const fake_player = jwplayer("fake_jwplayer");
                    const objSetupFake = {
                        key: "{{ Setting::get('jwplayer_license') }}",
                        aspectratio: "16:9",
                        width: "100%",
                        file: "/themes/bcco/player/1s_blank.mp4",
                        volume: 100,
                        mute: false,
                        autostart: true,
                        advertising: {
                            tag: "{{ Setting::get('jwplayer_advertising_file') }}",
                            client: "vast",
                            vpaidmode: "insecure",
                            skipoffset: {{ (int) Setting::get('jwplayer_advertising_skipoffset') ?: 5 }}, // Bỏ qua quảng cáo trong vòng 5 giây
                            skipmessage: "Bỏ qua sau xx giây",
                            skiptext: "Bỏ qua"
                        }
                    };
                    fake_player.setup(objSetupFake);
                    fake_player.on('complete', function(event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="350px" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });

                    fake_player.on('adSkipped', function(event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="350px" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });

                    fake_player.on('adComplete', function(event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="350px" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });
                } else {
                    if (wrapper) {
                        wrapper.innerHTML = `<iframe width="100%" height="350px" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                    }
                }
                return;
            }

            if (type == 'm3u8' || type == 'mp4') {
                wrapper.innerHTML = `<div id="jwplayer"></div>`;
                const player = jwplayer("jwplayer");
                const objSetup = {
                    key: "{{ Setting::get('jwplayer_license') }}",
                    aspectratio: "16:9",
                    width: "100%",
                    image: "{{ $currentMovie->getPosterUrl() }}",
                    file: link,
                    playbackRateControls: true,
                    playbackRates: [0.25, 0.75, 1, 1.25],
                    sharing: {
                        sites: [
                            "reddit",
                            "facebook",
                            "twitter",
                            "googleplus",
                            "email",
                            "linkedin",
                        ],
                    },
                    volume: 100,
                    mute: false,
                    autostart: true,
                    logo: {
                        file: "{{ Setting::get('jwplayer_logo_file') }}",
                        link: "{{ Setting::get('jwplayer_logo_link') }}",
                        position: "{{ Setting::get('jwplayer_logo_position') }}",
                    },
                    advertising: {
                        tag: "{{ Setting::get('jwplayer_advertising_file') }}",
                        client: "vast",
                        vpaidmode: "insecure",
                        skipoffset: {{ (int) Setting::get('jwplayer_advertising_skipoffset') ?: 5 }}, // Bỏ qua quảng cáo trong vòng 5 giây
                        skipmessage: "Bỏ qua sau xx giây",
                        skiptext: "Bỏ qua"
                    }
                };

                if (type == 'm3u8') {
                    const segments_in_queue = 50;

                    var engine_config = {
                        debug: !1,
                        segments: {
                            forwardSegmentCount: 50,
                        },
                        loader: {
                            cachedSegmentExpiration: 864e5,
                            cachedSegmentsCount: 1e3,
                            requiredSegmentsPriority: segments_in_queue,
                            httpDownloadMaxPriority: 9,
                            httpDownloadProbability: 0.06,
                            httpDownloadProbabilityInterval: 1e3,
                            httpDownloadProbabilitySkipIfNoPeers: !0,
                            p2pDownloadMaxPriority: 50,
                            httpFailedSegmentTimeout: 500,
                            simultaneousP2PDownloads: 20,
                            simultaneousHttpDownloads: 2,
                            // httpDownloadInitialTimeout: 12e4,
                            // httpDownloadInitialTimeoutPerSegment: 17e3,
                            httpDownloadInitialTimeout: 0,
                            httpDownloadInitialTimeoutPerSegment: 17e3,
                            httpUseRanges: !0,
                            maxBufferLength: 300,
                            // useP2P: false,
                        },
                    };
                    if (Hls.isSupported() && p2pml.hlsjs.Engine.isSupported()) {
                        var engine = new p2pml.hlsjs.Engine(engine_config);
                        player.setup(objSetup);
                        jwplayer_hls_provider.attach();
                        p2pml.hlsjs.initJwPlayer(player, {
                            liveSyncDurationCount: segments_in_queue, // To have at least 7 segments in queue
                            maxBufferLength: 300,
                            loader: engine.createLoaderClass(),
                        });
                    } else {
                        player.setup(objSetup);
                    }
                } else {
                    player.setup(objSetup);
                }


                const resumeData = 'OPCMS-PlayerPosition-' + id;
                player.on('ready', function() {
                    if (typeof(Storage) !== 'undefined') {
                        if (localStorage[resumeData] == '' || localStorage[resumeData] == 'undefined') {
                            console.log("No cookie for position found");
                            var currentPosition = 0;
                        } else {
                            if (localStorage[resumeData] == "null") {
                                localStorage[resumeData] = 0;
                            } else {
                                var currentPosition = localStorage[resumeData];
                            }
                            console.log("Position cookie found: " + localStorage[resumeData]);
                        }
                        player.once('play', function() {
                            console.log('Checking position cookie!');
                            console.log(Math.abs(player.getDuration() - currentPosition));
                            if (currentPosition > 180 && Math.abs(player.getDuration() - currentPosition) >
                                5) {
                                player.seek(currentPosition);
                            }
                        });
                        window.onunload = function() {
                            localStorage[resumeData] = player.getPosition();
                        }
                    } else {
                        console.log('Your browser is too old!');
                    }
                });

                player.on('complete', function() {
                    if (typeof(Storage) !== 'undefined') {
                        localStorage.removeItem(resumeData);
                    } else {
                        console.log('Your browser is too old!');
                    }
                })

                function formatSeconds(seconds) {
                    var date = new Date(1970, 0, 1);
                    date.setSeconds(seconds);
                    return date.toTimeString().replace(/.*(\d{2}:\d{2}:\d{2}).*/, "$1");
                }
            }
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const episode = '{{ $episode->id }}';
            let playing = document.querySelector(`[data-id="${episode}"]`);
            if (playing) {
                playing.click();
                return;
            }

            const servers = document.getElementsByClassName('streaming-server');
            if (servers[0]) {
                servers[0].click();
            }
        });
    </script>

    <link href="{{ asset('/themes/bcco/libs/raty/jquery.raty.css') }}" rel="stylesheet" />
    <script src="{{ asset('/themes/bcco/libs/raty/jquery.raty.js') }}"></script>
    <script>
        var rated = false;
        $('#star').raty({
            number: 10,
            starHalf: '/themes/bcco/libs/raty/images/star-half.png',
            starOff: '/themes/bcco/libs/raty/images/star-off.png',
            starOn: '/themes/bcco/libs/raty/images/star-on.png',
            click: function(score, evt) {
                if (!rated) {
                    $.ajax({
                        url: '{{ route('movie.rating', ['movie' => $currentMovie->slug]) }}',
                        data: JSON.stringify({
                            rating: score
                        }),
                        headers: {
                            "Content-Type": "application/json",
                            'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]')
                                .getAttribute(
                                    'content')
                        },
                        type: 'post',
                        dataType: 'json',
                        success: function(res) {
                            $('#average').html(res.rating_star);
                            $('#rate_count').html(res.rating_count);
                            $('#star').attr('data-score', res.rating_star);
                            rated = true;
                        }
                    });
                }
            }
        });
    </script>

    {!! setting('site_scripts_facebook_sdk') !!}
@endpush
