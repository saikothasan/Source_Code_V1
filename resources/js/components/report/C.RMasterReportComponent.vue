<template>
    <div>
        <h3 class="header text-center">C.R Master Report GENERATOR</h3>
        <section class="box-header">
            <form method="post" @submit.prevent="generateReport()" @keydown="allErrors.clear($event.target.name)">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row text-center spacer filter">

                    <div class=" col-lg-6 col-md-6 col-sm-12 col-xs-12 groupedInput">
                        <div class="row form-inline">
                            <div class="col-md-1 text-center">
                                <label class="groupedLabel">From</label>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input @input="allErrors.clear('from_date')" v-model="stockReportForm.from_date"
                                        name="from_date" type="date" class="form-control corner">
                                    <span class="text-danger" style="white-space: nowrap;" v-if="allErrors.has('from_date')"
                                        v-text="allErrors.get('from_date')">
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-1 text-center" style="margin-left: 25px;">
                                <label class="groupedLabel">To</label>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input @input="allErrors.clear('to_date')" v-model="stockReportForm.to_date"
                                        name="to_date" type="date" class="form-control corner">
                                    <span class="text-danger" style="white-space: nowrap;" v-if="allErrors.has('to_date')"
                                        v-text="allErrors.get('to_date')">
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
                                <model-select :options="resource.branches" v-model="stockReportForm.selectedBranch"
                                    @input="allErrors.clear('selectedBranch')" placeholder="Select Branch"></model-select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <model-select :options="resource.reportMode" @input="allErrors.clear('selectedReportMode')"
                                    v-model="stockReportForm.selectedReportMode"
                                    placeholder="Select Report Mode"></model-select>
                                <span class="text-danger" v-if="allErrors.has('selectedReportMode')"
                                    v-text="allErrors.get('selectedReportMode')">
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <model-select :options="resource.fileMode" @input="allErrors.clear('report_file_mode')"
                                    v-model="stockReportForm.report_file_mode"
                                    placeholder="Select File Mode"></model-select>
                                <span class="text-danger" v-if="allErrors.has('report_file_mode')"
                                    v-text="allErrors.get('report_file_mode')">
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
                <br>
                <div class="footer-comment">
                    <div class=" row ">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <center>Briefly explain why you need the report!</center>
                            <textarea class="form-control" name="description" style="border-radius: 8px"
                                v-model="stockReportForm.description">
                                        </textarea>
                            <span class="text-danger" v-if="allErrors.has('description')"
                                v-text="allErrors.get('description')">
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
        </section>
    </div>
</template>

<script>
import Errors from "../../helper/errors";
import collect from "collect.js";

export default {
    name: "CrMasterReportComponent",
    props: ["resource"],
    data() {
        return {
            allErrors: new Errors(),
            stockReportForm: {
                selectedBranch: {
                    text: "Select Branch",
                    value: "",
                },
                from_date: "",
                to_date: "",
                selectedReportMode: {},
                report_file_mode: {
                    text: "Print",
                    value: "print",
                },
                items: [],
                description: "",
                searchType: "stock",
            },
            html: "",
        };
    },
    methods: {
        async generateReport() {
            this.html = "";
            const form = {
                ...this.stockReportForm,
            };
            this.Loader(true);
            await axios
                .post(route("generate.cr.master.report"), form)
                .then((response) => {
                    //this.html = response.data;
                    if (response.data.status === 200) {
                        toastr.success(response.data.message);
                        let url = "";
                        if (
                            this.stockReportForm.report_file_mode.value ===
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
@media only screen and (max-width: 991px) {
  .search-filter {
    margin-top: 200px;
  }
}
</style>
