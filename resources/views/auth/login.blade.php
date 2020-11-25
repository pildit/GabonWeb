@extends('layouts.app')

@section('title', @lang('login'))

@section('content')
    <div id="login-form">
        <login-form></login-form>
    </div>
@endsection

@section('scripts')
    <script>
       Gabon.Base.getTranslations().then(() => {
           Gabon.User.render('login-form');
       });
    </script>
@endsection
