@extends('layouts.app')

@section('title', @lang('forgot_password'))

@section('content')
    <div id="forgot-password-form">
        <forgot-password-form></forgot-password-form>
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {
            Gabon.User.render('forgot-password-form');
        });
    </script>
@endsection
