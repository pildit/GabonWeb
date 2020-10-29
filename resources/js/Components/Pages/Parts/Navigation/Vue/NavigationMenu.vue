<template>
    <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-white clean-navbar" style="">
        <div class="container">
            <a class="navbar-brand text-capitalize text-success logo" href="/" style="">
                <i class="fas fa-globe-americas" style="height: 50px;width: 50px;font-size: 50px;color: rgba(13,146,32,0.9);"></i>
                Gabon
            </a>
            <button data-toggle="collapse"  class="navbar-toggler" data-target="#navcol-1">
                <span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" style="background-color: white;" id="navcol-1">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item dropdown" id="language-dropdown">
                        <a href="#" class=" nav-link dropdown-toggle waves-effect waves-light"
                           data-toggle="dropdown" role="button"
                           aria-haspopup="true"
                           aria-expanded="true">
                            <i :class="['flag', languages[lang]]"></i>
                        </a>
                        <ul class="nav-item dropdown-menu dropdown-default" aria-labelledby="lang">
                            <li class="nav-item" v-for="(country,lang) in languages">
                                <a @click="setLang(lang)" class="dropdown-item text-nowrap waves-effect waves-light">
                                    <i :class="['flag', languages[lang]]"></i>{{translations[country]}}
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import {mapGetters} from 'vuex';

export default {
    data() {
        return {

        }
    },
    computed: {
        ...mapGetters(['translations', 'languages', 'lang'])
    },
    methods: {
        setLang(lang) {
            this.$setCookie('language', lang);
            this.$store.commit('lang', lang);
            this.$store.dispatch('$fetchTranslations');
        }
    }
}
</script>

<style scoped>

</style>
