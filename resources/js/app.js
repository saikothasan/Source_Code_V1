import "vue-search-select/dist/VueSearchSelect.css";

import { ModelSelect, MultiSelect } from "vue-search-select";

import VModal from "vue-js-modal";
import Vue from "vue";
import mixin from "./mixin.js";
require("./bootstrap");
window.route = require("./helper/laravel-route.js");
window.Vue = require("vue");
Vue.use(VModal);
Vue.use(require("vue-moment"));

// Global Mixin
Vue.mixin(mixin);
Vue.component("model-select", ModelSelect);
Vue.component("multi-select", MultiSelect);
Vue.component(
    "add-purchase",
    require("./components/purchase/AddPurchaseComponent.vue").default
);
Vue.component(
    "purchase-return",
    require("./components/purchase/PurchaseReturnComponent").default
);
Vue.component(
    "sale-component",
    require("./components/sale/SaleComponent.vue").default
);
Vue.component(
    "sale-exchange",
    require("./components/sale/exchange/CreateExchangeComponent").default
);
Vue.component(
    "sale-return",
    require("./components/sale/return/CreateReturnComponent.vue").default
);
Vue.component(
    "create-transfer",
    require("./components/transfer-received/CreateTransferComponent").default
);
Vue.component(
    "add-cost-component",
    require("./components/cost/AddCostComponent").default
);
Vue.component(
    "add-payable-amount-component",
    require("./components/payable-amount/AddPayableAmountComponent").default
);
Vue.component(
    "transfer-component",
    require("./components/cash-drawer/TransferComponent").default
);
Vue.component(
    "payment-component",
    require("./components/cash-drawer/PaymentComponent").default
);
Vue.component(
    "transfer-money",
    require("./components/payment-method/MoneyTransferComponent").default
);
Vue.component(
    "sale-report",
    require("./components/report/SaleReportComponent").default
);
Vue.component(
    "stock-report",
    require("./components/report/StockReportComponent").default
);
Vue.component(
    "cr-master-report",
    require("./components/report/C.RMasterReportComponent").default
);
Vue.component(
    "product-report",
    require("./components/report/ProductReportComponent").default
);
Vue.component(
    "bank-payment",
    require("./components/bank/BankPaymentComponent").default
);
Vue.component(
    "add-offer",
    require("./components/offer/AddOfferComponent").default
);
Vue.component(
    "add-flat-discount",
    require("./components/offer/AddFlatDiscountOfferComponent").default
);
Vue.component(
    "add-up-to-discount",
    require("./components/offer/AddUpToDiscountComponent.vue").default
);
Vue.component(
    "add-combo-discount",
    require("./components/offer/AddComboDiscountComponent.vue").default
);
Vue.component(
    "add-buy-to-get-discount",
    require("./components/offer/AddBuyToGetDiscountComponent.vue").default
);
Vue.component(
    "add-coupon-discount",
    require("./components/offer/AddCouponDiscountComponent.vue").default
);
Vue.component(
    "product-details",
    require("./components/ecommarce/product/ProductDetailsComponent").default
);
Vue.component(
    "online-order-entry",
    require("./components/online-order/OnlineOrderComponent.vue").default
);
new Vue({
    el: "#app",
});
