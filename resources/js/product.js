import Vue from 'vue';

require('./bootstrap');
window.route = require('./helper/laravel-route.js');
window.Vue = require('vue');

import 'vue-search-select/dist/VueSearchSelect.css';
import { ModelSelect } from 'vue-search-select';
import Vuelidate from 'vuelidate';
import VoerroTagsInput from '@voerro/vue-tagsinput';

import VueLazyload from 'vue-lazyload';
Vue.use(VueLazyload)


import mixin from './mixin.js';
// Global Mixin
Vue.mixin(mixin);
Vue.use(Vuelidate);
Vue.component('tags-input', VoerroTagsInput);
Vue.component('model-select', ModelSelect);
Vue.component('add-product', require('./components/product/AddProductComponent').default);
Vue.component('edit-product', require('./components/product/EditProductComponent').default);
Vue.component('product-image', require('./components/product/ProductImageUpload').default);
Vue.component('add-gift-product', require('./components/gift/product/AddProductComponent').default);
Vue.component('edit-gift-product', require('./components/gift/product/EditProductComponent').default);
Vue.component('add-gift-purchase', require('./components/gift/purchase/AddPurchaseComponent').default);
new Vue({
	el: '#product'
});
