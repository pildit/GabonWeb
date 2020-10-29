@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div id="login-form">
        <login-form></login-form>
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.User.render('login-form');
    </script>
@endsection
