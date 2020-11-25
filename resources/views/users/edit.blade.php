@extends('layouts.app')

@section('title', @lang('edit_user'))

@section('content')
    <div class="container mt-5" id="user-form">
       <div class="card">
           <div class="card-body">
               <h5 class="card-title">@lang('edit_user'): {{json_decode($user)->email}}</h5>
               <user-form type-prop="edit" :user-prop="{{$user}}"></user-form>
           </div>
       </div>
    </div>
@endsection

@section('scripts')
    <script>
        {{--var user = {!! json_encode($user) !!};--}}
        Gabon.Base.getTranslations().then(() => {
            Gabon.User.render('user-form');
        });
    </script>
@endsection
