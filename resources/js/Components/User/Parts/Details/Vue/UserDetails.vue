<template>
<div>
    {{ translate('welcome_from_user_details') }} <br>
    {{translationsProp}}
</div>
</template>

<script>
export default {
    props: ['translationsProp'],
}
</script>

<style scoped>

</style>
