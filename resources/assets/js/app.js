
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

 require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('manager-check-form', require('./components/ManagerCheckForm.vue'));
Vue.component('payroll-form', require('./components/PayrollForm.vue'));
 
// Report's components
Vue.component('reportParent', require('./components/ReportParent.vue'));
Vue.component('bankTransferForm', require('./components/BankTransferForm.vue'));

// Master data components
Vue.component('masterData', require('./components/MasterData.vue'));
Vue.component('recent', require('./components/Recent.vue'));



const app = new Vue({
    el: '#app'
});
