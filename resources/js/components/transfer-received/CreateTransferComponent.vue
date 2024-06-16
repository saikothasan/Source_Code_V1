<template>
	<div class="content">
		<form @keydown="allErrors.clear($event.target.name)" @submit.prevent="purchaseStore()" @keydown.enter.prevent.self>
			<div class="custom-box ">
				<div class="box-body">
					<h4 class="text-center text-bold orange-color" style="padding-bottom: 20px;">Transfer Product</h4>
					<div class="row div-center">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
								<div class="form-group">
									<input type="date" class="form-control text-center" v-model="transfer.date" placeholder="Enter text" disabled>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
								<div class="form-group">
									<input type="text" class="form-control text-center" v-model.trim="transfer.invoice_code" placeholder="Enter text" disabled>
									<span class="text-danger " v-if="allErrors.has('invoice_code')" v-text="allErrors.get('invoice_code')">
									</span>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
								<div class="form-group">
									<input disabled type="text" :value="user.name" class="form-control text-center">
								</div>
							</div>
						</div>
					</div>
					<!-- <div class="row div-center">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="box box-warning text-center">
									<div class="box-header with-border">
										<h3 class="box-title ">Regular products and Offer Products cant be transfer in same invoice </h3>
										<div class="box-tools pull-right">
											<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div> -->

					<div class="row div-center">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
								<div class="form-group">
									<label class="radio-inline text-black" for="regular">
										<input id="regular" v-model="type" type="radio" value="regular">
										Regular
									</label>
									<!-- <label class="radio-inline text-black" for="offer">
										<input id="offer" v-model="type" type="radio" value="offer">
										Offer
									</label> -->
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
							</div>
						</div>
					</div>

					<div v-if="type === 'offer'" class="row div-center" style="margin-bottom: 20px">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
								<model-select v-model="offer_id" :options="offers" name="offer_id" placeholder="Select Offer" @input="allErrors.clear('offer_id')"></model-select>
								<span v-if="allErrors.has('offer_id')" class="text-danger " v-text="allErrors.get('offer_id')">
								</span>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
							</div>
						</div>
					</div>

					<div class="row div-center" style="margin-top: 20px">
						<div v-if="type=== 'regular' || type==='offer' && offer_id !== '' " class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
								<div class="form-group">
									<input type="text" name="product_sku" v-model="product_sku" class="form-control text-center" autocomplete="off" placeholder="SKU or Barcode">
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

							</div>
						</div>
						<div v-if="transferProducts.length > 0" class="text-center" style="margin-top: 17px;">
							Total Amount : BDT {{ totalCalculation.total_transfer }} /- &nbsp;&nbsp; Total Quantity :
							{{ totalCalculation.totalQuantity }}
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 11px;">
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

							</div>
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 text-center">
								<span class="text-danger " v-if="allErrors.has('product_sku')" v-text="allErrors.get('product_sku')">
								</span>
								<div v-if="spinner" style="text-align: center; font-size: 20px">
									<div class="overlay">
										<i class="fa fa-refresh fa-spin"></i>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"></div>
						</div>
					</div>

					<div style="overflow-x:auto;">
						<table class="table table-bordered" v-if="transferProducts.length > 0">
							<tbody>
								<tr>
									<th>Barcode</th>
									<th>Product</th>
									<th>SKU</th>
									<th>In Stock</th>
									<th class="text-center" style="width: 15%;">Quantity</th>
									<th class="text-center">Total Price</th>
									<th class="text-center">Action</th>
								</tr>
								<tr v-for="(product,index) in transferProducts">
									<td>{{ product.product_barcode }}</td>
									<td>{{ product.product_name }}</td>
									<td>{{ product.variation_sku }}</td>
									<td class="text-center">
										<div style="display: grid;">
											{{ product.available_stock }}
											<span class="text-danger" v-if="allErrors.has(`transfer_products.${index}.available_stock`)" v-text="allErrors.get(`transfer_products.${index}.available_stock`)">
											</span>
											<span class="text-danger" v-else-if="product.available_stock<product.quantity">
												Product Stock Out
											</span>
										</div>
									</td>
									<td class="text-center">
										<div class="input-group ">
											<input @input="quantityInput(index,product)" type="number" min="1" step="1" v-model.number="product.quantity" class="form-control text-center">
											<span class="text-danger" v-if="allErrors.has(`transfer_products.${index}.quantity`)" v-text="allErrors.get(`transfer_products.${index}.quantity`)">
											</span>
										</div>
									</td>
									<td class="text-center">{{ product.total_price }}</td>
									<td class="text-center" @click="transferProducts.splice(index,1)">
										<i class="fa fa-trash red-color pointer"></i>
									</td>
								</tr>

							</tbody>
						</table>
					</div>
					<div class="text-center">
						<h4 class="text-danger text-bold" v-if="allErrors.has('transfer_products')" v-text="allErrors.get('transfer_products')">
						</h4>
					</div>

				</div>
				<div class="row div-center " style="padding: 25px;">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						</div>
						<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
							<div class="form-group">
								<label style="margin-top: 7px; padding-left: 0;" class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label">Send </label>
								<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
									<model-select :options="sendBranch" v-model="transfer.receive_branch" @input="allErrors.clear('receive_branch')" name="receive_branch" placeholder="Select Branch"></model-select>
									<span class="text-danger " v-if="allErrors.has('receive_branch')" v-text="allErrors.get('receive_branch')">
									</span>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						</div>
					</div>
				</div>

			</div>
			<div style="margin-top: 30px;text-align: center;">
				<div>
					<button v-if="isLoading" type="button" style="color: white" class="btn bg-orange-color text-white">
						Sending...
					</button>
					<button v-else type="submit" style="color: white" class="btn bg-orange-color text-white">Send
					</button>
				</div>
			</div>
		</form>
	</div>
