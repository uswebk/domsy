export const state = () => ({
  labels: [],
  countOfDomains: [],
  soonExpiredDomains: [],
  totalPrice: 0,
  activeSummary: [],
})

export const mutations = {
  countOfDomains: (state, value) => (state.countOfDomains = value),
  soonExpiredDomains: (state, value) => (state.soonExpiredDomains = value),
  labels: (state, value) => (state.labels = value),
  totalPrice: (state, value) => (state.totalPrice = value),
  activeSummary: (state, value) => (state.activeSummary = value),
}

export const actions = {
  async fetchTransactionByMonths({ commit }, months) {
    const result = await this.$axios.get(
      '/api/domain/transaction?months=' + months
    )
    commit('labels', Object.keys(result.data))
    commit('countOfDomains', Object.values(result.data))
  },

  async fetchSortedExpiryByCount({ commit }, count) {
    const result = await this.$axios.get(
      '/api/domain/sort-expired?count=' + count
    )
    commit('soonExpiredDomains', Object.values(result.data))
  },

  async fetchTotalSeller({ commit }) {
    const result = await this.$axios.get('/api/domain/total-seller')
    commit('totalPrice', result.data.totalPrice)
  },

  async fetchActiveSummary({ commit }) {
    const result = await this.$axios.get('/api/domain/active-summary')
    commit('activeSummary', result.data)
  },
}

export const getters = {
  labels: (state) => state.labels,
  countOfDomains: (state) => state.countOfDomains,
  soonExpiredDomains: (state) => state.soonExpiredDomains,
  totalPrice: (state) => state.totalPrice,
  activeSummary: (state) => state.activeSummary,
}
