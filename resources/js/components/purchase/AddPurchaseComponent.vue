<template>
	<div class="content">
		<form @submit.prevent="purchaseStore()" @keydown="allErrors.clear($event.target.name)" @keydown.enter.prevent.self>
			<div class="custom-box ">
				<div class="box-body">
					<h4 class="text-center text-bold orange-color" style="padding-bottom: 20px;">Product Purchase</h4>
					<div class="row div-center ">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
								<div class="form-group">
									<input type="date" class="form-control text-center" v-model="purchase.date" placeholder="Enter text" disabled>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
								<div class="form-group">
									<input type="text" class="form-control text-center" v-model.trim="purchase.invoice" placeholder="Enter text" disabled>
									<span class="text-danger " v-if="allErrors.has('invoice')" v-text="allErrors.get('invoice')">
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
					<div class="row div-center ">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
						<div v-if="purchaseProducts.length > 0" class="col-lg-12 col-md-4 col-sm-12 col-xs-12 text-center" style="margin-top: 17px;">
							Margin : {{ totalCalculation.margin }} % &nbsp;&nbsp; &nbsp;&nbsp;Profit : BDT
							{{ totalCalculation.profit }}/- &nbsp;&nbsp;&nbsp;&nbsp;Total Quantity :
							{{ totalCalculation.totalQuantity }} &nbsp;&nbsp;&nbsp;&nbsp;Total
							Purchase Amount : BDT {{ totalCalculation.totalPurchase }} /-
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 11px;">
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
								<div style="font-size: 18px;" v-if="purchase.supplier_id">
									<div>Supplier :</div>
									<div>{{ purchase.supplier.name }}</div>
								</div>
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
					<div style="overflow-x: auto">
						<table class="table table-bordered" v-if="purchaseProducts.length > 0">
							<tbody>
								<tr>
									<th>Barcode</th>
									<th>Product</th>
									<th>SKU</th>
									<th>Buy Price</th>
									<th class="text-center" style="width: 15%;">Quantity</th>
									<th class="text-center">Total Price</th>
									<th class="text-center">Action</th>
								</tr>
								<tr v-for="(product,index) in purchaseProducts">
									<td>{{ product.product_barcode }}</td>
									<td>{{ product.product_name }}</td>
									<td>{{ product.variation_sku }}</td>
									<td class="text-center">{{ product.product_buy_price }}</td>
									<td class="text-center">
										<div class="input-group ">
											<input @input="quantityInput(index,product)" type="number" min="1" step="1" v-model.number="product.quantity" class="form-control text-center">
										</div>
									</td>

									<td class="text-center">{{ product.total_price }}</td>
									<td class="text-center" @click="purchaseProducts.splice(index,1)">
										<i class="fa fa-trash red-color pointer"></i>
									</td>
								</tr>

							</tbody>
						</table>
					</div>
					<div class="text-center">
						<h4 class="text-danger text-bold" v-if="allErrors.has('purchase_products')" v-text="allErrors.get('purchase_products')">
						</h4>
					</div>

				</div>
				<div class="row div-center " style="padding: 25px;">
					<div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
						<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						</div>
						<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
							<div class="form-group">
								<label for="exampleInputPassword1">Send</label>
								<input autocomplete="true" type="text" name="send_by" class="form-control" v-model="purchase.send_by" placeholder="Enter Send Name">
								<span class="text-danger" v-if="allErrors.has('send_by')" v-text="allErrors.get('send_by')">
								</span>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
							<div class="form-group">
								<label for="exampleInputPassword1">Receive</label>
								<model-select :options="receiveUser" v-model="purchase.receive_by" @input="allErrors.clear('receive_by')" name="receive_by" placeholder="Select Receive"></model-select>
								<span class="text-danger" v-if="allErrors.has('receive_by')" v-text="allErrors.get('receive_by')">
								</span>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						</div>
					</div>
				</div>
			</div>
			<div style="margin-top: 30px;text-align: center;">
				<div>
					<!--                    <button type="submit" style="margin-right: 20px;border-color: #ff9600;background: white;"-->
					<!--                            class="btn btn-default text-black">Barcode Print-->
					<!--                    </button>-->
					<button v-if="isLoading" type="button" style="color: white" class="btn bg-orange-color text-white">
						Purchasing....
					</button>
					<button v-else type="submit" style="color: white" class="btn bg-orange-color text-white">Purchase
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
	props: ["user", "invoice", "receiveUser", "date"],
	data() {
		return {
			purchase: {
				date: this.date,
				invoice: this.invoice,
				send_by: "",
				receive_by: "",
				supplier_id: "",
				supplier: {},
			},
			purchaseProducts: [],
			product_sku: "",
			allErrors: new Errors(),
			spinner: false,
			isLoading: false,
		};
	},
	watch: {
		product_sku() {
			if (this.product_sku.length < 1) {
				return true;
			}
			this.spinner = true;
			this.getSkuProduct();
		},
	},
	methods: {
		purchaseStore() {
			const _this = this;
			this.isLoading = true;
			this.Loader(true);
			const form = {
				...this.purchase,
				purchase_products: this.purchaseProducts,
				...this.totalCalculation,
			};
			axios
				.post(route("purchases.store"), form)
				.then((response) => {
					if (response.data.status === 201) {
						toastr.success("Purchase add successfully");
						const url = route(
							"purchases.show",
							response.data.result.id
						);
						this.newTab(url);
						this.reload(0);
						this.Loader();
					}
				})
				.catch((error) => {
					this.allErrors.record(error.response.data.errors);
					this.playSound();
					this.isLoading = false;
					this.Loader();
				});
		},
		getSkuProduct: _.debounce(function () {
			const _this = this;
			axios
				.post(route("sku-wise-product"), {
					product_sku: this.product_sku,
				})
				.then((response) => {
					this.allErrors.clear("purchase_products");
					if (response.data.result) {
						let supplier = collect(response.data.result)
							.pluck("supplier")
							.first();
						if (this.purchase.supplier_id.length < 1) {
							if (supplier) {
								this.purchase.supplier = supplier;
								this.purchase.supplier_id = supplier.id;
							}
						}
						if (this.purchase.supplier_id !== supplier.id) {
							toastr.warning(
								"You have already add other supplier products"
							);
							this.spinner = false;
							return;
						}
						let oldProduct = collect(this.purchaseProducts)
							.pluck("product_barcode")
							.toArray();
						let newProduct = collect(response.data.result)
							.whereNotIn("product_barcode", oldProduct)
							.toArray();
						for (const key in this.purchaseProducts) {
							if (
								this.purchaseProducts[key].product_barcode ===
								this.product_sku
							) {
								this.purchaseProducts[key].quantity += 1;
								this.quantityInput(
									key,
									this.purchaseProducts[key]
								);
							}
						}
						if (newProduct) {
							for (const newProductKey in newProduct) {
								this.purchaseProducts.push(
									newProduct[newProductKey]
								);
							}
							toastr.success("Product add successfully");
						}
					}
					this.product_sku = "";
					this.spinner = false;
				})
				.catch((error) => {
					this.allErrors.record(error.response.data.errors);
					this.playSound();
					this.spinner = false;
				});
		}, 500),
		quantityInput(index, current_product) {
			if (current_product.quantity < 1) {
				this.purchaseProducts[index].quantity = 1;
				this.purchaseProducts[index].total_price =
					parseInt(this.purchaseProducts[index].quantity) *
					current_product.product_buy_price;
				return;
			}
			this.purchaseProducts[index].total_price =
				parseInt(current_product.quantity) *
				current_product.product_buy_price;
		},
	},
	computed: {
		totalCalculation() {
			const totalPurchase = this.purchaseProducts.reduce(
				(total, current) => total + current.total_price,
				0
			);
			const totalQuantity = this.purchaseProducts.reduce(
				(total, current) => total + current.quantity,
				0
			);
			const totalSellPrice = this.purchaseProducts.reduce(
				(total, current) =>
					total + current.product_sell_price * current.quantity,
				0
			);
			const profit =
				parseFloat(totalSellPrice) - parseFloat(totalPurchase);
			const margin =
				(parseFloat(profit) / parseFloat(totalSellPrice)) * 100;
			return {
				totalPurchase: totalPurchase,
				profit: profit,
				margin: isNaN(margin) ? 0 : margin.toFixed(1),
				totalQuantity: totalQuantity,
			};
		},
	},
};
</script>
