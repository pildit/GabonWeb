@extends('layouts.app')

@section('title', 'Carnet d\'abattage')

@section('content')
    <div id="logbook-grid">
        {{--Carnet d'abattage--}}
        <logbook-grid></logbook-grid>
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {
            Gabon.Logbook.render('logbook-grid');
        });
    </script>
@endsection
