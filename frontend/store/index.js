export const state = () => ({
  pageLoading: false,
})

export const mutations = {
  pageLoading: (state, value) => (state.pageLoading = value),
}

export const actions = {
  async hasRole({ commit }, payload) {
    const result = await this.$axios.get('/api/role/user/page?endpoint=' + payload)
    return result
  },
}

export const getters = {
  pageLoading: (state) => state.pageLoading,
}