</template>
<script>
import Errors from "../../helper/errors";
import collect from "collect.js";

export default {
	props: ["user", "invoice", "sendBranch", "date", "offers"],
	data() {
		return {
			transfer: {
				date: this.date,
				invoice_code: this.invoice,
				receive_branch: "",
			},
			transferProducts: [],
			product_sku: "",
			allErrors: new Errors(),
			spinner: false,
			isLoading: false,
			type: "regular",
			offer_id: "",
		};
	},
	watch: {
		product_sku() {
			if (
				(this.product_sku.length < 1 && this.type === "regular") ||
				(this.product_sku.length < 1 &&
					this.type === "offer" &&
					this.offer_id.length < 1)
			) {
				return true;
			}
			this.spinner = true;
			this.getSkuBarcodeProduct();
		},
	},
	methods: {
		purchaseStore() {
			const _this = this;
			this.isLoading = true;
			this.Loader(true);
			const form = {
				...this.transfer,
				transfer_products: this.transferProducts,
				...this.totalCalculation,
			};
			axios
				.post(route("transfer-product.store"), form)
				.then((response) => {
					if (response.data.status === 200) {
						const result = response.data.result;
						for (const key in result) {
							let find = this.transferProducts.find(
								(item) =>
									item.product_barcode ===
									result[key].product_barcode
							);
							if (find) {
								find.available_stock =
									result[key].available_stock;
							}
						}
						toastr.error("Please check stock quantity");
						this.playSound();
						this.Loader();
					}
					if (response.data.status === 201) {
						toastr.success("Product transfer add successfully");
						const url = route(
							"transfer-product.show",
							response.data.result.id
						);
						this.newTab(url);
						this.reload(0);
						this.Loader();
					}
				})
				.catch((error) => {
					if (error && error.response.status === 422) {
						this.allErrors.record(error.response.data.errors);
						this.playSound();
					}
					this.isLoading = false;
					this.Loader();
				});
		},
		getSkuBarcodeProduct: _.debounce(function () {
			const _this = this;
			axios
				.get(route("transfer.product.search", this.product_sku), {
					params: {
						offer_id: this.offer_id,
					},
				})
				.then((response) => {
					if (response.data.result.length > 0) {
						let oldProduct = collect(this.transferProducts)
							.pluck("product_barcode")
							.toArray();
						let newProduct = collect(response.data.result)
							.whereNotIn("product_barcode", oldProduct)
							.toArray();
						for (const key in this.transferProducts) {
							if (
								this.transferProducts[key].product_barcode ===
								this.product_sku
							) {
								this.transferProducts[key].quantity += 1;
								this.quantityInput(
									key,
									this.transferProducts[key]
								);
							}
						}
						if (newProduct) {
							for (const newProductKey in newProduct) {
								this.transferProducts.push(
									newProduct[newProductKey]
								);
							}
							toastr.success("Product add successfully");
						}
						this.allErrors.clear("transfer_products");
					}
					this.product_sku = "";
					this.offer_id = "";
					this.type = "regular";
					this.spinner = false;
				})
				.catch((error) => {
					this.allErrors.record(error.response.data.errors);
					this.playSound();
					this.spinner = false;
				});
		}, 500),
		quantityInput(index, current_product) {
			if (current_product.available_stock < current_product.quantity) {
				this.transferProducts[index].quantity =
					current_product.available_stock;
				toastr.warning(
					"Available Stock " + current_product.available_stock
				);
				this.setQuantityTotal(index, current_product);
				return true;
			}
			if (current_product.quantity < 1) {
				this.transferProducts[index].quantity = 1;
				this.setQuantityTotal(index, current_product);
				return;
			}
			this.setQuantityTotal(index, current_product);
		},
		setQuantityTotal(index, current_product) {
			this.transferProducts[index].total_price =
				parseInt(current_product.quantity) *
				current_product.product_buy_price;
		},
	},
	computed: {
		totalCalculation() {
			const total_transfer = this.transferProducts.reduce(
				(total, current) => total + current.total_price,
				0
			);
			const totalQuantity = this.transferProducts.reduce(
				(total, current) => total + current.quantity,
				0
			);

			return {
				total_transfer: total_transfer,
				totalQuantity: totalQuantity,
			};
		},
	},
};
</script>
