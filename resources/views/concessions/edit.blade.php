@extends('layouts.app')

@section('title', @lang('concessions'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div id="sidemap" class="col-md-4" style="position: fixed; padding: 10px">
                    <side-map endpoint-name="concessions"></side-map>
                </div>
            </div>
            <div class="col-md-8 mt-4" id="concessions-form">
                <concessions-form style="overflow-x: scroll" v-permission="'concession.edit'" :concession-prop="concession"></concessions-form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {
            Gabon.Concession.render('concessions-form', {
                id : {{$id}}
            });
            Gabon.Geomap.render('sidemap');
        })
    </script>
@endsection
