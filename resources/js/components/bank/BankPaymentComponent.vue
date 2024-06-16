<template>
    <div class="content supplier_content">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="button-div">
                    <div class="row">
<!--                        <div class="col-md-6">-->
<!--                            <a :href="routeName('bank-transfer.create')" class="btn btn-success btn-sm">-->
<!--                                Supplier/Employee</a>-->
<!--                        </div>-->
<!--                        <div class="col-md-6">-->
<!--                            <a :href="routeName('bank-send-money.create')" class="btn btn-success btn-sm">-->
<!--                                Branch</a>-->

<!--                        </div>-->

                    </div>
                </div>
                <h2><strong> {{translatedTexts.Bank}} {{translatedTexts.Payment}}
                </strong></h2>

                <form class="form-horizontal" @submit.prevent="paymentStore" @keydown="allErrors.clear($event.target.name)">

                    <div class="box-body" style="text-align: left">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <model-select :options="resource.designations"
                                              v-model="designation"
                                              @input="designationUsers()"
                                              name="designation"
                                              :placeholder="translatedTexts.Select+' '+translatedTexts.Designation"></model-select>
                                <span class="text-danger text-left" v-if="allErrors.has('designation')"
                                      v-text="allErrors.get('designation')">
                            </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <model-select :options="users"
                                              v-model="paymentForm.user_id"
                                              @input="getUserBanks()"
                                              name="user_id"
                                              :placeholder="translatedTexts.Select+' '+translatedTexts.User"></model-select>
                                <span class="text-danger text-left" v-if="allErrors.has('user_id')"
                                      v-text="allErrors.get('user_id')">
                                </span>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-sm-12">
                                <model-select :options="banks"
                                              v-model="paymentForm.receiver_bank_id"
                                              @input="allErrors.clear('receiver_bank_id')"
                                              name="receiver_bank_id"
                                              :placeholder="translatedTexts.Select +' '+ translatedTexts.Receiver +' '+translatedTexts.Account"></model-select>
                                <span class="text-danger text-left" v-if="allErrors.has('receiver_bank_id')"
                                      v-text="allErrors.get('receiver_bank_id')">
                                </span>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <model-select :options="resource.sender_accounts"
                                              v-model="paymentForm.sender_bank_id"
                                              @input="allErrors.clear('sender_bank_id')"
                                              name="sender_bank_id"
                                              placeholder="Select Sender Account"></model-select>
                                <span class="text-danger text-left" v-if="allErrors.has('sender_bank_id')"
                                      v-text="allErrors.get('sender_bank_id')">
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" readonly name="payable_amount" class="form-control"
                                       :value="paymentForm.payable_amount.toLocaleString()" :placeholder="translatedTexts.Payable +' '+translatedTexts.Amount +' '+ translatedTexts.or +' '+ translatedTexts.Salary">
                                <span class="text-danger text-left" v-if="allErrors.has('payable_amount')"
                                      v-text="allErrors.get('payable_amount')">
                                </span>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="number" min="0" @input="payAmount()" v-model.number="paymentForm.paid" name="paid" class="form-control"
                                       id="paid" :placeholder="translatedTexts.Paid+ ' '+ translatedTexts.Amount">
                                <span class="text-danger text-left" v-if="allErrors.has('paid')"
                                      v-text="allErrors.get('paid')">
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" readonly  :value="paymentForm.due" name="due" class="form-control"
                                       :placeholder="translatedTexts.Due+' '+translatedTexts.Amount">
                                <span class="text-danger text-left" v-if="allErrors.has('due')"
                                      v-text="allErrors.get('due')">
                                </span>

                            </div>
                        </div>

                    </div>

                    <div class="row text-center form-group mt-5">

                        <div class="col-md-4">
                            <a :href="routeName('bank-transfer.index')">
                                <button type="button" class="btn btn-warning">{{translatedTexts.View}} {{translatedTexts.Transaction}}</button>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <button style="width: 90%" type="submit" class="btn btn-success">{{translatedTexts.Pay}}</button>
                        </div>


                        <div class="col-md-4">
                            <a :href="routeName('banks.create')">
                                <button type="button" class="btn  btn-primary"> {{translatedTexts.Add}} {{translatedTexts.Bank}}</button>
                            </a>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</template>

