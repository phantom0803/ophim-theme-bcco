<div class="container">
    <div class="playlist-wrapper mt-3 mb-5">
        <div class="row title-wrapper">
            <div class="col-sm-8"><h2 class="title">Phim Đề Cử</h2></div>
            <div class="col-sm-4 align-self-center text-right">
                <a href="/danh-sach/phim-de-cu" class="btn btn-icon btn-playlist btn-effect" title="Phim Đề Cử"> Xem tất cả <i class="fa fa-chevron-right"></i></a>
            </div>
        </div>
        <div class="pl-carousel-wrapper">
            <div class="pl-carousel">
                @foreach ($recommendations as $movie)
                    @include('themes::themebcco.inc.slider_movie_card')
                @endforeach
            </div>
        </div>
    </div>
</div>
