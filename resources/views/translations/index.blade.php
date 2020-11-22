@extends('layouts.app')

@section('title', @lang('translations'))

@section('content')
    <div id="translation-grid">
        <translation-grid></translation-grid>
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {
            Gabon.Translation.render('translation-grid');
        });
    </script>
@endsection

