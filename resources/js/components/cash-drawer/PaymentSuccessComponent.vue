<template>
    <modal name="paymentSuccess" :resizable="true" :scrollable="true" height="auto" @closed="closed">
        <div v-html="successData"></div>
    </modal>
</template>
<script>
export default {
    name: "paymentSuccess",
    props:['successData'],
    methods:{
        closed(){
            window.location.reload();
        },
    },

}
</script>

