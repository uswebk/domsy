export const state = () => ({
  greeting: '',
  greetingType: '',
  canStore: false,
  canUpdate: false,
  canDelete: false,
  pageLoading: true,
  clients: [],
})

export const mutations = {
  greeting: (state, value) => (state.greeting = value),
  greetingType: (state, value) => (state.greetingType = value),
  pageLoading: (state, value) => (state.pageLoading = value),
  clients: (state, value) => (state.clients = value),
  canStore: (state, value) => (state.canStore = value),
  canUpdate: (state, value) => (state.canUpdate = value),
  canDelete: (state, value) => (state.canDelete = value),
}

export const actions  = {
  sendMessage({ commit }, payload) {
    commit('greeting', payload.greeting)
    commit('greetingType', payload.greetingType)
  },

  async fetchClients({ commit }) {
    commit('pageLoading', true)
    const result = await this.$axios.get('/api/client')
    commit('clients', result.data)
    commit('pageLoading', false)
  },

  async storeClient({ dispatch }, payload) {
    const result = await this.$axios.post('/api/client', {
      ...payload,
    })
    dispatch('fetchClients')

    return result
  },

  async updateClient({ dispatch }, payload) {
    const result = await this.$axios.put('/api/client/' + payload.id, {
      ...payload,
    })
    dispatch('fetchClients')

    return result
  },

  async deleteClient({ dispatch }, payload) {
    const result = await this.$axios.delete('/api/client/' + payload.id, {
      ...payload,
    })
    dispatch('fetchClients')

    return result
  },

  async initRole({ commit }) {
    const result = await this.$axios.get('/api/role/user/?menu_id=5')

    commit('canStore', result.data.store)
    commit('canUpdate', result.data.update)
    commit('canDelete', result.data.delete)
  },
}

export const getters = {
  greeting: (state) => state.greeting,
  greetingType: (state) => state.greetingType,
  clients: (state) => state.clients,
  canStore: (state) => state.canStore,
  canUpdate: (state) => state.canUpdate,
  canDelete: (state) => state.canDelete,
  pageLoading: (state) => state.pageLoading,
}