<template>
    <modal name="transferSuccess" :resizable="true" :scrollable="true" height="auto" @closed="closed">
        <div v-html="successData"></div>
    </modal>
</template>
<script>
export default {
    name: "transferSuccess",
    props:['successData'],
    methods:{
        closed(){
            window.location.reload();
        },
    },

}
</script>

