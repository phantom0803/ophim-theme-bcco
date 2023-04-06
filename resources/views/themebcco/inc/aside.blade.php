<div class="sidebar-container">
    @foreach ($tops as $top)
        <div class="sidebar-widget-container border-container mb-5">
            <div class="title-wrapper">
                <h2 class="title"><i class="fa fa-star" style="color : #ffb137"></i> {{ $top['label'] }}
                </h2>
            </div>
            <div class="cscroller sidebar-widget-content scroll-y row">
                @foreach ($top['data'] as $movie)
                    <a href="{{ $movie->getUrl() }}"
                        title="{{ $movie->name }} | {{$movie->origin_name}} ({{$movie->name}})">
                        <div class="watch-later-item">
                            <div class="listing-container">
                                <div class="listing-image">
                                    <div data-bg="url({{ $movie->getThumbUrl() }})"
                                        class="r43 rocket-lazyload"></div>
                                </div>
                                <div class="listing-content">
                                    <div class="inner">
                                        <h6 class="title">{{ $movie->name }} </h6>
                                        <p> {{$movie->origin_name}} ({{$movie->name}})</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
