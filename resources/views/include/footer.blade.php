    <div class="separator"></div>
    <div class="footer_content">
        <div class="custom-text mx-auto text-center">
            {!! $cms['footer_text'] ?? "" !!}
        </div>
        <div class="separator"></div>

        <div class="col-sm p-3 SocialLinks">
            <div class="centerX">
                @foreach ($contacts['SocialLink'] as $social)
                    @if ($social['status'] == '1')
                        <div class="social-item d-inline-block">
                            <a href="{{ $social['value'] }}" title="{{ $social['name'] }}">
                                <img src="{{ asset('img/icons/'.$social['icon']) }}" title="{{ $social['name'] }}">
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="col-sm pb-3 Contact">
            <div class="centerX">
                <div class="d-flex flex-row flex-wrap">
                @foreach ($contacts['Contact'] as $contact)
                    @if ($contact['status'] == '1')
                        <div class="contact-item">
                            {{ $contact['name'] }}: {{ $contact['value'] }}
                        </div>
                    @endif
                @endforeach
                </div>
            </div>
        </div>
    </div>
