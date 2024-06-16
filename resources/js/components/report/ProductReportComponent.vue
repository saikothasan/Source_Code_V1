<template>
	<div>
        <h3 class="header text-center">Product Report</h3>
		<div class="box-header">
    							<form method="post" @submit.prevent="generateReport()" @keydown="allErrors.clear($event.target.name)">
    								<div class="row ">
    									<div class="col-md-3"></div>
    									<div class=" col-md-6" disabled="true">
    										<label for="">Search Product</label>
    										<div v-if="spinner" style="text-align: center; font-size: 20px">
    											<div class="overlay" style="margin-top: 38px; position: absolute; z-index: 99999; margin-left: 44%;">
    												<i class="fa fa-refresh fa-spin text-green"></i>
    											</div>
    										</div>
    										<model-select :options="products" @input="productInfo()" v-model="productReportForm.items" @searchchange="searchKeyPress" placeholder=""></model-select>
    										<span class="text-danger" v-if="allErrors.has('product')" v-text="allErrors.get('product')">
    										</span>
    									</div>
    									<div class="col-md-3"></div>

    								</div>

    								<div class="text-center" v-if="Object.keys(productReportForm.product).length > 0">
    									<h4 class="text-bold">{{ productReportForm.product.name }}</h4>
    									<span class="text-bold">Barcode: {{ productReportForm.product.product_barcode }}</span><br>
    									<span>Supplier : {{ productReportForm.product.supplier_name }} &nbsp;&nbsp; Adding Date : {{
    									    productReportForm.product.date
    									}} ({{ productReportForm.product.added_by }})</span>
    									<br />
    									<br />
    									<br />
    								</div>

    								<div class="row main-box">
    									<div class="col-md-2"></div>
    									<div class="col-md-8 text-center">
    										<label><input type="checkbox" @input="allErrors.clear('selectedBranch')" id="allBranch" v-model="allSelectedBranch" @change="selectAllBranch()" @click="allErrors.clear('selectedBranch')" /></label>
    										<label for="allBranch">Select Branches</label>
    										<hr>
    										<div style="display:flex;justify-content: space-between;">
    											<div class="branch" v-for="(branch, index) in resource.branches" :key="branch.value">
    												<input type="checkbox" :value="branch" :id="'branch_id' + branch.value" :disabled="!productReportForm.available_branch.includes(branch.value)" v-model="productReportForm.selectedBranch" @input="allErrors.clear('selectedBranch')">
    												<label :for="'branch_id' + branch.value">{{ branch.text }}</label>
    											</div>
    										</div>
    										<span class="text-danger" v-if="allErrors.has('selectedBranch')" v-text="allErrors.get('selectedBranch')">
    										</span>
    									</div>
    									<div class="col-md-2"></div>
    								</div>
    								<br />
    								<div class="row main-box">
    									<div class="col-md-4"></div>
    									<div class="col-md-4 text-center">
    										<label> History</label>
    										<hr>
    										<div style="display:flex;justify-content: space-between;">
    											<div class="branch" v-for="(history, index) in resource.history" :key="history.value">
    												<input type="checkbox" :value="history" :id="'history' + history.value" v-model="productReportForm.history" @input="allErrors.clear('history')">
    												<label :for="'history' + history.value">{{ history.text }}</label>
    											</div>
    										</div>
    										<span class="text-danger" v-if="allErrors.has('history')" v-text="allErrors.get('history')">
    										</span>
    									</div>
    									<div class="col-md-4"></div>
    								</div>

    								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row text-center spacer filter">

    									<div class=" col-lg-6 col-md-6 col-sm-12 col-xs-12 groupedInput">
    										<div class="row form-inline">
    											<div class="col-md-1 text-center">
    												<label class="groupedLabel">From</label>
    											</div>
    											<div class="col-md-4">
    												<div class="form-group">
    													<input @input="allErrors.clear('from_date')" v-model="productReportForm.from_date" name="from_date" type="date" class="form-control corner">
    													<span class="text-danger text-nowrap" v-if="allErrors.has('from_date')" v-text="allErrors.get('from_date')">
    													</span>
    												</div>
    											</div>
    											<div class="col-md-1 text-center" style="margin-left: 25px;">
    												<label class="groupedLabel">To</label>
    											</div>
    											<div class="col-md-4">
    												<div class="form-group">
    													<input @input="allErrors.clear('to_date')" v-model="productReportForm.to_date" name="to_date" type="date" class="form-control corner">
    													<span class="text-danger text-nowrap" v-if="allErrors.has('to_date')" v-text="allErrors.get('to_date')">
    													</span>
    												</div>
    											</div>
    										</div>
    									</div>
    									<br>
    									<br>

    								</div>

    								<div class="row">
    									<div class="col-md-12 search-filter">
    										<div class="col-md-3">
    											<div class="form-group">
    												<model-select :options="resource.pieces" v-model="productReportForm.selectedPiece" @input="allErrors.clear('selectedPiece')" placeholder="Select Pieces"></model-select>
    												<span class="text-danger" v-if="allErrors.has('selectedPiece')" v-text="allErrors.get('selectedPiece')">
    												</span>
    											</div>
    										</div>

    										<div class="col-md-3">
    											<div class="form-group">
    												<model-select :options="resource.reportMode" @input="allErrors.clear('selectedReportMode')" v-model="productReportForm.selectedReportMode" placeholder="Select Report Mode"></model-select>
    												<span class="text-danger" v-if="allErrors.has('selectedReportMode')" v-text="allErrors.get('selectedReportMode')">
    												</span>
    											</div>
    										</div>
    										<div class="col-md-3">
    											<div class="form-group">
    												<model-select :options="resource.fileMode" @input="allErrors.clear('report_file_mode')" v-model="productReportForm.report_file_mode" placeholder="Select File Mode"></model-select>
    												<span class="text-danger" v-if="allErrors.has('report_file_mode')" v-text="allErrors.get('report_file_mode')">
    												</span>
    											</div>
    										</div>

    									</div>
    								</div>
    								<div class="footer-comment">
    									<div class=" row ">
    										<div class="col-md-3"></div>
    										<div class="col-md-6">
    											<center>Briefly explain why you need the report!</center>
    											<textarea class="form-control" name="description" style="border-radius: 8px" v-model="productReportForm.description">
                                        </textarea>
    											<span class="text-danger" v-if="allErrors.has('description')" v-text="allErrors.get('description')">
    											</span>
    										</div>
    										<div class="col-md-3"></div>
    									</div>
    								</div>
    								<br>
    								<center>
    									<button type="submit" class="btn bg-black" style="padding:10px;border-radius: 7px;">
    										GENERATE
    									</button>
    								</center>
    							</form>
    							<div v-html="html"></div>
    						</div>
		<!--        <div v-if="successData" v-html="successData"></div>-->
	</div>
