<template>
    <div class="text-right">
        <button class="btn btn-sm btn-outline-success" @click="editRole(rowProp.id)" v-if="rowProp.name != 'admin'">
            <i class="fas fa-edit"></i>
            {{ translate('edit') }}
        </button>
        <role-modal type-prop="edit" v-model="modals.form"></role-modal>
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
