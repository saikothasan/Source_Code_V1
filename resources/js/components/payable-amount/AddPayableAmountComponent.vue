<template>
    <div>

        <form method="POST" @submit.prevent="submitPayment()" @keydown="allErrors.clear($event.target.name)">
            <table class="table table-striped table-responsive example-table" style="white-space: pre;">
                <thead>
                <tr>
                    <th><input type="checkbox" v-model="allSelected" @change="selectAll"></th>
                    <th>Date</th>
                    <th>Invoice</th>
                    <th>Items</th>
                    <th>Quantity</th>
                    <th>Total Sale</th>
                    <th>Buy Price</th>
                    <th>Payable Amount</th>
                    <th>Advance Payment</th>
                    <!--                    <th>Total Paid</th>-->
                    <th>Pay Amount</th>
                    <th>Remaining Due</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(purchase,key) in purchaseList " :key="purchase.id">
                    <td><input type="checkbox" :disabled="purchase.total_payable<=0" v-model="selectedPurchase" :value="purchase"></td>
                    <td>{{ purchase.date  | moment("MMMM Do YYYY") }}</td>
                    <td>{{ purchase.invoice }}</td>
                    <td>{{ purchase.total_items }}</td>
                    <td>{{ purchase.total_quantity }} pcs</td>
                    <td>{{ purchase.total_sell.toLocaleString() }}</td>
                    <td>{{ purchase.subtotal.toLocaleString() }}</td>
                    <td>{{ purchase.total_payable.toLocaleString() }}</td>
                    <!--						<td>{{ purchase.advance_payment }}</td>-->
                    <td>{{ purchase.total_paid.toLocaleString() }}</td>
                    <td>
                        <input class="form-group" style="color: black;width: 100px; height: 36px;"
                               :disabled="payAmountEnable(purchase.invoice)" type="number"
                               @keyup="purchaseDue(purchase)" @input="allErrors.clear('purchase_data.pay_amount')"
                               v-model.number="purchase.pay_amount"/>
                        <span class="text-danger " v-if="allErrors.has('purchase_data.pay_amount')"
                              v-text="allErrors.get('purchase_data.pay_amount')">
							</span>
                    </td>
                    <td class="text-center"> {{ purchase.due_amount.toLocaleString() }}</td>
                </tr>
                </tbody>
            </table>
            <div class="row" style="margin-top: 10px; width: 96%;">
                <div class="col-md-10 text-right">
                    Total Buy Amount :
                </div>
                <div class="col-md-2 text-right">
                    {{ totalCalculation.totalBuyPrice.toLocaleString() }}
                </div>
            </div>
            <div class="row" style="margin-top: 10px; width: 96%;">
                <div class="col-md-10 text-right">
                    Advance Payment :
                </div>
                <div class="col-md-2 text-right">
                    {{ totalCalculation.totalAdvancePayment.toLocaleString() }}
                </div>
            </div>
            <div class="row" style="margin-top: 10px; width: 96%;">
                <div class="col-md-10 text-right">
                    Payable Amount :
                </div>
                <div class="col-md-2 text-right">
                    {{ totalCalculation.totalPayAbleAmount.toLocaleString() }}
                </div>
            </div>

            <div class="alert alert-danger" v-if="Object.keys(allErrors.errors).length > 0">
                <ul>
                    <li v-for="(error,index) in allErrors.errors">
                        <span v-if="error[0]" v-text="error[0]"></span>
                    </li>
                </ul>
            </div>
            <div class="row" style="margin-top:  20px">
                <div class="col-md-12 ">
                    <h2 style="text-align: center;">Payment</h2>
                </div>
            </div>
            <hr style="margin-top: 20px;margin-bottom: 20px;border: 0;border-top: 2px solid #020101;"/>
            <div class="row">
                <div class="col-md-12">
                    <div class="row" style="display: flex; justify-content: space-between">
                        <div class="col-md-3" style="display: flex; justify-content: space-between">
                            <div>
                                <div>Total Paid Amount</div>
                                <div>
                                    {{ totalCalculation.totalAdvancePayment.toLocaleString() }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>Select Sender Bank Account</label>
                            <select class="form-control" style="color: black;"
                                    v-model="paymentForm.sender_bank_id">
                                <option value selected>Select Sender Account</option>
                                <option v-for="(sender_account,index) in senderAccount" :value="sender_account.id"
                                        :key="index">
                                    {{ sender_account.name }} ({{sender_account.amount.toLocaleString()}})
                                </option>
                            </select>
                            <span class="text-danger " v-if="allErrors.has('sender_bank_id')"
                                  v-text="allErrors.get('sender_bank_id')">
                            </span>
                        </div>
                        <div class="col-md-3">
                            <label>Select {{ supplier.name }} Bank</label>
                            <select class="form-control" style="color: black;"
                                    v-model="paymentForm.receiver_bank_id">
                                <option value selected>Select Supplier bank</option>
                                <option v-for="(bank,index) in supplierBanks" :value="bank.id">
                                    {{ bank.name }} - {{ bank.account_no }}
                                </option>
                            </select>
                            <span class="text-danger " v-if="allErrors.has('receiver_bank_id')"
                                  v-text="allErrors.get('receiver_bank_id')">
                            </span>
                        </div>
                        <div class="col-md-2 row">
                            <div class="row">
                                <div class="col-md-6 text-right text-red">Pay</div>
                                <div class="col-md-6 text-red text-right">{{ totalCalculation.totalPayingAmount.toLocaleString() }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 text-right text-red">Due</div>
                                <div class="col-md-6 text-red text-right">{{ totalCalculation.totalDue.toLocaleString() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="text-center ">
                <div class="row">
                    <div class="col-md-4">
                        <a :href="routeName('suppliers.index')">
                            <button type="button" class="btn btn-primary">View Supplier</button>

                        </a>
                    </div>
                    <div class="col-md-4">
                        <button :disabled="selectedPurchase.length < 1" type="submit" class="btn btn-success">Pay
                        </button>
                    </div>
                    <div class="col-md-4">
                        <a :href="routeName('home')">
                            <button type="button" class="btn btn-primary">Home</button>

                        </a>
                    </div>
                </div>
            </div>
        </form>
        <PaymentModalComponent :successData="successData"/>
    </div>
</template>
<script>
import Errors from "../../helper/errors";
import PaymentModalComponent from "../payable-amount/PaymentModalComponent";
import {collect} from "collect.js";

export default {
    name: "AddPayableAmountComponent",
    props: [
        "purchases",
        "supplier",
        "fromDate",
        "toDate",
        "senderAccount",
        "supplierBanks"
    ],
    components: {PaymentModalComponent},
    data() {
        return {
            purchaseList: this.purchases,
            selectedPurchase: [],
            payAbleAmount: [],
            allSelected: false,
            allErrors: new Errors(),
            paymentForm: {
                sender_bank_id: '',
                receiver_bank_id: '',
                total_price: "",
                total_advance: "",
                total_pay: "",
                total_due: "",
                total_payable: "",
                supplier: this.supplier,
                from_date: this.fromDate,
                to_date: this.toDate,
                selectBank: {},
            },
            successData: {},
        };
    },
    watch: {
        selectedPurchase() {
            if (Object.keys(this.selectedPurchase).length === 0) {
                this.payAbleAmount = [];
                return true;
            }
        },
        allSelected() {
            if (this.allSelected === false) {
                this.payAbleAmount = [];
            }
        },
        "paymentForm.paymentMethod"()
        {
            if(this.paymentForm.paymentMethod.name !==  'Banks')
            {
                this.paymentForm.selectBank = {};
            }
        }
    },
    methods: {
        async selectAll() {
            if (this.allSelected) {
                this.selectedPurchase = this.purchases.filter((p) => p.total_payable>0);
            } else {
                this.selectedPurchase = [];
            }
        },
        payAmountEnable(invoice) {
            return !collect(this.selectedPurchase)
                .pluck("invoice")
                .contains(invoice);
        },
        purchaseDue: function (purchase) {
            if(purchase.pay_amount <= 0) {
                purchase.pay_amount = 0;
                purchase.due_amount = 0;
                return false;
            }
            if (purchase.pay_amount > purchase.total_payable) {
                purchase.pay_amount = 0;
                purchase.due_amount = 0;
                toastr.warning("Payable amount " + purchase.total_payable);
                return false;
            }
            if (purchase.total_payable && purchase.pay_amount > 0) {
                purchase.due_amount = purchase.total_payable - purchase.pay_amount;
            }
        },
        submitPayment: function () {

            if (this.selectedPurchase.length > 0) {
                const form = {
                    ...this.paymentForm,
                    purchase_data: this.selectedPurchase,
                };
                this.allErrors.allClear();
                this.Loader(true);
                axios
                    .post(route("supplier.payment"), form)
                    .then((response) => {
                        if (response.status === 200) {
                            toastr.success("Cost added successfully");
                            this.successData = response.data;
                            this.$emit(
                                "successData",
                                this.$modal.show("PaymentSuccessModal")
                            );
                        }
                        this.Loader();
                    })
                    .catch((error) => {
                        if (error && error.response.status === 422) {
                            this.allErrors.record(error.response.data.errors);
                        }
                        this.playSound();
                        this.isLoading = false;
                        this.Loader();
                    });
            }
        },
    },
    computed: {
        totalCalculation() {
            const totalBuyPrice = this.selectedPurchase.reduce(
                (total, current) => total + current.subtotal,
                0
            );
            const totalAdvancePayment = this.selectedPurchase.reduce(
                (total, current) => total + current.advance_payment,
                0
            );
            const totalPayAbleAmount = this.selectedPurchase.reduce(
                (total, current) => total + current.total_payable,
                0
            );
            const totalPayingAmount = this.selectedPurchase.reduce(
                (total, current) => total + current.pay_amount,
                0
            );
            const totalDue = totalPayAbleAmount - totalPayingAmount;
            this.paymentForm.total_price = totalBuyPrice;
            this.paymentForm.total_advance = totalAdvancePayment;
            this.paymentForm.total_pay = totalPayingAmount;
            this.paymentForm.total_due = totalDue;
            this.paymentForm.total_payable = totalPayAbleAmount;
            return {
                totalBuyPrice: totalBuyPrice,
                totalAdvancePayment: totalAdvancePayment,
                totalPayAbleAmount: totalPayAbleAmount,
                totalPayingAmount: totalPayingAmount,
                totalDue: totalDue,
            };
        },
    },
};
</script>


