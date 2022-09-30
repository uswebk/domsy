export const state = () => ({
  greeting: '',
  greetingType: '',
  canStore: false,
  canUpdate: false,
  canDelete: false,
  canRoleStore: false,
  canRoleUpdate: false,
  canRoleDelete: false,
  pageLoading: false,
  roles: [],
  accounts: [],
  tabs: [],
})

export const mutations = {
  greeting: (state, value) => (state.greeting = value),
  greetingType: (state, value) => (state.greetingType = value),
  pageLoading: (state, value) => (state.pageLoading = value),
  roles: (state, value) => (state.roles = value),
  accounts: (state, value) => (state.accounts = value),
  canStore: (state, value) => (state.canStore = value),
  canUpdate: (state, value) => (state.canUpdate = value),
  canDelete: (state, value) => (state.canDelete = value),
  canRoleStore: (state, value) => (state.canRoleStore = value),
  canRoleUpdate: (state, value) => (state.canRoleUpdate = value),
  canRoleDelete: (state, value) => (state.canRoleDelete = value),
}

export const actions = {
  sendMessage({ commit }, payload) {
    commit('greeting', payload.greeting)
    commit('greetingType', payload.greetingType)
  },

  initMessage({ commit }) {
    commit('greeting', '')
    commit('greetingType', '')
  },

  async fetchRoles({ commit }) {
    commit('pageLoading', true)
    const result = await this.$axios.get('api/role')
    commit('roles', result.data)
    commit('pageLoading', false)
  },

  async fetchAccounts({ commit }) {
    commit('pageLoading', true)
    const result = await this.$axios.get('/api/user')
    commit('accounts', result.data)
    commit('pageLoading', false)
  },

  async storeAccount({ dispatch }, payload) {
    const result = await this.$axios.post('/api/account/', {
      ...payload,
    })
    dispatch('fetchAccounts')

    return result
  },

  async updateAccount({ dispatch }, payload) {
    const result = await this.$axios.put('/api/account/' + payload.id, {
      ...payload,
    })
    dispatch('fetchAccounts')

    return result
  },

  async updateProfile({ dispatch }, payload) {
    const result = await this.$axios.put('/api/me/' + payload.id, {
      ...payload,
    })
    return result
  },

  async deleteAccount({ dispatch }, payload) {
    const result = await this.$axios.delete('/api/account/' + payload.id, {
      ...payload,
    })
    dispatch('fetchAccounts')

    return result
  },

  async withdrawAccount({ dispatch }, payload) {
    // const result = await this.$axios.post('/api/account/withdraw/' + payload.id)
    // return result
  },

  async initRole({ commit }) {
    const result = await this.$axios.get('/api/role/has/?menu_id=8')

    commit('canStore', result.data.store)
    commit('canUpdate', result.data.update)
    commit('canDelete', result.data.delete)
    commit('canRoleStore', result.data.roleStore)
    commit('canRoleUpdate', result.data.roleUpdate)
    commit('canRoleDelete', result.data.roleDelete)
  },
}

export const getters = {
  greeting: (state) => state.greeting,
  greetingType: (state) => state.greetingType,
  accounts: (state) => state.accounts,
  roles: (state) => state.roles,
  canStore: (state) => state.canStore,
  canUpdate: (state) => state.canUpdate,
  canDelete: (state) => state.canDelete,
  canRoleStore: (state) => state.canRoleStore,
  canRoleUpdate: (state) => state.canRoleUpdate,
  canRoleDelete: (state) => state.canRoleDelete,
  pageLoading: (state) => state.pageLoading,
  tabs: (state) => state.tabs,
}
