@extends('layouts.app')

@section('title', @lang('quality'))

@section('content')
<div id="quality-grid">
    <quality-grid v-permission="'quality.view'"></quality-grid>
</div>
@endsection

@section('scripts')
<script>
    Gabon.Base.getTranslations().then(() => {
        Gabon.Quality.render('quality-grid');
    });
</script>
@endsection
