@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <div class="container mt-5" id="user-form">
       <div class="card">
           <div class="card-body">
               <h5 class="card-title">Edit User: {{json_decode($user)->email}}</h5>
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
