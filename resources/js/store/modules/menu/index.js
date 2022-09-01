import axios from 'axios'

const state = {
  menus: [],
}

const mutations = {
  menus: (state, value) => (state.menus = value),
}

const actions = {
  async fetchMenus({ commit }) {
    const result = await axios.get('api/menus')
    commit('menus', result.data)
  },
}

const getters = {
  menus: (state) => state.menus,
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions,
}
