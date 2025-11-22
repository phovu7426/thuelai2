<div id="home-slider" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        @foreach ($slides as $key => $slide)
            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                <img src="{{ asset('storage/' . $slide->image) }}" class="d-block w-100" alt="{{ $slide->title }}">
                <div class="carousel-caption d-none d-md-block">
                    <h2>{{ $slide->title }}</h2>
                    <p>{{ $slide->description }}</p>
                    @if ($slide->link)
                        <a href="{{ $slide->link }}" class="btn btn-primary">Xem chi tiết</a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    <a class="carousel-control-prev" href="#home-slider" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#home-slider" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
