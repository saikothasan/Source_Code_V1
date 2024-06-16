<template>
	<div class="content">
		<form @submit.prevent="purchaseReturnStore()" @keydown.enter.prevent.self>
			<div class="table-size">
				<h4 class="font-weight-bold" style="border-bottom: 1px solid #49505c;width: 18%;font-weight: 700;">
					Product Purchase</h4>
				<span></span>
				<div style="display: grid;">
					<span>{{ purchase.date_format }} (Invoice No - {{ purchase.invoice }})</span>
					<span>{{ purchase.user.name }}</span>
					<span>{{ purchase.send_by }}</span>
					<span>Receive by {{ purchase.receive.name }}</span>
				</div>
				<div class="alert alert-danger" v-if="Object.keys(allErrors.errors).length > 0">
					<ul>
						<li v-for="(error, index) in allErrors.errors" :key="index">
							<span v-if="error[0]" v-text="error[0]"></span>
						</li>
					</ul>
				</div>
				<table class="table table-bordered" style="margin-top: 18px;">
					<tbody>
						<tr>
							<th>Product Name</th>
							<th>SKU</th>
							<th>Barcode</th>
							<th>Quantity</th>
							<th>Amount</th>
							<th>Available</th>
							<th class="text-center">Return</th>
						</tr>
						<tr v-for="(purchase_product,index) in purchaseReturn.purchase_products">
							<td v-html="purchase_product.product_name"></td>
							<td>{{ purchase_product.product_sku }}</td>
							<td>{{ purchase_product.product_barcode }}</td>
							<td>{{ purchase_product.quantity }} pcs</td>
							<td>{{ purchase_product.total }}/-</td>
							<td>{{ purchase_product.available_stock }} pcs</td>
							<td style="width: 15%;">
								<input type="number" @input="quantityInput(index,purchase_product)" min="0" :max="purchase_product.available_stock" v-model.number="purchase_product.return_quantity" class="form-control">
								<span class="text-danger" v-if="allErrors.has(`purchase_products.${index}.return_quantity`)" v-text="allErrors.get(`purchase_products.${index}.return_quantity`)">
								</span>
							</td>

						</tr>
					</tbody>
				</table>
				<div>
					<h4 class="text-right"> Returned Total Product : {{ totalCalculation.total_return_quantity }} Pieces
						{{ totalCalculation.total_return_amount }}/-</h4>
				</div>

			</div>
			<div style="margin-top: 30px;text-align: center;">
				<div>

					<button v-if="isLoading" type="button" style="color: white" class="btn bg-orange-color text-white">
						Submiting....
					</button>
					<button v-else type="submit" style="color: white" class="btn bg-orange-color text-white">Submit
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
	props: ["purchase"],
	data() {
		return {
			allErrors: new Errors(),
			spinner: false,
			isLoading: false,
			purchaseReturn: {
				...this.purchase,
			},
		};
	},
	watch: {},
	methods: {
		purchaseReturnStore() {
			this.isLoading = true;
			this.Loader(true);
			const purchase_products = collect(
				this.purchaseReturn.purchase_products
			)
				.filter(function (value) {
					return value.return_quantity > 0;
				})
				.toArray();
			let form = {
				...this.purchaseReturn,
				...this.totalCalculation,
			};
			form.purchase_products = purchase_products;

			axios
				.post(route("purchase-return.store"), form)
				.then((response) => {
					if (response.data.status === 201) {
						toastr.success("Purchase return successfully");
						const url = route(
							"purchase-return.show",
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
		quantityInput(index, current_product) {
			this.allErrors.clear(`purchase_products.${index}.return_quantity`);
			if (
				current_product.available_stock <
				current_product.return_quantity
			) {
				this.purchaseReturn.purchase_products[
					index
				].return_quantity = 0;
				toastr.warning(
					"Available Stock " + current_product.available_stock
				);
				return false;
			}
			if (current_product.return_quantity < 1) {
				this.purchaseReturn.purchase_products[
					index
				].return_quantity = 0;
				return false;
			}
		},
	},
	computed: {
		totalCalculation() {
			const total_return_quantity =
				this.purchaseReturn.purchase_products.reduce(
					(total, current) => total + current.return_quantity,
					0
				);
			const total_return_amount =
				this.purchaseReturn.purchase_products.reduce(
					(total, current) =>
						total + current.rate * current.return_quantity,
					0
				);
			return {
				total_return_quantity: total_return_quantity,
				total_return_amount: total_return_amount,
			};
		},
	},
};
</script>
