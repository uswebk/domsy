import axios from 'axios'

const state = {
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
}

const mutations = {
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

const actions = {
  sendMessage({ commit }, payload) {
    commit('greeting', payload.greeting)
    commit('greetingType', payload.greetingType)
  },

  async fetchRoles({ commit }) {
    commit('pageLoading', true)

    const result = await axios.get('api/roles')

    commit('roles', result.data)
    commit('pageLoading', false)
  },

  async fetchAccounts({ commit }) {
    commit('pageLoading', true)

    const result = await axios.get('/api/users')

    commit('accounts', result.data)
    commit('pageLoading', false)
  },

  async storeAccount({ dispatch }, payload) {
    const result = await axios.post('/api/accounts/', {
      ...payload,
    })

    dispatch('fetchAccounts')

    return result
  },

  async updateAccount({ dispatch }, payload) {
    const result = await axios.put('/api/accounts/' + payload.id, {
      ...payload,
    })

    dispatch('fetchAccounts')

    return result
  },

  async deleteAccount({ dispatch }, payload) {
    const result = await axios.delete('/api/accounts/' + payload.id, {
      ...payload,
    })

    dispatch('fetchAccounts')

    return result
  },

  async initRole({ commit }) {
    const result = await axios.get('/api/roles/user/?menu_id=8')

    commit('canStore', result.data.store)
    commit('canUpdate', result.data.update)
    commit('canDelete', result.data.delete)
    commit('canRoleStore', result.data.roleStore)
    commit('canRoleUpdate', result.data.roleUpdate)
    commit('canRoleDelete', result.data.roleDelete)
  },
}

const getters = {
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

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions,
}
