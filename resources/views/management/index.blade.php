@extends('layouts.app')

@section('title', @lang('management'))

@section('content')

    <main class="page landing-page text-center" ref="main-section">

        <section class="clean-block clean-services dark" id="management">
            <div class="container p-5">
                @verbatim
                <div class="block-heading p-5">
                    <h2 class="text-success" style="color: rgb(90,135,8);opacity: 1;filter: blur(0px);">{{ translate('management') }}</h2>
                    <p></p>
                </div>
                @endverbatim
                <div class="row">
                    <vue-card v-for="(item, index) in management"
                              :item="item"
                              :key="index"
                              v-permissions="item.permission"></vue-card>
                </div>
            </div>
        </section>
    </main>

@endsection

@section('scripts')
    <script>
        Gabon.Base.getTranslations().then(() => {
            Gabon.Pages.render('management');
        });
    </script>
@endsection
