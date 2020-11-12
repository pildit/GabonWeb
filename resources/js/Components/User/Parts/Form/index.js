import _ from "lodash";
import Vue from 'vue';
import store from "store/store";
import UserForm from "./Vue/UserForm.vue";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: {UserForm},
        created() {
            this.$store.dispatch('user/types');
            this.$store.dispatch('role/permissions');
            this.$store.dispatch('role/roles');
        }
    }

    return new Vue(_.merge(options, vueOptions));
}
