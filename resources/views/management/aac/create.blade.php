@extends('layouts.app')

@section('title', @lang('aac_create'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                {{ lang('the_map') }}
            </div>
            <div class="col-md-8 mt-4" id="aac-form">
                <aac-form v-permission="'AAC.add'"></aac-form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {
            Gabon.Management.AAC.render('aac-form');
        })
    </script>
@endsection
