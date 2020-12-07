<template>
    <div><span :class="{'text-muted': !getCellValue}">{{getCellValue || `(empty)`}}</span></div>
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
