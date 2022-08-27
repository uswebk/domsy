import axios from 'axios'

const state = {
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
}

const mutations = {
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
}

const actions = {
  sendMessage({ commit }, payload) {
    commit('greeting', payload.greeting)
    commit('greetingType', payload.greetingType)
  },

  // TODO: VueRouter使用後、クエリパラメータから絞り込みできるようにする
  async fetchDns({ commit }) {
    commit('pageLoading', true)

    const result = await axios.get('/api/dns')

    commit('dns', result.data)
    commit('pageLoading', false)
  },

  async fetchDomains({ commit }) {
    const result = await axios.get('/api/domains')

    commit('domains', result.data)
  },

  async fetchDnsRecordTypes({ commit }) {
    const result = await axios.get('/api/dns-record-type')

    commit('dnsRecordTypes', result.data)
  },

  async storeDns({ dispatch }, payload) {
    const result = await axios.post('/api/dns/', {
      ...payload,
    })

    dispatch('fetchDns')

    return result
  },

  async updateDns({ dispatch }, payload) {
    const result = await axios.put('/api/dns/' + payload.id, {
      ...payload,
    })

    dispatch('fetchDns')

    return result
  },

  async deleteDns({ dispatch }, payload) {
    const result = await axios.delete('/api/dns/' + payload.id, {
      ...payload,
    })

    dispatch('fetchDns')

    return result
  },

  async initRole({ commit }) {
    let result = await axios.get('/api/roles/user/?menu_id=3')

    commit('canStore', result.data.store)
    commit('canUpdate', result.data.update)
    commit('canDelete', result.data.delete)
  },
}

const getters = {
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
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions,
}
