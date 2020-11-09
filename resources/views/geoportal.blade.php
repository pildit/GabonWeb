@extends('layouts.app')

@section('title', "Home")

@section('content')
    <div>
        GEOPORTAL
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {

        });
    </script>
@endsection
