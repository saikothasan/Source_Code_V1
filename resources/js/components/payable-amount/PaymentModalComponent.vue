<template>
    <modal  name="PaymentSuccessModal" :resizable="true" :scrollable="true" height="auto" @closed="closed">
        <div v-html="successData"></div>
    </modal>
</template>

<script>
export default {
    name: "PaymentModal",
    props:['successData'],
    methods:{
        closed(){
            window.location.reload();
        },
    },
}
</script>

<style scoped>

</style>
