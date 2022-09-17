export const state = () => ({
  greeting: '',
  greetingType: '',
  canStore: false,
  canUpdate: false,
  canDelete: false,
  pageLoading: true,
  categorizedDomains: {
    active: [],
    inactive: [],
    managementOnly: [],
    transferred: [],
  },
  domains: [],
  tabs: [],
})

export const mutations = {
  greeting: (state, value) => (state.greeting = value),
  greetingType: (state, value) => (state.greetingType = value),
  pageLoading: (state, value) => (state.pageLoading = value),
  categorizedDomains: (state, value) => (state.categorizedDomains = value),
  domains: (state, value) => (state.domains = value),
  canStore: (state, value) => (state.canStore = value),
  canUpdate: (state, value) => (state.canUpdate = value),
  canDelete: (state, value) => (state.canDelete = value),
}

export const actions = {
  sendMessage({ commit }, payload) {
    commit('greeting', payload.greeting)
    commit('greetingType', payload.greetingType)
  },

  async fetchCategorizedDomains({ commit }) {
    commit('pageLoading', true)
    const result = await this.$axios.get('/api/domain')

    const domains = {
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
    commit('categorizedDomains', domains)
    commit('pageLoading', false)
  },

  async fetchDomains({ commit }) {
    commit('pageLoading', true)
    const result = await this.$axios.get('/api/domain')
    commit('domains', result.data)
    commit('pageLoading', false)
  },

  async storeDomain({ dispatch }, payload) {
    const result = await this.$axios.post('/api/domain/', {
      ...payload,
    })
    dispatch('fetchDomains')
    dispatch('fetchCategorizedDomains')

    return result
  },

  async updateDomain({ dispatch }, payload) {
    const result = await this.$axios.put('/api/domain/' + payload.id, {
      ...payload,
    })
    dispatch('fetchDomains')
    dispatch('fetchCategorizedDomains')

    return result
  },

  async deleteDomain({ dispatch }, payload) {
    const result = await this.$axios.delete('/api/domain/' + payload.id, {
      ...payload,
    })
    dispatch('fetchDomains')
    dispatch('fetchCategorizedDomains')

    return result
  },

  async initRole({ commit }) {
    const result = await this.$axios.get('/api/role/has/?menu_id=2')

    commit('canStore', result.data.store)
    commit('canUpdate', result.data.update)
    commit('canDelete', result.data.delete)
  },
}

export const getters = {
  greeting: (state) => state.greeting,
  greetingType: (state) => state.greetingType,
  domains: (state) => state.domains,
  categorizedDomains: (state) => state.categorizedDomains,
  canStore: (state) => state.canStore,
  canUpdate: (state) => state.canUpdate,
  canDelete: (state) => state.canDelete,
  pageLoading: (state) => state.pageLoading,
  tabs: (state) => state.tabs,
}
