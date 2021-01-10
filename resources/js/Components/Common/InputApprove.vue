<template>
    <div v-show="!submitted">
        {{translate('new_value')}}: {{value}}
        <a @click.prevent="change" class="text-success"><i class="fas fa-check"></i></a>
        <a @click.prevent="submitted = true" class="text-danger"><i class="fas fa-times"></i></a>
    </div>
</template>

<script>
export default {
    model: {
        prop: 'value',
    },

    props: ['value'],

    data() {
        return {
            submitted: false
        }
    },

    methods: {
        change() {
            this.$emit('apply', this.value);
            this.submitted = true;
        }
    }
}
</script>

<style scoped>

</style>
