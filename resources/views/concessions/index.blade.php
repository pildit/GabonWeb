@extends('layouts.app')

@section('title', @lang('concessions'))

@section('content')

<main class="page landing-page text-center" ref="main-section">

    <section class="clean-block clean-services dark">
        <div class="container p-5">
            <div class="block-heading p-5">
                <h2 class="text-success" style="color: rgb(90,135,8);opacity: 1;filter: blur(0px);">Concessions</h2>
                <p></p>
            </div>
            <div class="row" id="concessions">
                <box-resource v-for="item in concessions" :item="item"></box-resource>
            </div>
        </div>
    </section>
</main>

@endsection

@section('scripts')
<script>
    Gabon.Base.getTranslations().then(() => {
        Gabon.Pages.render('concessions');
    });
</script>
@endsection
