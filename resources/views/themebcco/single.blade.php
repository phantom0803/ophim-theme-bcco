@extends('themes::themebcco.layout')

@push('header')
    <link href="{{ asset('/themes/bcco/css/single.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="block mt-3 mb-3">
        <div class="block-body" itemscope itemtype="http://schema.org/Movie">
            <div class="row">
                <div class="col-md-4">
                    <div class="movie-thumb position-relative">
                        <img class="img img-fluid"
                            alt="{{ $currentMovie->name }} | {{ $currentMovie->origin_name }} ({{ $currentMovie->publish_year }})"
                            src="{{ $currentMovie->getThumbUrl() }}" itemprop="image">

                        @if (!$currentMovie->is_copyright && count($currentMovie->episodes) && $currentMovie->episodes[0]['link'] != '')
                            <a href="{{ $currentMovie->episodes->sortBy([['server', 'asc']])->groupBy('server')->first()->sortByDesc('name', SORT_NATURAL)->groupBy('name')->last()->sortByDesc('type')->first()->getUrl() }}" class="btn btn-danger btn-block mt-2">Xem Phim</a>
                        @else
                            <div>Đang cập nhật...</div>
                        @endif

                    </div>
                </div>
                <div class="col-md-8">
                    <div class="head">
                        <div class="c1">
                            <h1 class="title" itemprop="name">{{ $currentMovie->name }} </h1>
                            <h2> {{ $currentMovie->origin_name }} ({{ $currentMovie->publish_year }})</h2>
                        </div>
                        <div class="meta-info">
                            <ul>
                                <li>
                                    <span>Thể loại: </span>
                                    {!! $currentMovie->categories->map(function ($category) {
                                            return '<a href="' .
                                                $category->getUrl() .
                                                '" title="' .
                                                $category->name .
                                                '" rel="category tag">' .
                                                $category->name .
                                                '</a>';
                                        })->implode(', ') !!}
                                </li>
                                <li>
                                    <span>Quốc gia: </span>
                                    {!! $currentMovie->regions->map(function ($region) {
                                            return '<a href="' . $region->getUrl() . '" title="' . $region->name . '">' . $region->name . '</a>';
                                        })->implode(', ') !!}
                                </li>
                                <li>
                                    <span>Trạng thái: </span>
                                    <span itemprop="duration">{{ $currentMovie->episode_current }}
                                        {{ $currentMovie->language }}</span>
                                </li>
                                <li>
                                    <span>Đạo diễn: </span>
                                    {!! $currentMovie->directors->map(function ($director) {
                                            return '<a href="' .
                                                $director->getUrl() .
                                                '" tite="Đạo diễn ' .
                                                $director->name .
                                                '" itemprop="director">' .
                                                $director->name .
                                                '</a>';
                                        })->implode(', ') !!}
                                </li>
                                <li>
                                    <span>Diễn viên: </span>
                                    {!! $currentMovie->actors->map(function ($actor) {
                                            return '<a href="' .
                                                $actor->getUrl() .
                                                '" tite="Diễn viên ' .
                                                $actor->name .
                                                '" itemprop="actor">' .
                                                $actor->name .
                                                '</a>';
                                        })->implode(', ') !!}
                                </li>
                            </ul>
                        </div>
                        <div class="rating-block">
                            <div class="box-rating" itemprop="aggregateRating" itemscope
                                itemtype="https://schema.org/AggregateRating">
                                <div id="star" data-score="{{$currentMovie->getRatingStar()}}"
                                    style="cursor: pointer;"></div>
                                <div>
                                    <div id="div_average" style="line-height: 16px; margin: 0 5px; ">
                                        <span id="hint"></span> ( <span class="average" id="average"
                                            itemprop="ratingValue">
                                            {{$currentMovie->getRatingStar()}}</span>&nbsp;điểm
                                        /&nbsp; <span id="rate_count"
                                            itemprop="ratingCount">{{$currentMovie->getRatingCount()}}</span>
                                        &nbsp;lượt)
                                    </div>
                                    <meta itemprop="bestRating" content="10" />
                                </div>
                            </div>
                        </div>
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

                    </div>
                </div>
            </div>
            <div class="film-info-block mt-3">
                <div class="title-hd">
                    <h2>Nội dung phim</h2>
                </div>
                <div class="film-info" itemprop="description">
                    <h3>{{ $currentMovie->name }}, {{ $currentMovie->origin_name }} ({{ $currentMovie->publish_year }})
                    </h3>
                    @if ($currentMovie->content)
                        <p>{!! $currentMovie->content !!}</p>
                    @else
                        <p>Hãy xem phim để cảm nhận...</p>
                    @endif
                </div>
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
                <div style="color:red;font-weight:bold;padding:5px">Lưu ý các bạn không nên nhấp vào các đường link ở phần
                    bình luận, kẻ gian có thể đưa virut vào thiết bị hoặc hack mất facebook của các bạn. </div>
                <div data-order-by="reverse_time" class="fb-comments"
                    data-href="{{ $currentMovie->getUrl() }}" data-width="100%" data-numposts="10"></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
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
