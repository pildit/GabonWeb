<template>
<div>
    {{msg}} <br>
    {{translationsProp}}
</div>
</template>

<script>
export default {
    props: ['translationsProp'],
    data() {
        return {
            msg : "Welcome from user details component"
        }
    }
}
</script>

<style scoped>

</style>
