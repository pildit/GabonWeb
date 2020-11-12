@extends('layouts.app')

@section('title', 'Species')

@section('content')
<div id="species-grid">
    <species-grid></species-grid>
</div>
@endsection

@section('scripts')
<script>
    Gabon.Base.getTranslations().then(() => {
        Gabon.Species.render('species-grid');
    });
</script>
@endsection