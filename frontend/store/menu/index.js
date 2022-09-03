
const state = {
  pageLoading: false,
  menus: [],
}

const mutations = {
  pageLoading: (state, value) => (state.pageLoading = value),
  menus: (state, value) => (state.menus = value),
}

const actions = {
  async fetchMenus({ commit }) {
    commit('pageLoading', true)
    const result = await this.$axios.get('api/menus')
    commit('menus', result.data)
    commit('pageLoading', false)
  },
}

const getters = {
  pageLoading: (state) => state.pageLoading,
  menus: (state) => state.menus,
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions,
}
