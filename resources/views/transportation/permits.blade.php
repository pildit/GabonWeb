@extends('layouts.app')

@section('title', @lang('transport_permits'))

@section('content')
    <div id="permit-grid">
        <permit-grid></permit-grid>
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {
            Gabon.Permit.render('permit-grid');
        });
    </script>
@endsection
