@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div id="register-form">
        <register-form></register-form>
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.User.render('register-form');
    </script>
@endsection