</template>

<script>
import Errors from "../../helper/errors";
import collect from "collect.js";
import VoerroTagsInput from "@voerro/vue-tagsinput";

export default {
	name: "ProductReportComponent",
	props: ["resource"],
	components: {
		"tags-input": VoerroTagsInput,
	},
	data() {
		return {
			allSelectedBranch: false,
			allErrors: new Errors(),
			productReportForm: {
				selectedBranch: [],
				selectedPiece: { text: "Select Pieces", value: "", total: 0 },
				from_date: "",
				to_date: "",
				selectedReportMode: {},
				report_file_mode: {
					text: "Print",
					value: "print",
				},
				items: {},
				description: "",
				searchType: "stock",
				product: {},
				available_branch: [],
				history: [],
			},
			sellerList: [],
			successData: {},
			html: "",
			products: [],
			spinner: false,
		};
	},
	watch: {},
	methods: {
		selectAllBranch() {
			if (this.allSelectedBranch) {
				this.productReportForm.selectedBranch =
					this.resource.branches.filter((item) =>
						this.productReportForm.available_branch.includes(
							item.value
						)
					);
			} else {
				this.productReportForm.selectedBranch = [];
			}
		},
		async generateReport() {
			this.html = "";
			const form = {
				...this.productReportForm,
			};
			this.Loader(true);
			await axios
				.post(route("generate.product.report"), form)
				.then((response) => {
					//this.html = response.data;
					if (response.data.status === 200) {
						toastr.success(response.data.message);
						let url = "";
						if (
							this.productReportForm.report_file_mode.value ===
							"print"
						) {
							url = route(
								"report-history.show",
								response.data.result.id
							);
						} else {
							url = route(
								"report.download",
								response.data.result.id
							);
						}

						this.newTab(url);
						// this.reload(0);
						this.Loader();
					}
					this.Loader();
				})
				.catch((error) => {
					if (error && error.response.status === 422) {
						this.allErrors.record(error.response.data.errors);
					}
					this.playSound();
					this.Loader(false);
				});
		},
		searchKeyPress(value) {
			if (value === "") {
				this.spinner = false;
				return;
			}
			this.spinner = true;
			this.searchProduct(value);
			this.allErrors.clear("product");
		},
		searchProduct: _.debounce(function (value) {
			let data = {
				search: value,
				searchType: this.productReportForm.searchType,
			};
			axios
				.post(route("report.product.search"), data)
				.then((response) => {
					if (response.data.status === 200) {
						this.products = response.data.result;
						if (this.products.length === 1) {
							if (value === response.data.result[0].value) {
								this.productReportForm.items =
									response.data.result[0];
								this.productInfo();
							}
						}
					} else {
						toastr.warning("Something went wrong");
					}
					this.spinner = false;
				})
				.catch((error) => {
					//this.spinner = false;
				});
		}, 500),
		async productInfo() {
			const form = {
				...this.productReportForm.items,
			};
			this.Loader(true);
			await axios
				.post(route("report.product.info"), form)
				.then((response) => {
					this.productReportForm.product =
						response.data.result.product;
					this.productReportForm.available_branch =
						response.data.result.available_branch;
					this.selectAllBranch();
					this.Loader(false);
				})
				.catch((error) => {
					this.Loader(false);
				});
		},
	},
};
</script>

<style scoped>
@media only screen and (max-width: 991px) {
  .search-filter {
    margin-top: 200px;
  }
}
</style>
