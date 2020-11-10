<template>
    <div class="text-right">
        <a :href="editRoute()" class="text-success aligned fz-16"
           :title="translate('Edit')"
           v-tooltip>
            <i class="fas fa-edit"></i>
        </a>
        <a class="text-success aligned fz-16"
           :title="translate('Resend Confirmation Email')"
           v-tooltip >
            <i class="far fa-envelope"></i>
        </a>
        <switches v-model="enabled" color="green" title="Approve User" v-tooltip></switches>
    </div>
</template>

<script>
import User from "components/User/User";
import Translation from "components/Mixins/Translation";
import Switches from 'vue-switches';

export default {

    mixins: [Translation],

    props: ["rowProp", "optionsProp"],

    components: {Switches},

    data() {
        return {
            enabled: false
        }
    },

    methods: {
        editRoute() {
            return User.buildRoute('users.edit', {id: this.rowProp.id});
        }
    }

}
</script>

<style scoped>
.aligned {
    vertical-align: middle;
}
.fz-16 {
    font-size: 16px;
}
.vue-switcher {
    position: relative;
    display: inline-block;
    margin-bottom: 0;
    vertical-align: middle;
    margin-left: 0.2em;
}

</style>
