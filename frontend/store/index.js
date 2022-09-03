export const state = () => ({
  pageLoading: false,
})

const mutations = {
  pageLoading: (state, value) => (state.pageLoading = value),
}

const getters = {
  pageLoading: (state) => state.pageLoading,
}

export default {
  getters,
  mutations,
}
