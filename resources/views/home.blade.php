@extends('layouts.app')

@section('title', "Home")

@section('content')

    <!--Mask-->
    <div id="intro" class="view">

        <div class="mask rgba-green-light">

            <div class="container-fluid d-flex align-items-center justify-content-center h-100">

                <div class="row d-flex justify-content-center text-center">

                    <div class="col-md-10">

                        <!-- Heading -->
                        <h4 class="display-4  white-text pt-5 mb-2"><?=lang("Intro title")?></h4>

                        <!-- Divider -->
                        <hr class="hr-light">

                        <!-- Description -->
                        <h5 class="white-text my-4"><?=lang("Intro description")?></h5>
                        <button type="button" id="read-more" class="btn btn-outline-white"><?=lang("Read more")?><i class="fas fa-book ml-2"></i></button>

                    </div>

                </div>

            </div>

        </div>

    </div>
    <!--/.Mask-->
    <main class="page landing-page text-center">

        <section class="clean-block clean-services dark">
            <div class="container p-5">
                <div class="block-heading p-5">
                    <h2 class="text-success" style="color: rgb(90,135,8);opacity: 1;filter: blur(0px);"><?=lang("Wood trakking applications")?></h2>
                    <p><?=lang("wood tracking description")?></p>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-4 p-4">
                        <div class="card"><img class="card-img-top w-100 d-block" src="/images/inventory.jpg">
                            <div class="card-body">
                                <h4 class="card-title"><?=lang("Inventory title")?></h4>
                                <p class="card-text"><?=lang("Inventory description")?></p>
                            </div>
                            <div><button class="btn btn-outline-success btn-sm" type="button" disabled=""><?=lang("Coming soon")?></button></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 p-4">
                        <div class="card"><img class="card-img-top w-100 d-block" src="/images/harvest.jpg">
                            <div class="card-body">
                                <h4 class="card-title"><?=lang("Regulations title")?></h4>
                                <p class="card-text"><?=lang("Regulations title")?></p>
                            </div>
                            <div><button class="btn btn-outline-success btn-sm" type="button"  disabled=""><?=lang("Coming soon")?></button></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 p-4">
                        <div class="card"><img class="card-img-top w-100 d-block" src="/images/harvest2.jpg">
                            <div class="card-body">
                                <h4 class="card-title"><?=lang("Harvest title")?></h4>
                                <p class="card-text"><?=lang("Harvest description")?></p>
                            </div>
                            <div><button class="btn btn-outline-success btn-sm" type="button" disabled=""><?=lang("Coming soon")?></button></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 p-4">
                        <div class="card"><img class="card-img-top w-100 d-block" src="/images/transportation.jpg">
                            <div class="card-body">
                                <h4 class="card-title"><?=lang("Transportation title")?></h4>
                                <p class="card-text"><?=lang("Transportation description")?></p>
                            </div>
                            <div><button class="btn btn-success btn-sm" type="button" onclick="window.location.href='/transportation_intro'"><?=lang("Launch")?></button></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 p-4">
                        <div class="card"><img class="card-img-top w-100 d-block" src="/images/depot.jpg">
                            <div class="card-body">
                                <h4 class="card-title"><?=lang("Depot title")?></h4>
                                <p class="card-text"><?=lang("Depot description")?></p>
                            </div>
                            <div class="text-success"><button class="btn btn-outline-success btn-sm" type="button" disabled=""><?=lang("Coming soon")?></button></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 p-4">
                        <div class="card"><img class="card-img-top w-100 d-block" src="/images/transformation.jpg">
                            <div class="card-body">
                                <h4 class="card-title"><?=lang("Transformation title")?></h4>
                                <p class="card-text"><?=lang("Transformation description")?></p>
                            </div>
                            <div><button class="btn btn-outline-success btn-sm" type="button" disabled=""><?=lang("Coming soon")?></button></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="clean-block clean-info dark"></section>
        <section class="clean-block features">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-success"><?=lang("Features title")?></h2>
                    <p><?=lang("Features description")?></p>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-5 feature-box p-4"><i class="fas fa-mobile-alt icon" style="color: rgb(40,167,69);"></i>
                        <h4><?=lang("Mobile apps title")?></h4>
                        <p><?=lang("Mobile apps description")?></p>
                    </div>
                    <div class="col-md-5 feature-box p-4"><i class="fa fa-database icon" style="color: rgb(40,167,69);"></i>
                        <h4><?=lang("Central database sync title")?></h4>
                        <p><?=lang("Central database sync description")?></p>
                    </div>
                    <div class="col-md-5 feature-box p-4"><i class="fas fa-signal" style="color: rgb(40,167,69);"></i>
                        <h4><?=lang("Offline data recording title")?></h4>
                        <p><?=lang("Offline data recording description")?></p>
                    </div>
                    <div class="col-md-5 feature-box p-4"><i class="fas fa-map-marked-alt icon" style="color: rgb(40,167,69);"></i>
                        <h4><?=lang("Geoportal")?></h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam urna, dignissim nec auctor in, mattis vitae leo.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('scripts')
    <script>
        (() => {
           $('#read-more').click(()=> {
               $('html, body').animate({
                   scrollTop: $("main").offset().top - 75
               }, 600);
           });
        })();
    </script>
@endsection
