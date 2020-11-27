<template>
    <div class="text-right">
        <a v-permission="'roles.edit'" class="text-success aligned fz-16" @click="editRole(rowProp.id)" v-if="rowProp.name != 'admin'"
           :title="translate('edit')" v-tooltip>
            <i class="fas fa-edit"></i>
        </a>
        <role-modal v-permission="'roles.edit'" type-prop="edit" v-model="modals.form"></role-modal>
    </div>
</template>

<script>
import RoleModal from "./RoleModal";
import Role from "components/Role/Role";

export default {

    props: ["rowProp", "optionsProp"],

    components: {RoleModal},

    data() {
        return {
            modals: {
                form: false
            }
        }
    },

    methods: {
        editRole(id) {
            Role.get(id).then(() => this.modals.form = true);
        }
    }
}
</script>

<style scoped>

</style>
