<template>
	<div>
		<section class="content">
			<div class="dashboard">
				<div class="row text-center">
					<div class="col-md-4"></div>
					<form method="POST" class="col-md-4" @submit.prevent="paymentStore()" @keydown="allErrors.clear($event.target.name)">
						<div class="form-group">
							<h1><strong style="color:black">{{ translatedTexts.Payment }} </strong></h1>
						</div>
						<div class="form-group">
							<model-select :options="paymentResource.employee" v-model="paymentForm.selectedEmployee" @input="allErrors.clear('selectedEmployee')" :placeholder="translatedTexts.Select + ' ' + translatedTexts.Employee">
							</model-select>
							<span class="text-danger" v-if="allErrors.has('selectedEmployee')" v-text="allErrors.get('selectedEmployee')">
							</span>
						</div>

						<div class="form-group">
							<input type="text" class="form-control" v-model="paymentForm.note" :placeholder="translatedTexts.Note" @input="allErrors.clear('note')">
							<span class="text-danger " v-if="allErrors.has('note')" v-text="allErrors.get('note')">
							</span>
						</div>

						<div class="form-group">
							<input type="text" class="form-control" v-model="paymentForm.amount" placeholder="0.00" @input="allErrors.clear('amount')">
							<span class="text-danger " v-if="allErrors.has('amount')" v-text="allErrors.get('amount')">
							</span>
						</div>

						<div class="form-group">
							<input type="text" class="form-control" disabled v-model="user.name">
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-success">
								<strong>{{ translatedTexts.Confirm }}</strong>
							</button>
						</div>
					</form>
					<div class="col-md-4"></div>
				</div>
			</div>

		</section>
		<!--        <PaymentSuccessComponent :successData="successData"/>-->
	</div>
</template>

<script>
import Errors from "../../helper/errors";
import Translate from "../../helper/translate";
import PaymentSuccessComponent from "./PaymentSuccessComponent";

export default {
	name: "PaymentComponent",
	components: { PaymentSuccessComponent },
	props: ["paymentResource"],
	data() {
		return {
			paymentForm: {
				sender_cash_id: this.paymentResource.cashDrawer.id,
				selectedEmployee: "",
				note: "",
				amount: this.paymentResource.cashDrawer.amount,
			},
			allErrors: new Errors(),
			user: this.paymentResource.user,
			successData: {},
			translator: new Translate(),
			translatedTexts: {},
		};
	},
	created() {
		this.translateData(); // Call the translateData method during component creation
	},
	methods: {
		async translateData() {
			try {
				const keys = ["Payment", "Confirm","Select","Employee","Note"]; // Array of keys to be translated
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
			};
			axios
				.post(route("payment.store"), form)
				.then((response) => {
					if (response.status === 201) {
						toastr.success("Payment Successful");
						const url = route(
							"cash-drawer.show",
							response.data.result.id
						);
						this.newTab(url);
						this.reload(0);
						this.Loader();
						// this.successData = response.data;
						// this.$emit('successData', this.$modal.show("paymentSuccess"));
					}
				})
				.catch((error) => {
					this.allErrors.record(error.response.data.errors);
					if (error.response.data.message) {
						toastr.warning(error.response.data.message);
					}
					this.playSound();
					this.Loader();
				});
		},
	},
};
</script>

<style scoped>
</style>
