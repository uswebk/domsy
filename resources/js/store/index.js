import Vue from 'vue'
import Vuex from 'vuex'

import domain from './modules/domain'
import registrar from './modules/registrar'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    domain,
    registrar,
  },
})

export default store
