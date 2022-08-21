import Vue from 'vue'
import Vuex from 'vuex'

import domain from './domain'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    domain,
  },
})

export default store
