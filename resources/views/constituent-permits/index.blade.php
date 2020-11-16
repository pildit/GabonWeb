@extends('layouts.app')

@section('title', 'Constituent permits')

@section('content')
<div id="items-grid">
    <items-grid></items-grid>
</div>
@endsection

@section('scripts')
<script>
    Gabon.Base.getTranslations().then(() => {
        Gabon.ConstituentPermit.render('items-grid');
    });
</script>
@endsection