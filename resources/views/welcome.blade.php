@extends('layouts.app')

@section('title', 'Homepage TEST')

@section('content')

    <div id="user-details">
        <user-details></user-details>
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.User.render('user-details');
    </script>
@endsection


