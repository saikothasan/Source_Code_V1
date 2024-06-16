<template>
	<div>
		<section class="content">
			<div class="dashboard">
				<div class="row text-center">
					<div class="col-md-4"></div>
					<form method="POST" class="col-md-4" @submit.prevent="transferStore()" @keydown="allErrors.clear($event.target.name)">
						<div class="form-group">
							<h1 style="color:black"><strong style="color:black">{{translatedTexts.Transfer}} </strong>{{translatedTexts.Cash}}</h1>
						</div>
						<div class="form-group">
							<select class="form-control" v-model="transferForm.selectedBranch" @change="allErrors.clear('selectedBranch.id')">
								<option :value="{}" selected>{{translatedTexts.Select}} {{translatedTexts.Branch}}</option>
								<option v-for="branch in transferResource.allBranch" :value="branch">
									{{ branch.name }}
								</option>
							</select>
							<span class="text-danger " v-if="allErrors.has('selectedBranch.id')" v-text="allErrors.get('selectedBranch.id')">
							</span>
						</div>
						<div class="form-group">
							<select class="form-control" v-model="transferForm.selectPaymentMethod" @change="allErrors.clear('selectPaymentMethod')">
								<option :value="{}" selected>{{translatedTexts.Select}} {{translatedTexts.Payment}} {{translatedTexts.Method}}</option>
								<option v-for="payment in transferResource.paymentMethod" :value="payment.id">
									{{ payment.name }}
								</option>
							</select>
							<span class="text-danger " v-if="allErrors.has('selectPaymentMethod')" v-text="allErrors.get('selectPaymentMethod')">
							</span>
						</div>

						<div class="form-group">
							<select class="form-control" v-model="transferForm.selectedBank" v-if=" bankList.length > 0" @change="allErrors.clear('selectedBank.account_no')">
								<option :value="{}" selected>{{translatedTexts.Select}} {{translatedTexts.Bank}} {{translatedTexts.Account}}</option>
								<option v-for="bank in bankList" :value="bank">
									{{ bank.name }} {{bank.account_no}}
								</option>
							</select>
							<span class="text-danger " v-if="allErrors.has('selectedBank.account_no')" v-text="allErrors.get('selectedBank.account_no')">
							</span>
						</div>

						<div class="form-group">
							<input type="text" class="form-control" v-model="transferForm.note" :placeholder="translatedTexts.Note" @input="allErrors.clear('note')">
							<span class="text-danger " v-if="allErrors.has('note')" v-text="allErrors.get('note')">
							</span>
						</div>

						<div class="form-group">
							<input type="text" class="form-control" v-model="transferForm.amount" placeholder="0.00" @input="allErrors.clear('amount')">
							<span class="text-danger " v-if="allErrors.has('amount')" v-text="allErrors.get('amount')">
							</span>
						</div>

						<div class="form-group">
							<input type="text" class="form-control" disabled v-model="user.name">
						</div>

						<div class="form-group">
							<button type="submit" :disabled="this.transferForm.amount === ''" style="color: black;" class="btn btn-success">
								{{translatedTexts.Confirm}}
								{{translatedTexts.Transfer}}
							</button>
						</div>
					</form>
					<div class="col-md-4"></div>
				</div>
			</div>

			<TransferSuccess :successData="successData" />
		</section>
	</div>
</template>

<script>
import Errors from "../../helper/errors";
import TransferSuccess from "./TransferSuccessCompoment";
import Translate from "../../helper/translate";
export default {
	name: "TransferComponent",
	components: { TransferSuccess },
	props: ["transferResource"],
	data() {
		return {
			transferForm: {
				sender_cash_id: this.transferResource.cashDrawer.branch_id,
				selectedBranch: {},
				selectPaymentMethod: {},
				selectedBank: {},
				note: "",
				amount: this.transferResource.cashDrawer.amount,
			},
			bankList: [],
			user: this.transferResource.user,
			modalShow: false,
			successData: {},
			allErrors: new Errors(),
            translator: new Translate(),
			translatedTexts: {},
		};
	},
    created() {
		this.translateData(); // Call the translateData method during component creation
	},
	watch: {
		"transferForm.selectedBranch"() {
			if (this.transferForm.selectedBranch > 0) {
				this.getBranchBankOrCashDrawer();
			}
		},
		"transferForm.selectPaymentMethod"() {
			if (this.transferForm.selectPaymentMethod > 0) {
				this.getBranchBankOrCashDrawer();
				this.bankList = [];
				this.cashDrawerList = [];
			}
		},
		"transferForm.amount"() {
			if (
				this.transferForm.amount >
				this.transferResource.cashDrawer.amount
			) {
				this.transferForm.amount = "";
				toastr.warning(
					"Available amount " +
						this.transferResource.cashDrawer.amount
				);
			}
		},
	},
	methods: {
        async translateData() {
			try {
				const keys = ["Transfer","Cash","Select","Branch","Payment","Method","Bank","Account","Confirm","Note"]; // Array of keys to be translated
				const translatedData = await this.translator.translate(keys);
				this.translatedTexts = translatedData;
			} catch (error) {
				console.error(error);
			}
		},
		getBranchBankOrCashDrawer: function () {
			const data = {
				selected_branch: this.transferForm.selectedBranch,
				select_payment_method: this.transferForm.selectPaymentMethod,
			};
			axios
				.post(route("get-branch-banks-cash-drawer"), data)
				.then((response) => {
					if (response.data.result !== null) {
						this.bankList = response.data.result;
						if (this.bankList.length === 0) {
							toastr.warning("This branch has no bank account");
						} else {
							toastr.success(response.data.message);
						}
					}
				})
				.catch((error) => {
					console.log(error.message);
				});
		},
		transferStore() {
			this.isLoading = true;
			const form = {
				...this.transferForm,
			};
			this.Loader(true);
			axios
				.post(route("transfer.store"), form)
				.then((response) => {
					if (response.status === 201) {
						toastr.success("Successfully Transferred");
						const url = route(
							"cash-drawer.show",
							response.data.result.id
						);
						this.newTab(url);
						this.reload(0);
						this.Loader();
						// this.successData = response.data;
						// this.$emit('successData', this.$modal.show("transferSuccess"));
					}
				})
				.catch((error) => {
					toastr.warning(error.response.data.message);
					this.allErrors.record(error.response.data.errors);
					this.playSound();
					this.Loader();
				});
		},
	},
};
</script>

<style scoped>
</style>
