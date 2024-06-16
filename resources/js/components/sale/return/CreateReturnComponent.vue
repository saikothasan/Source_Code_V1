<template>
	<section class="content">
		<div class="dashboard">
			<div>
				<form @keydown="allErrors.clear($event.target.name)" @keydown.enter.prevent.self @submit.prevent="saleReturnStore()" role="form">
					<div class="sale-row">
						<div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
							<div class="box box-primary none-border">
								<div class="box-header with-border">
									<h3 class="box-title">Return</h3>
								</div>

								<div class="box-body">
									<div class="row">
										<div class="form-group col-md-6">
											<label for="Name">Invoice</label>
											<div class="input-group">
												<input @keyup.enter="findInvoice" class="form-control corner" name="invoice_code" placeholder="Enter Invoice" style="text-align: left" type="text" v-model="invoice_code" />
												<span @click="findInvoice" class="input-group-addon pointer">
													<i class="fa fa-search"></i>
												</span>
											</div>
											<span class="text-danger" v-if="allErrors.has('invoice_code')" v-text="allErrors.get('invoice_code')"></span>
										</div>
										<div class="form-group col-md-6">
											<label for="phoneNumber">Phone</label>
											<div class="input-group">
												<input @keyup.enter="customerInvoice" class="form-control" name="customer" placeholder="Enter Phone Number" style="text-align: left" type="number" v-model="customer_phone" />
												<span @click="customerInvoice" class="input-group-addon pointer">
													<i class="fa fa-search"></i>
												</span>
											</div>
											<span class="text-danger" v-if="allErrors.has('customer')" v-text="allErrors.get('customer')"></span>
										</div>
									</div>

									<div class="table" v-if="customerSaleList.length > 0">
										<table class="table table-striped w-auto">
											<thead>
												<tr>
													<th>Invoice</th>
													<th>Date</th>
													<th>Name</th>
													<th class="text-right">Quantity</th>
													<th class="text-right">Amount</th>
													<th></th>
												</tr>
											</thead>
											<tbody>
												<tr :key="index" class="table-info" v-for="(sale, index) in customerSaleList">
													<td>{{ sale.invoice_code }}</td>
													<td>{{ sale.created_at | moment("MMMM Do Y, h:mm a") }}</td>
													<td>
														<span>{{ sale.customer.name }}</span>
													</td>
													<td class="text-center">
														<span>{{ sale.total_quantity }}</span>
													</td>
													<td class="text-right">{{ sale.final_total.toLocaleString() }}</td>
												</tr>
											</tbody>
										</table>
									</div>

									<div class="row" v-if="Object.keys(main_invoice).length > 0">
										<div class="form-group col-md-12">
											<div style="display: flex; justify-content: space-between">
												<label for="Product">Sale Details</label>
												<label for="Product" v-if="findSeller">Seller : {{findSeller.text}}</label>
												<label for="Product">Sale: {{ main_invoice.sale_date }}</label>
											</div>
											<div class="table-outline">
												<table class="table table-striped w-auto">
													<thead class="table-head">
														<tr>
															<th>S.N</th>
															<th>Product Name</th>
															<th class="text-right">Price</th>
															<th style="width: 15%">Quantity</th>
															<th class="text-right">Total</th>
															<th></th>
														</tr>
													</thead>
													<tbody>
														<tr :key="index" class="table-info" v-for="(product, index) in changeable_products">
															<td>{{ index + 1 }}.</td>
															<td>
																<div style="display: grid">
																	<span>{{ product.product_name }}</span>
																	<span>{{ product.product_barcode }}</span>
																</div>
															</td>
															<td class="text-right">{{ product.sale_rate }}</td>
															<td class="text-center">
																<span>{{ product.quantity }}</span>
															</td>
															<td class="text-right">{{ product.product_total }}</td>
															<td class="pointer" style="margin-bottom: 2px">
																<span @click="oldProductRemove(index, product)">
																	<i class="fa fa-times-circle text-red" style="font-size: 16px"></i>
																</span>
																<span @click="oldProductQuantityDecrease(index, product)">
																	<i class="fa fa-minus-circle text-green" style="font-size: 16px"></i>
																</span>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
											<div class="row" style="margin-top: 10px; width: 96%">
												<div class="col-md-10 text-right">Total Product</div>
												<div class="col-md-2 text-right">{{ mainInvoiceCalculation.productTotalQuantity.toLocaleString() }} pcs</div>
											</div>
											<div class="row" style="width: 96%">
												<div class="col-md-10 text-right">Total Product Price</div>
												<div class="col-md-2 text-right">{{ mainInvoiceCalculation.product_total.toLocaleString() }}</div>
											</div>
											<div v-if="main_invoice.delivery_id">
												<div class="row" style="width: 96%">
													<div class="col-md-10 text-right" style="display: flex; justify-content: end">Delivery Charge
													</div>
													<div class="col-md-2 text-right">
														{{ main_invoice.delivery_charge }}
													</div>
												</div>
												<div class="row" style="width: 96%" v-if="main_invoice.additional_delivery_charge > 0">
													<div class="col-md-10 text-right" style="display: flex; justify-content: end">Additional Delivery Charge
													</div>
													<div class="col-md-2 text-right">
														{{ main_invoice.additional_delivery_charge }}
													</div>
												</div>
											</div>
											<div class="row" style="width: 96%">
												<div class="col-md-10 text-right">Additional Charge</div>
												<div class="col-md-2 text-right">{{ main_invoice.additional_charge }}</div>
											</div>

											<div class="row" style="width: 96%">
												<div class="col-md-10 text-right" style="display: flex; justify-content: end">
													Discount (
													<span>{{ main_invoice.discount_percentage }}</span>%)
												</div>
												<div class="col-md-2 text-right">(-) {{ mainInvoiceCalculation.discount_amount }}</div>
											</div>
											<div class="row" style="width: 96%">
												<div class="col-md-10 text-right" style="display: flex; justify-content: end">
													Vat (
													<span>{{ main_invoice.vat_percentage }}</span>
													%)
												</div>
												<div class="col-md-2 text-right" style="white-space: pre">(+) {{ mainInvoiceCalculation.vat_amount }}</div>
											</div>
											<div class="row" style="width: 96%">
												<div class="col-md-10 text-right" style="display: flex; justify-content: end">
													Flat Discount
												</div>
												<div class="col-md-2 text-right" style="white-space: pre">(-) {{ mainInvoiceCalculation.flat_discount }}</div>
											</div>
											<div class="row" style="width: 96%">
												<div class="col-md-6"></div>
												<div class="col-md-6">
													<hr style="margin-top: 5px; margin-bottom: 5px; border: 0; border-top: 1px solid #000000" />
												</div>
											</div>
											<div class="row" style="width: 96%">
												<div class="col-md-10 text-right">Total Amount</div>
												<div class="col-md-2 text-right" style="white-space: pre">{{ mainInvoiceCalculation.total_amount.toLocaleString() }}</div>
											</div>
										</div>
									</div>

									<div class="row" v-if="returnProducts.length > 0">
										<div class="form-group col-md-12">
											<div style="display: flex; justify-content: space-between">
												<label for="Product">Return</label>
												<label for="Product">{{ resource.date }}</label>
											</div>
											<div class="table-outline">
												<table class="table table-striped w-auto">
													<thead class="table-head">
														<tr>
															<th>S.N</th>
															<th>Product Name</th>
															<th class="text-right">Price</th>
															<th class="text-center">Quantity</th>
															<th class="text-right">Total</th>
															<th></th>
														</tr>
													</thead>
													<tbody>
														<tr :key="index" class="table-info" v-for="(product, index) in returnProducts">
															<td>{{ index + 1 }}.</td>
															<td>
																<div style="display: grid">
																	<span>{{ product.product_name }}</span>
																</div>
															</td>
															<td class="text-right">
																<span>{{ product.sale_rate }}</span>
															</td>
															<td class="text-center">
																<span>{{ product.quantity }}</span>
															</td>
															<td class="text-right">{{ product.product_total }}</td>
															<td class="pointer" style="margin-bottom: 2px">
																<span @click="returnProductRemove(index, product)">
																	<i class="fa fa-times-circle text-red" style="font-size: 16px"></i>
																</span>
																<span @click="returnProductQuantityDecrease(index, product)">
																	<i class="fa fa-minus-circle text-green" style="font-size: 16px"></i>
																</span>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
											<div class="row" style="margin-top: 10px; width: 96%">
												<div class="col-md-10 text-right">Total Product</div>
												<div class="col-md-2 text-right">{{ returnCalculation.productTotalQuantity.toLocaleString() }} pcs</div>
											</div>
											<div class="row" style="width: 96%">
												<div class="col-md-10 text-right">Total Product Price</div>
												<div class="col-md-2 text-right">{{ returnCalculation.product_total.toLocaleString() }}</div>
											</div>

											<div class="row" style="width: 96%">
												<div class="col-md-10 text-right" style="display: flex; justify-content: end">
													Discount (
													<span>{{ main_invoice.discount_percentage }}</span>%)
												</div>
												<div class="col-md-2 text-right">(-) {{ returnCalculation.discount_amount }}</div>
											</div>
											<div class="row" style="width: 96%;">
												<div class="col-md-10 text-right" style="display: flex; justify-content: end">
													Vat (
													<span>{{ main_invoice.vat_percentage }}</span>
													%)
												</div>
												<div class="col-md-2 text-right" style="white-space: pre;">(+) {{ returnCalculation.vat_total }}</div>
											</div>
											<div class="row" style="width: 96%">
												<div class="col-md-10 text-right" style="display: flex; justify-content: end">
													Flat Discount
												</div>
												<div class="col-md-2 text-right">(-) {{ returnCalculation.flat_discount_total }}</div>
											</div>
											<div class="row" style="width: 96%">
												<div class="col-md-6"></div>
												<div class="col-md-6">
													<hr style="margin-top: 5px; margin-bottom: 5px; border: 0; border-top: 1px solid #000000" />
												</div>
											</div>
											<div class="row" style="width: 96%">
												<div class="col-md-10 text-right">Total Amount</div>
												<div class="col-md-2 text-right">{{ returnCalculation.return_total.toLocaleString() }}</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="alert alert-danger" v-if="Object.keys(allErrors.errors).length > 0">
								<ul>
									<li :key="index" v-for="(error, index) in allErrors.errors">
										<span v-if="error[0]" v-text="error[0]"></span>
									</li>
								</ul>
							</div>
							<div class="row" style="margin-top: 20px">
								<div class="col-md-12">
									<h2 style="text-align: center">Payment</h2>
								</div>
							</div>
							<hr style="margin-top: 20px; margin-bottom: 20px; border: 0; border-top: 2px solid #7c34db" />
							<div class="row">
								<div class="col-md-12">
									<div class="row">
										<div class="col-md-6 row">
											<div class="col-md-6">New Amount</div>
											<div class="col-md-6">{{ mainInvoiceCalculation.sale_net_total }}</div>
										</div>
										<div class="col-md-6 row">
											<div class="col-md-8">Return Amount</div>
											<div class="col-md-4 text-right">
												<input :value="returnCalculation.return_total" readonly style="width: 137px; pointer-events: none" type="text" />
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /.box -->
						<div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
							<div class="box box-primary none-border">
								<div class="box-header with-border">
									<h3 class="box-title">Showing Bill</h3>
								</div>
								<div class="ticket invoice invoice-font invoice-border">
									<div class="text-center">
										<!-- <img alt class="image" src="/images/sale_print.png" /> -->
									</div>
									<p class="centered">
										<br />
										<strong>
											{{ resource.user.branch.address }}
										</strong>
									</p>
									<div class="row" style="margin-bottom: 7px">
										<div class="col-md-8" style="font-size: 10px">Vat Reg No# 004452563-0202</div>
										<div class="col-md-4" style="font-size: 11px; text-align: end">Mushak-6.3</div>
									</div>

									<p class="bill">Invoice</p>
									<h4 class="text-center">
										<strong>{{ main_invoice.invoice_code }}</strong>
									</h4>
									<div class="row">
										<div class="col-md-6">{{ customer.phone }}</div>
										<div class="col-md-6 text-right">{{ main_invoice.sale_date }}</div>
									</div>
									<div class="row">
										<div class="col-md-12">{{ customer.name }}</div>
									</div>
									<div class="row">
										<div class="col-md-12 text-left">{{ customer.address }}</div>
									</div>

									<div class="row" v-if="main_invoice.delivery_id">
										<div class="col-md-12 text-left">
											Delivery :
											{{ main_invoice.delivery.name }}
										</div>
									</div>
									<br />

									<table style="width: 100%">
										<tbody>
											<tr :key="index" style="border-bottom: 1px dashed black; border-collapse: collapse" v-for="(product, index) in changeable_products">
												<td class="mrp">
													{{ index + 1 }}
													.
												</td>
												<td class="description">
													{{ product.product_name }}
													X
													{{ product.quantity }}
												</td>
												<td class="price">
													=
													{{ product.net_total }}
												</td>
											</tr>
										</tbody>
									</table>

									<table class="not-dashed" style="width: 100%; margin-top: 5px">
										<tbody>
											<tr>
												<td style="vertical-align: baseline">
													<div style="display: grid">
														<u v-html="paymentMethodName"></u>
													</div>
												</td>
												<td>
													<p>Amount</p>
													<p>Vat ({{ main_invoice.vat_percentage }}%)</p>
													<p v-if="mainInvoiceCalculation.delivery_charge > 0">Delivery Charge</p>
													<p v-if="main_invoice.additional_charge > 0">Additional Charge</p>
													<p>Total</p>
													<p>Discount</p>
													<p>Total Amount</p>
													<p>Paid</p>
													<p>Due</p>
													<p>Change Amount</p>
												</td>
												<td>
													<p class="left">{{ mainInvoiceCalculation.product_total.toLocaleString() }}</p>
													<p class="left">{{ mainInvoiceCalculation.vat_amount }}</p>
													<p class="left" v-if="mainInvoiceCalculation.delivery_charge > 0">{{ mainInvoiceCalculation.delivery_charge }}</p>
													<p class="left" v-if="main_invoice.additional_charge > 0">{{ main_invoice.additional_charge }}</p>
													<p class="left">{{ mainInvoiceCalculation.total_amount_with_vat }}</p>
													<p class="left">{{ mainInvoiceCalculation.total_discount }}</p>
													<p class="left">{{ mainInvoiceCalculation.sale_net_total }}</p>
													<p class="left">{{ mainInvoiceCalculation.pay_amount }}</p>
													<p class="left">{{ mainInvoiceCalculation.due_total }}</p>
													<p class="left">{{ mainInvoiceCalculation.change_amount }}</p>
												</td>
											</tr>
										</tbody>
									</table>
									<!-- Old Return Products-->
									<div v-if="Object.keys(main_invoice).length > 0 && main_invoice.sale_returns.length > 0">
										<SaleReturnProductsBill :sale_returns="main_invoice.sale_returns"></SaleReturnProductsBill>
									</div>
									<!-- Old Return Products-->
									<!-- Current Return Products-->
									<div v-if="returnProducts.length > 0">
										<p class="text-center" style="margin-top: 5%">
											Return :
											{{ resource.date }}
										</p>
										<table style="width: 100%">
											<tbody>
												<tr :key="index" style="border-bottom: 1px dashed black; border-collapse: collapse" v-for="(product, index) in returnProducts">
													<td class="mrp">
														{{ index + 1 }}
														.
													</td>
													<td class="description">
														{{ product.product_name }}
														X
														{{ product.quantity }}
													</td>
													<td class="price">
														=
														{{ product.product_total }}
													</td>
												</tr>
											</tbody>
										</table>

										<table class="not-dashed" style="width: 100%; margin-top: 5px">
											<tbody>
												<tr>
													<td style="vertical-align: baseline">
														<div style="display: grid"></div>
													</td>
													<td>
														<p>Total</p>
														<p>Vat ({{ main_invoice.vat_percentage }}%)</p>
														<p>Discount</p>
														<p>Return</p>
													</td>
													<td>
														<p class="left">{{ returnCalculation.product_total.toLocaleString() }}</p>
														<p class="left">(+) {{ returnCalculation.vat_total.toLocaleString() }}</p>
														<p class="left">(-) {{ returnCalculation.discount_total.toLocaleString() }}</p>
														<p class="left">{{ returnCalculation.return_total.toLocaleString() }}</p>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
									<!-- Current Return Products-->

									<div class="footer">
										<div class="row">
											<div class="col-md-12" v-if="main_invoice.invoice_code">
												<barcode :height="50" :width="1.5" v-bind:value="main_invoice.invoice_code">{{ main_invoice.invoice_code }}</barcode>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12" style="font-size: 8px; margin-top: -5px">
												<span class="centered">www.colourful.com.bd</span>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<span class="centered" style="font-size: 8px">RETURN INVOICE</span>
											</div>
										</div>
										<!--                                     <span class="centered"> www.facebook.com/ColourFulIslamicWear/</span>-->
										<!--                                    <span class="centered"> PHONE : 01785992233 </span> -->
									</div>
								</div>
							</div>
							<div class="row" style="padding: 30px">
								<div class="col-md-12" style="text-align: -webkit-center">
									<button class="hidden-print btn btn-success btn-sm btn-block" type="submit">Return Order</button>
								</div>
							</div>
							<!-- /.box -->
						</div>
					</div>
				</form>
			</div>
		</div>
	</section>
