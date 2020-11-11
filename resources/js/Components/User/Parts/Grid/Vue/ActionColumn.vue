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
        <switches v-model="isApproved" color="green" title="Approve User" @input="approve" :emit-on-mount="false" v-tooltip></switches>
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
            isApproved: this.rowProp.status == 2
        }
    },

    methods: {
        editRoute() {
            return User.buildRoute('users.edit', {id: this.rowProp.id});
        },
        approve(val) {
            let promise = val ? User.approve(this.rowProp.id) : User.update({id: this.rowProp.id, status: 0});

            return promise.finally(() => this.rowProp.status = val ? 2 : 0);
        },
    },

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
