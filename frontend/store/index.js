const state = {
  pageLoading: false,
}

const mutations = {
  pageLoading: (state, value) => (state.pageLoading = value),
}

const getters = {
  pageLoading: (state) => state.pageLoading,
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
}
