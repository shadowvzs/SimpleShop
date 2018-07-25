<div id="Slides" class="carousel slide">
    <ul class="carousel-indicators">
        @foreach ($slides as $key => $slide)
            <li class="item{{ $key }} {{ $key == 0 ? 'active' : ''}}" data-slide-to="{{ $key }}" data-target=".carousel.slide"></li>
        @endforeach
    </ul>

    <div class="carousel-inner">
        @foreach ($slides as $key => $slide)
            <div class="carousel-item {{ $key == 0 ? 'active' : ''}}">
                <img src="{{ asset('img/slides/'.$slide['image']) }}" width="100%">
            </div>
        @endforeach
    </div>

    <a class="carousel-control-prev" href=".carousel.slide">
        <span class="carousel-control-prev-icon"></span>
    </a>
    <a class="carousel-control-next" href=".carousel.slide">
        <span class="carousel-control-next-icon"></span>
    </a>
</div>

<script>
$(document).ready(function(){
    var Slides = $("#Slides");
    Slides.carousel();
    $(".carousel-control-prev").click(function(e){
        e.preventDefault();
        Slides.carousel("prev");
    });
    $(".carousel-control-next").click(function(e){
        e.preventDefault();
        Slides.carousel("next");
    });
});
</script>
