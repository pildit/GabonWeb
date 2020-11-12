import Vue from 'vue';

Vue.directive('popover', {
    inserted: (el) => {
        $(el).popover();
    }
})
