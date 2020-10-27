<template>
    <main class="page landing-page text-center" ref="main-section">

        <section class="clean-block clean-services dark">
            <div class="container p-5">
                <div class="block-heading p-5">
                    <h2 class="text-success" style="color: rgb(90,135,8);opacity: 1;filter: blur(0px);">{{translations['Wood trakking applications']}}</h2>
                    <p>{{translations['wood tracking description']}}</p>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-4 p-4">
                        <div class="card"><img class="card-img-top w-100 d-block" src="/images/inventory.jpg">
                            <div class="card-body">
                                <h4 class="card-title">{{translations['Inventory title']}}</h4>
                                <p class="card-text">Inventory description</p>
                            </div>
                            <div><button class="btn btn-outline-success btn-sm" type="button" disabled="">Coming soon</button></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 p-4">
                        <div class="card"><img class="card-img-top w-100 d-block" src="/images/harvest.jpg">
                            <div class="card-body">
                                <h4 class="card-title">{{translations['Regulations title']}}</h4>
                                <p class="card-text">{{translations['Regulations title']}}</p>
                            </div>
                            <div><button class="btn btn-outline-success btn-sm" type="button"  disabled="">{{translations['Coming soon']}}</button></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 p-4">
                        <div class="card"><img class="card-img-top w-100 d-block" src="/images/harvest2.jpg">
                            <div class="card-body">
                                <h4 class="card-title">{{translations['Harvest title']}}</h4>
                                <p class="card-text">{{translations['Harvest description']}}</p>
                            </div>
                            <div><button class="btn btn-outline-success btn-sm" type="button" disabled="">{{translations['Coming soon']}}</button></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 p-4">
                        <div class="card"><img class="card-img-top w-100 d-block" src="/images/transportation.jpg">
                            <div class="card-body">
                                <h4 class="card-title">{{translations['Transportation title']}}</h4>
                                <p class="card-text">{{translations['Transportation description']}}</p>
                            </div>
                            <div><button class="btn btn-success btn-sm" type="button" onclick="window.location.href='/transportation_intro'">{{translations['Launch']}}</button></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 p-4">
                        <div class="card"><img class="card-img-top w-100 d-block" src="/images/depot.jpg">
                            <div class="card-body">
                                <h4 class="card-title">{{translations['Depot title']}}</h4>
                                <p class="card-text">{{translations['Depot description']}}</p>
                            </div>
                            <div class="text-success"><button class="btn btn-outline-success btn-sm" type="button" disabled="">{{translations['Coming soon']}}</button></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 p-4">
                        <div class="card"><img class="card-img-top w-100 d-block" src="/images/transformation.jpg">
                            <div class="card-body">
                                <h4 class="card-title">{{translations['Transformation title']}}</h4>
                                <p class="card-text">Transformation description</p>
                            </div>
                            <div><button class="btn btn-outline-success btn-sm" type="button" disabled="">{{translations['Coming soon']}}</button></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="clean-block clean-info dark"></section>
        <section class="clean-block features">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-success">{{translations['Features title']}}</h2>
                    <p>{{translations['Features description']}}</p>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-5 feature-box p-4"><i class="fas fa-mobile-alt icon" style="color: rgb(40,167,69);"></i>
                        <h4>{{translations['Mobile apps title']}}</h4>
                        <p>{{translations['Mobile apps description']}}</p>
                    </div>
                    <div class="col-md-5 feature-box p-4"><i class="fa fa-database icon" style="color: rgb(40,167,69);"></i>
                        <h4>{{translations['Central database sync title']}}</h4>
                        <p>{{translations['Central database sync description']}}</p>
                    </div>
                    <div class="col-md-5 feature-box p-4"><i class="fas fa-signal" style="color: rgb(40,167,69);"></i>
                        <h4>{{translations['Offline data recording title']}}</h4>
                        <p>{{translations['Offline data recording description']}}</p>
                    </div>
                    <div class="col-md-5 feature-box p-4"><i class="fas fa-map-marked-alt icon" style="color: rgb(40,167,69);"></i>
                        <h4>{{translations['Geoportal']}}</h4>
                        <p>{{translations['Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam urna, dignissim nec auctor in, mattis vitae leo.']}}</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>

<script>
import {mapGetters} from 'vuex';

export default {
    computed: {
        ...mapGetters(['translations'])
    }
}
</script>

<style scoped>

</style>
