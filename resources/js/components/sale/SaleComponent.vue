<template>
    <section class="content">
        <div class="dashboard">
            <div class="row">
                <form role="form" @submit.prevent="newSaleStore()" @keydown="allErrors.clear($event.target.name)"
                    @keydown.enter.prevent.self>
                    <div>
                        <div class="col-lg-8 col-sm-7">
                            <div class="box box-primary none-border">
                                <div class="box-header with-border">
                                    <h3 class="box-title">{{ translatedTexts.New }} {{ translatedTexts.Sale }}</h3>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="phoneNumber">{{ translatedTexts.Phone }}
                                                {{ translatedTexts.Number }}</label>
                                            <div class="input-group">
                                                <input type="number" style="text-align: left" autocomplete="on"
                                                    name="customer.phone" v-model.trim="customer_phone"
                                                    placeholder="Enter Phone Number" class="form-control" />
                                                <span v-if="spinner.customer_spinner" class="input-group-addon"
                                                    style="text-align: center; font-size: 20px; color: #f50000">
                                                    <i class="fa fa-refresh fa-spin"></i>
                                                </span>
                                                <span v-else-if="spinner.customer_find"
                                                    class="input-group-addon text-green"><i class="fa fa-check"></i></span>
                                                <span v-else-if="spinner.customer_new"
                                                    class="input-group-addon text-black"><i class="fa fa-user"></i></span>
                                                <span v-else class="input-group-addon pointer" @click="getCustomer">
                                                    <i class="fa fa-search"></i>
                                                </span>
                                            </div>
                                            <span class="text-danger" v-if="allErrors.has('customer.phone')"
                                                v-text="allErrors.get('customer.phone')"></span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Name">{{ translatedTexts.Name }}</label>
                                            <input name="customer.name" type="text" class="form-control corner"
                                                style="text-align: left" v-model="customer.name" placeholder="Enter Name" />
                                            <span class="text-danger" v-if="allErrors.has('customer.name')"
                                                v-text="allErrors.get('customer.name')"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="address">{{ translatedTexts.Address }}</label>
                                            <textarea name="customer.address" type="text" class="form-control corner"
                                                style="text-align: left" v-model="customer.address"
                                                placeholder=" Enter Address">
                                            </textarea>
                                            <span class="text-danger" v-if="allErrors.has('customer.address')"
                                                v-text="allErrors.get('customer.address')"> </span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="address">{{ translatedTexts.Seller }}</label>
                                            <model-select :options="saleResource.seller_users" v-model="sale_info.seller_id"
                                                @input="allErrors.clear('seller_id')" name="seller_id"
                                                placeholder="Select Seller"></model-select>
                                            <span class="text-danger" v-if="allErrors.has('seller_id')"
                                                v-text="allErrors.get('seller_id')"> </span>
                                        </div>
                                    </div>
                                    <div v-if="pathaoDeliveryInfoShow">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="address">{{ translatedTexts.City }}</label>
                                                <model-select :options="pathaoCityList" v-model="pathao_info.recipient_city"
                                                    @input="getZoneList()" placeholder="Select City"></model-select>
                                                <span class="text-danger"
                                                    v-if="allErrors.has('pathao_info.recipient_city.city_id')"
                                                    v-text="allErrors.get('pathao_info.recipient_city.city_id')">
                                                </span>
                                                <span v-if="spinner.zone"
                                                    style="text-align: center; font-size: 14px; color: green">
                                                    <i class="fa fa-refresh fa-spin"></i>
                                                    {{ translatedTexts.Fetching }} {{ translatedTexts.Zone }}....
                                                </span>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="address">{{ translatedTextsZone }}</label>
                                                <model-select :options="pathaoZoneList" v-model="pathao_info.recipient_zone"
                                                    @input="getAreaList()" placeholder="Select Zone"></model-select>
                                                <span class="text-danger"
                                                    v-if="allErrors.has('pathao_info.recipient_zone.zone_id')"
                                                    v-text="allErrors.get('pathao_info.recipient_zone.zone_id')">
                                                </span>

                                                <span v-if="spinner.area"
                                                    style="text-align: center; font-size: 14px; color: green">
                                                    <i class="fa fa-refresh fa-spin"></i>
                                                    {{ translatedTextsFetching }} {{ translatedTextsArea }}....
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="address">{{ translatedTextsArea }}</label>
                                                <model-select :options="pathaoAreaList" v-model="pathao_info.recipient_area"
                                                    @input="allErrors.clear('pathao_info.recipient_area.area_id')"
                                                    placeholder="Select Area"></model-select>
                                                <span class="text-danger"
                                                    v-if="allErrors.has('pathao_info.recipient_area.area_id')"
                                                    v-text="allErrors.get('pathao_info.recipient_area.area_id')">
                                                </span>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="address">{{ translatedTextsPickup }}
                                                    {{ translatedTextsStore }}</label>
                                                <model-select :options="pathaoStoreList" v-model="pathao_info.store"
                                                    @input="allErrors.clear('pathao_info.store.store_id')"
                                                    placeholder="Select Store"></model-select>
                                                <span class="text-danger" v-if="allErrors.has('pathao_info.store.store_id')"
                                                    v-text="allErrors.get('pathao_info.store.store_id')"> </span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="address">{{ translatedTextsDelivery }}
                                                    {{ translatedTextsType }}</label>
                                                <model-select :options="deliveryType" v-model="pathao_info.delivery_type"
                                                    @input="allErrors.clear('pathao_info.delivery_type')"
                                                    placeholder="Select Delivery Type"></model-select>
                                                <span class="text-danger" v-if="allErrors.has('pathao_info.delivery_type')"
                                                    v-text="allErrors.get('pathao_info.delivery_type')"> </span>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="address">{{ translatedTextsItem }} {{ translatedTextsType }}</label>
                                                <model-select :options="itemType" v-model="pathao_info.item_type"
                                                    @input="allErrors.clear('pathao_info.item_type')"
                                                    placeholder="Select Item Type"></model-select>
                                                <span class="text-danger" v-if="allErrors.has('pathao_info.item_type')"
                                                    v-text="allErrors.get('pathao_info.item_type')"> </span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="Name">{{ translatedTextsItem }}
                                                    {{ translatedTextsQuantity }}</label>
                                                <input name="pathao_info.item_quantity" type="text" readonly
                                                    class="form-control corner" style="text-align: left"
                                                    :value="pathao_info.item_quantity" placeholder="Enter Item Quantity" />
                                                <span class="text-danger" v-if="allErrors.has('pathao_info.item_quantity')"
                                                    v-text="allErrors.get('pathao_info.item_quantity')"></span>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="Name">{{ translatedTextsItem }} {{ translatedTextsWeight }}</label>
                                                <input name="pathao_info.item_weight" type="number" step="0.01"
                                                    class="form-control corner" style="text-align: left"
                                                    v-model="pathao_info.item_weight" placeholder="Enter Item Weight" />
                                                <span class="text-danger" v-if="allErrors.has('pathao_info.item_weight')"
                                                    v-text="allErrors.get('pathao_info.item_weight')"></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="address">{{ translatedTextsSpecial }}
                                                    {{ translatedTextsinstruction }}</label>
                                                <textarea name="pathao_info.special_instruction" type="text"
                                                    class="form-control corner" style="text-align: left"
                                                    v-model="pathao_info.special_instruction"
                                                    placeholder=" Enter Special instruction">
                                                </textarea>
                                                <span class="text-danger"
                                                    v-if="allErrors.has('pathao_info.special_instruction')"
                                                    v-text="allErrors.get('pathao_info.special_instruction')">
                                                </span>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="address">{{ translatedTextsItem }}
                                                    {{ translatedTextsdescription }}</label>
                                                <textarea name="pathao_info.item_description" type="text"
                                                    class="form-control corner" style="text-align: left"
                                                    v-model="pathao_info.item_description"
                                                    placeholder="Enter Item description">
                                                </textarea>
                                                <span class="text-danger"
                                                    v-if="allErrors.has('pathao_info.item_description')"
                                                    v-text="allErrors.get('pathao_info.item_description')"> </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-if="winxDeliveryInfoShow">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="address">Location</label>
                                                <model-select :options="winxLocationList" v-model="winx_info.delivery_area"
                                                    placeholder="Select Location">
                                                </model-select>
                                                <span class="text-danger"
                                                    v-if="allErrors.has('winx_info.delivery_area.value')"
                                                    v-text="allErrors.get('winx_info.delivery_area.value')">
                                                </span>
                                                <span v-if="spinner.zone"
                                                    style="text-align: center; font-size: 14px; color: green">
                                                    <i class="fa fa-refresh fa-spin"></i>
                                                    Fetching Zone....
                                                </span>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="address">Pickup Store</label>
                                                <model-select :options="winxStoreList" v-model="winx_info.store"
                                                    @input="allErrors.clear('winx_info.store.value')"
                                                    placeholder="Select Store"></model-select>
                                                <span class="text-danger" v-if="allErrors.has('winx_info.store.value')"
                                                    v-text="allErrors.get('winx_info.store.value')"> </span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="address">Package</label>
                                                <model-select :options="winxPackageList" v-model="winx_info.package"
                                                    placeholder="Select Package">
                                                </model-select>
                                                <span class="text-danger" v-if="allErrors.has('winx_info.package')"
                                                    v-text="allErrors.get('winx_info.package')">
                                                </span>
                                                <span v-if="spinner.zone"
                                                    style="text-align: center; font-size: 14px; color: green">
                                                    <i class="fa fa-refresh fa-spin"></i>
                                                    Fetching Zone....
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6" v-if="sale_info.offerOption !== true">
                                            <label for="Product">Product</label>
                                            <input type="text" class="form-control corner" @keyup.enter="getProduct()"
                                                v-model.trim="product_barcode" placeholder="Enter product barcode" />
                                            <span v-if="spinner.product"
                                                style="text-align: center; font-size: 16px; color: green"> <i
                                                    class="fa fa-refresh fa-spin"></i> Checking.... </span>
                                        </div>
                                        <!-- <div class="form-group col-md-2 selectBoxmargin">
											<input id="deliveryOption" type="checkbox" @input="checkDeliveryOption($event)" v-model="sale_info.deliveryOption" />
											<label for="deliveryOption">Option</label>
										</div> -->
                                        <div class="form-group col-md-4 selectBoxmargin2"
                                            v-if="sale_info.deliveryOption === true">
                                            <model-select :options="saleResource.deliveryMan"
                                                v-model="sale_info.delivery_man"
                                                placeholder="Select Delivery Man"></model-select>
                                            <span v-if="spinner.deliveryLoad"
                                                style="text-align: center; font-size: 14px; color: green">
                                                <i class="fa fa-refresh fa-spin"></i>
                                                Fetching {{ sale_info.delivery_man.name }} ....
                                            </span>
                                            <span v-if="spinner.priceCalculation"
                                                style="text-align: center; font-size: 14px; color: green">
                                                <i class="fa fa-refresh fa-spin"></i>
                                                Price calculation for {{ sale_info.delivery_man.name }}
                                            </span>
                                            <!--                                            <div class="form-group " style="margin-top: 5px">-->
                                            <!--                                                <input id="is_inside_dhaka" type="checkbox"-->
                                            <!--                                                       v-model="sale_info.is_inside_dhaka"/>-->
                                            <!--                                                    <label for="is_inside_dhaka">Inside Dhaka</label>-->
                                            <!--                                            </div>-->
                                        </div>
                                    </div>
                                    <!-- <div class=" form-group row">
										<div class="col-md-2">
											<input id="offerOption" type="checkbox" @input="checkOfferOption($event)" v-model="sale_info.offerOption" />
											<label for="offerOption">Offer</label>
										</div>
										<div class="col-md-10" v-if="sale_info.offerOption === true">
											<div class="col-md-6">
												<select class="form-control" v-model="offer_type" @change="getOfferList(offer_type)">
													<option :value="{}" selected>Select Offer Type</option>
													<option v-for="(offer_type, index) in saleResource.offers" :value="offer_type.value" :key="index">
														{{ offer_type.text }}
													</option>
												</select>
											</div>
											<div class="col-md-6">
												<select class="form-control" v-model="offer">
													<option :value="{}" selected>Select Offer</option>
													<option v-for="(offer, index) in offerList" :value="offer.id" :key="index">
														{{ offer.title }}
													</option>
												</select>
											</div>
											                                                <div style="margin: auto">
											                                                    <i v-if="index === 0" @click="addMoreOffer"
											                                                       style="font-size: 16px"
											                                                       class="fa fa-plus-circle text-green pointer"></i>
											                                                    <i v-if="index !== 0" @click="saleOffers.splice(index, 1)"
											                                                       style="font-size: 16px"
											                                                       class="fa fa-times-circle text-red pointer"></i>
											                                                </div>
										</div>
									</div> -->
                                    <div v-if="sale_info.offerOption === true" class="form-group row">
                                        <div class="form-group col-md-4">
                                            <label for="Product">Product</label>
                                            <input type="text" class="form-control corner" @keyup.enter="getOfferProduct()"
                                                v-model.trim="offer_product_barcode" placeholder="Enter product barcode" />
                                            <span v-if="spinner.offerProduct"
                                                style="text-align: center; font-size: 16px; color: green"> <i
                                                    class="fa fa-refresh fa-spin"></i> Checking.... </span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="Product">Combo Code</label>
                                            <input v-model="combo_code" class="form-control corner"
                                                placeholder="Place your Combo Code here" type="text"
                                                @keyup.enter="getOfferProduct()" />
                                            <span v-if="spinner.product"
                                                style="text-align: center; font-size: 16px; color: green">
                                                <i class="fa fa-refresh fa-spin"></i> Checking....
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="Product">Details</label>
                                            <div class="table-outline">
                                                <table class="table table-striped " >
                                                    <thead class="table-head">
                                                        <tr>
                                                            <th>S.N</th>
                                                            <th>Product Name</th>
                                                            <th class="text-right">In Stock</th>
                                                            <!--                                                        <th class="text-right">In Offer</th>-->
                                                            <th class="text-right">Unite Price</th>
                                                            <th style="width: 15%">Quantity</th>
                                                            <th class="text-right">Price</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="table-info" v-for="(sale_product, index) in saleProducts"
                                                            :key="index">
                                                            <td>{{ index + 1 }}.</td>
                                                            <td>
                                                                <div style="display: grid">
                                                                    <span>{{ sale_product.product_name }}</span>
                                                                    <span class="text-warning"
                                                                        v-if="sale_product.offer_name !== null">{{
                                                                            sale_product.offer_name }} Offer Added</span>
                                                                    <!--                                                                <span class="text-warning"  v-if="sale_product.discount_amount !== null">{{ sale_product.discount_amount }} </span>-->
                                                                    <span class="text-danger"
                                                                        v-if="sale_product.available_stock < 1">Product
                                                                        Stock Out</span>
                                                                    <span class="text-danger"
                                                                        v-else-if="sale_product.available_stock < sale_product.quantity">
                                                                        Available Stock {{
                                                                            sale_product.available_stock
                                                                        }}
                                                                    </span>
                                                                </div>
                                                            </td>
                                                            <td class="text-right">{{ sale_product.available_stock }} Pcs
                                                            </td>
                                                            <!--                                                        <td class="text-right">{{ sale_product.available_in_offer }} Pcs-->
                                                            <!--                                                        </td>-->
                                                            <td class="text-right">{{
                                                                sale_product.product_sell_price
                                                            }}
                                                            </td>
                                                            <td>
                                                                <input type="number"
                                                                    @input="quantityInput(index, sale_product)"
                                                                    class="sale-quantity"
                                                                    v-model.number="sale_product.quantity" />
                                                            </td>
                                                            <td class="text-right">{{ sale_product.total_price }}</td>
                                                            <td class="pointer" style="margin-bottom: 2px">
                                                                <span @click="saleProducts.splice(index, 1)">
                                                                    <i style="font-size: 16px"
                                                                        class="fa fa-times-circle text-red"></i>
                                                                </span>
                                                                <span @click="quantityUpdate(index, sale_product)">
                                                                    <i style="font-size: 16px"
                                                                        class="fa fa-plus-circle text-green"></i>
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
                                                    <div class="col-md-10 text-right"
                                                        style="display: flex; justify-content: end">Delivery Charge
                                                    </div>
                                                    <div class="col-md-2 text-right">
                                                        {{ totalCalculation.delivery_charge }}
                                                    </div>
                                                </div>
                                                <div class="row" style="width: 96%" v-if="additionalDeliveryCharge > 0">
                                                    <div class="col-md-10 text-right"
                                                        style="display: flex; justify-content: end">Additional Delivery
                                                        Charge
                                                    </div>
                                                    <div class="col-md-2 text-right">
                                                        {{ additionalDeliveryCharge }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" style="width: 96%">
                                                <div class="col-md-10 text-right">Additional Charge</div>
                                                <div class="col-md-2 text-right">
                                                    <input style="text-align: right; margin-left: -28px; width: 68%"
                                                        @input="additionalInputCharge" type="number" class="vat" min="0"
                                                        step="0.01" v-model.number="sale_info.additional_charge" />
                                                </div>
                                            </div>
                                            <div class="row" style="width: 96%">
                                                <div class="col-md-10 text-right"
                                                    style="display: flex; justify-content: end">
                                                    Discount (<input style="width: 10%" min="0" max="100" step="0.01"
                                                        type="number" class="vat" v-model="discount_percentage" /> %)
                                                </div>
                                                <div class="col-md-2 text-right">{{
                                                    totalCalculation.discount_amount
                                                }}
                                                </div>
                                            </div>
                                            <div class="row" style="width: 96%">
                                                <div class="col-md-10 text-right"
                                                    style="display: flex; justify-content: end">
                                                    Vat (<input style="width: 10%" type="number" min="0" max="100"
                                                        step="0.01" class="vat" v-model.number="vat_percentage" /> %)
                                                </div>
                                                <div class="col-md-2 text-right">{{ totalCalculation.vat_amount }}</div>
                                            </div>
                                            <div class="row" style="width: 96%">
                                                <div class="col-md-6"></div>
                                                <div class="col-md-6">
                                                    <hr
                                                        style="margin-top: 5px; margin-bottom: 5px; border: 0; border-top: 1px solid #000000" />
                                                </div>
                                            </div>
                                            <div class="row" style="width: 96%">
                                                <div class="col-md-10 text-right">Total Amount</div>
                                                <div class="col-md-2 text-right">{{
                                                    totalCalculation.total_amount
                                                }}
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
                            <hr style="margin-top: 20px; margin-bottom: 20px; border: 0; border-top: 2px solid #7c34db" />
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row" style="display: flex; justify-content: space-between">
                                        <div class="col-md-3" style="display: flex; justify-content: space-between">
                                            <div>
                                                <div>Total Paid Amount</div>
                                                <div>
                                                    {{ totalCalculation.sale_net_total }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="multiple-payment" v-for="(sale_payment, index) in salePayments"
                                                :key="index">
                                                <div class="col-md-6">
                                                    <label v-if="index === 0">Payment Method</label>
                                                    <select
                                                        @input="allErrors.clear(`sale_payments.${index}.payment_method.value`)"
                                                        @change="(sale_payment.payment_reference = ''), (sale_payment.pay_amount = '')"
                                                        class="form-control" v-model="sale_payment.payment_method">
                                                        <option :value="{}" selected>Select Payment Method</option>
                                                        <option
                                                            v-for="(payment_method, index) in saleResource.paymentMethod"
                                                            :value="payment_method"
                                                            :disabled="!sale_info.deliveryOption && payment_method.text === 'COD'"
                                                            :key="index">
                                                            {{ payment_method.text }}
                                                        </option>
                                                    </select>
                                                    <span class="text-danger"
                                                        v-if="allErrors.has(`sale_payments.${index}.payment_method.value`)"
                                                        v-text="allErrors.get(`sale_payments.${index}.payment_method.value`)">
                                                    </span>
                                                </div>
                                                <div class="text-right col-md-6"
                                                    v-if="sale_payment.payment_method && sale_payment.payment_method.reference_status == 1">
                                                    <label v-if="index === 0">Payment Reference</label>
                                                    <input :name="`sale_payments.${index}.payment_reference`" type="text"
                                                        v-model="sale_payment.payment_reference" class="paid-input" />
                                                    <span class="text-danger"
                                                        v-if="allErrors.has(`sale_payments.${index}.payment_reference`)"
                                                        v-text="allErrors.get(`sale_payments.${index}.payment_reference`)">
                                                    </span>
                                                </div>
                                                <div class="text-center col-md-6">
                                                    <label v-if="index === 0">Pay Amount</label>
                                                    <input :name="`sale_payments.${index}.pay_amount`" type="number" min="0"
                                                        step="0.01" @input="onlyNumber(sale_payment)"
                                                        v-model.number="sale_payment.pay_amount" class="paid-input" />
                                                    <span class="text-danger"
                                                        v-if="allErrors.has(`sale_payments.${index}.pay_amount`)"
                                                        v-text="allErrors.get(`sale_payments.${index}.pay_amount`)">
                                                    </span>
                                                </div>
                                                <div style="margin: auto">
                                                    <i v-if="index === 0" @click="addMorePayment" style="font-size: 16px"
                                                        class="fa fa-plus-circle text-green pointer"></i>
                                                    <i v-if="index !== 0" @click="salePayments.splice(index, 1)"
                                                        style="font-size: 16px"
                                                        class="fa fa-times-circle text-red pointer"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-10 text-right text-red">Due</div>
                                        <div class="col-md-2 text-red text-right">{{ totalCalculation.due_total }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-10 text-right">Discount</div>
                                        <div class="col-md-2 text-right">
                                            <input style="text-align: right; margin-left: -28px; width: 68%" type="number"
                                                class="vat" min="0" step="0.01" v-model.number="flat_discount" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-10 text-right text-blue">Change Amount</div>
                                        <div class="col-md-2 text-blue text-right">{{
                                            totalCalculation.change_amount
                                        }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-5">
                            <div class="box box-primary none-border">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Showing Bill</h3>
                                </div>
                                <div class="ticket invoice invoice-font invoice-border">
                                    <div class="text-center">
                                        <!-- <img class="image" src="/images/sale_print.png" alt="" /> -->

                                    </div>
                                    <p class="centered">
                                        <br />
                                        <strong>
                                            {{ saleResource.user.branch.address }}
                                        </strong>
                                    </p>
                                    <div class="row" style="margin-bottom: 7px"
                                        v-if="saleResource.user.branch.name !== 'ONLINE BRANCH'">
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
                                            {{ saleResource.date }}
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

                                    <div class="row" v-if="Object.keys(sale_info.delivery_man).length > 0">
                                        <div class="col-md-12 text-left">
                                            Delivery :
                                            {{ sale_info.delivery_man.name }}
                                        </div>
                                    </div>
                                    <br />

                                    <table style="width: 100%">
                                        <tbody>
                                            <tr style="border-bottom: 1px dashed black; border-collapse: collapse"
                                                v-for="(sale_product, index) in saleProducts" :key="index">
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
                                        <!--                                        <thead>-->
                                        <!--                                        <tr>-->
                                        <!--                                            <th class="mrp"><u>Bkash</u></th>-->
                                        <!--                                            <th class="description">Amount</th>-->
                                        <!--                                            <th class="price">{{ totalCalculation.product_total.toLocaleString() }}</th>-->
                                        <!--                                        </tr>-->
                                        <!--                                        </thead>-->
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
                                                    <p class="left">{{
                                                        totalCalculation.product_total.toLocaleString()
                                                    }}</p>
                                                    <p class="left">{{ totalCalculation.vat_amount }}</p>
                                                    <p v-if="totalCalculation.delivery_charge > 0" class="left">
                                                        {{ total_delivery_charge }}
                                                    </p>
                                                    <p v-if="totalCalculation.additional_charge > 0" class="left">
                                                        {{ totalCalculation.additional_charge }}
                                                    </p>
                                                    <p class="left">{{ totalCalculation.total_amount_with_vat }}</p>
                                                    <p class="left">{{ totalCalculation.total_discount }}</p>
                                                    <p class="left">{{ totalCalculation.sale_net_total }}</p>
                                                    <p class="left">{{ totalCalculation.pay_amount }}</p>
                                                    <p class="left">{{ totalCalculation.due_total }}</p>
                                                    <p class="left">{{ totalCalculation.change_amount }}</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="footer">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <barcode :width="1.5" :height="50" v-bind:value="sale_info.invoice_code">
                                                    {{ sale_info.invoice_code }}
                                                </barcode>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <span class="centered" v-html="saleResource.settings.sale_footer"
                                                    style="font-size: 8px;    white-space: pre-line;"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="padding: 30px">
                                <div class="col-md-12" style="text-align: -webkit-center">
                                    <button type="submit" class="hidden-print btn btn-success btn-sm btn-block">Confirm
                                        Order
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>
<script>
import Errors from "../../helper/errors";
import collect from "collect.js";
import VueBarcode from "vue-barcode";
import Translate from "../../helper/translate";

export default {
    props: ["saleResource"],
    components: {
        barcode: VueBarcode,
    },
    data() {
        return {
            translator: new Translate(),
            translatedTexts: {},
            customer_phone: "",
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
                offer: false,
                offerProduct: false,
            },
            isLoading: false,
            sale_info: {
                invoice_code: this.saleResource.invoice_code,
                seller_id: this.saleResource.user.id,
                delivery_man: {},
                deliveryOption: false,
                offerOption: false,
                is_inside_dhaka: false,
                additional_charge: 0,
            },
            salePayments: [],
            saleOffers: [],
            vat_percentage: Number(this.saleResource.settings.vat_percentage),
            discount_percentage: 0,
            flat_discount: 0,
            saleProducts: [],
            defaultPaymentFormat: {
                payment_method: {},
                pay_amount: "",
                payment_number: "",
                payment_reference: "",
            },
            // defaultOfferFormat: {
            // offer_type: {},
            // offer: {},
            // },
            pathaoCityList: [],
            pathaoZoneList: [],
            pathaoAreaList: [],
            pathaoStoreList: [],
            winxStoreList: [],
            winxLocationList: [],
            winxPackageList: [],
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
            winx_info: {
                store: {},
                recipient_name: "",
                recipient_phone: "",
                recipient_address: "",
                package: {},
                delivery_area: {},
                sale_price: "",
                cod: "",
                insurance: "",
                merchant_invoice: "",
            },
            total_delivery_charge: 0,
            offer_type: {},
            offer: {},
            offer_product_barcode: "",
            combo_code: "",
            offerList: [],
        };
    },
    watch: {
        customer_phone() {
            if (this.customer_phone.length < 1) {
                this.spinner.customer_spinner = false;
                this.spinner.customer_new = false;
                this.spinner.customer_find = false;
                this.formReset(this.customer);
                return;
            }
            this.spinner.customer_spinner = true;
            if (this.customer_phone.length > 10) {
                this.getCustomer();
            }
        },
        "sale_info.delivery_man"() {
            if (this.sale_info.delivery_man.name === "Pathao") {
                this.getPathaoCityStore();
                this.sale_info.delivery_man.delivery_charge = 0;
                let findCod = collect(this.saleResource.paymentMethod)
                    .where("text", "COD")
                    .first();
                if (findCod) {
                    this.salePayments[0].payment_method = findCod;
                    this.salePayments[0].pay_amount = "";
                    this.salePayments[0].payment_number = "";
                    this.salePayments[0].payment_reference = "";
                }
            }
            if (this.sale_info.delivery_man.name === "Winx") {
                this.getWinxLocationStorePackage();
                this.sale_info.delivery_man.delivery_charge = 0;
                let findCod = collect(this.saleResource.paymentMethod)
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
        "winx_info.delivery_area"() {
            this.getWinxDeliveryPrice();
        },
        "winx_info.package"() {
            this.getWinxDeliveryPrice();
        },
        totalQuantity() {
            this.pathao_info.item_quantity = this.totalQuantity;
        },
        discount_percentage() {
            if (this.discount_percentage > 100) {
                toastr.error("Discount percentage can't be greeter then 100");
                this.discount_percentage = 0;
                return false;
            }
        },
    },
    created() {
        this.translateData(); // Call the translateData method during component creation
    },
    methods: {
        async translateData() {
            try {
                const keys = ["Paid", "Due", "New", "Sale", "Phone", "Number", "Name", "Address", "Seller", "City", "Fetching", "Zone", "Area", "Pickup", "Store", "Delivery", "Type", "Item", "Quantity", "Weight", "Special", "Instruction", "Description", "Location", "Package", "Product", "Checking", "Price calculation for", "Combo", "Code", "Details", "Name", "In", "Stock", "Unite", "Price", "Offer", "Added", "Out", "Available", "Pcs", "Total", "pcs", "Delivery Charge", "Additional Charge", "Discount", "Total Amount", "Payment", "Method", "Select", "Reference", "Pay", "Amount", "Change", "Showing", "Bill", "Vat"]; // Array of keys to be translated
                const translatedData = await this.translator.translate(keys);
                this.translatedTexts = translatedData;
            } catch (error) {
                console.error(error);
            }
        },
        newSaleStore() {
            const _this = this;
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
                customer: this.customer,
                sale_payments: this.salePayments,
                additional_delivery_charge: this.additionalDeliveryCharge,
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
            if (this.sale_info.delivery_man.name === "Winx") {
                this.winx_info.recipient_name = this.customer.name;
                this.winx_info.recipient_phone = this.customer.phone;
                this.winx_info.recipient_address = this.customer.address;
                this.winx_info.amount_to_collect = parseInt(
                    this.totalCalculation.sale_net_total
                );
                form.winx_info = this.winx_info;
            }
            axios
                .post(route("sales.store"), form)
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
                        toastr.success("New Sale successfully");
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
        getCustomer: _.debounce(function () {
            this.customer.phone = this.customer_phone;
            if (this.customer_phone.length < 1) {
                this.spinner.customer_spinner = false;
                this.spinner.customer_new = false;
                this.spinner.customer_find = false;
                return true;
            }
            axios
                .post(route("sale-customer-search"), {
                    customer_phone: this.customer_phone,
                })
                .then((response) => {
                    if (response.data.result !== null) {
                        this.customer = response.data.result;
                        this.spinner.customer_spinner = false;
                        this.spinner.customer_new = false;
                        this.spinner.customer_find = true;
                        this.allErrors.clear("customer.phone");
                        this.allErrors.clear("customer.name");
                        this.allErrors.clear("customer.address");
                        toastr.success(response.data.message);
                    } else {
                        this.formReset(this.customer);
                        this.spinner.customer_spinner = false;
                        this.spinner.customer_new = true;
                        this.spinner.customer_find = false;
                        this.customer.phone = this.customer_phone;
                    }
                })
                .catch((error) => {
                    this.formReset(this.customer);
                    this.spinner.customer_spinner = false;
                    this.spinner.customer_new = false;
                    this.spinner.customer_find = false;
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
                    this.product_barcode &&
                    this.saleProducts[key].offer_id === null
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
                                .where("available_in_offer", "===", 0)
                                .first();
                            for (const key in this.saleProducts) {
                                if (
                                    this.saleProducts[key].product_barcode ===
                                    this.product_barcode &&
                                    this.saleProducts[key].offer_id === null
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
        getOfferProduct: _.debounce(function () {
            // if (this.offer_product_barcode.length < 1 && this.offer_type !== '' && this.offer !== '' || this.offer_type !== '' && this.offer !== '' && this.combo_code !== '') {
            //     return true;
            // }
            this.spinner.offerProduct = true;
            for (const key in this.saleProducts) {
                if (
                    this.saleProducts[key].product_barcode ===
                    this.offer_product_barcode &&
                    this.saleProducts[key].offer_id !== null
                ) {
                    if (
                        this.saleProducts[key].available_in_offer <=
                        this.saleProducts[key].quantity
                    ) {
                        toastr.warning(
                            this.saleProducts[key].product_name +
                            " Available In Offer " +
                            this.saleProducts[key].available_in_offer
                        );
                        this.offer_product_barcode = "";
                        this.offer_type = {};
                        this.offer = {};
                        this.spinner.offerProduct = false;
                        return;
                    }
                }
            }
            axios
                .post(route("sale-offer-product-add"), {
                    offer_type: this.offer_type,
                    offer: this.offer,
                    combo_code: this.combo_code,
                    product_barcode: this.offer_product_barcode,
                })
                .then((response) => {
                    if (response.data.status === 200) {
                        const result = response.data.result;
                        if (result.length > 1) {
                            for (const key in result) {
                                if (this.saleProducts.length < 1) {
                                    this.saleProducts.push(result[key]);
                                } else {
                                    const barcodeProduct = collect(
                                        this.saleProducts
                                    )
                                        .where(
                                            "product_barcode",
                                            result[key].product_barcode
                                        )
                                        .where("offer_id", "!==", null)
                                        .first();
                                    for (const key in this.saleProducts) {
                                        if (
                                            this.saleProducts[key]
                                                .product_barcode ===
                                            this.offer_product_barcode &&
                                            this.saleProducts[key]
                                                .available_in_offer >=
                                            this.saleProducts[key].quantity
                                        ) {
                                            this.saleProducts[
                                                key
                                            ].quantity += 1;
                                            this.quantityInput(
                                                key,
                                                this.saleProducts[key]
                                            );
                                        }
                                    }
                                    if (barcodeProduct) {
                                        barcodeProduct.available_in_offer =
                                            result[key].available_in_offer;
                                    } else {
                                        this.saleProducts.unshift(result[key]);
                                    }
                                }
                            }
                        } else {
                            if (this.saleProducts.length < 1) {
                                this.saleProducts.push(result);
                            } else {
                                const barcodeProduct = collect(
                                    this.saleProducts
                                )
                                    .where(
                                        "product_barcode",
                                        result.product_barcode
                                    )
                                    .where("offer_id", "!==", null)
                                    .first();
                                for (const key in this.saleProducts) {
                                    if (
                                        this.saleProducts[key]
                                            .product_barcode ===
                                        this.offer_product_barcode &&
                                        this.saleProducts[key]
                                            .available_in_offer >=
                                        this.saleProducts[key].quantity
                                    ) {
                                        this.saleProducts[key].quantity += 1;
                                        this.quantityInput(
                                            key,
                                            this.saleProducts[key]
                                        );
                                    }
                                }
                                if (barcodeProduct) {
                                    barcodeProduct.available_in_offer =
                                        result.available_in_offer;
                                } else {
                                    this.saleProducts.unshift(result);
                                }
                            }
                        }
                        // if (this.saleProducts.length < 1) {
                        //     this.saleProducts.push(result);
                        // } else {
                        //     const barcodeProduct = collect(this.saleProducts)
                        //         .where("product_barcode", result.product_barcode).where("offer_id", "!==", null)
                        //         .first();
                        //     for (const key in this.saleProducts) {
                        //         if (this.saleProducts[key].product_barcode === this.offer_product_barcode && this.saleProducts[key].available_in_offer >= this.saleProducts[key].quantity) {
                        //             this.saleProducts[key].quantity += 1;
                        //             this.quantityInput(key, this.saleProducts[key]);
                        //         }
                        //     }
                        //     if (barcodeProduct) {
                        //         barcodeProduct.available_in_offer = result.available_in_offer;
                        //     } else {
                        //         this.saleProducts.unshift(result);
                        //     }
                        // }
                        this.offer_product_barcode = "";
                        this.combo_code = "";
                        this.offer_type = {};
                        this.offer = {};
                        this.spinner.offerProduct = false;
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
                    this.spinner.offerProduct = false;
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
        checkDeliveryOption(event) {
            if (this.customer_phone.length <= 0) {
                toastr.error("Customer required");
                event.target.checked = false;
                this.sale_info.deliveryOption = false;
            }
            this.sale_info.delivery_man = {};
            this.salePayments.map(function (key, index) {
                if (key.payment_method.text === "COD") {
                    key.payment_method = {};
                    key.pay_amount = "";
                    key.payment_reference = "";
                }
            });
        },
        checkOfferOption(event) {
            if (this.customer_phone.length <= 0) {
                toastr.error("Customer required");
                event.target.checked = false;
                this.sale_info.offerOption = false;
            }
        },
        addMorePayment() {
            if (
                this.salePayments.length <
                this.saleResource.paymentMethod.length
            ) {
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
                .catch((error) => { });
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
                .catch((error) => { });
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
        getWinxLocationStorePackage() {
            this.spinner.deliveryLoad = true;
            Promise.all([
                axios.get(route("winx-location")),
                axios.get(route("winx-store")),
                axios.get(route("winx-package")),
            ]).then((res) => {
                if (
                    res[0].data.result &&
                    res[1].data.result &&
                    res[2].data.result
                ) {
                    this.winxLocationList = res[0].data.result;
                    this.winxStoreList = res[1].data.result;
                    this.winxPackageList = res[2].data.result;
                    this.spinner.deliveryLoad = false;
                } else {
                    toastr.error("Something went wrong");
                }
            });
        },
        getWinxDeliveryPrice: _.debounce(async function () {
            if (
                !Object.keys(this.winx_info.store).length &&
                Object.keys(this.winx_info.delivery_area).length &&
                !Object.keys(this.winx_info.package).length
            ) {
                return;
            }

            this.spinner.priceCalculation = true;
            if (this.winx_info.delivery_area.inside_city !== 0) {
                this.sale_info.delivery_man.delivery_charge =
                    this.winx_info.package.inside_city;
            }
            if (this.winx_info.delivery_area.sub_city !== 0) {
                this.sale_info.delivery_man.delivery_charge =
                    this.winx_info.package.sub_city;
            }
            if (this.winx_info.delivery_area.inter_district !== 0) {
                this.sale_info.delivery_man.delivery_charge =
                    this.winx_info.package.inter_district;
            }
            this.spinner.priceCalculation = false;
            this.allErrors.allClear();
        }, 500),
        additionalInputCharge() {
            if (this.sale_info.additional_charge <= 0) {
                this.sale_info.additional_charge = 0;
            }
        },
        getOfferList(offer_type) {
            this.spinner.offer = true;
            axios
                .post(route("offer-list"), { offer_type: offer_type })
                .then((response) => {
                    toastr.success(response.data.message);
                    this.offerList = response.data.result;
                    this.spinner.offer = false;
                })
                .catch((error) => {
                    toastr.error(error.response.data.message);
                });
        },
    },
    mounted() {
        this.salePayments = [{ ...this.defaultPaymentFormat }];
        // this.saleOffers = [{...this.defaultOfferFormat}];
    },
    computed: {
        totalCalculation() {
            let deliveryCharge = 0;
            let changeAmount = 0;
            let dueTotal = 0;
            let flat_discount = 0;
            let discount_percentage = 0;
            let vat_percentage = 0;
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
            if (this.discount_percentage > 0) {
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
            if (pay_amount > saleNetTotal) {
                changeAmount = pay_amount - saleNetTotal;
            }
            let totalDiscount = discountAmount;
            totalDiscount = discountAmount + flat_discount;

            if (pay_amount < saleNetTotal) {
                dueTotal = saleNetTotal - pay_amount;
            }
            if (dueTotal < 1) {
                this.allErrors.clear("due_total");
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
                        this.saleResource.settings.inside_dhaka_charge
                    ) {
                        additionalDeliveryCharge =
                            parseFloat(
                                this.saleResource.settings.inside_dhaka_charge
                            ) -
                            parseFloat(
                                this.sale_info.delivery_man.delivery_charge
                            );
                    }
                } else {
                    if (
                        this.sale_info.delivery_man.delivery_charge <
                        this.saleResource.settings.outside_dhaka_charge
                    ) {
                        additionalDeliveryCharge =
                            parseFloat(
                                this.saleResource.settings.outside_dhaka_charge
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
        pathaoDeliveryInfoShow() {
            return (
                this.sale_info.deliveryOption === true &&
                this.sale_info.delivery_man &&
                this.sale_info.delivery_man.name === "Pathao" &&
                !this.spinner.deliveryLoad
            );
        },
        winxDeliveryInfoShow() {
            return (
                this.sale_info.deliveryOption === true &&
                this.sale_info.delivery_man &&
                this.sale_info.delivery_man.name === "Winx" &&
                !this.spinner.deliveryLoad
            );
        },
        totalQuantity() {
            return this.saleProducts.reduce(
                (total, current) => total + current.quantity,
                0
            );
        },
    },
};
</script>

<style>
.ticket {
    width: 100%;
    margin: 0px;
    padding-right: 10px;
}
form{
    background: none!important;
}
.table-outline{
    overflow-x: auto;
}
</style>
