<div class="col-lg-3 col-md-4 col-6 pr-1 pl-1">
    <a href="{{ $movie->getUrl() }}" title="{{$movie->name}} | {{$movie->origin_name}} ({{$movie->publish_year}})">
        <div class="movie-box-2 mb-1">
            <div class="listing-container">
                <div class="listing-image">
                    <div data-bg="url({{$movie->getThumbUrl()}})" class="r43 rocket-lazyload">
                    </div>
                </div>
                <div class="listing-content text-left">
                    <h6 class="title elipsis">{{$movie->name}} </h6>
                    <p class="elipsis"> {{$movie->origin_name}} ({{$movie->publish_year}})</p>
                </div>
            </div>
            <div class="ribbon">{{$movie->episode_current}} {{$movie->quality}}</div>
        </div>
    </a>
</div>
