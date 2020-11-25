@extends('layouts.app')

@section('title', @lang('register'))

@section('content')
    <div id="register-form">
        <register-form></register-form>
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {
            Gabon.User.render('register-form');
        });
    </script>
@endsection
