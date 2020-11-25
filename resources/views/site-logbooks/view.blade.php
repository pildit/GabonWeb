@extends('layouts.app')

@section('title', @lang('site_logbook_items'))

@section('content')
    <div id="site-logbook-item-grid">
        <site-logbook-item-grid></site-logbook-item-grid>
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {
            Gabon.SiteLogbookItem.render('site-logbook-item-grid');
        });
    </script>
@endsection

