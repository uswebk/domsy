export const state = () => ({
  greeting: '',
  greetingType: '',
  canStore: false,
  canUpdate: false,
  canDelete: false,
  pageLoading: true,
  registrars: [],
})

export const mutations = {
  greeting: (state, value) => (state.greeting = value),
  greetingType: (state, value) => (state.greetingType = value),
  pageLoading: (state, value) => (state.pageLoading = value),
  registrars: (state, value) => (state.registrars = value),
  canStore: (state, value) => (state.canStore = value),
  canUpdate: (state, value) => (state.canUpdate = value),
  canDelete: (state, value) => (state.canDelete = value),
}

export const actions  = {
  sendMessage({ commit }, payload) {
    commit('greeting', payload.greeting)
    commit('greetingType', payload.greetingType)
  },

  async fetchRegistrars({ commit }) {
    commit('pageLoading', true)
    const result = await this.$axios.get('/api/registrar')
    commit('registrars', result.data)
    commit('pageLoading', false)
  },

  async storeRegistrar({ dispatch }, payload) {
    const result = await this.$axios.post('/api/registrar/', {
      ...payload,
    })
    dispatch('fetchRegistrars')

    return result
  },

  async updateRegistrar({ dispatch }, payload) {
    const result = await this.$axios.put('/api/registrar/' + payload.id, {
      ...payload,
    })
    dispatch('fetchRegistrars')

    return result
  },

  async deleteRegistrar({ dispatch }, payload) {
    const result = await this.$axios.delete('/api/registrar/' + payload.id, {
      ...payload,
    })
    dispatch('fetchRegistrars')

    return result
  },

  async initRole({ commit }) {
    const result = await this.$axios.get('/api/role/user/?menu_id=4')

    commit('canStore', result.data.store)
    commit('canUpdate', result.data.update)
    commit('canDelete', result.data.delete)
  },
}

export const getters = {
  greeting: (state) => state.greeting,
  greetingType: (state) => state.greetingType,
  registrars: (state) => state.registrars,
  canStore: (state) => state.canStore,
  canUpdate: (state) => state.canUpdate,
  canDelete: (state) => state.canDelete,
  pageLoading: (state) => state.pageLoading,
}