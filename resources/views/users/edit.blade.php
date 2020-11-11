@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <div class="container mt-5" id="user-form">
       <div class="card">
           <div class="card-body">
               <user-form type-prop="edit"></user-form>
           </div>
       </div>
    </div>
@endsection

@section('scripts')
    <script>
        var user = {!! json_encode($user) !!};
        Gabon.Base.getTranslations().then(() => {
            Gabon.User.render('user-form', {
                user: user
            });
        });
    </script>
@endsection
