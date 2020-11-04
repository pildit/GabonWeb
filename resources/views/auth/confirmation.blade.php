@extends('layouts.app')

@section('title', 'Account Confirmation')

@section('content')
    <div id="account-confirmation">
        <account-confirmation token-prop="{{$token}}"></account-confirmation>
    </div>
@endsection

@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {
            Gabon.User.render('account-confirmation');
        });
    </script>
@endsection

