<template>
    <div v-html="getCellValue"></div>
</template>

<script>
import RenderMixin from "./Mixins/RenderMixin";

export default {
    props:["rowProp", "columnProp", "keyProp", "instance" , "index"],
    mixins: [RenderMixin]
}
</script>

<style scoped>

</style>
