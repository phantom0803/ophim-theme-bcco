<div class="pl-carousel-cell">
    <a href="{{ $movie->getUrl() }}" title="{{ $movie->name }} | {{ $movie->origin_name }} ({{ $movie->publish_year }})">
        <div class="movie-box-1 movie-box-2">
            <div data-bg="url({{ $movie->thumb_url }})" class="poster r43 rocket-lazyload">
            </div>
            <div class="movie-details text-left pl-2 pr-2">
                <h6 class="movie-title">{{ $movie->name }} </h6>
                <span class="released"> {{ $movie->origin_name }} ({{ $movie->publish_year }})</span>
            </div>
            <div class="ribbon">{{ $movie->episode_current }} {{ $movie->language }}</div>
        </div>
    </a>
</div>
