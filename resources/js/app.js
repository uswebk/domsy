/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import '@mdi/font/css/materialdesignicons.css'

window.Vue = require('vue').default

Vue.use(Vuetify)

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
Vue.component('auth-login-page', require('./pages/auth/Login.vue').default)
Vue.component(
  'auth-register-page',
  require('./pages/auth/Register.vue').default
)
Vue.component('auth-verify-page', require('./pages/auth/Verify.vue').default)

Vue.component(
  'auth-passwords-email-page',
  require('./pages/auth/passwords/Email.vue').default
)
Vue.component(
  'auth-passwords-reset-page',
  require('./pages/auth/passwords/Reset.vue').default
)

Vue.component('top-page', require('./pages/frontend/TopPage.vue').default)

Vue.component(
  'dashboard-page',
  require('./pages/frontend/DashboardPage.vue').default
)
Vue.component('account-page', require('./pages/frontend/Account.vue').default)

Vue.component(
  'registrar-page',
  require('./pages/frontend/RegistrarPage.vue').default
)

Vue.component('client-page', require('./pages/frontend/ClientPage.vue').default)

Vue.component('domain-page', require('./pages/frontend/DomainPage.vue').default)

Vue.component('dns-page', require('./pages/frontend/DnsPage.vue').default)

Vue.component(
  'dealing-page',
  require('./pages/frontend/DealingPage.vue').default
)

/**
 * Component
 */
Vue.component(
  'header-component',
  require('./components/HeaderComponent.vue').default
)
Vue.component(
  'navigation-component',
  require('./components/NavigationComponent.vue').default
)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
  el: '#app',
  vuetify: new Vuetify(),
})
