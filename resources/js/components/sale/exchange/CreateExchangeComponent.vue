<template>
	<section class="content">
		<div class="dashboard">
			<div>
				<form role="form" @submit.prevent="saleExchangeStore()" @keydown="allErrors.clear($event.target.name)" @keydown.enter.prevent.self>
					<div class="sale-row">
						<div class="col-md-8">
							<div class="box box-primary none-border">
								<div class="box-header with-border">
									<h3 class="box-title">Exchange</h3>
								</div>

								<div class="box-body">
									<div class="row">
										<div class="form-group col-md-6">
											<label for="Name">Invoice</label>
											<div class="input-group">
												<input @keyup.enter="findInvoice" name="invoice_code" type="text" class="form-control corner" style="text-align: left" v-model.trim="invoice_code" placeholder="Enter Invoice" />
												<span class="input-group-addon pointer" @click="findInvoice">
													<i class="fa fa-search"></i>
												</span>
											</div>
											<span class="text-danger" v-if="allErrors.has('invoice_code')" v-text="allErrors.get('invoice_code')"> </span>
										</div>
										<div class="form-group col-md-6">
											<label for="phoneNumber">Phone</label>
											<div class="input-group">
												<input name="customer" type="number" style="text-align: left" @keyup.enter="customerInvoice" v-model.trim="customer_phone" placeholder="Enter Phone Number" class="form-control" />
												<span class="input-group-addon pointer" @click="customerInvoice">
													<i class="fa fa-search"></i>
												</span>
											</div>
											<span class="text-danger" v-if="allErrors.has('customer')" v-text="allErrors.get('customer')"> </span>
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
												<tr class="table-info" v-for="(sale, index) in customerSaleList" :key="index">
													<td>{{ sale.invoice_code }}</td>
													<td>
														{{ sale.created_at | moment("MMMM Do Y, h:mm a") }}
													</td>
													<td>
														<span>{{ sale.customer.name }}</span>
													</td>
													<td class="text-center">
														<span>{{ sale.total_quantity }}</span>
													</td>
													<td class="text-right">
														{{ sale.final_total.toLocaleString() }}
													</td>
												</tr>
											</tbody>
										</table>
									</div>

									<div class="row" v-if="Object.keys(main_invoice).length > 0">
										<div class="form-group col-md-12">
											<div style="display: flex; justify-content: space-between">
												<label for="Product">Old Product</label>
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
														<tr class="table-info" v-for="(product, index) in changeable_products" :key="index">
															<td>{{ index + 1 }}.</td>
															<td>
																<div style="display: grid">
																	<span>{{ product.product_name }}</span>
																	<span>{{ product.product_barcode }}</span>
																</div>
															</td>
															<td class="text-right">
																{{ product.sale_rate }}
															</td>
															<td class="text-center">
																<span>{{ product.quantity }}</span>
															</td>
															<td class="text-right">
																{{ product.product_total }}
															</td>
															<td class="pointer" style="margin-bottom: 2px">
																<span @click="oldProductRemove(index, product)">
																	<i style="font-size: 16px" class="fa fa-times-circle text-red"></i>
																</span>
																<span @click="oldProductQuantityDecrease(index, product)">
																	<i style="font-size: 16px" class="fa fa-minus-circle text-green"></i>
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
											<div class="row" style="width: 96%" v-if="main_invoice.additional_charge> 0">
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
												<label for="Product">Exchange Return</label>
												<label for="Product"> {{ resource.date }}</label>
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
														<tr class="table-info" v-for="(product, index) in returnProducts" :key="index">
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
															<td class="text-right">
																{{ product.product_total }}
															</td>
															<td class="pointer" style="margin-bottom: 2px">
																<span @click="returnProductRemove(index, product)">
																	<i style="font-size: 16px" class="fa fa-times-circle text-red"></i>
																</span>
																<span @click="returnProductQuantityDecrease(index, product)">
																	<i style="font-size: 16px" class="fa fa-minus-circle text-green"></i>
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

											<div class="row" style="width: 96%">
												<div class="col-md-10 text-right" style="display: flex; justify-content: end">
													Flat Discount
												</div>
												<div class="col-md-2 text-right">(-) {{ returnCalculation.flat_discount_total }}</div>
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
												<div class="col-md-6"></div>
												<div class="col-md-6">
													<hr style="margin-top: 5px; margin-bottom: 5px; border: 0; border-top: 1px solid #000000" />
												</div>
											</div>
											<div class="row" style="width: 96%">
												<div class="col-md-10 text-right">Total</div>
												<div class="col-md-2 text-right">{{ returnCalculation.return_total.toLocaleString() }}</div>
											</div>
										</div>
									</div>

									<div v-if="deliveryInfoShow">
										<div class="row">
											<div class="form-group col-md-6">
												<label for="address">City</label>
												<model-select :options="pathaoCityList" v-model="pathao_info.recipient_city" @input="getZoneList()" placeholder="Select City"></model-select>
												<span class="text-danger" v-if="allErrors.has('pathao_info.recipient_city.city_id')" v-text="allErrors.get('pathao_info.recipient_city.city_id')">
												</span>
												<span v-if="spinner.zone" style="text-align: center; font-size: 14px; color: green">
													<i class="fa fa-refresh fa-spin"></i>
													Fetching Zone....
												</span>
											</div>
											<div class="form-group col-md-6">
												<label for="address">Zone</label>
												<model-select :options="pathaoZoneList" v-model="pathao_info.recipient_zone" @input="getAreaList()" placeholder="Select Zone"></model-select>
												<span class="text-danger" v-if="allErrors.has('pathao_info.recipient_zone.zone_id')" v-text="allErrors.get('pathao_info.recipient_zone.zone_id')">
												</span>

												<span v-if="spinner.area" style="text-align: center; font-size: 14px; color: green">
													<i class="fa fa-refresh fa-spin"></i>
													Fetching Area....
												</span>
											</div>
										</div>
										<div class="row">
											<div class="form-group col-md-6">
												<label for="address">Area</label>
												<model-select :options="pathaoAreaList" v-model="pathao_info.recipient_area" @input="allErrors.clear('pathao_info.recipient_area.area_id')" placeholder="Select Area"></model-select>
												<span class="text-danger" v-if="allErrors.has('pathao_info.recipient_area.area_id')" v-text="allErrors.get('pathao_info.recipient_area.area_id')">
												</span>
											</div>

											<div class="form-group col-md-6">
												<label for="address">Pickup Store</label>
												<model-select :options="pathaoStoreList" v-model="pathao_info.store" @input="allErrors.clear('pathao_info.store.store_id')" placeholder="Select Store"></model-select>
												<span class="text-danger" v-if="allErrors.has('pathao_info.store.store_id')" v-text="allErrors.get('pathao_info.store.store_id')"> </span>
											</div>
										</div>
										<div class="row">
											<div class="form-group col-md-6">
												<label for="address">Delivery Type</label>
												<model-select :options="deliveryType" v-model="pathao_info.delivery_type" @input="allErrors.clear('pathao_info.delivery_type')" placeholder="Select Delivery Type"></model-select>
												<span class="text-danger" v-if="allErrors.has('pathao_info.delivery_type')" v-text="allErrors.get('pathao_info.delivery_type')"> </span>
											</div>

											<div class="form-group col-md-6">
												<label for="address">Item Type</label>
												<model-select :options="itemType" v-model="pathao_info.item_type" @input="allErrors.clear('pathao_info.item_type')" placeholder="Select Item Type"></model-select>
												<span class="text-danger" v-if="allErrors.has('pathao_info.item_type')" v-text="allErrors.get('pathao_info.item_type')"> </span>
											</div>
										</div>
										<div class="row">
											<div class="form-group col-md-6">
												<label for="Name">Item Quantity</label>
												<input name="pathao_info.item_quantity" type="text" readonly class="form-control corner" style="text-align: left" :value="pathao_info.item_quantity" placeholder="Enter Item Quantity" />
												<span class="text-danger" v-if="allErrors.has('pathao_info.item_quantity')" v-text="allErrors.get('pathao_info.item_quantity')"></span>
											</div>
											<div class="form-group col-md-6">
												<label for="Name">Item Weight</label>
												<input name="pathao_info.item_weight" type="number" step="0.01" class="form-control corner" style="text-align: left" v-model="pathao_info.item_weight" placeholder="Enter Item Weight" />
												<span class="text-danger" v-if="allErrors.has('pathao_info.item_weight')" v-text="allErrors.get('pathao_info.item_weight')"></span>
											</div>
										</div>
										<div class="row">
											<div class="form-group col-md-6">
												<label for="address">Special instruction</label>
												<textarea name="pathao_info.special_instruction" type="text" class="form-control corner" style="text-align: left" v-model="pathao_info.special_instruction" placeholder=" Enter Special instruction">
                                                </textarea>
												<span class="text-danger" v-if="allErrors.has('pathao_info.special_instruction')" v-text="allErrors.get('pathao_info.special_instruction')">
												</span>
											</div>
											<div class="form-group col-md-6">
												<label for="address">Item description</label>
												<textarea name="pathao_info.item_description" type="text" class="form-control corner" style="text-align: left" v-model="pathao_info.item_description" placeholder="Enter Item description">
                                                </textarea>
												<span class="text-danger" v-if="allErrors.has('pathao_info.item_description')" v-text="allErrors.get('pathao_info.item_description')"> </span>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="form-group col-md-6">
											<label for="Product">Product</label>
											<input type="text" class="form-control corner" @keyup.enter="getProduct()" v-model.trim="product_barcode" placeholder="Enter product barcode" />
											<span v-if="spinner.product" style="text-align: center; font-size: 16px; color: green"> <i class="fa fa-refresh fa-spin"></i> Checking.... </span>
										</div>
										<!-- <div class="form-group col-md-2 selectBoxmargin">
											<input id="deliveryOption" type="checkbox" @input="checkDeliveryOption()" v-model="sale_info.deliveryOption" />
											<label for="deliveryOption">Option</label>
										</div> -->
										<div class="form-group col-md-4 selectBoxmargin2" v-if="sale_info.deliveryOption === true">
											<model-select :options="resource.deliveryMan" v-model="sale_info.delivery_man" placeholder="Select Delivery Man"> </model-select>
											<span v-if="spinner.deliveryLoad" style="text-align: center; font-size: 14px; color: green">
												<i class="fa fa-refresh fa-spin"></i>
												Fetching {{ sale_info.delivery_man.name }} ....
											</span>
											<span v-if="spinner.priceCalculation" style="text-align: center; font-size: 14px; color: green">
												<i class="fa fa-refresh fa-spin"></i>
												Price calculation for {{ sale_info.delivery_man.name }}
											</span>
										</div>
									</div>
									<div class="row">
										<div class="form-group col-md-12">
											<label for="Product">New Product</label>
											<div class="table-outline">
												<table class="table table-striped w-auto">
													<thead class="table-head">
														<tr>
															<th>S.N</th>
															<th>Product Name</th>
															<th class="text-right">In Stock</th>
															<th class="text-right">Unite Price</th>
															<th style="width: 15%">Quantity</th>
															<th class="text-right">Price</th>
															<th></th>
														</tr>
													</thead>
													<tbody>
														<tr class="table-info" v-for="(sale_product, index) in saleProducts" :key="index">
															<td>{{ index + 1 }}.</td>
															<td>
																<div style="display: grid">
																	<span>{{ sale_product.product_name }}</span>
																	<span class="text-danger" v-if="sale_product.available_stock < 1">Product Stock Out</span>
																	<span class="text-danger" v-else-if="sale_product.available_stock < sale_product.quantity">
																		Available Stock
																		{{ sale_product.available_stock }}
																	</span>
																</div>
															</td>
															<td class="text-right">
																{{ sale_product.available_stock }}
																Pcs
															</td>
															<td class="text-right">
																{{ sale_product.product_sell_price }}
															</td>
															<td>
																<input type="number" @input="quantityInput(index, sale_product)" class="sale-quantity" v-model.number="sale_product.quantity" />
															</td>
															<td class="text-right">
																{{ sale_product.total_price }}
															</td>
															<td class="pointer" style="margin-bottom: 2px">
																<!--                                                            <img class="image-size"-->
																<!--                                                                 src="/images/sales/04.png"-->
																<!--                                                                 alt="edit"/>-->
																<span @click="saleProducts.splice(index, 1)">
																	<i style="font-size: 16px" class="fa fa-times-circle text-red"></i>
																</span>
																<span @click="quantityUpdate(index, sale_product)">
																	<i style="font-size: 16px" class="fa fa-plus-circle text-green"></i>
																</span>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
											<div class="row" style="margin-top: 10px; width: 96%">
												<div class="col-md-10 text-right">Total Product</div>
												<div class="col-md-2 text-right">
													{{ totalQuantity.toLocaleString() }} pcs
												</div>
											</div>
											<div class="row" style="width: 96%">
												<div class="col-md-10 text-right">Total Product Price</div>
												<div class="col-md-2 text-right">
													{{ totalCalculation.product_total.toLocaleString() }}
												</div>
											</div>
											<div v-if="Object.keys(sale_info.delivery_man).length > 0">
												<div class="row" style="width: 96%">
													<div class="col-md-10 text-right" style="display: flex; justify-content: end">Delivery Charge
													</div>
													<div class="col-md-2 text-right">
														{{ totalCalculation.delivery_charge }}
													</div>
												</div>
												<div class="row" style="width: 96%" v-if="additionalDeliveryCharge > 0">
													<div class="col-md-10 text-right" style="display: flex; justify-content: end">Additional Delivery Charge
													</div>
													<div class="col-md-2 text-right">
														{{ additionalDeliveryCharge }}
													</div>
												</div>
											</div>

											<div class="row" style="width: 96%">
												<div class="col-md-10 text-right">Additional Charge</div>
												<div class="col-md-2 text-right">
													<input style="text-align: right; margin-left: -28px; width: 68%" @input="additionalInputCharge" type="number" class="vat" min="0" step="0.01" v-model.number="sale_info.additional_charge" />
												</div>
											</div>
											<div class="row" style="width: 96%">
												<div class="col-md-10 text-right" style="display: flex; justify-content: end">
													Discount (<input style="width: 10%" min="0" max="100" step="0.01" type="number" class="vat" v-model="discount_percentage" />
													%)
												</div>
												<div class="col-md-2 text-right">
													{{ totalCalculation.discount_amount }}
												</div>
											</div>
											<div class="row" style="width: 96%">
												<div class="col-md-10 text-right" style="display: flex; justify-content: end">
													Vat (<input style="width: 10%" type="number" min="0" max="100" step="0.01" class="vat" v-model.number="vat_percentage" />
													%)
												</div>
												<div class="col-md-2 text-right">
													{{ totalCalculation.vat_amount }}
												</div>
											</div>
											<div class="row" style="width: 96%">
												<div class="col-md-6"></div>
												<div class="col-md-6">
													<hr style="margin-top: 5px; margin-bottom: 5px; border: 0; border-top: 1px solid #000000" />
												</div>
											</div>
											<div class="row" style="width: 96%">
												<div class="col-md-10 text-right">Total Amount</div>
												<div class="col-md-2 text-right">
													{{ totalCalculation.total_amount }}
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="alert alert-danger" v-if="Object.keys(allErrors.errors).length > 0">
								<ul>
									<li v-for="(error, index) in allErrors.errors" :key="index">
										<span v-if="error[0]" v-text="error[0]"></span>
									</li>
								</ul>
							</div>
							<div class="row" style="margin-top: 20px">
								<div class="col-md-12">
									<h2 style="text-align: center">Payment</h2>
								</div>
							</div>
							<div class="row" style="padding-bottom: 6px;display:flex">
								<div class="col-md-3">New Product</div>
								<div class="col-md-6">
									{{ totalCalculation.total_amount }} /-
								</div>
							</div>
							<div class="row" style="padding-bottom: 6px;display:flex">
								<div class="col-md-3">Return Total</div>
								<div class="col-md-6">
									(-) {{ returnCalculation.return_total }} /-
								</div>
							</div>
							<div class="row" style="padding-bottom: 6px;display:flex">
								<div class="col-md-3">Payable Amount</div>
								<div class="col-md-6">
									{{ totalCalculation.payable_amount }} /-
								</div>
							</div>
							<div class="row" style="padding-bottom: 6px;display:flex;color: red;" v-if=" totalCalculation.buy_more_product_amount >0">
								<div class="col-md-3">Buy More Product</div>
								<div class="col-md-6">
									{{ totalCalculation.buy_more_product_amount }} /-
								</div>
							</div>
							<hr style="margin-top: 20px; margin-bottom: 20px; border: 0; border-top: 2px solid #7c34db" />
							<div class="row">
								<div class="col-md-12">
									<div class="row" style="display: flex; justify-content: space-between">
										<div class="col-md-3" style="display: flex; justify-content: space-between">
										</div>
										<div class="col-md-9" :class="{ 'pointer-events': totalCalculation.payable_amount <=0}">
											<div class="multiple-payment" v-for="(sale_payment, index) in salePayments" :key="index">
												<div class="col-md-6">
													<label v-if="index === 0">Payment Method</label>
													<select @input="allErrors.clear(`sale_payments.${index}.payment_method.value`)" @change="(sale_payment.payment_reference = ''), (sale_payment.pay_amount = '')" class="form-control" v-model="sale_payment.payment_method">
														<option :value="{}" selected>Select Payment Method</option>
														<option v-for="(payment_method, index) in resource.paymentMethod" :value="payment_method" :disabled="!sale_info.deliveryOption && payment_method.text === 'COD'" :key="index">
															{{ payment_method.text }}
														</option>
													</select>
													<span class="text-danger" v-if="allErrors.has(`sale_payments.${index}.payment_method.value`)" v-text="allErrors.get(`sale_payments.${index}.payment_method.value`)">
													</span>
												</div>
												<div class="text-right col-md-6" v-if="sale_payment.payment_method && sale_payment.payment_method.reference_status == 1">
													<label v-if="index === 0">Payment Reference</label>
													<input :name="`sale_payments.${index}.payment_reference`" type="text" v-model="sale_payment.payment_reference" class="paid-input" />
													<span class="text-danger" v-if="allErrors.has(`sale_payments.${index}.payment_reference`)" v-text="allErrors.get(`sale_payments.${index}.payment_reference`)">
													</span>
												</div>
												<div class="text-center col-md-6">
													<label v-if="index === 0">Pay Amount</label>
													<input :name="`sale_payments.${index}.pay_amount`" type="number" min="0" step="0.01" @input="onlyNumber(sale_payment)" v-model.number="sale_payment.pay_amount" class="paid-input" />
													<span class="text-danger" v-if="allErrors.has(`sale_payments.${index}.pay_amount`)" v-text="allErrors.get(`sale_payments.${index}.pay_amount`)">
													</span>
												</div>
												<div style="margin: auto">
													<i v-if="index === 0" @click="addMorePayment" style="font-size: 16px" class="fa fa-plus-circle text-green pointer"></i>
													<i v-if="index !== 0" @click="salePayments.splice(index, 1)" style="font-size: 16px" class="fa fa-times-circle text-red pointer"></i>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-10 text-right text-red">Due</div>
										<div class="col-md-2 text-red text-right">
											{{ totalCalculation.due_total }}
										</div>
									</div>
									<div class="row">
										<div class="col-md-10 text-right">Discount</div>
										<div class="col-md-2 text-right">
											<input style="text-align: right; margin-left: -28px; width: 68%" type="number" class="vat" min="0" step="0.01" v-model.number="flat_discount" />
										</div>
									</div>
									<div class="row">
										<div class="col-md-10 text-right text-blue">Change Amount</div>
										<div class="col-md-2 text-blue text-right">
											{{ totalCalculation.change_amount }}
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /.box -->
						<div class="col-md-4">
							<!-- general form elements -->
							<div class="box box-primary none-border">
								<div class="box-header with-border">
									<h3 class="box-title">Showing Bill</h3>
								</div>
								<!-- /.box-header -->
								<!-- form start -->
								<div class="ticket invoice invoice-font invoice-border">
									<div class="text-center">
										<!-- <img class="image" src="/images/sale_print.png" alt="" /> -->

									</div>
									<p class="centered">
										<br />
										<strong>
											<!--                                        H # 14, Block # A, Main Road <br>-->
											<!--                                        Rampura, Banasree-->
											{{ resource.user.branch.address }}
										</strong>
									</p>
									<div class="row" style="margin-bottom: 7px">
										<div class="col-md-8" style="font-size: 10px">Vat Reg No# 004452563-0202</div>
										<div class="col-md-4" style="font-size: 11px; text-align: end">Mushak-6.3</div>
									</div>

									<p class="bill">Invoice</p>
									<h4 class="text-center">
										<strong> {{ sale_info.invoice_code }} </strong>
									</h4>
									<div class="row">
										<div class="col-md-6">
											{{ customer.phone }}
										</div>
										<div class="col-md-6">
											{{ resource.date }}
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											{{ customer.name }}
										</div>
									</div>
									<div class="row">
										<div class="col-md-12 text-left">
											{{ customer.address }}
										</div>
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
											<tr style="border-bottom: 1px dashed black; border-collapse: collapse" v-for="(product, index) in changeable_products" :key="index">
												<td class="mrp">{{ index + 1 }} .</td>
												<td class="description">
													{{ product.product_name }} X
													{{ product.quantity }}
												</td>
												<td class="price">= {{ product.product_total }}</td>
											</tr>
										</tbody>
									</table>

									<table style="width: 100%; margin-top: 5px" class="not-dashed">
										<tbody>
											<tr>
												<td style="vertical-align: baseline">
													<div style="display: grid">
														<u v-html="main_invoice.payments_name"></u>
													</div>
												</td>
												<td>
													<p>Amount</p>
													<p>Vat ({{ vat_percentage }}%)</p>
													<p v-if="mainInvoiceCalculation.delivery_charge > 0">Delivery Charge</p>
													<p v-if="mainInvoiceCalculation.additional_charge > 0">Additional Charge</p>
													<p>Total</p>
													<p>Discount</p>
													<p>Total Amount</p>
													<p>Paid</p>
													<p>Due</p>
													<p>Change Amount</p>
												</td>
												<td>
													<p class="left">
														{{ mainInvoiceCalculation.product_total.toLocaleString() }}
													</p>
													<p class="left">
														{{ mainInvoiceCalculation.vat_amount }}
													</p>
													<p v-if="mainInvoiceCalculation.delivery_charge > 0" class="left">
														{{ mainInvoiceCalculation.total_delivery_charge_amount }}
													</p>
													<p v-if="mainInvoiceCalculation.additional_charge > 0" class="left">
														{{ mainInvoiceCalculation.additional_charge }}
													</p>
													<p class="left">
														{{ mainInvoiceCalculation.total_amount_with_vat }}
													</p>
													<p class="left">
														{{ mainInvoiceCalculation.total_discount }}
													</p>
													<p class="left">
														{{ mainInvoiceCalculation.sale_net_total }}
													</p>
													<p class="left">
														{{ mainInvoiceCalculation.pay_amount }}
													</p>
													<p class="left">
														{{ mainInvoiceCalculation.due_total }}
													</p>
													<p class="left">
														{{ mainInvoiceCalculation.change_amount }}
													</p>
												</td>
											</tr>
										</tbody>
									</table>
									<!-- Old Return Products-->
									<div v-if="Object.keys(main_invoice).length > 0 && main_invoice.sale_returns.length > 0">
										<SaleReturnProductsBill :sale_returns="main_invoice.sale_returns"> </SaleReturnProductsBill>
									</div>
									<!-- Old Return Products-->
									<!-- Current Return Products-->
									<div v-if="returnProducts.length > 0">
										<p class="text-center" style="margin-top: 5%">Exchange Return : {{ resource.date }}</p>
										<table style="width: 100%">
											<tbody>
												<tr style="border-bottom: 1px dashed black; border-collapse: collapse" v-for="(product, index) in returnProducts" :key="index">
													<td class="mrp">{{ index + 1 }} .</td>
													<td class="description">
														{{ product.product_name }} X
														{{ product.quantity }}
													</td>
													<td class="price">= {{ product.product_total }}</td>
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
									<!-- Current Exchange Products-->
									<div>
										<p class="text-center" style="margin-top: 5%">Exchange : {{ resource.date }}</p>
										<div class="row" v-if="Object.keys(sale_info.delivery_man).length > 0">
											<div class="col-md-12 text-left">
												Delivery :
												{{ sale_info.delivery_man.name }}
											</div>
										</div>
										<br />
										<table style="width: 100%">
											<tbody>
												<tr style="border-bottom: 1px dashed black; border-collapse: collapse" v-for="(sale_product, index) in saleProducts" :key="index">
													<td class="mrp">{{ index + 1 }} .</td>
													<td class="description">
														{{ sale_product.product_name }} X
														{{ sale_product.quantity }}
													</td>
													<td class="price">= {{ sale_product.total_price }}</td>
												</tr>
											</tbody>
										</table>

										<table style="width: 100%; margin-top: 5px" class="not-dashed">
											<tbody>
												<tr>
													<td style="vertical-align: baseline">
														<div style="display: grid">
															<u v-html="paymentMethodName"></u>
														</div>
													</td>
													<td>
														<p>Amount</p>
														<p>Vat ({{ vat_percentage }}%)</p>
														<p v-if="totalCalculation.delivery_charge > 0">Delivery Charge</p>
														<p v-if="totalCalculation.additional_charge > 0">Additional Charge</p>
														<p>Total</p>
														<p>Discount</p>
														<p>Total Amount</p>
														<p>Paid</p>
														<p>Due</p>
														<p>Change Amount</p>
													</td>
													<td>
														<p class="left">
															{{ totalCalculation.product_total.toLocaleString() }}
														</p>
														<p class="left">
															{{ totalCalculation.vat_amount }}
														</p>
														<p v-if="totalCalculation.delivery_charge > 0" class="left">
															{{ total_delivery_charge }}
														</p>
														<p v-if="totalCalculation.additional_charge > 0" class="left">
															{{ totalCalculation.additional_charge }}
														</p>
														<p class="left">
															{{ totalCalculation.total_amount_with_vat }}
														</p>
														<p class="left">
															{{ totalCalculation.total_discount }}
														</p>
														<p class="left">
															{{ totalCalculation.sale_net_total }}
														</p>
														<p class="left">
															{{ totalCalculation.pay_amount }}
														</p>
														<p class="left">{{ totalCalculation.due_total }}</p>
														<p class="left">
															{{ totalCalculation.change_amount }}
														</p>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
									<!-- Current Exchange Products-->
									<div class="footer">
										<div class="row">
											<div class="col-md-12" v-if="main_invoice.invoice_code">
												<barcode :width="1.5" :height="50" v-bind:value="main_invoice.invoice_code">
													{{ main_invoice.invoice_code }}
												</barcode>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12" style="font-size: 8px; margin-top: -5px">
												<span class="centered"> www.colourful.com.bd </span>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<span class="centered" style="font-size: 8px">EXCHANGE CUSTOMER COPY </span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row" style="padding: 30px">
								<div class="col-md-12" style="text-align: -webkit-center">
									<button type="submit" class="hidden-print btn btn-success btn-sm btn-block">Exchange Order</button>
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
import Errors from "../../../helper/errors.js";
import collect from "collect.js";
import VueBarcode from "vue-barcode";
import SaleReturnProductsBill from "../return/SaleReturnProductsBill.vue";

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
				deliveryLoad: false,
				zone: false,
				area: false,
				priceCalculation: false,
			},
			isLoading: false,
			sale_info: {
				delivery_man: {},
				deliveryOption: false,
				additional_charge: 0,
			},
			salePayments: [],
			vat_percentage: Number(this.resource.settings.vat_percentage),
			discount_percentage: 0,
			flat_discount: 0,
			saleProducts: [],
			defaultPaymentFormat: {
				payment_method: {},
				pay_amount: "",
				payment_number: "",
				payment_reference: "",
			},
			pathaoCityList: [],
			pathaoZoneList: [],
			pathaoAreaList: [],
			pathaoStoreList: [],
			deliveryType: [
				{
					text: "Normal delivery",
					value: 48,
				},
				{
					text: "On demand Delivery",
					value: 12,
				},
			],
			itemType: [
				{
					text: "Parcel",
					value: 2,
				},
				{
					text: "Document",
					value: 1,
				},
			],
			pathao_info: {
				store: {},
				recipient_name: "",
				recipient_phone: "",
				recipient_address: "",
				recipient_city: {},
				recipient_zone: {},
				recipient_area: {},
				delivery_type: 48,
				item_type: 2,
				special_instruction: "",
				item_quantity: "",
				item_weight: "",
				amount_to_collect: "",
				item_description: "",
				pricePlan: {},
			},
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
			total_delivery_charge: 0,
		};
	},
	watch: {
		"sale_info.delivery_man"() {
			if (this.sale_info.delivery_man.name === "Pathao") {
				this.getPathaoCityStore();
				this.sale_info.delivery_man.delivery_charge = 0;
				let findCod = collect(this.resource.paymentMethod)
					.where("text", "COD")
					.first();
				if (findCod) {
					this.salePayments[0].payment_method = findCod;
					this.salePayments[0].pay_amount = "";
					this.salePayments[0].payment_number = "";
					this.salePayments[0].payment_reference = "";
				}
			}
		},
		"pathao_info.store"() {
			this.getPathaoDeliveryPrice();
		},
		"pathao_info.item_type"() {
			this.getPathaoDeliveryPrice();
		},
		"pathao_info.delivery_type"() {
			this.getPathaoDeliveryPrice();
		},
		"pathao_info.item_weight"() {
			this.getPathaoDeliveryPrice();
		},
		"pathao_info.recipient_city"() {
			this.getPathaoDeliveryPrice();
		},
		"pathao_info.recipient_zone"() {
			this.getPathaoDeliveryPrice();
		},
		totalQuantity() {
			this.pathao_info.item_quantity = this.totalQuantity;
		},
	},
	methods: {
		saleExchangeStore() {
			const _this = this;
			if (this.returnProducts.length < 1) {
				toastr.error("Return product required");
				return false;
			}
			if (this.totalCalculation.due_total > 0) {
				toastr.error("Sale due amount must be 0");
				return false;
			}
			this.isLoading = true;
			this.Loader(true);
			this.allErrors.allClear();
			const form = {
				...this.sale_info,
				sale_products: this.saleProducts,
				...this.totalCalculation,
				additional_delivery_charge: this.additionalDeliveryCharge,
				customer: this.customer,
				sale_payments: this.salePayments,
				return_products: this.returnProducts,
				return_calculation: this.returnCalculation,
				main_products: this.changeable_products,
				main_invoice_calculation: this.mainInvoiceCalculation,
				main_invoice: this.main_invoice,
			};
			if (this.sale_info.delivery_man.name === "Pathao") {
				this.pathao_info.recipient_name = this.customer.name;
				this.pathao_info.recipient_phone = this.customer.phone;
				this.pathao_info.recipient_address = this.customer.address;
				this.pathao_info.amount_to_collect = parseInt(
					this.totalCalculation.sale_net_total
				);
				form.pathao_info = this.pathao_info;
			}
			axios
				.post(route("sale-exchange.store"), form)
				.then((response) => {
					if (response.data.status === 200) {
						const result = response.data.result;
						for (const key in result) {
							let find = this.saleProducts.find(
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
						toastr.success("Sale Exchange successfully");
						const url = route(
							"sales.show",
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
					if (error && error.response.data.success === "false") {
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
				invoice_type: "exchange",
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
		getProduct: _.debounce(function () {
			if (this.product_barcode.length < 1) {
				return true;
			}
			this.spinner.product = true;
			for (const key in this.saleProducts) {
				if (
					this.saleProducts[key].product_barcode ===
					this.product_barcode
				) {
					if (
						this.saleProducts[key].available_stock <=
						this.saleProducts[key].quantity
					) {
						toastr.warning(
							this.saleProducts[key].product_name +
								" Available Stock " +
								this.saleProducts[key].available_stock
						);
						this.product_barcode = "";
						this.spinner.product = false;
						return;
					}
				}
			}
			axios
				.post(route("sale-product-add"), {
					product_barcode: this.product_barcode,
				})
				.then((response) => {
					if (response.data.status === 200) {
						const result = response.data.result;
						if (this.saleProducts.length < 1) {
							this.saleProducts.push(result);
						} else {
							const barcodeProduct = collect(this.saleProducts)
								.where(
									"product_barcode",
									result.product_barcode
								)
								.first();
							for (const key in this.saleProducts) {
								if (
									this.saleProducts[key].product_barcode ===
									this.product_barcode
								) {
									this.saleProducts[key].quantity += 1;
									this.quantityInput(
										key,
										this.saleProducts[key]
									);
								}
							}
							if (barcodeProduct) {
								barcodeProduct.available_stock =
									result.available_stock;
							} else {
								this.saleProducts.unshift(result);
							}
						}
						this.product_barcode = "";
						this.spinner.product = false;
						this.allErrors.clear("product_sku");
						this.allErrors.clear("sale_products");
						toastr.success(response.data.message);
					} else {
						toastr.success(response.data.message);
					}
				})
				.catch((error) => {
					if (error && error.response.status === 422) {
						this.allErrors.record(error.response.data.errors);
					}
					toastr.error(error.response.data.message);
					this.playSound();
					this.spinner.product = false;
				});
		}, 0),
		quantityUpdate(index, current_product) {
			current_product.quantity += 1;
			this.quantityInput(index, current_product);
		},
		quantityInput(index, current_product) {
			if (current_product.available_stock < current_product.quantity) {
				this.saleProducts[index].quantity =
					current_product.available_stock;
				toastr.warning(
					"Available Stock " + current_product.available_stock
				);
				this.setQuantityTotal(index, current_product);
				return;
			}
			if (current_product.quantity < 1) {
				this.saleProducts[index].quantity = 1;
				this.setQuantityTotal(index, current_product);
				return;
			}
			this.setQuantityTotal(index, current_product);
		},
		setQuantityTotal(index, current_product) {
			this.saleProducts[index].total_price = (
				current_product.quantity * current_product.product_sell_price
			).toFixed(2);
		},
		checkDeliveryOption() {
			this.sale_info.delivery_man = {};
			this.salePayments.map(function (key, index) {
				if (key.payment_method.text === "COD") {
					key.payment_method = {};
					key.pay_amount = "";
					key.payment_reference = "";
				}
			});
		},
		addMorePayment() {
			if (this.salePayments.length < this.resource.paymentMethod.length) {
				this.salePayments.push({ ...this.defaultPaymentFormat });
			}
		},
		onlyNumber(payment) {
			if (payment.pay_amount > 0) {
				// payment.pay_amount = parseInt(payment.pay_amount);
			} else {
				payment.pay_amount = "";
			}
		},
		getPathaoCityStore() {
			this.spinner.deliveryLoad = true;
			Promise.all([
				axios.get(route("pathao-city")),
				axios.get(route("pathao-store")),
			]).then((res) => {
				if (res[0].data.result && res[1].data.result) {
					this.pathaoCityList = res[0].data.result;
					this.pathaoStoreList = res[1].data.result;
					this.spinner.deliveryLoad = false;
				} else {
					toastr.error("Something went wrong");
				}
			});
		},
		getZoneList() {
			this.spinner.zone = true;
			this.allErrors.clear("pathao_info.recipient_city.city_id");
			this.pathao_info.recipient_zone = {};
			this.pathao_info.recipient_area = {};
			this.pathao_info.pricePlan = {};
			this.pathaoZoneList = [];
			this.pathaoAreaList = [];
			axios
				.get(
					route(
						"pathao-zone",
						this.pathao_info.recipient_city.city_id
					)
				)
				.then((response) => {
					if (response.data.result) {
						this.pathaoZoneList = response.data.result;
						this.spinner.zone = false;
					}
					this.allErrors.clear("pathao_info.recipient_city");
				})
				.catch((error) => {});
		},
		getAreaList() {
			this.spinner.area = true;
			this.allErrors.clear("pathao_info.recipient_zone.zone_id");
			this.pathao_info.recipient_area = {};
			axios
				.get(
					route(
						"pathao-area",
						this.pathao_info.recipient_zone.zone_id
					)
				)
				.then((response) => {
					if (response.data.result) {
						this.pathaoAreaList = response.data.result;
						this.spinner.area = false;
					}
				})
				.catch((error) => {});
		},
		getPathaoDeliveryPrice: _.debounce(async function () {
			let condition =
				this.pathao_info.store &&
				this.pathao_info.item_type &&
				this.pathao_info.delivery_type &&
				this.pathao_info.item_weight &&
				this.pathao_info.recipient_city &&
				this.pathao_info.recipient_zone;
			if (!condition) {
				return;
			}
			this.spinner.priceCalculation = true;
			const form_data = {
				store_id: this.pathao_info.store.store_id,
				item_type: this.pathao_info.item_type,
				delivery_type: this.pathao_info.delivery_type,
				item_weight: this.pathao_info.item_weight,
				recipient_city: this.pathao_info.recipient_city.city_id,
				recipient_zone: this.pathao_info.recipient_zone.zone_id,
			};
			await axios
				.post(route("pathao-price-calculation"), form_data)
				.then((response) => {
					if (response.data.result) {
						this.pathao_info.pricePlan = response.data.result;
						this.sale_info.delivery_man.delivery_charge =
							response.data.result.price;
						this.spinner.priceCalculation = false;
						this.allErrors.allClear();
					}
				})
				.catch((error) => {
					if (error && error.response.status === 422) {
						this.allErrors.record(error.response.data.errors);
						this.playSound();
					}
				});
		}, 500),
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
		additionalInputCharge() {
			if (this.sale_info.additional_charge <= 0) {
				this.sale_info.additional_charge = 0;
			}
		},
	},
	mounted() {
		this.salePayments = [{ ...this.defaultPaymentFormat }];
	},
	computed: {
		totalCalculation() {
			let deliveryCharge = 0;
			let changeAmount = 0;
			let dueTotal = 0;
			let flat_discount = 0;
			let discount_percentage = 0;
			let vat_percentage = 0;
			let payable_amount = 0;
			let buy_more_product_amount = 0;
			let discountAmount = 0;
			let total_delivery_charge_amount = 0;
			let pay_amount = this.salePayments.reduce(
				(total_pay, current) => total_pay + current.pay_amount,
				0
			);
			if (this.flat_discount > 0) {
				flat_discount = this.flat_discount;
			}
			if (this.discount_percentage > 0) {
				discount_percentage = this.discount_percentage;
			}
			if (this.vat_percentage > 0) {
				vat_percentage = this.vat_percentage;
			}
			if (Object.keys(this.sale_info.delivery_man).length > 0) {
				deliveryCharge = this.sale_info.delivery_man.delivery_charge;
				total_delivery_charge_amount = parseFloat(
					this.total_delivery_charge
				);
			}
			const productTotal = this.saleProducts.reduce(
				(total, current) =>
					total + current.product_sell_price * current.quantity,
				0
			);
			if (discount_percentage > 0) {
				discountAmount = Math.round(
					((productTotal +
						total_delivery_charge_amount +
						this.sale_info.additional_charge) *
						discount_percentage) /
						100
				);
			}
			const vatAmount = Math.round(
				((productTotal +
					total_delivery_charge_amount +
					this.sale_info.additional_charge -
					discountAmount) *
					vat_percentage) /
					100
			);

			const totalAmount =
				productTotal +
				vatAmount +
				total_delivery_charge_amount +
				this.sale_info.additional_charge -
				discountAmount;
			const totalAmountWithVat =
				productTotal +
				vatAmount +
				total_delivery_charge_amount +
				this.sale_info.additional_charge;
			const saleNetTotal = totalAmount - flat_discount;

			let totalDiscount = discountAmount;
			totalDiscount = discountAmount + flat_discount;

			if (this.returnCalculation.return_total <= saleNetTotal) {
				payable_amount =
					saleNetTotal - this.returnCalculation.return_total;
				if (pay_amount > payable_amount) {
					changeAmount = pay_amount - payable_amount;
				}
				if (pay_amount < payable_amount) {
					dueTotal = payable_amount - pay_amount;
				}
			} else {
				buy_more_product_amount =
					this.returnCalculation.return_total - saleNetTotal;
			}
			if (dueTotal < 1) {
				this.allErrors.clear("due_total");
			}
			if (buy_more_product_amount <= 0) {
				this.allErrors.clear("buy_more_product_amount");
			}

			if (payable_amount <= 0) {
				this.salePayments = [];
				this.salePayments = [{ ...this.defaultPaymentFormat }];
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
				payable_amount: parseFloat(payable_amount).toFixed(2),
				buy_more_product_amount: parseFloat(
					buy_more_product_amount
				).toFixed(2),
				additional_charge: parseFloat(
					this.sale_info.additional_charge
				).toFixed(2),
			};
		},
		additionalDeliveryCharge() {
			let additionalDeliveryCharge = 0;
			if (
				Object.keys(this.sale_info.delivery_man).length > 0 &&
				this.sale_info.delivery_man.delivery_charge > 0
			) {
				if (this.pathao_info.recipient_city.text === "Dhaka") {
					if (
						this.sale_info.delivery_man.delivery_charge <
						this.resource.settings.inside_dhaka_charge
					) {
						additionalDeliveryCharge =
							parseFloat(
								this.resource.settings.inside_dhaka_charge
							) -
							parseFloat(
								this.sale_info.delivery_man.delivery_charge
							);
					}
				} else {
					if (
						this.sale_info.delivery_man.delivery_charge <
						this.resource.settings.outside_dhaka_charge
					) {
						additionalDeliveryCharge =
							parseFloat(
								this.resource.settings.outside_dhaka_charge
							) -
							parseFloat(
								this.sale_info.delivery_man.delivery_charge
							);
					}
				}

				this.total_delivery_charge = parseFloat(
					this.sale_info.delivery_man.delivery_charge +
						additionalDeliveryCharge
				).toFixed(2);
			}
			return parseFloat(additionalDeliveryCharge).toFixed(2);
		},
		paymentMethodName() {
			return collect(this.salePayments)
				.pluck("payment_method.text")
				.implode("<br>");
		},
		deliveryInfoShow() {
			return (
				this.sale_info.deliveryOption === true &&
				this.sale_info.delivery_man &&
				this.sale_info.delivery_man.name === "Pathao" &&
				!this.spinner.deliveryLoad
			);
		},
		totalQuantity() {
			return this.saleProducts.reduce(
				(total, current) => total + current.quantity,
				0
			);
		},
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
				productTotal +
				vatAmount +
				total_delivery_charge_amount +
				additional_charge;

			let totalDiscount = discountAmount;
			totalDiscount = discountAmount + flat_discount;
			if (this.changeable_products.length > 0) {
				totalAmount =
					productTotal +
					vatAmount +
					total_delivery_charge_amount +
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
				total_delivery_charge_amount: parseFloat(
					total_delivery_charge_amount
				).toFixed(2),
				additional_charge: parseFloat(additional_charge).toFixed(2),
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
