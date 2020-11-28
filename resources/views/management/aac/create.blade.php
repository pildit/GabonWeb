@extends('layouts.app')

@section('title', @lang('aac_create'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div id="sidemap" class="col-md-4" style="position: fixed; padding: 10px">
                    <side-map endpoint-name="aac-create"></side-map>
                </div>
            </div>
            <div class="col-md-8 mt-4" id="aac-form">
                <aac-form v-permission="'AAC.add'" style="overflow-x: scroll" endpoint-name="aac-create"></aac-form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {
            Gabon.Management.AAC.render('aac-form');
            Gabon.Geomap.render('sidemap');
        })
    </script>
@endsection
