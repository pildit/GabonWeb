import Vue from 'vue';

Vue.directive('tooltip', {
    inserted: (el)=> {
        $(el).tooltip();
    },
})
