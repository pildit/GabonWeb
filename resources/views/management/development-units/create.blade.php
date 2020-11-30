@extends('layouts.app')

@section('title', @lang('development_unit_create'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div id="sidemap" class="col-md-4" style="position: fixed; padding: 10px">
                    <side-map endpoint-edit="development-unit-edit" endpoint-create="development-unit-create"></side-map>
                </div>
            </div>
            <div class="col-md-8 mt-4" id="development-unit-form">
                <development-unit-form endpoint-edit="development-unit-edit" endpoint-create="development-unit-create" style="overflow-x: scroll" v-permission="'development-unit.add'"></development-unit-form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {
            Gabon.Management.DevelopmentUnit.render('development-unit-form');
            Gabon.Geomap.render('sidemap');
        })
    </script>
@endsection
