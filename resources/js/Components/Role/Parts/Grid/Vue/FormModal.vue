<template>
    <bmodal ref="roleForm" size="large" :closed="() => $emit('display', false)">
        <div slot="title">
            Modal TITLE
        </div>
        <div slot="body">
            MODAL BODY
        </div>
        <div slot="footer">
            FOOTER
        </div>
    </bmodal>
</template>

<script>
import bmodal from 'components/Common/BootstrapModal.vue'

export default {
    model: {
      prop: 'state',
      event: 'display'
    },

    props: ['state'],

    components: {bmodal},

    watch: {
        state(val) {
            if(!val) return;
            this.$refs.roleForm.open();
        }
    }
}
</script>

<style scoped>

</style>
