@extends('layouts.app')

@section('title', @lang('companies'))

@section('content')
<div id="companies-grid">
        <companies-grid></companies-grid>
    </div>
@endsection

@section('scripts')
<script>
    Gabon.Base.getTranslations().then(() => {
    Gabon.Company.render('companies-grid');
});
</script>
@endsection
