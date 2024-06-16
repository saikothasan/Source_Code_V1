<template>
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<h2><strong> Money Transfer </strong></h2>
			<form class="form-horizontal" method="POST" @keydown="allErrors.clear($event.target.name)" @submit.prevent="transferStore()">
				<div class="box-body">
					<div class="form-group">
						<div class="col-sm-12">
							<select class="form-control" v-model="transferForm.selectedPaymentMethod" @change="allErrors.clear('selectedPaymentMethod.id')">
								<option :value="{}" selected>Select Payment Method</option>
								<option v-for="method in transferResource.paymentMethod" :value="method">
									{{ method.name }}
								</option>
							</select>
							<span class="text-danger " v-if="allErrors.has('selectedPaymentMethod.id')" v-text="allErrors.get('selectedPaymentMethod.id')">
							</span>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
							<select class="form-control" v-model="transferForm.selectedReceiverType" @change="allErrors.clear('receiverType')">
								<option value selected>Select Receive Type</option>
								<option v-for="receiverType in transferResource.receiverType" :value="receiverType">
									{{ receiverType }}
								</option>
							</select>
							<span class="text-danger " v-if="allErrors.has('receiverType')" v-text="allErrors.get('receiverType')">
							</span>
						</div>
					</div>
					<div class="form-group" v-show="transferForm.selectedReceiverType === 'Cash Drawer'">
						<div class="col-sm-12">
							<select class="form-control" v-model="transferForm.selectedBranch" @change="allErrors.clear('selectedBranch.id')">
								<option :value="{}" selected>Select Branch</option>
								<option v-for="branch in transferResource.branch" :value="branch">
									{{ branch.name }}s
								</option>
							</select>
							<span class="text-danger " v-if="allErrors.has('selectedBranch.id')" v-text="allErrors.get('selectedBranch.id')">
							</span>
						</div>
					</div>

					<div class="form-group" v-if="transferForm.selectedReceiverType === 'Bank' ">
						<div class="col-sm-12">
							<select class="form-control" v-model="transferForm.selectedBank" :key @change="allErrors.clear('selectedBank.id')">
								<option :value="{}" selected>Select Receiver</option>
								<option v-for="banks in transferResource.mainBranchBank" :value="banks">{{ banks.name }}
									- {{ banks.account_no }}
								</option>
							</select>
							<span class="text-danger " v-if="allErrors.has('selectedBank.id')" v-text="allErrors.get('selectedBank.id')">
							</span>
						</div>
					</div>
					<!--                    <div class="form-group" v-if="transferForm.selectedReceiverType === 'Cash Drawer' " >-->
					<!--                        <div class="col-sm-12">-->
					<!--                            <select-->
					<!--                                class="form-control" v-model="transferForm.selectedCashDrawer" :key-->
					<!--                                @change="allErrors.clear('selectedCashDrawer.id')">-->
					<!--                                <option :value="{}" selected>Select Receiver</option>-->
					<!--                                <option v-for="cashDrawer in transferResource.cashDrawer" :value="cashDrawer">-->
					<!--                                    {{ cashDrawer.name }}-->
					<!--                                </option>-->
					<!--                            </select>-->
					<!--                            <p class="form-control" v-model="transferForm.selectedCashDrawer">{{transferForm.selectedCashDrawer.name}} Cash Drawer</p>-->
					<!--                            <span class="text-danger "-->
					<!--                                  v-if="allErrors.has('selectedCashDrawer.id')"-->
					<!--                                  v-text="allErrors.get('selectedCashDrawer.id')">-->
					<!--                            </span>-->
					<!--                        </div>-->
					<!--                    </div>-->
					<div class="form-group">
						<div class="col-sm-12">
							<input type="number" class="form-control" style="color: black;" disabled v-model.number="transferForm.availableAmount" placeholder="0.00">
						</div>

					</div>
					<div class="form-group">
						<div class="col-sm-12">
							<input type="number" class="form-control" style="color: black;" step="0.01" v-model.number.trim="transferForm.transferAmount" placeholder="0.00" @input="allErrors.clear('transferAmount')">
						</div>
						<span class="text-danger " v-if="allErrors.has('transferAmount')" v-text="allErrors.get('transferAmount')">
						</span>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
							<input type="number" class="form-control" style="color: black;" disabled v-model.number="transferForm.remainingAmount" placeholder="0.00" @input="allErrors.clear('remainingAmount')">
						</div>
					</div>
				</div>
				<div class="text-center ">
					<div class="row">
						<div class="col-md-6">
							<a :href="paymentMethod">
								<button class="btn btn-primary" style="width: 70%;">Payment Method</button>
							</a>
						</div>
						<div class="col-md-6">
							<button type="submit" :disabled="this.transferForm.transferAmount === 0" class="btn btn-success">
								Transfer
							</button>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="col-md-4"></div>
	</div>
