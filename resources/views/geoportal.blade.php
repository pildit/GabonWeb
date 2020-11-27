@extends('layouts.app')

@section('title', @lang('geoportal'))

@section('content')
    <div id="geoportalpage">
       <geoportal-page></geoportal-page>
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {
            Gabon.Pages.render('geoportalpage');
        });
    </script>
@endsection
