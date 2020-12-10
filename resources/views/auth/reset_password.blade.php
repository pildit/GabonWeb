@extends('layouts.app')

@section('title', @lang('reset_password'))

@section('content')
    <div id="reset-password">
        <reset-password></reset-password>
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {
            Gabon.User.render('reset-password');
        });
    </script>
@endsection
