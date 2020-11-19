@extends('layouts.app')

@section('title', 'Developement Unit Edit')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                THE MAP
            </div>
            <div class="col-md-8 mt-4" id="development-unit-form">
                <development-unit-form :development-unit-prop="development_unit" ref="development_unit_form"></development-unit-form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {
            Gabon.Management.DevelopmentUnit.render('development-unit-form', {
                id : {{$id}}
            });
        })
    </script>
@endsection
