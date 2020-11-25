@extends('layouts.app')

@section('title', @lang('roles'))

@section('content')
    <div id="roles-grid">
        <roles-grid></roles-grid>
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {
            Gabon.Role.render('roles-grid');
        });
    </script>
@endsection
