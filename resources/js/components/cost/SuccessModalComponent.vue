<template>
    <modal  name="costAdded" :resizable="true" :scrollable="true" height="auto" @closed="closed">
        <div v-html="successData"></div>
    </modal>
</template>
<script>
export default {
    name: "costModal",
    props:['successData'],
    methods:{
        closed(){
            window.location.reload();
        },
    },

}
</script>

