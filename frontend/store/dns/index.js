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
  page: 1,
  pageSize: 10,
  searchWord: '',
  applyResults: [
    {
      successList: [],
      errorList: [],
    },
  ],
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
  page: (state, value) => (state.page = value),
  searchWord: (state, value) => (state.searchWord = value),
  applyResults: (state, value) => (state.applyResults = value),
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

  async fetchDnsRecordTypes({ commit }) {
    const result = await this.$axios.get('/api/dns-record-type')

    commit('dnsRecordTypes', result.data)
  },

  async storeDns({ dispatch }, payload) {
    const result = await this.$axios.post('/api/dns/', {
      ...payload,
    })
    dispatch('fetchDns')

    return result
  },

  async updateDns({ dispatch }, payload) {
    const result = await this.$axios.put('/api/dns/' + payload.id, {
      ...payload,
    })
    dispatch('fetchDns')

    return result
  },

  async deleteDns({ dispatch }, payload) {
    const result = await this.$axios.delete('/api/dns/' + payload.id, {
      ...payload,
    })
    dispatch('fetchDns')

    return result
  },

  async applyRecord({ dispatch, commit }) {
    const result = await this.$axios.post('/api/dns/apply')
    dispatch('fetchDns')

    console.log(result.data)
    commit('applyResults', result.data)

    // 成功ドメインリスト, 失敗ドメインリスト を格納
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
  page: (state) => state.page,
  pageSize: (state) => state.pageSize,
  searchWord: (state) => state.searchWord,
  applyResults: (state) => state.applyResults,
}
