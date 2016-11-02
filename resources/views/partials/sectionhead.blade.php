<section class="content-header">
    <h1>
        {{ $page_title }}
    </h1>
    @if (Session::has('flash_alert_notice'))
    <div class="alert {{ Session::get('alert_class','alert-success') }}">{{ Session::get('flash_alert_notice') }}</div>
    @endif
</section>
