<template>
    <div class="text-right">
        <a :href="editRoute()" class="text-success aligned fz-16"
           :title="translate('Edit')"
           data-placement="left"
           v-tooltip>
            <i class="fas fa-edit"></i>
        </a>
        <a class="text-success aligned fz-16"
           :title="translate('Resend Confirmation Email')"
           data-placement="left"
           v-tooltip >
            <i class="far fa-envelope"></i>
        </a>
    </div>
</template>

<script>
import User from "components/User/User";
import Translation from "components/Mixins/Translation";

export default {

    mixins: [Translation],

    props: ["rowProp", "optionsProp"],

    data() {
        return {
            boolean: false
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

</style>
