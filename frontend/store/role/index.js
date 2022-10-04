export const state = () => ({
  greeting: '',
  greetingType: '',
  canStore: false,
  canUpdate: false,
  canDelete: false,
  pageLoading: false,
  roles: [],
  roleItems: [],
})

export const mutations = {
  greeting: (state, value) => (state.greeting = value),
  greetingType: (state, value) => (state.greetingType = value),
  pageLoading: (state, value) => (state.pageLoading = value),
  roles: (state, value) => (state.roles = value),
  roleItems: (state, value) => (state.roleItems = value),
  canStore: (state, value) => (state.canStore = value),
  canUpdate: (state, value) => (state.canUpdate = value),
  canDelete: (state, value) => (state.canDelete = value),
}

export const actions = {
  sendMessage({ commit }, payload) {
    commit('greeting', payload.greeting)
    commit('greetingType', payload.greetingType)
  },

  async fetchRoles({ commit }) {
    commit('pageLoading', true)
    const result = await this.$axios.get('api/role')
    commit('roles', result.data)
    commit('pageLoading', false)
  },

  async fetchRoleItems({ commit }) {
    const result = await this.$axios.get('api/menus/items')
    commit('roleItems', result.data)
  },

  async storeRole({ dispatch }, payload) {
    const result = await this.$axios.post('/api/role/', {
      ...payload,
    })
    dispatch('fetchRoles')

    return result
  },

  async updateRole({ dispatch }, payload) {
    const result = await this.$axios.put('/api/role/' + payload.id, {
      ...payload,
    })
    dispatch('fetchRoles')

    return result
  },

  async deleteRole({ dispatch }, payload) {
    const result = await this.$axios.delete('/api/role/' + payload.id, {
      ...payload,
    })
    dispatch('fetchRoles')

    return result
  },

  async initRole({ commit }) {
    const result = await this.$axios.get('/api/role/has/?menu_id=10')

    commit('canStore', result.data.store)
    commit('canUpdate', result.data.update)
    commit('canDelete', result.data.delete)
  },
}

export const getters = {
  greeting: (state) => state.greeting,
  greetingType: (state) => state.greetingType,
  roles: (state) => state.roles,
  roleItems: (state) => state.roleItems,
  canStore: (state) => state.canStore,
  canUpdate: (state) => state.canUpdate,
  canDelete: (state) => state.canDelete,
  pageLoading: (state) => state.pageLoading,
}
