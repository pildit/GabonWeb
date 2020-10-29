@extends('layouts.app')

@section('title', 'Homepage TEST')

@section('content')

    <div id="user-details">
        <user-details :translations-prop="translations"></user-details>
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.Base.getTranslations().then((translations) => {
            Gabon.User.render('user-details', {
                translations: translations,
                test: 'test'
            });
        });
    </script>
@endsection


