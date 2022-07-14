/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vuetify from 'vuetify';

window.Vue = require('vue').default;

Vue.use(Vuetify);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/**
 * Page
 */
Vue.component('dashboard-page', require('./pages/Dashboard.vue').default);
Vue.component('account-page', require('./pages/Account.vue').default);

/**
 * Component
 */
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('test-component', require('./components/TestComponent.vue').default);
Vue.component('registrar-add-new-button-component', require('./components/registrar/AddNewButton.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
});
