@extends('layouts.app')

@section('title', @lang('management_unit_edit'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div id="sidemap" class="col-md-4" style="position: fixed; padding: 10px">
                    <side-map endpoint-name="management-unit"></side-map>
                </div>
            </div>
            <div class="col-md-8 mt-4" id="management-unit-form">
                <management-unit-form style="overflow-x: scroll" v-permission="'management-unit.edit'" :management-unit-prop="management_unit" ref="management_unit_form"></management-unit-form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {
            Gabon.Management.ManagementUnit.render('management-unit-form', {
                id : {{$id}}
            });
            Gabon.Geomap.render('sidemap');
        })
    </script>
@endsection
