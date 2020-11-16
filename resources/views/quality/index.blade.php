@extends('layouts.app')

@section('title', 'Quality')

@section('content')
<div id="quality-grid">
    <quality-grid></quality-grid>
</div>
@endsection

@section('scripts')
<script>
    Gabon.Base.getTranslations().then(() => {
        Gabon.Quality.render('quality-grid');
    });
</script>
@endsection