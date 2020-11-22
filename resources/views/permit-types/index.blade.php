@extends('layouts.app')

@section('title', @lang('permit_types'))

@section('content')
<div id="permit-types-grid">
    <permit-types-grid></permit-types-grid>
</div>
@endsection

@section('scripts')
<script>
    Gabon.Base.getTranslations().then(() => {
        Gabon.PermitType.render('permit-types-grid');
    });
</script>
@endsection
