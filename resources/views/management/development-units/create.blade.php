@extends('layouts.app')

@section('title', 'Developement Unit')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                THE MAP
            </div>
            <div class="col-md-8 mt-4" id="development-unit-form">
                <development-unit-form></development-unit-form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {
            Gabon.Management.DevelopmentUnit.render('development-unit-form');
        })
    </script>
@endsection