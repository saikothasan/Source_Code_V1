<template>
	<div class="content ">
		<form @submit.prevent="productStore()" @keydown="allErrors.clear($event.target.name)">
			<div class="custom-box ">
				<div class="box-body" :class="{'pointer-events': isLoading }">
					<h4 class="text-center text-bold" style="padding-bottom: 20px;">Add Product Information</h4>
					<div class="row div-center ">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<div class="form-group">
									<label for="supplier_id">Supplier</label>
									<model-select :options="suppliers" v-model="product.supplier_id" :isDisabled="supplier_disable || product.total_stock > 0" @input="allErrors.clear('supplier_id')" name="supplier_id" placeholder="Select Supplier"></model-select>
									<span class="text-danger" v-if="allErrors.has('supplier_id')" v-text="allErrors.get('supplier_id')">
									</span>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<div class="form-group">
									<label for="category_id">Category</label>
									<model-select :options="categories" v-model="product.category_id" :isDisabled="product.total_stock > 0" @input="allErrors.clear('category_id')" name="category_id" placeholder="Select Category"></model-select>
									<span class="text-danger" v-if="allErrors.has('category_id')" v-text="allErrors.get('category_id')">
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="row div-center ">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<div class="form-group">
									<label for="productName">Product Name</label>
									<input @input="product.product_slug=product.name" type="text" class="form-control" id="productName" v-model="product.name" name="name" placeholder="Enter product name">
									<span class="text-danger" v-if="allErrors.has('name')" v-text="allErrors.get('name')">
									</span>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<div class="form-group">
									<label for="brand_id">Brand</label>
									<model-select :options="brands" v-model="product.brand_id" @input="allErrors.clear('brand_id')" placeholder="Select Brand"></model-select>
									<span class="text-danger" v-if="allErrors.has('brand_id')" v-text="allErrors.get('brand_id')">
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="row div-center ">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<div class="form-group">
									<label for="buy_price">Buy Price</label>
									<div class="input-group">
										<div class="input-group-addon">
											BDT
										</div>
										<input id="buy_price" type="number" name="buy_price" min="0" v-model="product.buy_price" placeholder="Enter Buy Price" class="form-control">

									</div>
									<span class="text-danger" v-if="allErrors.has('buy_price')" v-text="allErrors.get('buy_price')">
									</span>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<div class="form-group">
									<label for="sell_price">Sell Price</label>
									<div class="input-group">
										<div class="input-group-addon">
											BDT
										</div>
										<input type="number" min="0" name="sell_price" id="sell_price" v-model="product.sell_price" placeholder="Enter Sell Price" class="form-control">

									</div>
									<span class="text-danger" v-if="allErrors.has('sell_price')" v-text="allErrors.get('sell_price')">
									</span>
								</div>
							</div>
						</div>

					</div>
					<div class="text-center" v-if="marginProfit">
						<span :class="marginProfit.profit < 0 ? 'text-danger'  : 'text-success'"> Margin : {{
                                marginProfit.margin
                            }} % &nbsp;&nbsp; &nbsp;&nbsp;Profit : BDT {{
                                marginProfit.profit
                            }}/-</span>
					</div>
					<div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label for="description">Description</label>
								<textarea id="description" name="description" placeholder="Enter description" class="form-control"></textarea>
								<span class="text-danger" v-if="allErrors.has('description')" v-text="allErrors.get('description')">
								</span>
							</div>
						</div>
					</div>
				</div>

			</div>
			<div class="custom-box " style="margin-top: 20px">
				<div class="box-body">
					<h4 class="text-center  text-bold" style="padding-bottom: 15px;">Inventory</h4>
					<div class="row div-center ">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<div class="form-group">
									<label for="product_sku">SKU</label>
									<input type="text" class="form-control" maxlength="10" name="product_sku" id="product_sku" v-model="product.product_sku" placeholder="Enter sku" readonly>
									<span class="text-danger" v-if="allErrors.has('product_sku')" v-text="allErrors.get('product_sku')">
									</span>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<div class="form-group">
									<label for="product_code">Barcode</label>
									<input type="text" maxlength="8" v-model="product.product_code" class="form-control" id="product_code" name="product_code" placeholder="Enter barcode" readonly>
									<span class="text-danger" v-if="allErrors.has('product_code')" v-text="allErrors.get('product_code')">
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="custom-box " style="margin-top: 20px">
				<div class="box-body">
					<h4 class="text-left  text-bold" style="padding-bottom: 15px;">Options</h4>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-check">
							<input :disabled="product.total_stock > 0" @input="checkedOption($event)" class="form-check-input" type="checkbox" v-model="product_options" id="optionsChecked" checked>
							<label class="form-check-label" for="optionsChecked" style="margin-left: 10px;display: contents;">
								This product has options, like size or color
							</label>
						</div>
					</div>
				</div>
				<div v-if="product_options">
					<div class="box-body option-hr" v-for="(option , index) in variationOptions" :key="index">
						<!--                     Option Items-->
						<div class="row div-center" v-if="!option.editOption">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="col-lg-11 col-md-11 col-sm-12 col-xs-12">
										<div class="form-group ">
											<label class="control-label">{{ option.optionName.text }}</label>
											<div class="option-items">
												<span v-for="valueName in option.optionValues" class="option-badge">
													<span>
														{{ valueName.text }}
													</span>
												</span>
											</div>
										</div>
									</div>
									<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
										<div class="form-group option-delete-icon" style="display: flex">
											<i class="fa fa-edit pointer" style="margin-right: 20px;" @click="option.editOption=true"></i>
											<i v-if="product.total_stock <=0" @click="optionRemove(index)" class="fa fa-trash pointer"></i>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--                    Option Items-->
						<div class="row div-center " v-if="option.editOption">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="col-lg-11 col-md-11 col-sm-12 col-xs-12">
										<div class="form-group">
											<label>Option name</label>
											<model-select :options="variations" :isDisabled="!option.delete_show" @input="optionChange(index,option,option.optionName)" v-model="option.optionName" placeholder="Select Option"></model-select>
											<span class="text-danger" v-show="Object.values(option.optionName).length < 1 && !option.option_error">
												Option name is required
											</span>
											<span class="text-danger" v-show="option.option_error">
												{{ option.option_error }}
											</span>
										</div>
									</div>
									<div v-if="option.delete_show" class="col-md-1 pointer">
										<div @click="optionRemove(index)" class="form-group option-delete-icon ">
											<i class="fa fa-trash"></i>

										</div>

									</div>
								</div>

								<div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12" v-if="option.optionName.variation_value">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="form-group ">
											<label class="control-label">Option values
											</label>
											<tags-input element-id="tags" v-model="option.optionValues" :existing-tags="option.optionName.variation_value" :id-field="'value'" :text-field="'text'" :typeahead="true" :typeahead-show-on-focus="true" :add-tags-on-blur="false" :typeahead-always-show="true" :placeholder="''" :discard-search-text="`${option.optionName.text} option values`" :before-removing-tag="tags => tags.delete ?? true">
											</tags-input>
											<span class="text-danger" v-show="option.optionValues.length < 1">
												Option values is required
											</span>
										</div>
									</div>

								</div>
								<div class="col-lg-2 col-md-2 col-sm-4 col-xs-4" @click="optionDone(index,option)">
									<button type="button" class="btn btn-block btn-default">Done</button>
								</div>
							</div>
						</div>

					</div>
				</div>

				<hr v-if="product_options && addMoreShow">
				<div class="box-body" v-if="product_options && addMoreShow">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-group pointer" @click="addMoreOption" style="display: flex">
							<i class="fa fa-plus"></i>
							<label class="form-check-label pointer" style="margin-left: 10px;margin-top: -3px;">
								Add another option
							</label>
						</div>
					</div>
				</div>
			</div>
			<div v-if="product_options" class="custom-box " style="margin-top: 20px">
				<div class="box-body">
					<h4 class="text-center  text-bold" style="padding-bottom: 15px;">Variants</h4>
					<div class="box-body table-responsive no-padding">
						<table class="table table-condensed">
							<tbody>
								<tr>
									<th style="width: 18%;">Variant</th>
									<th>Buy Price</th>
									<th>Sell Price</th>
									<th>SKU</th>
									<th>Barcode</th>
									<th>Action</th>
								</tr>
								<tr v-for="(variation_value,index) in variationValues" :key="index">
									<td style="width: 18%;">
										{{ variation_value.variation_values_names }}
									</td>
									<td>
										<div class="input-group">
											<div class="input-group-addon">
												BDT
											</div>
											<input type="number" v-model="variation_value.variant_buy_price" :name="`variation_values.${index}.variant_buy_price`" class="form-control">
										</div>
										<span class="text-danger" v-if="allErrors.has(`variation_values.${index}.variant_buy_price`)" v-text="allErrors.get(`variation_values.${index}.variant_buy_price`)">
										</span>

									</td>
									<td>
										<div class="input-group">
											<div class="input-group-addon">
												BDT
											</div>
											<input type="number" v-model="variation_value.variation_price" :name="`variation_values.${index}.variation_price`" class="form-control">
										</div>
										<span class="text-danger" v-if="allErrors.has(`variation_values.${index}.variation_price`)" v-text="allErrors.get(`variation_values.${index}.variation_price`)">
										</span>

									</td>
									<td>
										<div class="form-group">
											<input type="text" v-model="variation_value.variation_sku" class="form-control" readonly :name="`variation_values.${index}.variation_sku`" placeholder="Enter SKU">
											<span class="text-danger" v-if="allErrors.has(`variation_values.${index}.variation_sku`)" v-text="allErrors.get(`variation_values.${index}.variation_sku`)">
											</span>
										</div>
									</td>
									<td>
										<div class="form-group">
											<input type="text" :name="`variation_values.${index}.variation_barcode`" v-model="variation_value.variation_barcode" class="form-control" placeholder="Enter barcode" readonly>
											<span class="text-danger" v-if="allErrors.has(`variation_values.${index}.variation_barcode`)" v-text="allErrors.get(`variation_values.${index}.variation_barcode`)">
											</span>
										</div>
									</td>
									<td class="text-center ">
										<i v-if="variation_value.delete_show" class="fa fa-trash pointer" @click="variantRemove(index)"></i>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div style="margin-top: 20px;text-align: center;">
				<div>
					<button type="submit" class="btn btn-primary" v-if="!isLoading">Update</button>
					<button type="button" class="btn btn-primary" v-else>Updating...</button>
				</div>
			</div>
		</form>
	</div>
