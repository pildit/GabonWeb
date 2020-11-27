@extends('layouts.app')

@section('title', @lang('parcels'))

@section('content')
    <div id="items-grid">
        <items-grid v-permission="'parcels.view'"></items-grid>
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {
            Gabon.Parcel.render('items-grid');
        });
    </script>
@endsection
