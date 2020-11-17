<template>
    <div>
        <a :href="getEditRoute()" class="btn btn-sm btn-outline-success"><i class="fas fa-edit"></i> {{translate('Edit')}}</a>
        <switches v-model="isApproved" color="green" title="Approve Item" @input="approve" :emit-on-mount="false" v-tooltip></switches>
    </div>
</template>

<script>
export default {

    props: ["rowProp", "optionsProp"],

    data() {
      return {
          isApproved: this.rowProp.Approved
      }
    },

    methods: {
        getEditRoute() {

        },

        approve() {
            
        }
    }

}
</script>

<style scoped>

</style>
