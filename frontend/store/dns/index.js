export const state = () => ({
  greeting: '',
  greetingType: '',
  canStore: false,
  canUpdate: false,
  canDelete: false,
  pageLoading: true,
  dns: [],
  domains: [],
  dnsRecordTypes: [],
  domainId: {},
  pagiNation: {
    page: 1,
    size: 10,
  },
})

export const mutations = {
  greeting: (state, value) => (state.greeting = value),
  greetingType: (state, value) => (state.greetingType = value),
  pageLoading: (state, value) => (state.pageLoading = value),
  dns: (state, value) => (state.dns = value),
  domains: (state, value) => (state.domains = value),
  dnsRecordTypes: (state, value) => (state.dnsRecordTypes = value),
  domainId: (state, value) => (state.domainId = value),
  canStore: (state, value) => (state.canStore = value),
  canUpdate: (state, value) => (state.canUpdate = value),
  canDelete: (state, value) => (state.canDelete = value),
  pagiNation: (state, value) => (state.pagiNation = value),
}

export const actions = {
  sendMessage({ commit }, payload) {
    commit('greeting', payload.greeting)
    commit('greetingType', payload.greetingType)
  },

  async fetchDns({ commit }, payload) {
    commit('pageLoading', true)
    const result = await this.$axios.get('/api/dns', {
      params: {
        ...payload,
      },
    })

    commit('dns', result.data)
    commit('pageLoading', false)
  },

  async fetchDnsPaging({ commit }, pagiNation) {
    commit('pageLoading', true)
    // TODO: use keyword query
    const result = await this.$axios.get('/api/dns', {
      params: {
        ...pagiNation,
      },
    })
    commit('dns', result.data)
    commit('pageLoading', false)
  },

  async fetchDnsRecordTypes({ commit }) {
    const result = await this.$axios.get('/api/dns-record-type')

    commit('dnsRecordTypes', result.data)
  },

  async storeDns({ dispatch }, payload) {
    // TODO: Pagination
    const result = await this.$axios.post('/api/dns/', {
      ...payload,
    })

    dispatch('fetchDns')

    return result
  },

  async updateDns({ dispatch }, payload) {
    // TODO: Pagination
    const result = await this.$axios.put('/api/dns/' + payload.id, {
      ...payload,
    })

    dispatch('fetchDns')

    return result
  },

  async deleteDns({ dispatch }, payload) {
    // TODO: Pagination
    const result = await this.$axios.delete('/api/dns/' + payload.id, {
      ...payload,
    })

    dispatch('fetchDns')

    return result
  },

  async initRole({ commit }) {
    const result = await this.$axios.get('/api/role/has/?menu_id=3')

    commit('canStore', result.data.store)
    commit('canUpdate', result.data.update)
    commit('canDelete', result.data.delete)
  },
}

export const getters = {
  greeting: (state) => state.greeting,
  greetingType: (state) => state.greetingType,
  dns: (state) => state.dns,
  domains: (state) => state.domains,
  dnsRecordTypes: (state) => state.dnsRecordTypes,
  domainId: (state) => state.domainId,
  canStore: (state) => state.canStore,
  canUpdate: (state) => state.canUpdate,
  canDelete: (state) => state.canDelete,
  pageLoading: (state) => state.pageLoading,
  pagiNation: (state) => state.pagiNation,
}
