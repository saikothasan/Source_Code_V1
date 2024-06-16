<template>
	<div class="row filter">
		<div class=" col-md-6" disabled="true">
			<label for="">Search Product</label>
			<div v-if="spinner" style="text-align: center; font-size: 20px">
				<div class="overlay" style="margin-top: 38px; position: absolute; z-index: 99999; margin-left: 44%;">
					<i class="fa fa-refresh fa-spin text-green"></i>
				</div>
			</div>
			<tags-input element-id="tags" :placeholder="''" :id-field="'value'" :text-field="'text'" v-model="form.items" :existing-tags="products" :only-existing-tags="true" @change="searchKeyPress" :typeahead="true" :typeahead-style="'dropdown'" :typeahead-always-show="false" :typeahead-hide-discard="true" :typeahead-show-on-focus="true"></tags-input>
		</div>
	</div>
</template>

<script>
import collect from "collect.js";
import VoerroTagsInput from "@voerro/vue-tagsinput";

export default {
	name: "ProductSearch",
	props: ["form"],
	components: {
		"tags-input": VoerroTagsInput,
	},
	data() {
		return {
			products: [],
			spinner: false,
		};
	},
	methods: {
		searchKeyPress(value) {
			this.spinner = true;
			this.products = [];
			this.searchProduct(value);
		},
		searchProduct: _.debounce(function (value) {
			if (this.form.selectedBranch.length < 1) {
				toastr.warning("Select Branch");
				this.spinner = false;
				return false;
			}

			if (this.form.selectedSupplier.length < 1) {
				toastr.warning("Select Supplier");
				this.spinner = false;
				return false;
			}
			if (this.form.selectedCategory.length < 1) {
				toastr.warning("Select Category");
				this.spinner = false;
				return false;
			}
			if (this.form.selectedBrand.length < 1) {
				toastr.warning("Select Brand");
				this.spinner = false;
				return false;
			}
			let data = {
				selectedBranch: collect(this.form.selectedBranch)
					.pluck("value")
					.toArray(),
				selectedSupplier: collect(this.form.selectedSupplier)
					.pluck("value")
					.toArray(),
				selectedCategory: collect(this.form.selectedCategory)
					.pluck("value")
					.toArray(),
				selectedBrand: collect(this.form.selectedBrand)
					.pluck("value")
					.toArray(),
				search: value,
				searchType: this.form.searchType,
			};
			axios
				.post(route("report.product.search"), data)
				.then((response) => {
					if (response.data.status === 200) {
						this.products = response.data.result;
					} else {
						toastr.warning("Something went wrong");
					}
					this.spinner = false;
				})
				.catch((error) => {
					//this.spinner = false;
				});
		}, 500),
	},
};
</script>

<style scoped>
</style>
