<template>
	<div>
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<h2><strong> {{translatedTexts.New}} {{translatedTexts.Cost}} </strong></h2>
				<form class="form-horizontal" method="POST" @submit.prevent="costStore()" @keydown="allErrors.clear($event.target.name)">
					<div class="box-body">
						<div class="form-group" v-if="costResource.user.is_main_branch">
							<div class="col-sm-12">
								<select name="cost_branch_id" class="form-control" style="width: 100%; color: black;" v-model="costForm.cost_branch_id">
									<option value="">{{translatedTexts.Select}} {{translatedTexts.Branch}}</option>
									<option v-for="(cost_branch , index) in costBranch" :key="index" :value="cost_branch.value">
										{{ cost_branch.text }}
									</option>
								</select>
								<span class="text-danger " v-if="allErrors.has('cost_branch_id')" v-text="allErrors.get('cost_branch_id')">
								</span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<select class="form-control" style="width: 100%; color: black;" v-model="costForm.selectedCost" @change="getCostCategory(costForm.selectedCost)">
									<option value="">{{translatedTexts.Select}} {{translatedTexts.Cost}} {{translatedTexts.Type}}</option>
									<option v-for="(cost , index) in allCostType" :key="index" :value="index">
										{{ cost }}
									</option>
								</select>
								<span class="text-danger " v-if="allErrors.has('selectedCost')" v-text="allErrors.get('selectedCost')">
								</span>
							</div>
						</div>
						<div class="form-group" v-show="showCategory === true ">
							<div class="col-sm-12">
								<select class="form-control" style="width: 100%; color: black;" v-model="costForm.selectedCostCategory" @change="getCostCategoryField(costForm.selectedCostCategory)">
									<option value="">{{translatedTexts.Select}} {{translatedTexts.Cost}} {{translatedTexts.Category}}</option>
									<option v-for="(category , key) in costCategory" :value="key">
										{{ key.charAt(0).toUpperCase() + key.slice(1) }}
									</option>
								</select>
								<span class="text-danger " v-if="allErrors.has('selectedCostCategory')" v-text="allErrors.get('selectedCostCategory')">
								</span>
							</div>
						</div>

						<div class="form-group" v-for="(key ,index) in costForm.details">
							<div class="col-sm-12" v-if="index === 'selected_month'">
								<select class="form-control" style="width: 100%; color: black;" v-model="costForm.details[index]">
									<option value="">{{translatedTexts.Select}} {{ index }}</option>
									<option v-for="(month , monthIndex) in costResource.allMonth" :value="monthIndex">
										{{ month }}
									</option>
								</select>
								<span class="text-danger" v-if="allErrors.has(`details.${index}`)" v-text="allErrors.get(`details.${index}`)">
								</span>
							</div>

							<div class="col-sm-12" v-else-if="index === 'selected_payment_method'">
								<select class="form-control" style="width: 100%; color: black;" v-model="costForm.details[index]">
									<option value="">{{translatedTexts.Select}} {{ index }}</option>
									<option v-for="method  in costResource.paymentMethod" :value="method.id">
										{{ method.name }}
									</option>
								</select>
								<span class="text-danger" v-if="allErrors.has(`details.${index}`)" v-text="allErrors.get(`details.${index}`)">
								</span>
							</div>
							<div class="col-sm-12" v-else-if="index === 'selected_asset_position'">
								<!--                                <select class="form-control" style="width: 100%; color: black;"-->
								<!--                                        v-model="costForm.details[index]">-->
								<!--                                    <option value="">Select {{ index }}</option>-->
								<!--                                    <option v-for="asset  in costResource.assetPosition" :value="asset.name">-->
								<!--                                        {{ asset.name }}-->
								<!--                                    </option>-->
								<!--                                </select>-->
								<model-select :options="costResource.assetPosition" v-model="costForm.details[index]" @input="allErrors.clear(`details.${index}`)" :placeholder="index"></model-select>
								<span class="text-danger" v-if="allErrors.has(`details.${index}.index`)" v-text="allErrors.get(`details.${index}.index`)">
								</span>

							</div>
							<div class="col-sm-12" v-else-if="index === 'selected_employee'">
								<!--                                <select class="form-control" style="width: 100%; color: black;"-->
								<!--                                        v-model="costForm.details[index]">-->
								<!--                                    <option value="">Select {{ index }}</option>-->
								<!--                                    <option v-for="employee  in costResource.allEmployee" :value="employee.name">-->
								<!--                                        {{ employee.name }}-->
								<!--                                    </option>-->
								<!--                                </select>-->
								<model-select :options="costResource.allEmployee" v-model="costForm.details[index]" @change="allErrors.clear(`details.${index}`)" :placeholder="index"></model-select>

								<span class="text-danger" v-if="allErrors.has(`details.${index}`)" v-text="allErrors.get(`details.${index}`)">
								</span>

							</div>
							<div v-else class="col-sm-12">
								<input type="text" v-model="costForm.details[index]" class="form-control" style="color: black;" :placeholder="index">
								<span class="text-danger" v-if="allErrors.has(`details.${index}`)" v-text="allErrors.get(`details.${index}`)">
								</span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<input type="text" :readonly="amountReadonly" v-model="costForm.amount" min="1" class="form-control" style="color: black;" :placeholder="costForm.amount">
								<span class="text-danger " v-if="allErrors.has('amount')" v-text="allErrors.get('amount')">
								</span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<input type="text" v-model="user_name" readonly class="form-control" style="color: black;" placeholder="User auto">
							</div>
						</div>
					</div>
					<div class="row text-center form-group mt-5">
						<div class="col-md-3"></div>
						<div class="col-md-6">
							<button type="submit" class="btn btn-success">{{translatedTexts.Confirm}}</button>
						</div>
						<div class="col-md-3"></div>
					</div>
				</form>
			</div>
			<div class="col-md-4"></div>
		</div>
		<SuccessModal :successData="successData" />
	</div>
