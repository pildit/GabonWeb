@extends('layouts.app')

@section('title', 'Site Logbooks')

@section('content')
    <div id="site-logbook-grid">
        <site-logbook-grid></site-logbook-grid>
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {
            Gabon.SiteLogbook.render('site-logbook-grid');
        });
    </script>
@endsection