</template>
<script>
import collect from "collect.js";
import Errors from "../../helper/errors";

export default {
	props: [
		"categories",
		"suppliers",
		"brands",
		"variations",
		"product_info",
		"productOptions",
		"productOptionsValues",
		"authSupplier",
	],
	data() {
		return {
			product: { ...this.product_info },
			product_options: this.product_info.product_options,
			variationOptions: [...this.productOptions],
			variationValues: [...this.productOptionsValues],
			optionsDefault: {
				optionName: {},
				option_error: "",
				tag: "",
				optionValues: [],
				editOption: true,
				delete_show: true,
			},
			allErrors: new Errors(),
			generate_barcode: "",
			supplier_disable: false,
		};
	},
	watch: {
		"product.supplier_id"() {
			this.generateSkuBarcode();
		},
		"product.category_id"() {
			this.generateSkuBarcode();
		},
		"product.product_sku"() {
			this.updateVariantSku();
		},
		"product.product_code"() {
			this.updateVariantSku();
		},
	},
	methods: {
		productStore() {
			const _this = this;
			this.isLoading = true;
			this.Loader(true);
			const form = {
				...this.product,
				options: this.variationOptions,
				variation_values: this.variationValues,
				product_options: this.product_options,
				product_margin: this.marginProfit.margin,
				product_profit: this.marginProfit.profit,
			};
			axios
				.put(route("products.update", this.product.id), form)
				.then((response) => {
					if (response.data.status === 201) {
						toastr.success("Product updated successfully");
						this.reload(500);
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
		generateSkuBarcode() {
			let supplier = collect(this.suppliers)
				.where("value", this.product.supplier_id)
				.first();
			let category = collect(this.categories)
				.where("value", this.product.category_id)
				.first();

			if (supplier && category) {
				let payload = {
					supplier: supplier,
					category: category,
				};
				axios
					.post(route("generate-sku-barcode"), payload)
					.then((response) => {
						this.product.product_sku =
							response.data.result.sku ?? "";
						// this.product.product_code = response.data.result.product_code ?? "";
						this.generate_barcode =
							response.data.result.generate_barcode ?? "";
						this.allErrors.clear("product_sku");
						this.allErrors.clear("product_code");
					})
					.catch((error) => {});
			}
		},
		generateLastSkuBarcode() {
			let supplier = collect(this.suppliers)
				.where("value", this.product.supplier_id)
				.first();
			let category = collect(this.categories)
				.where("value", this.product.category_id)
				.first();

			if (supplier && category) {
				let payload = {
					supplier: supplier,
					category: category,
				};
				axios
					.post(route("generate-sku-barcode"), payload)
					.then((response) => {
						// this.product.product_sku = response.data.result.sku ?? "";
						// this.product.product_code = response.data.result.product_code ?? "";
						this.generate_barcode =
							response.data.result.generate_barcode ?? "";
						this.allErrors.clear("product_sku");
						this.allErrors.clear("product_code");
					})
					.catch((error) => {});
			}
		},
		optionChange(index, option, current) {
			option.optionValues = [];
			let find = this.variationOptions.find((item, key) => {
				return key !== index && item.optionName.text === current.text;
			});
			if (find) {
				option.optionName = {};
				option.option_error = `You've already used the option name "${current.text}"`;
			} else {
				option.option_error = "";
			}
		},
		checkedOption(event) {
			this.variationOptions = [];
			if (event.target.checked) {
				this.variationOptions = [{ ...this.optionsDefault }];
			} else {
				this.variationOptions = [];
			}
		},
		addMoreOption() {
			if (this.variationOptions.length < this.variations.length) {
				this.variationOptions.push({ ...this.optionsDefault });
			}
			return false;
		},
		optionDone(index, option) {
			if (
				this.product.product_sku === "" ||
				this.product.product_code === ""
			) {
				toastr.warning("Please add SKU & Barcode");
				return false;
			}
			if (
				Object.values(option.optionName).length > 0 &&
				option.optionValues.length > 0
			) {
				this.variationCombination();
				option.editOption = false;
			}
		},
		optionRemove(index) {
			this.variationOptions.splice(index, 1);
			if (this.variationOptions.length < 1) {
				this.variationOptions = [];
				this.variationValues = [];
				this.product_options = false;
			} else {
				this.variationCombination();
			}
		},
		variantRemove(index) {
			const _this = this;
			this.variationValues.splice(index, 1);
			if (this.variationValues.length < 1) {
				this.variationOptions = [];
				this.variationValues = [];
				this.product_options = false;
			}
			// option values check & remove
			let options = collect(this.variationOptions)
				.pluck("optionValues")
				.toArray();
			let optionsValues = collect(this.variationValues)
				.pluck("variationValues")
				.collapse()
				.toArray();
			options.map((value, index) => {
				value.map((value2, index2) => {
					if (!optionsValues.includes(value2.text)) {
						_this.variationOptions[index].optionValues.splice(
							index2,
							1
						);
					}
				});
			});
		},
		variationCombination() {
			const _this = this;
			let options = collect(this.variationOptions)
				.pluck("optionValues")
				.toArray();
			let combination = this.combinationsGenerate(options);
			let result = [];
			let next_index = 0;
			combination.map((value, index) => {
				let value_name = collect(value).pluck("text").toArray();
				let find_value_name = collect(value)
					.pluck("text")
					.toArray()
					.splice(0, this.productOptions.length);
				let old_barcode = collect(this.productOptionsValues)
					.pluck("variation_values_names")
					.contains(find_value_name.join("-"));
				let oldValue = _this.variationValues[index - next_index];
				if (!old_barcode) {
					oldValue = {};
					next_index++;
				}

				let buy_price = oldValue ? oldValue.variant_buy_price : "";
				let price = oldValue ? oldValue.variation_price : "";
				let sku = oldValue ? oldValue.variation_sku : "";
				let barcode = oldValue ? oldValue.variation_barcode : "";
				result.push({
					delete_show: !barcode,
					variationValues: value_name,
					variation_values_names: value_name.join("-"),
					variant_buy_price: buy_price
						? buy_price
						: _this.product.buy_price,
					variation_price: price ? price : _this.product.sell_price,
					variation_sku: sku ? sku : _this.product.product_sku,
					variation_barcode: barcode
						? barcode
						: parseInt(_this.generate_barcode) + next_index - 1,
				});
			});
			this.variationValues = result;
		},
		combinationsGenerate(array) {
			let result = [[]];
			array.map((property_values) => {
				let temp = [];
				result.map((result_item) => {
					property_values.map((property_value) => {
						temp.push(result_item.concat(property_value));
					});
				});
				result = temp;
			});
			return result;
		},
		updateVariantSku() {
			if (this.variationValues.length > 1) {
				for (const key in this.variationValues) {
					this.variationValues[key].variation_sku =
						this.product.product_sku ?? "";
				}
			}
		},
		variantValueRemoveCheck(value) {
			console.log(value);
		},
	},
	mounted() {
		if (this.authSupplier && this.authSupplier.supplier) {
			this.supplier_disable = true;
		}
		this.generateLastSkuBarcode();
	},
	computed: {
		marginProfit() {
			if (this.product.sell_price && this.product.buy_price) {
				let profit =
					parseFloat(this.product.sell_price) -
					parseFloat(this.product.buy_price);
				let margin = parseFloat(
					(profit / parseFloat(this.product.sell_price)) * 100
				);
				return {
					profit: profit,
					margin: margin.toFixed(1),
				};
			} else {
				return "";
			}
		},
		addMoreShow() {
			return this.variationOptions.length < this.variations.length;
		},
	},
};
</script>
