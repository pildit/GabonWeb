@extends('layouts.app')

@section('title', @lang('aac_edit'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div id="sidemap" class="col-md-4" style="position: fixed; padding: 10px">
                    <side-map endpoint-create="aac-create" endpoint-edit="aac-edit"></side-map>
                </div>
            </div>
            <div class="col-md-8 mt-4" id="aac-form">
                <aac-form endpoint-create="aac-create" endpoint-edit="aac-edit" style="overflow-x: scroll" v-permission="'AAC.edit'" :aac-prop="annual_allowable_cut"></aac-form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {
            Gabon.Management.AAC.render('aac-form', {
                id: {{$id}}
            });
            Gabon.Geomap.render('sidemap');
        })
    </script>
@endsection
