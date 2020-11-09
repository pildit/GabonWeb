@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <div id="users-grid">
        <users-grid></users-grid>
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {
            Gabon.User.render('users-grid');
        });
    </script>
@endsection

