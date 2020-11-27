@extends('layouts.app')

@section('title', @lang('constituent_permit'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div id="sidemap" class="col-md-4" style="position: fixed; padding: 10px">
                    <side-map endpoint-name="constituent-permit"></side-map>
                </div>
            </div>
            <div class="col-md-8 mt-4" id="constituent-permit-form">
                <constituent-permit-form style="overflow-x: scroll"></constituent-permit-form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {
            Gabon.ConstituentPermit.render('constituent-permit-form');
            Gabon.Geomap.render('sidemap');
        })
    </script>
@endsection
