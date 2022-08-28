import Vue from 'vue'
import Vuex from 'vuex'

import domain from './modules/domain'
import registrar from './modules/registrar'
import client from './modules/client'
import dns from './modules/dns'
import dealing from './modules/dealing'
import account from './modules/account'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    domain,
    registrar,
    client,
    dns,
    dealing,
    account,
  },
})

export default store
