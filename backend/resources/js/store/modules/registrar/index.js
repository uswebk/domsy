import axios from 'axios'

const state = {
  greeting: '',
  greetingType: '',
  canStore: false,
  canUpdate: false,
  canDelete: false,
  pageLoading: true,
  registrars: [],
}

const mutations = {
  greeting: (state, value) => (state.greeting = value),
  greetingType: (state, value) => (state.greetingType = value),
  pageLoading: (state, value) => (state.pageLoading = value),
  registrars: (state, value) => (state.registrars = value),
  canStore: (state, value) => (state.canStore = value),
  canUpdate: (state, value) => (state.canUpdate = value),
  canDelete: (state, value) => (state.canDelete = value),
}

const actions = {
  sendMessage({ commit }, payload) {
    commit('greeting', payload.greeting)
    commit('greetingType', payload.greetingType)
  },

  async fetchRegistrars({ commit }) {
    commit('pageLoading', true)

    const result = await axios.get('/api/registrars')

    commit('registrars', result.data)
    commit('pageLoading', false)
  },

  async storeRegistrar({ dispatch }, payload) {
    const result = await axios.post('/api/registrars/', {
      ...payload,
    })

    dispatch('fetchRegistrars')

    return result
  },

  async updateRegistrar({ dispatch }, payload) {
    const result = await axios.put('/api/registrars/' + payload.id, {
      ...payload,
    })

    dispatch('fetchRegistrars')

    return result
  },

  async deleteRegistrar({ dispatch }, payload) {
    const result = await axios.delete('/api/registrars/' + payload.id, {
      ...payload,
    })

    dispatch('fetchRegistrars')

    return result
  },

  async initRole({ commit }) {
    let result = await axios.get('/api/roles/user/?menu_id=4')

    commit('canStore', result.data.store)
    commit('canUpdate', result.data.update)
    commit('canDelete', result.data.delete)
  },
}

const getters = {
  greeting: (state) => state.greeting,
  greetingType: (state) => state.greetingType,
  registrars: (state) => state.registrars,
  canStore: (state) => state.canStore,
  canUpdate: (state) => state.canUpdate,
  canDelete: (state) => state.canDelete,
  pageLoading: (state) => state.pageLoading,
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions,
}