</template>
<script>
import Errors from "../../../helper/errors";
import collect from "collect.js";
import VueBarcode from "vue-barcode";
import SaleReturnProductsBill from "./SaleReturnProductsBill.vue";

export default {
	props: ["resource"],
	components: {
		barcode: VueBarcode,
		SaleReturnProductsBill,
	},
	data() {
		return {
			customer_phone: "",
			invoice_code: "",
			product_barcode: "",
			customer: {
				id: "",
				name: "",
				address: "",
				phone: "",
				zip_code: "",
				email: "",
				district_id: "",
				created_at: "",
			},
			allErrors: new Errors(),
			spinner: {
				customer_spinner: false,
				customer_find: false,
				customer_new: false,
				product: false,
			},
			isLoading: false,
			pay_amount: 0,
			changeable_products: [],
			main_products: [],
			main_invoice: {
				id: "",
				invoice_payment: {},
				invoice_products: [],
				sale_returns: [],
			},
			returnProducts: [],
			customerSaleList: [],
		};
	},
	watch: {},
	methods: {
		saleReturnStore() {
			const _this = this;
			this.isLoading = true;
			this.Loader(true);
			this.allErrors.allClear();
			const form = {
				main_products: this.changeable_products,
				main_invoice_calculation: this.mainInvoiceCalculation,
				main_invoice: this.main_invoice,
				customer: this.customer,
				return_products: this.returnProducts,
				return_detail: this.returnCalculation,
			};
			axios
				.post(route("sale-return.store"), form)
				.then((response) => {
					if (response.data.status === 201) {
						toastr.success("Sale return successfully");
						this.reload(0);
						this.Loader();
					}
				})
				.catch((error) => {
					if (error && error.response.status === 422) {
						this.allErrors.record(error.response.data.errors);
						this.playSound();
					}
					if (error && error.response.data.success === false) {
						toastr.error(error.response.data.message);
					}
					this.isLoading = false;
					this.Loader();
				});
		},
		findInvoice: _.debounce(function () {
			this.main_products = [];
			this.changeable_products = [];
			this.returnProducts = [];
			this.main_invoice = {};
			this.customer = {};
			if (this.invoice_code.length < 1) {
				return true;
			}
			const form = {
				invoice_code: this.invoice_code,
				invoice_type: "return",
			};
			axios
				.post(route("get-invoice"), form)
				.then((response) => {
					if (response.data.result) {
						this.main_products = _.cloneDeep(
							response.data.result.invoice_products
						);
						this.main_invoice = _.cloneDeep(response.data.result);
						this.customer = response.data.result.customer;
						this.changeable_products = _.cloneDeep(
							response.data.result.invoice_products
						);
						this.allErrors.clear("invoice_code");
					}
				})
				.catch((error) => {
					if (error && error.response.status === 422) {
						this.allErrors.record(error.response.data.errors);
						this.playSound();
					}
				});
		}, 0),
		customerInvoice: _.debounce(function () {
			this.customerSaleList = [];
			if (this.customer_phone.length < 1) {
				return true;
			}
			axios
				.get(route("customer-invoice", this.customer_phone))
				.then((response) => {
					this.customerSaleList = response.data.result;
				})
				.catch((error) => {
					if (error && error.response.status === 422) {
						this.allErrors.record(error.response.data.errors);
						this.playSound();
					}
				});
		}, 0),
		oldProductQuantityDecrease(index, product) {
			let find = collect(this.returnProducts)
				.where("sale_detail_id", product.sale_detail_id)
				.first();
			if (product.quantity <= 1) {
				this.oldProductRemove(index, product);
				return;
			}
			product.quantity = parseFloat(product.quantity - 1).toFixed(2);
			if (product.discount_total > 0) {
				product.discount_total = parseFloat(
					product.discount_total - product.single_discount
				).toFixed(2);
			}
			if (product.vat_total > 0) {
				product.vat_total = parseFloat(
					product.vat_total - product.single_vat
				).toFixed(2);
			}
			product.product_total = parseFloat(
				product.quantity * product.sale_rate
			).toFixed(2);
			product.net_total = parseFloat(
				product.final_sale_rate * product.quantity
			).toFixed(2);
			let return_product = {
				...product,
			};
			if (find) {
				let quantity = parseInt(find.quantity);
				find.quantity = parseFloat(quantity + 1).toFixed(2);
				find.discount_total = parseFloat(
					find.discount_total + product.single_discount
				).toFixed(2);
				find.vat_total = (
					parseFloat(find.vat_total) + parseFloat(product.single_vat)
				).toFixed(2);
				console.log(find.vat_total);
				find.product_total = parseFloat(
					find.quantity * find.sale_rate
				).toFixed(2);
				find.net_total = parseFloat(
					find.final_sale_rate * find.quantity
				).toFixed(2);
				if (product.quantity < 1) {
					this.oldProductRemove(index, product);
				}
			} else {
				return_product.quantity = parseFloat(1).toFixed(2);
				return_product.discount_total = parseFloat(
					return_product.single_discount
				).toFixed(2);
				return_product.vat_total = parseFloat(
					return_product.single_vat
				).toFixed(2);
				return_product.product_total = parseFloat(
					return_product.quantity * return_product.sale_rate
				).toFixed(2);
				return_product.net_total = parseFloat(
					return_product.final_sale_rate * 1
				).toFixed(2);
				this.returnProducts.push(return_product).toFixed(2);
			}
		},
		oldProductRemove(index, product) {
			const return_index = this.returnProducts.findIndex((item) => {
				return item.sale_detail_id === product.sale_detail_id;
			});
			if (return_index >= 0) {
				let main_product = _.cloneDeep(
					collect(this.main_products)
						.where("sale_detail_id", product.sale_detail_id)
						.first()
				);
				this.returnProducts[return_index].quantity =
					main_product.quantity;
				this.returnProducts[return_index].discount_total =
					main_product.discount_total;
				this.returnProducts[return_index].vat_total =
					main_product.vat_total;
				this.returnProducts[return_index].product_total =
					main_product.product_total;
				this.returnProducts[return_index].net_total =
					main_product.net_total;
				this.changeable_products.splice(index, 1);
			} else {
				this.returnProducts.unshift(product);
				this.changeable_products.splice(index, 1);
			}
		},
		returnProductQuantityDecrease(index, product) {
			let find = collect(this.changeable_products)
				.where("sale_detail_id", product.sale_detail_id)
				.first();
			if (product.quantity <= 1) {
				this.returnProductRemove(index, product);
				return;
			}
			product.quantity = parseFloat(product.quantity - 1).toFixed(2);
			if (product.discount_total > 0) {
				product.discount_total = parseFloat(
					product.discount_total - product.single_discount
				).toFixed(2);
			}
			if (product.vat_total > 0) {
				product.vat_total = parseFloat(
					product.vat_total - product.single_vat
				).toFixed(2);
			}
			product.product_total = parseFloat(
				product.quantity * product.sale_rate
			).toFixed(2);
			product.net_total = parseFloat(
				product.final_sale_rate * product.quantity
			).toFixed(2);
			let return_product = {
				...product,
			};
			if (find) {
				let quantity = parseInt(find.quantity);
				find.quantity = parseFloat(quantity + 1).toFixed(2);
				console.log(find.quantity);
				find.discount_total = parseFloat(
					find.discount_total + product.single_discount
				).toFixed(2);
				find.vat_total = parseFloat(
					find.vat_total + product.single_vat
				).toFixed(2);
				find.product_total = parseFloat(
					find.quantity * find.sale_rate
				).toFixed(2);
				find.net_total = parseFloat(
					find.final_sale_rate * find.quantity
				).toFixed(2);
				if (product.quantity < 1) {
					this.returnProductRemove(index, product);
				}
			} else {
				return_product.quantity = parseFloat(1).toFixed(2);
				return_product.discount_total = parseFloat(
					return_product.single_discount
				).toFixed(2);
				return_product.vat_total = parseFloat(
					return_product.single_vat
				).toFixed(2);
				return_product.product_total = parseFloat(
					return_product.quantity * return_product.sale_rate
				).toFixed(2);
				return_product.net_total = parseFloat(
					return_product.final_sale_rate * 1
				).toFixed(2);
				this.changeable_products.push(return_product);
			}
		},
		returnProductRemove(index, product) {
			const changeable_index = this.changeable_products.findIndex(
				(item) => {
					return item.sale_detail_id === product.sale_detail_id;
				}
			);
			if (changeable_index >= 0) {
				let main_product = _.cloneDeep(
					collect(this.main_products)
						.where("sale_detail_id", product.sale_detail_id)
						.first()
				);
				this.changeable_products[changeable_index].quantity =
					main_product.quantity;
				this.changeable_products[changeable_index].discount_total =
					main_product.discount_total;
				this.changeable_products[changeable_index].vat_total =
					main_product.vat_total;
				this.changeable_products[changeable_index].product_total =
					main_product.product_total;
				this.changeable_products[changeable_index].net_total =
					main_product.net_total;
				this.returnProducts.splice(index, 1);
			} else {
				this.changeable_products.push(product);
				this.returnProducts.splice(index, 1);
			}
		},
	},
	mounted() {
		this.findInvoice();
	},
	computed: {
		mainInvoiceCalculation() {
			let deliveryCharge = 0;
			let changeAmount = 0;
			let dueTotal = 0;
			let pay_amount = 0;
			let flat_discount = 0;
			let discount_percentage = 0;
			let vat_percentage = 0;
			let totalAmount = 0;
			let saleNetTotal = 0;
			let discountAmount = 0;
			let total_delivery_charge_amount = 0;
			let additional_charge = 0;
			let vatAmount = 0;
			if (this.main_invoice.id) {
				pay_amount = this.main_invoice.pay_amount;
				dueTotal = this.main_invoice.due_total;
				changeAmount = this.main_invoice.change_amount;
			}
			if (this.main_invoice.flat_discount > 0) {
				flat_discount = this.main_invoice.flat_discount;
			}
			if (this.main_invoice.discount_amount > 0) {
				discount_percentage = this.main_invoice.discount_percentage;
			}
			if (this.main_invoice.vat_amount > 0) {
				vat_percentage = this.main_invoice.vat_percentage;
			}
			if (this.main_invoice.additional_charge > 0) {
				additional_charge = parseFloat(
					this.main_invoice.additional_charge
				);
			}
			if (this.main_invoice && this.main_invoice.delivery_id) {
				deliveryCharge = this.main_invoice.delivery_charge;
				total_delivery_charge_amount =
					parseFloat(deliveryCharge) +
					parseFloat(this.main_invoice.additional_delivery_charge);
			}
			const productTotal = this.changeable_products.reduce(
				(total, current) =>
					total + current.sale_rate * current.quantity,
				0
			);
			const productTotalQuantity = this.changeable_products.reduce(
				(total, current) =>
					parseFloat(total) + parseFloat(current.quantity),
				0
			);
			flat_discount = this.changeable_products.reduce(
				(total, current) =>
					total +
					parseFloat(current.single_flat_discount) *
						parseFloat(current.quantity),
				0
			);
			if (this.main_invoice.discount_amount && productTotalQuantity > 0) {
				discountAmount = Math.round(
					((productTotal +
						total_delivery_charge_amount +
						additional_charge) *
						discount_percentage) /
						100
				);
			}
			if (this.main_invoice.vat_amount && productTotalQuantity > 0) {
				vatAmount = Math.round(
					((productTotal +
						total_delivery_charge_amount +
						additional_charge -
						discountAmount) *
						vat_percentage) /
						100
				);
			}
			const totalAmountWithVat =
				productTotal + vatAmount + deliveryCharge + additional_charge;

			let totalDiscount = discountAmount;
			totalDiscount = discountAmount + flat_discount;
			if (this.changeable_products.length > 0) {
				totalAmount =
					productTotal +
					vatAmount +
					deliveryCharge +
					additional_charge -
					(discountAmount + flat_discount);
				saleNetTotal = totalAmount;
			} else {
				totalAmount =
					productTotal +
					vatAmount +
					deliveryCharge -
					(discountAmount + flat_discount);
				saleNetTotal = totalAmount;
			}
			return {
				product_total: parseFloat(productTotal).toFixed(2),
				vat_amount: parseFloat(vatAmount).toFixed(2),
				discount_amount: parseFloat(discountAmount).toFixed(2),
				total_amount: parseFloat(totalAmount).toFixed(2),
				total_amount_with_vat:
					parseFloat(totalAmountWithVat).toFixed(2),
				sale_net_total: parseFloat(saleNetTotal).toFixed(2),
				change_amount: parseFloat(changeAmount).toFixed(2),
				total_discount: parseFloat(totalDiscount).toFixed(2),
				due_total: parseFloat(dueTotal).toFixed(2),
				pay_amount: parseFloat(pay_amount).toFixed(2),
				delivery_charge: parseFloat(deliveryCharge).toFixed(2),
				flat_discount: parseFloat(flat_discount).toFixed(2),
				discount_percentage: parseFloat(discount_percentage).toFixed(2),
				vat_percentage: parseFloat(vat_percentage).toFixed(2),
				productTotalQuantity:
					parseFloat(productTotalQuantity).toFixed(2),
			};
		},
		returnCalculation() {
			let discount_total = 0;
			const productTotal = this.returnProducts.reduce(
				(total, current) =>
					parseFloat(total) + parseFloat(current.product_total),
				0
			);
			const productTotalQuantity = this.returnProducts.reduce(
				(total, current) =>
					parseFloat(total) + parseFloat(current.quantity),
				0
			);
			const return_total = this.returnProducts.reduce(
				(total, current) =>
					parseFloat(total) + parseFloat(current.net_total),
				0
			);
			let discount_amount = this.returnProducts.reduce(
				(total, current) =>
					parseFloat(total) + parseFloat(current.discount_total),
				0
			);
			const vat_total = this.returnProducts.reduce(
				(total, current) =>
					parseFloat(total) + parseFloat(current.vat_total),
				0
			);
			const flat_discount_total = this.returnProducts.reduce(
				(total, current) =>
					total + current.single_flat_discount * current.quantity,
				0
			);
			const final_return_total = return_total - flat_discount_total;
			discount_total = discount_amount + flat_discount_total;
			this.allErrors.clear("return_products");
			return {
				product_total: parseFloat(productTotal).toFixed(2),
				return_total: parseFloat(final_return_total).toFixed(2),
				discount_total: parseFloat(discount_total).toFixed(2),
				discount_amount: parseFloat(discount_amount).toFixed(2),
				vat_total: parseFloat(vat_total).toFixed(2),
				flat_discount_total: parseFloat(flat_discount_total).toFixed(2),
				productTotalQuantity:
					parseFloat(productTotalQuantity).toFixed(2),
			};
		},
		paymentMethodName() {
			if (Object.keys(this.main_invoice).length > 0) {
				return collect(this.main_invoice.invoice_payment.payments)
					.pluck("payment_method.text")
					.implode("<br>");
			}
		},
		findSeller() {
			return collect(this.resource.seller_users)
				.where("value", parseInt(this.main_invoice.seller_id))
				.first();
		},
	},
};
</script>
<style scoped>
</style>
