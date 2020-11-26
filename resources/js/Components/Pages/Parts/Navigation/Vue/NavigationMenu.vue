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
                  <menu-item v-for="(item, index) in menu"
                             :key="index"
                             :model="item">
                  </menu-item>
                  <!-- if guest -->
                  <li v-if="!logged_in" class="nav-item">
                    <a class="nav-link text-nowrap" href="/login">{{ translate('login') }}</a>
                  </li>
                  <!-- if logged in -->
                  <li v-else class="nav-item dropdown">
                    <a href="#" class=" nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{  username }}<span class="caret"></span></a>
                    <ul class="nav-item dropdown-menu dropdown-default" aria-labelledby="about-us">
                      <li class="nav-item">
                        <a class="dropdown-item text-nowrap" href="/logout">{{ translate("logout") }}</a>
                      </li>
                    </ul>
                  </li>

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
                                    <i :class="['flag', languages[lang]]"></i>{{ translate(country) }}
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
import {mapGetters, mapState} from 'vuex';

import MenuItem from './MenuItem.vue';

export default {
    data() {
        return {}
    },
    computed: {
        ...mapGetters(['translations', 'languages', 'lang', 'menu', 'logged_in']),
        ...mapState(['loggedUser']),
      username()  {
          return this.loggedUser.firstname + ' ' + this.loggedUser.lastname;
      }
    },
    methods: {
        setLang(lang) {
            this.$setCookie('language', lang);
            this.$store.commit('lang', lang);
            this.$store.dispatch('$fetchTranslations');
        }
    },
    created() {
      this.$store.dispatch('$fetchMenu').then(() =>this.$hideLoading());
    },
    components : {MenuItem}
}
</script>

<style scoped>

</style>
