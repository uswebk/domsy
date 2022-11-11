export const state = () => ({
  pageLoading: false,
  menus: [],
})

export const mutations = {
  pageLoading: (state, value) => (state.pageLoading = value),
  menus: (state, value) => (state.menus = value),
}

export const actions = {
  async fetchMenus({ commit }) {
    commit('pageLoading', true)
    try {
      const result = await this.$axios.get('api/menus')
      commit('menus', result.data)
    } catch (error) {
      commit('menus', [])
    }
    commit('pageLoading', false)
  },
}

export const getters = {
  pageLoading: (state) => state.pageLoading,
  menus: (state) => state.menus,
}
