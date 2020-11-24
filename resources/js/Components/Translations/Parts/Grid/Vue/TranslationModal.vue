<template>
    <bmodal ref="permitModal" size="medium" :closed="() => $emit('display', false)">
        <div slot="title">
            <h4 class="modal-title w-100 font-weight-bold">{{translate('permit_details')}}</h4>

        </div>
        <div slot="body">
            text
        </div>
    </bmodal>
</template>

<script>

    import bmodal from 'components/Common/BootstrapModal.vue';
    import {mapGetters} from 'vuex';

    export default {
        model: {
            prop: 'state',
            event: 'display'
        },


        props: ['state', 'typeProp'],

        components: {bmodal},

        computed: {
            ...mapGetters('permit', ['permit'])
        },

        methods: {
            closeModal() {
                this.$refs.permitModal.close();
                this.$emit('done');
                Vent.$emit('grid-refresh');
            }
        },
        watch: {
            state(val) {
                if(!val) return;
                this.$refs.permitModal.open();
            }
        }
    }
</script>

<style scoped>
</style>
