import axios from 'axios'

const state = {
  greeting: '',
  greetingType: '',
  canStore: false,
  canUpdate: false,
  canDelete: false,
  pageLoading: true,
  domains: [{ active: [], inactive: [], managementOnly: [], transferred: [] }],
  tabs: [],
}

const mutations = {
  greeting: (state, value) => (state.greeting = value),
  greetingType: (state, value) => (state.greetingType = value),
  pageLoading: (state, value) => (state.pageLoading = value),
  domains: (state, domains) => (state.domains = domains),
  tabs: (state, tabs) => (state.tabs = tabs),
  canStore: (state, value) => (state.canStore = value),
  canUpdate: (state, value) => (state.canUpdate = value),
  canDelete: (state, value) => (state.canDelete = value),
}

const actions = {
  sendMessage({ commit }, payload) {
    commit('greeting', payload.greeting)
    commit('greetingType', payload.greetingType)
  },

  async fetchDomains({ commit }) {
    commit('pageLoading', true)

    const result = await axios.get('/api/domains')

    let domains = {
      active: [],
      inactive: [],
      managementOnly: [],
      transferred: [],
    }

    result.data.forEach((domain) => {
      if (domain.is_transferred) {
        domains.transferred.push(domain)
      }

      if (domain.is_management_only) {
        domains.managementOnly.push(domain)
      }

      if (domain.is_active) {
        domains.active.push(domain)
      } else {
        domains.inactive.push(domain)
      }
    })

    commit('domains', domains)
    commit('tabs', Object.keys(domains))
    commit('pageLoading', false)
  },

  async storeDomain({ dispatch }, payload) {
    const result = await axios.post('/api/domains/', {
      ...payload,
    })

    dispatch('fetchDomains')

    return result
  },

  async updateDomain({ dispatch }, payload) {
    const result = await axios.put('/api/domains/' + payload.id, {
      ...payload,
    })

    dispatch('fetchDomains')

    return result
  },

  async deleteDomain({ dispatch }, payload) {
    const result = await axios.delete('/api/domains/' + payload.id, {
      ...payload,
    })

    dispatch('fetchDomains')

    return result
  },

  async initRole({ commit }) {
    let result = await axios.get('/api/roles/user/?menu_id=2')

    commit('canStore', result.data.store)
    commit('canUpdate', result.data.update)
    commit('canDelete', result.data.delete)
  },
}

const getters = {
  greeting: (state) => state.greeting,
  greetingType: (state) => state.greetingType,
  domains: (state) => state.domains,
  canStore: (state) => state.canStore,
  canUpdate: (state) => state.canUpdate,
  canDelete: (state) => state.canDelete,
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