<script>
import Errors from "../../helper/errors";
import Translate from "../../helper/translate";

export default {
    name: "BankPayment",
    props: ['resource'],
    data() {
        return {
            allErrors: new Errors(),
            paymentForm: {
                designation: {},
                payment_type: '',
                user_id : '',
                payable_amount: '',
                paid: '',
                due: '',
                receiver_bank_id: '',
                sender_bank_id: '',
            },
            designation: {},
            users: [],
            banks: [],
            translator: new Translate(),
            translatedTexts: {},
        }
    },
    created() {
        this.translateData(); // Call the translateData method during component creation
    },
    methods: {
        async translateData() {
            try {
                const keys = ["Add","Bank","Pay","Select","Cost","Type","Category","Confirm","Designation","User","Receiver","Account","Sender","Payable","Amount","or","Salary","Paid","Amount","Due","View","Transaction"]; // Array of keys to be translated
                const translatedData = await this.translator.translate(keys);
                this.translatedTexts = translatedData;
            } catch (error) {
                console.error(error);
            }
        },
        paymentStore() {
            this.isLoading = true;
            this.Loader(true);
            const form = {
                ...this.paymentForm,
            }
            this.allErrors.allClear();
            axios
                .post(route('bank-transfer.store'), form)
                .then((response) => {
                    if (response.status === 200) {
                        toastr.success("Bank Payment Successful");
                        const url = route("supplier.payment-details", response.data.result.id);
                        this.newTab(url);
                        this.reload(0);
                        this.Loader();
                    }
                })
                .catch(error => {
                    if (error && error.response.status === 422) {
                        this.allErrors.record(error.response.data.errors);
                    }
                    this.playSound();
                    this.Loader();
                })
        },
         async designationUsers() {
            this.allErrors.clear('designation');
            this.users = [];
            this.paymentForm.user_id = "";
            this.paymentForm.payment_type = this.designation.text;
            this.paymentForm.designation = this.designation.value;
          await  axios
                .post(route('get-designation-user'), {designation : this.paymentForm.designation})
                .then((response) => {
                    if (response.status === 200) {
                        this.users = response.data.result;
                    }
                })
                .catch(error => {

                })
        },
        async getUserBanks() {
            this.banks = [];
            this.allErrors.clear('user_id');
            if(this.paymentForm.payment_type === 'Supplier') {
                await this.getSupplierPayableAmount();
            }
            await axios
                .post(route('get-user.bank'), this.paymentForm)
                .then((response) => {
                    if (response.status === 200) {
                        this.banks = response.data.result;
                    }
                })
                .catch(error => {

                })
        },
        async getSupplierPayableAmount() {
            this.paymentForm.payable_amount = 0;
            this.Loader(true);
            await  axios
                .post(route('supplier-payable'), this.paymentForm)
                .then((response) => {
                    if (response.status === 200) {
                        this.paymentForm.payable_amount = response.data.result;
                        this.allErrors.clear('payable_amount')
                        this.Loader();
                    }
                })
                .catch(error => {
                    this.Loader();
                })
        },
        payAmount() {
            if(this.paymentForm.paid <= 0) {
                this.paymentForm.due = '';
                return false
            }
                if(this.paymentForm.paid > this.paymentForm.payable_amount) {
                this.paymentForm.paid = '';
                this.paymentForm.due = '';
                toastr.error("Paid amount can't be greeter then payable amount");
                return false;
            }
            this.allErrors.clear('due')
            this.paymentForm.due = parseFloat(this.paymentForm.payable_amount)-parseFloat(this.paymentForm.paid);
        }

    },
}
</script>

<style scoped>

</style>
