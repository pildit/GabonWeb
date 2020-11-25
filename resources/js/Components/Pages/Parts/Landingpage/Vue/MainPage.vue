<template>
    <main class="page landing-page text-center" ref="main-section">

        <section class="clean-block clean-services dark">
            <div class="container p-5">
                <div class="block-heading p-5">
                    <h2 class="text-success" style="color: rgb(90,135,8);opacity: 1;filter: blur(0px);">{{ translate('wood_tracking_applications') }}</h2>
                    <p>{{ translate('wood_tracking_description') }}</p>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-4 p-4">
                        <div class="card"><img class="card-img-top w-100 d-block" src="/images/inventory.jpg">
                            <div class="card-body">
                                <h4 class="card-title">{{ translate('inventory_title') }}</h4>
                                <p class="card-text">{{ translate('inventory_description') }}</p>
                            </div>
                            <div><button class="btn btn-outline-success btn-sm" type="button" disabled="">{{ translate('coming_soon') }}</button></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 p-4">
                        <div class="card"><img class="card-img-top w-100 d-block" src="/images/harvest.jpg">
                            <div class="card-body">
                                <h4 class="card-title">{{ translate('regulations_title') }}</h4>
                                <p class="card-text">{{ translate('regulations_title') }}</p>
                            </div>
                            <div><button class="btn btn-outline-success btn-sm" type="button"  disabled="">{{ translate('coming_soon') }}</button></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 p-4">
                        <div class="card"><img class="card-img-top w-100 d-block" src="/images/harvest2.jpg">
                            <div class="card-body">
                                <h4 class="card-title">{{ translate('harvest_title') }}</h4>
                                <p class="card-text">{{ translate('harvest_description') }}</p>
                            </div>
                            <div><button class="btn btn-outline-success btn-sm" type="button" disabled="">{{ translate('coming_soon') }}</button></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 p-4">
                        <div class="card"><img class="card-img-top w-100 d-block" src="/images/transportation.jpg">
                            <div class="card-body">
                                <h4 class="card-title">{{ translate('transportation_title') }}</h4>
                                <p class="card-text">{{ translate('transportation_description') }}</p>
                            </div>
                            <div><button class="btn btn-success btn-sm" type="button" onclick="window.location.href='/transportation_intro'">{{ translate('launch') }}</button></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 p-4">
                        <div class="card"><img class="card-img-top w-100 d-block" src="/images/depot.jpg">
                            <div class="card-body">
                                <h4 class="card-title">{{ translate('depot_title') }}</h4>
                                <p class="card-text">{{ translate('depot_description') }}</p>
                            </div>
                            <div class="text-success"><button class="btn btn-outline-success btn-sm" type="button" disabled="">{{ translate('coming_soon') }}</button></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 p-4">
                        <div class="card"><img class="card-img-top w-100 d-block" src="/images/transformation.jpg">
                            <div class="card-body">
                                <h4 class="card-title">{{ translate('transformation_title') }}</h4>
                                <p class="card-text">{{ translate('transformation_description') }}</p>
                            </div>
                            <div><button class="btn btn-outline-success btn-sm" type="button" disabled="">{{ translate('coming_soon') }}</button></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="clean-block clean-info dark"></section>
        <section class="clean-block features">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-success">{{ translate('features_title') }}</h2>
                    <p>{{ translate('features_description') }}</p>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-5 feature-box p-4"><i class="fas fa-mobile-alt icon" style="color: rgb(40,167,69);"></i>
                        <h4>{{ translate('mobile_apps_title') }}</h4>
                        <p>{{ translate('mobile_apps_description') }}</p>
                    </div>
                    <div class="col-md-5 feature-box p-4"><i class="fa fa-database icon" style="color: rgb(40,167,69);"></i>
                        <h4>{{ translate('central_database_sync_title') }}</h4>
                        <p>{{ translate('central_database_sync_description') }}</p>
                    </div>
                    <div class="col-md-5 feature-box p-4"><i class="fas fa-signal" style="color: rgb(40,167,69);"></i>
                        <h4>{{ translate('offline_data_recording_title') }}</h4>
                        <p>{{ translate('offline_data_recording_description') }}</p>
                    </div>
                    <div class="col-md-5 feature-box p-4"><i class="fas fa-map-marked-alt icon" style="color: rgb(40,167,69);"></i>
                        <h4>{{ translate('geoportal') }}</h4>
                        <p>{{ translate('lorem_ipsum_text') }}</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>

<script>

export default {

}
</script>

<style scoped>

</style>
