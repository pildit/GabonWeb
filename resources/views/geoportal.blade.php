@extends('layouts.app')

@section('title', @lang('geoportal'))

@section('content')
    <div>
        {{ lang('geoportal') }}
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {

        });
    </script>
@endsection
