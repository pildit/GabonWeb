@extends('layouts.app')

@section('title', @lang('management_unit_create'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                {{ lang('the_map') }}
            </div>
            <div class="col-md-8 mt-4" id="management-unit-form">
                <management-unit-form v-permission="'management-unit.add'"></management-unit-form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {
            Gabon.Management.ManagementUnit.render('management-unit-form');
        })
    </script>
@endsection
