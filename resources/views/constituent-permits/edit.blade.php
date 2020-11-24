@extends('layouts.app')

@section('title', @lang('constituent_permit'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                {{lang('the_map')}}
            </div>
            <div class="col-md-8 mt-4" id="constituent-permit-form">
                <constituent-permit-form :constituent-permit-prop="constituent_permit" ref="constituent_permit_form"></constituent-permit-form>
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
        })
    </script>
@endsection
