<title>{{ $getTitle() }}</title>
@if (!config('meta-tags.show_website_to_robots'))
    <meta name="robots"
          content="noindex nofollow" />
@endif
<meta name="description"
      content="{{ $getDescription() }}">
<link rel="shortlink"
      href="{{ $getAppUrl() }}">

@if ($getGoogleSiteVerification())
    <meta name="google-site-verification"
          content="{{ $getGoogleSiteVerification() }}" />
@endif

@if ($getFacebookDomainVerification())
    <meta name="facebook-domain-verification"
          content="{{ $getFacebookDomainVerification() }}" />
@endif

@foreach ($getOgData() as $tag => $value)
    @if ($value !== null)
        <meta property="og:{{ $tag }}"
              content="{!! $value !!}">
    @endif
@endforeach

@foreach ($getOgImage() as $tag => $value)
    @if ($value !== null)
        <meta property="og:{{ $tag }}"
              content="{!! $value !!}">
    @endif
@endforeach

@foreach ($getTwitterData() as $tag => $value)
    @if ($value !== null)
        <meta name="twitter:{{ $tag }}"
              content="{{ $value }}" />
    @endif
@endforeach

@push('head-js')
    @if ($getGoogleTagManagerKey())
        <!-- Google Tag Manager -->
        <script name="GTM-DataLayer">
            window.dataLayer = window.dataLayer || [];
        </script>
        <script name="GTM-Script">
            var gtmEnv = @json($getGoogleTagManagerEnvironnement());
            (function(w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start': new Date().getTime(),
                    event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s),
                    dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;

                let queryParameters = i + dl;
                queryParameters = gtmEnv ? queryParameters + gtmEnv : queryParameters

                j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + queryParameters

                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', '{{ $getGoogleTagManagerKey() }}');
        </script>
        <!-- End Google Tag Manager -->
    @endif
@endpush


@push('js')
    {!! $getSchema() !!}
@endpush


@push('top-body')
    @if ($getGoogleTagManagerKey())
        <!-- Google Tag Manager (noscript) -->
        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id={!! $getGoogleTagManagerKey() . $getGoogleTagManagerEnvironnement() !!}"
                    height="0"
                    title="google-tag-manager"
                    width="0"
                    style="display:none;visibility:hidden">
            </iframe>
        </noscript>
        <!-- End Google Tag Manager (noscript) -->
    @endif
@endpush
