export const state = () => ({
  greeting: '',
  greetingType: '',
  canStore: false,
  canUpdate: false,
  canDetail: false,
  canUpdateBilling: false,
  pageLoading: true,
  dealings: { active: [], stop: [] },
  dealing: { domain: [] },
})

export const mutations = {
  greeting: (state, value) => (state.greeting = value),
  greetingType: (state, value) => (state.greetingType = value),
  pageLoading: (state, value) => (state.pageLoading = value),
  dealings: (state, value) => (state.dealings = value),
  dealing: (state, value) => (state.dealing = value),
  canStore: (state, value) => (state.canStore = value),
  canUpdate: (state, value) => (state.canUpdate = value),
  canDetail: (state, value) => (state.canDetail = value),
  canUpdateBilling: (state, value) => (state.canUpdateBilling = value),
}

export const actions  = {
  sendMessage({ commit }, payload) {
    commit('greeting', payload.greeting)
    commit('greetingType', payload.greetingType)
  },

  async fetchDealings({ commit }) {
    commit('pageLoading', true)
    const result = await this.$axios.get('/api/dealing')
    const dealings = {
      active: [],
      stop: [],
    }
    result.data.forEach((dealing) => {
      if (dealing.is_halt) {
        dealings.stop.push(dealing)
      } else {
        dealings.active.push(dealing)
      }
    })
    commit('dealings', dealings)
    commit('pageLoading', false)
  },

  async fetchDealing({ commit }, dealingId) {
    const result = await this.$axios.get('/api/dealing/' + dealingId)
    commit('dealing', result.data)
  },

  async storeDealing({ dispatch }, payload) {
    const result = await this.$axios.post('/api/dealing', {
      ...payload,
    })
    dispatch('fetchDealings')

    return result
  },

  async updateDealing({ dispatch }, payload) {
    const result = await this.$axios.put('/api/dealing/' + payload.id, {
      ...payload,
    })
    dispatch('fetchDealings')

    return result
  },

  async updateBilling({ dispatch }, payload) {
    const result = await this.$axios.put('/api/dealing/billings/' + payload.id, {
      ...payload,
    })

    return result
  },

  async initRole({ commit }) {
    const result = await this.$axios.get('/api/role/user/?menu_id=6')

    commit('canStore', result.data.store)
    commit('canUpdate', result.data.update)
    commit('canDetail', result.data.detail)
    commit('canUpdateBilling', result.data.updateBilling)
  },
}

export const getters = {
  greeting: (state) => state.greeting,
  greetingType: (state) => state.greetingType,
  dealings: (state) => state.dealings,
  dealing: (state) => state.dealing,
  canStore: (state) => state.canStore,
  canUpdate: (state) => state.canUpdate,
  canDetail: (state) => state.canDetail,
  canUpdateBilling: (state) => state.canUpdateBilling,
  pageLoading: (state) => state.pageLoading,
  intervalCategories: () => ['DAY', 'WEEK', 'MONTH', 'YEAR'],
}