</template>

<script>
import Errors from "../../helper/errors";
import collect from "collect.js";

export default {
	name: "PaymentAmount",
	props: ["transferResource"],
	data() {
		return {
			transferForm: {
				selectedPaymentMethod: {},
				selectedReceiverType: "",
				selectedBank: {},
				selectedBranch: {},
				selectedCashDrawer: {},
				availableAmount: 0,
				transferAmount: 0,
				remainingAmount: 0,
			},
			allErrors: new Errors(),
		};
	},
	watch: {
		"transferForm.selectedPaymentMethod"() {
			this.transferForm.availableAmount =
				this.transferForm.selectedPaymentMethod
					.method_balance_sum_total_balance ?? 0;
		},
		"transferForm.transferAmount"() {
			this.calculateRemaining();
		},
		"transferForm.selectedReceiverType"() {
			if (this.transferForm.selectedReceiverType === "Cash Drawer") {
				this.transferForm.selectedBank = {};
			} else if (this.transferForm.selectedReceiverType === "Bank") {
				this.transferForm.selectedCashDrawer = {};
			}
		},
		"transferForm.selectedBranch"() {
			if (Object.keys(this.transferForm.selectedBranch).length > 0) {
				this.transferForm.selectedCashDrawer = collect(
					this.transferResource.cashDrawer
				)
					.where("branch_id", this.transferForm.selectedBranch.id)
					.first();
			}
		},
		"transferForm.selectedBank"() {
			if (Object.keys(this.transferForm.selectedBank).length > 0) {
				this.transferForm.selectedBranch = collect(
					this.transferResource.branch
				)
					.where("id", this.transferForm.selectedBank.branch_id)
					.first();
			}
		},
	},
	methods: {
		calculateRemaining() {
			let availableAmount = this.transferForm.availableAmount;
			let transferAmount = this.transferForm.transferAmount;
			if (transferAmount > availableAmount) {
				this.transferForm.transferAmount = "";
				this.transferForm.remainingAmount = availableAmount;
				toastr.warning("Available amount " + availableAmount);
				return;
			}
			if (availableAmount && transferAmount > 0) {
				this.transferForm.remainingAmount =
					availableAmount - transferAmount;
			}
		},
		transferStore() {
			const form = {
				...this.transferForm,
			};
			this.Loader(true);
			axios
				.post(route("transfer-money.store"), form)
				.then((response) => {
					if (response.data.status === 201) {
						toastr.success("Money Transfer successfully");
						const url = route(
							"transfer-money.show",
							response.data.result.id
						);
						this.newTab(url);
						this.reload(0);
						this.Loader();
						// this.successData = response.data;
						// this.$emit('successData', this.$modal.show("costAdded"));
					}
				})
				.catch((error) => {
					this.allErrors.record(error.response.data.errors);
					this.playSound();
					this.isLoading = false;
					this.Loader();
				});
		},
	},
	computed: {
		paymentMethod() {
			return route("purchases.create");
		},
	},
};
</script>

<style scoped>
</style>