</template>

<script>
import Errors from "../../helper/errors";
import SuccessModal from "../cost/SuccessModalComponent";
import Translate from "../../helper/translate";
export default {
	props: ["costResource", "costBranch"],
	components: { SuccessModal },
	data() {
		return {
			allCostType: this.costResource.all_cost_type,
			// allCostCategory: {},
			costCategory: [],
			showCategory: false,
			allErrors: new Errors(),
			user_name: this.costResource.user.name,
			costForm: {
				selectedCost: "",
				selectedCostCategory: "",
				details: {},
				amount: this.costResource.amount,
				selected_employee: "",
				cost_branch_id: this.costResource.user.branch_id,
			},
			employeePhone: "",
			successData: {},
			amountReadonly: false,
			modalShow: false,
            translator: new Translate(),
			translatedTexts: {},
		};
	},
    created() {
		this.translateData(); // Call the translateData method during component creation
	},
	watch: {
		"costForm.details.tiffin_price"() {
			this.tiffinTotal();
		},
		"costForm.details.tiffin_qty"() {
			this.tiffinTotal();
		},
		"costForm.details.purchase_cost"() {
			this.purchaseTotal();
		},
		"costForm.details.purchase_transport_cost"() {
			this.purchaseTotal();
		},
		"costForm.selectedCostCategory"() {
			this.amountReadonly =
				this.costForm.selectedCostCategory === "tiffin";
			this.amountReadonly =
				this.costForm.selectedCostCategory === "asset";
		},
		"costForm.details.amount_receiver_phone"() {
			this.employeePhone = this.costForm.details.amount_receiver_phone;
		},
		employeePhone() {
			if (this.employeePhone.length < 11) {
				return true;
			}
			this.getEmployee();
		},
	},
	methods: {
        async translateData() {
			try {
				const keys = ["New","Cost","Select","Branch","Cost","Type","Category","Confirm",]; // Array of keys to be translated
				const translatedData = await this.translator.translate(keys);
				this.translatedTexts = translatedData;
			} catch (error) {
				console.error(error);
			}
		},
		tiffinTotal() {
			let tiffin_price = this.costForm.details.tiffin_price;
			let tiffin_qty = this.costForm.details.tiffin_qty;
			if (tiffin_price && tiffin_qty > 0) {
				this.costForm.amount = tiffin_price * tiffin_qty;
			}
		},
		purchaseTotal() {
			let purchase_price = parseInt(this.costForm.details.purchase_cost);
			let purchase_transport = parseInt(
				this.costForm.details.purchase_transport_cost
			);
			if (purchase_price && purchase_transport > 0) {
				this.costForm.amount = purchase_price + purchase_transport;
			}
		},
		getCostCategory(val) {
			if (val === "one_time_cost") {
				this.showCategory = false;
				this.costForm.details = this.costResource.cost_type[val];
			} else {
				this.showCategory = true;
				this.costCategory = this.costResource.cost_type[val];
			}
		},
		getCostCategoryField(val) {
			const costCategory = this.costForm.selectedCost;
			this.costForm.details =
				this.costResource.cost_type[costCategory][val];
		},
		costStore() {
			this.isLoading = true;
			const form = {
				...this.costForm,
			};
			this.Loader(true);
			axios
				.post(route("costs.store"), form)
				.then((response) => {
					if (response.status === 200) {
						toastr.success("Cost added successfully");
						this.successData = response.data;
						this.$emit(
							"successData",
							this.$modal.show("costAdded")
						);
						this.Loader();
					}
				})
				.catch((error) => {
					// console.log(error.response);
					if (error.response.status === 400) {
						toastr.error(error.response.data.message);
						this.playSound();
						this.isLoading = false;
						this.Loader();
					} else {
						this.allErrors.record(error.response.data.errors);
						this.playSound();
						this.isLoading = false;
						this.Loader();
					}
				});
		},
		getEmployee: _.debounce(function () {
			axios
				.post(route("cost-employee-search"), {
					employeePhone: this.employeePhone,
				})
				.then((response) => {
					if (response.data.result !== null) {
						this.costForm.selected_employee =
							response.data.result.id;
						this.costForm.details.amount_receiver_name =
							response.data.result.name;
						toastr.success(response.data.message);
					} else {
						toastr.success(response.data.message);
						// this.formReset(this.employeePhone);
						this.costForm.details.amount_receiver_phone =
							this.employeePhone;
					}
				})
				.catch((error) => {
					this.formReset(this.employeePhone);
					alert(error);
				});
		}, 0),
	},
};
</script>

