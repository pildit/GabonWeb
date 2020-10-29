@extends('layouts.app')

@section('title', "Home")

@section('content')
    <div id="landingpage">

        <div id="intro" class="view">
            <intro-info></intro-info>
        </div>

        <main-page></main-page>
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {
           Gabon.Pages.render('landingpage');
        });
    </script>
@endsection
