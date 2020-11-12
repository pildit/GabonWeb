<template>

    <div class="mask rgba-green-light">

        <div class="container-fluid d-flex align-items-center justify-content-center h-100">

            <div class="row d-flex justify-content-center text-center">

                <div class="col-md-10">

                    <!-- Heading -->
                    <h4 class="display-4  white-text pt-5 mb-2">{{translate('Intro title')}}</h4>

                    <!-- Divider -->
                    <hr class="hr-light">

                    <!-- Description -->
                    <h5 class="white-text my-4">{{translate('Intro description')}}</h5>
                    <button type="button" id="read-more" @click="scrollToMain()" class="btn btn-outline-white">{{translate('Read more')}}<i class="fas fa-book ml-2"></i></button>

                </div>

            </div>

        </div>

    </div>


</template>

<script>

export default {
    methods: {
        scrollToMain() {
            $('html, body').animate({
                scrollTop: $("main").offset().top - 75
            }, 600);
        }
    }

}
</script>

<style scoped>

</style>
