/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');

import Vue from 'vue';
window.Vue = require('vue');

// import VueAxios from 'vue-axios';
// import VueRouter from 'vue-router';
import axios from 'axios';

import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';

// import Datepicker from "vuejs-datepicker/dist/vuejs-datepicker.esm.js";
// import * as lang from "vuejs-datepicker/src/locale";

import vClickOutside from 'v-click-outside';
Vue.use(vClickOutside);

import VueLazyload from 'vue-lazyload'
Vue.use(VueLazyload)
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// window.Vue.use(VueRouter);
// Vue.use(VueAxios, axios);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('datepicker-component', require('./components/DatepickerComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('accordion', require('./components/Accordion.vue').default);
Vue.component('accordion-item', require('./components/AccordionItem.vue').default);
Vue.component('slider', require('./components/Slider.vue').default);
Vue.component('side-bar', require('./components/SideBar.vue').default);
Vue.component('category-list', require('./components/CategoryList.vue').default);
Vue.component('tag-list', require('./components/TagList.vue').default);
Vue.component('user-list', require('./components/UserList.vue').default);
Vue.component('user-detail', require('./components/UserDetail.vue').default);
Vue.component('user-reviews', require('./components/UserReviews.vue').default);
Vue.component('cart-list', require('./components/CartList.vue').default);
Vue.component('product-list', require('./components/ProductList.vue').default);
Vue.component('product-detail', require('./components/ProductDetail.vue').default);
Vue.component('product-password', require('./components/ProductPassword.vue').default);
Vue.component('product-reviews', require('./components/ProductReviews.vue').default);
Vue.component('mypage-breadcrumb', require('./components/MypageBreadcrumb.vue').default);
Vue.component('list-breadcrumb', require('./components/ListBreadcrumb.vue').default);
Vue.component('product-item', require('./components/ProductItem.vue').default);
Vue.component('user-item', require('./components/UserItem.vue').default);
Vue.component('to-top', require('./components/ToTop.vue').default);
Vue.component('sp-to-top', require('./components/SpToTop.vue').default);
Vue.component('image-upload-component', require('./components/ImageUploadComponent.vue').default);
Vue.component('vue-upload-multiple-image-drawing', require('./components/VueUploadMultipleImageDrawing.vue').default);
Vue.component('file-upload-component', require('./components/FileUploadComponent.vue').default);
Vue.component('star-rating-component', require('./components/StarRatingComponent.vue').default);
Vue.component('order-detail', require('./components/OrderDetail.vue').default);
Vue.component('message-detail', require('./components/MessageDetail.vue').default);
Vue.component('partner-detail', require('./components/PartnerDetail.vue').default);

Vue.component('DatePicker', require('vue2-datepicker'));
// Vue.component('Datepicker');

const app = new Vue({
    el: '#app',
    // components: { DatePicker },
    data() {
        return {
            show_toggle_bar: false,
            click_toggle_bar: false,
        };
    },
    methods: {
        openSideToggle: function() {
            this.show_toggle_bar = true;
            this.click_toggle_bar = true;
        },
        outsideSideToggle (event) {
            if (this.click_toggle_bar) {
                this.click_toggle_bar = false;
            } else {
                this.show_toggle_bar = false;
            }
        }
    }
    // components: {
    //     vuejsDatepicker
    // },
    // data() {
    //     return {
    //         default_date_format: 'yyyy-MM-dd',
    //         lang: {
    //             formatLocale: {
    //                 firstDayOfWeek: 1,
    //             },
    //             monthBeforeYear: false,
    //         },
    //         value1: "",
    //     }
    //
    // }
});
