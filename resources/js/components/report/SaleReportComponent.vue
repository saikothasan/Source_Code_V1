<template>
    <div>
        <div class="col-md-12">
            <div class="col-md-12 text-center">
                <h3 class="header">SALES REPORT GENERATOR</h3>
            </div>
        </div>
        <div class="report-form">
            <form method="post" @submit.prevent="generateReport()" @keydown="allErrors.clear($event.target.name)">
                <div class="row main-box">
                    <div class="col-md-3">
                        <label><input type="checkbox" @input="allErrors.clear('selectedBranch')" id="allBranch"
                                v-model="allSelectedBranch" @change="selectAllBranch()"
                                @click="allErrors.clear('selectedBranch')" /></label>
                        <label for="allBranch">Select Branches</label>
                        <hr>
                        <div class="branch" v-for="(branch, index) in resource.branches" :key="branch.value">
                            <input type="checkbox" :value="branch" :id="'branch_id' + branch.value"
                                v-model="saleReportForm.selectedBranch" @input="allErrors.clear('selectedBranch')">
                            <label :for="'branch_id' + branch.value">{{
                                branch.text
                            }}</label>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <label><input type="checkbox" id="allCategory" v-model="allSelectedCategory"
                                @change="selectAllCategory()" :disabled="saleReportForm.selectedSupplier.length <= 0"
                                @input="allErrors.clear('selectedCategory')" /></label>
                        <label for="allCategory">Select Categories</label>
                        <hr>
                        <div class="category">
                            <div class="col-md-3" v-for="category in resource.categories">
                                <input type="checkbox" :value="category" :id="'category_id' + category.value"
                                    :disabled="!filter_data.categories.includes(category.value) || saleReportForm.selectedSupplier.length <= 0"
                                    @input="allErrors.clear('selectedCategory')" v-model="saleReportForm.selectedCategory">
                                <label :for="'category_id' + category.value"
                                    :class="{ 'color-gray': !filter_data.categories.includes(category.value) || saleReportForm.selectedSupplier.length <= 0 }">{{
                                        category.text
                                    }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>
                <div class="row">
                    <div class="col-md-3">
                        <label><input type="checkbox" id="allSupplier" v-model="allSelectedSupplier"
                                @change="selectAllSupplier()" :disabled="saleReportForm.selectedBranch.length <= 0"
                                @input="allErrors.clear('selectedSupplier')" /></label>
                        <label for="allSupplier">Select Supplier</label>
                        <hr>
                        <div class="supplier" v-for="supplier in resource.suppliers">
                            <input type="checkbox" :value="supplier" :id="'supplier_id' + supplier.value"
                                :disabled="!filter_data.suppliers.includes(supplier.value)"
                                @input="allErrors.clear('selectedSupplier')" v-model="saleReportForm.selectedSupplier">
                            <label :for="'supplier_id' + supplier.value"
                                :class="{ 'color-gray': !filter_data.suppliers.includes(supplier.value) }">{{
                                    supplier.text
                                }}</label>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <label><input type="checkbox" id="allBrand" v-model="allSelectedBrand" @change="selectAllBrand()"
                                :disabled="saleReportForm.selectedSupplier.length <= 0"
                                @input="allErrors.clear('selectedBrand')" /></label>
                        <label for="allBrand">Select Brand</label>
                        <hr>
                        <div class="brand">
                            <div class="col-md-3" v-for="brand in resource.brands">
                                <input type="checkbox" :value="brand" :id="'brand_id' + brand.value"
                                    :disabled="!filter_data.brands.includes(brand.value) || saleReportForm.selectedSupplier.length <= 0"
                                    @input="allErrors.clear('selectedBrand')" v-model="saleReportForm.selectedBrand">
                                <label :for="'brand_id' + brand.value"
                                    :class="{ 'color-gray': !filter_data.brands.includes(brand.value) || saleReportForm.selectedSupplier.length <= 0 }">{{
                                        brand.text
                                    }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="alert alert-danger" v-if="Object.keys(allErrors.errors).length > 0">
                    <ul>
                        <li v-for="(error, index) in allErrors.errors" :key="index">
                            <span v-if="error[0]" v-text="error[0]"></span>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row text-center spacer filter">

                    <div class=" col-lg-6 col-md-6 col-sm-12 col-xs-12 groupedInput" style="height: 38px">
                        <div class="row form-inline">
                            <div class="col-md-1 text-center">
                                <label class="groupedLabel">From</label>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input @input="allErrors.clear('from_date')" v-model="saleReportForm.from_date"
                                        name="from_date" type="date" class="form-control corner">
                                </div>
                            </div>
                            <div class="col-md-1 text-center" style="margin-left: 25px;">
                                <label class="groupedLabel">To</label>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input @input="allErrors.clear('to_date')" v-model="saleReportForm.to_date"
                                        name="to_date" type="date" class="form-control corner">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>

                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-3">
                            <div class="form-group">
                                <model-select :options="resource.paymentMethods"
                                    @input="allErrors.clear('selectedPaymentMethod')"
                                    v-model="saleReportForm.selectedPaymentMethod" s
                                    placeholder="Select Payment Method"></model-select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <model-select :options="filter_data.seller" v-model="saleReportForm.selectedSeller"
                                    @input="allErrors.clear('selectedSeller')" placeholder="Select Seller"></model-select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <model-select :options="resource.statusFilter" @input="allErrors.clear('select_status')"
                                    v-model="saleReportForm.select_status" placeholder="Select Status"></model-select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <model-select :options="resource.amountType" @input="allErrors.clear('selectedAmountType')"
                                    v-model="saleReportForm.selectedAmountType" placeholder="Select Amount"></model-select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row footer-section">
                    <div class="col-md-12" style="justify-content: center; display: flex;">

                        <div class="col-md-4">
                            <div class="form-group">
                                <model-select :options="resource.reportMode" @input="allErrors.clear('selectedReportMode')"
                                    v-model="saleReportForm.selectedReportMode"
                                    placeholder="Select Report Mode"></model-select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <model-select :options="resource.fileMode" @input="allErrors.clear('report_file_mode')"
                                    v-model="saleReportForm.report_file_mode" placeholder="Select File Mode"></model-select>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <ProductSearchComponent :form="saleReportForm"></ProductSearchComponent>
                <br>
                <div class="footer-comment">
                    <div class=" row ">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <center>Briefly explain why you need the report!</center>
                            <textarea cols="60" rows="5" name="description" style="border-radius: 8px"
                                v-model="saleReportForm.description">
                                        </textarea>
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
        </div>
    </div>
</template>

<script>
import Errors from "../../helper/errors";
import collect from "collect.js";
import ProductSearchComponent from "./ProductSearchComponent";

export default {
    name: "SaleReportComponent",
    props: ["resource"],
    components: {
        "tags-input": VoerroTagsInput,
        ProductSearchComponent,
    },
    data() {
        return {
            allSelectedBranch: false,
            allSelectedCategory: false,
            allSelectedSupplier: false,
            allSelectedBrand: false,
            allErrors: new Errors(),
            saleReportForm: {
                selectedBranch: [],
                selectedCategory: [],
                selectedSupplier: [],
                selectedBrand: [],
                selectedPaymentMethod: {
                    text: "Select Payment Method",
                    value: "",
                },
                selectedSeller: { text: "Select Seller", value: "" },
                selectedAmountType: {
                    text: "Select Amount",
                    value: "",
                    amount: 0,
                },
                from_date: "",
                to_date: "",
                selectedReportMode: {},
                select_status: { value: "", text: "Select Status" },
                report_file_mode: {},
                items: [],
                description: "",
                searchType: "sale",
            },
            sellerList: [],
            successData: {},
            html: "",
            filter_data: {
                seller: [],
                brands: [],
                categories: [],
                suppliers: [],
            },
        };
    },
    watch: {
        "saleReportForm.selectedBranch"() {
            this.objectArrayReset(this.filter_data);
            if (this.saleReportForm.selectedBranch.length > 0) {
                this.getFilterData("branch");
            } else {
                this.filter_data.seller = [];
                this.allSelectedCategory = false;
                this.allSelectedBrand = false;
                this.allSelectedSupplier = false;
                this.allSelectedBranch = false;
                this.saleReportForm.selectedCategory = [];
                this.saleReportForm.selectedBrand = [];
                this.saleReportForm.selectedSupplier = [];
                this.saleReportForm.items = [];
            }
        },
        "saleReportForm.selectedSupplier"() {
            this.getFilterData("supplier");
            if (this.saleReportForm.selectedSupplier.length < 1) {
                this.allSelectedCategory = false;
                this.allSelectedBrand = false;
                this.allSelectedSupplier = false;
                this.saleReportForm.selectedCategory = [];
                this.saleReportForm.selectedBrand = [];
                this.saleReportForm.items = [];
            }
        },
    },
    methods: {
        selectAllBranch() {
            if (this.allSelectedBranch) {
                this.saleReportForm.selectedBranch =
                    this.resource.branches.filter((item) => item);
            } else {
                this.saleReportForm.selectedBranch = [];
            }
        },
        selectAllCategory() {
            if (this.allSelectedCategory) {
                this.saleReportForm.selectedCategory =
                    this.resource.categories.filter((item) =>
                        this.filter_data.categories.includes(item.value)
                    );
            } else {
                this.saleReportForm.selectedCategory = [];
            }
        },
        selectAllSupplier() {
            if (this.allSelectedSupplier) {
                this.saleReportForm.selectedSupplier =
                    this.resource.suppliers.filter((item) =>
                        this.filter_data.suppliers.includes(item.value)
                    );
            } else {
                this.saleReportForm.selectedSupplier = [];
            }
        },
        selectAllBrand() {
            if (this.allSelectedBrand) {
                this.saleReportForm.selectedBrand = this.resource.brands.filter(
                    (item) => this.filter_data.brands.includes(item.value)
                );
            } else {
                this.saleReportForm.selectedBrand = [];
            }
        },
        async getFilterData(type) {
            let data = {
                selectedBranch: collect(this.saleReportForm.selectedBranch)
                    .pluck("value")
                    .toArray(),
                selectedSupplier: collect(this.saleReportForm.selectedSupplier)
                    .pluck("value")
                    .toArray(),
            };
            let supplier = this.filter_data.suppliers;
            await axios
                .post(route("sale-report.filter"), data)
                .then((response) => {
                    if (response.data.status === 200) {
                        if (type === "branch") {
                            this.filter_data = response.data.result;
                        } else {
                            this.filter_data = response.data.result;
                            this.filter_data.suppliers = supplier;
                        }
                        this.saleReportForm.selectedCategory =
                            this.saleReportForm.selectedCategory.filter(
                                (item) =>
                                    this.filter_data.categories.includes(
                                        item.value
                                    )
                            );
                        this.saleReportForm.selectedBrand =
                            this.saleReportForm.selectedBrand.filter((item) =>
                                this.filter_data.brands.includes(item.value)
                            );
                    } else {
                        toastr.warning("Something went wrong");
                        this.objectArrayReset(this.filter_data);
                    }
                })
                .catch((error) => {
                    this.objectArrayReset(this.filter_data);
                });
        },
        async generateReport() {
            this.html = "";
            const form = {
                ...this.saleReportForm,
            };
            this.Loader(true);
            await axios
                .post(route("generate.sale.report"), form)
                .then((response) => {
                    //this.html = response.data;
                    if (response.data.status === 200) {
                        toastr.success(response.data.message);
                        let url = "";
                        if (
                            this.saleReportForm.report_file_mode.value ===
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
    },
};
</script>

<style scoped>
.report-form{
    margin:5px;
    border:4px double skyblue;
    border-radius: 1rem;
}
.container {
    margin-top: 50px;
}</style>
