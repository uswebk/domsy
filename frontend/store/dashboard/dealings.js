export const state = () => ({
  soonBillings: [],
  amounts: [],
  labels: [],
})

export const mutations = {
  soonBillings: (state, value) => (state.soonBillings = value),
  amounts: (state, value) => (state.amounts = value),
  labels: (state, value) => (state.labels = value),
}

export const actions = {
  async fetchAmountByMonths({ commit }, months) {
    const result = await this.$axios.get(
      '/api/dealing/billing/transaction?months=' + months
    )
    commit('labels', Object.keys(result.data))
    commit('amounts', Object.values(result.data))
  },

  async fetchSortedBillingsByCount({ commit }, count) {
    const result = await this.$axios.get(
      '/api/dealing/billing/sort-billing-date?count=' + count
    )
    commit('soonBillings', Object.values(result.data))
  },
}

export const getters = {
  soonBillings: (state) => state.soonBillings,
  amounts: (state) => state.amounts,
  labels: (state) => state.labels,
}
