@extends('layouts.app')

@section('title', @lang('parcel_create'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div id="sidemap" class="col-md-4" style="position: fixed; padding: 10px">
                    <side-map endpoint-edit="parcels-edit" endpoint-create="parcels-create"></side-map>
                </div>
            </div>
            <div class="col-md-8 mt-4" id="parcel-form">
                <parcel-form :parcel-prop="parcel" endpoint-edit="parcels-edit" endpoint-create="parcels-create" style="overflow-x: scroll" v-permission="'parcels.add'"></parcel-form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {
            Gabon.Parcel.render('parcel-form', {
                id : {{$id}}
            });
            Gabon.Geomap.render('sidemap');
        })
    </script>
@endsection
