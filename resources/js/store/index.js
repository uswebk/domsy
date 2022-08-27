import Vue from 'vue'
import Vuex from 'vuex'

import domain from './modules/domain'
import registrar from './modules/registrar'
import client from './modules/client'
import dns from './modules/dns'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    domain,
    registrar,
    client,
    dns,
  },
})

export default store
