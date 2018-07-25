<div class="separator"></div>

<div class="col-sm-11 row mx-auto">
	@if (!empty($cms['footer_social']))
    <div class="col-sm p-3 SocialLinks">
        <div class="centerX">
            <h2>{{ Lang::get('default.social') }}</h2>
              @foreach ($contacts['SocialLink'] as $social)
                  @if ($social['status'] == '1')
                  <div class="social-item">
                      <img src="{{ asset('img/icons/'.$social['icon']) }}">
                      &nbsp;&nbsp;&nbsp;
                      <a href="{{ $social['value'] }}" title="{{ $social['name'] }}">
                          {{ $social['name'] }}
                      </a>
                  </div>
                  @endif
              @endforeach
        </div>
    </div>
	@endif
	@if (!empty($cms['footer_map']))
    <div class="col-sm p-3 map">
          <iframe src="{{ $cms['map'] }}" allowfullscreen="" frameborder="0"></iframe>
		  <!-- https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5435.928819643834!2d21.929802999629814!3d47.06054848694138!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x474647e056cf23f9%3A0x9a1c1b519cdc1b5b!2sStrada+Dun%C4%83rea+13%2C+Oradea!5e0!3m2!1sro!2sro!4v1524975411442 -->
    </div>
	@endif
	@if (!empty($cms['footer_contact']))
    <div class="col-sm p-3 Contact">
        <div class="centerX">
            <h2>{{ Lang::get('default.contact') }}</h2>
            @foreach ($contacts['Contact'] as $contact)
                @if ($contact['status'] == '1')
                    <div class="contact-item">
                        {{ $contact['name'] }}: {{ $contact['value'] }}
                    </div>
                @endif
            @endforeach
        </div>
    </div>
	@endif
</div>

<div class="footer-menu text-center">
    @foreach ($pages as $page)
        @if (isset($page['type']) && $page['type'] != 2 && $page['place'] == 1 && $page['status'] == 1)
			<a href="{{ $page['url'] ?? '/'}}" class="d-block d-sm-inline-block">{{$page['name'] ?? "unknown"}}</a>
        @endif
    @endforeach
</div>