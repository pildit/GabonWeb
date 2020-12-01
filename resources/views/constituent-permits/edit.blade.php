@extends('layouts.app')

@section('title', @lang('constituent_permit'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div id="sidemap" class="col-md-4" style="position: fixed; padding: 10px">
                    <side-map endpoint-create="constituent-permit-create" endpoint-edit="constituent-permit-edit"></side-map>
                </div>
            </div>
            <div class="col-md-8 mt-4" id="constituent-permit-form">
                <constituent-permit-form endpoint-create="constituent-permit-create" endpoint-edit="constituent-permit-edit" style="overflow-x: scroll" :constituent-permit-prop="constituent_permit" ref="constituent_permit_form"></constituent-permit-form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {
            Gabon.ConstituentPermit.render('constituent-permit-form', {
                id : {{$id}}
            });
            Gabon.Geomap.render('sidemap');
        })
    </script>
@endsection
