@extends('layouts.app')

@section('title', @lang('concessions'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                {{lang('the_map')}}
            </div>
            <div class="col-md-8 mt-4" id="concessions-form">
                <concessions-form></concessions-form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {
            Gabon.Concession.render('concessions-form');
        })
    </script>
@endsection
