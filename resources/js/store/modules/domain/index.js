import axios from 'axios'

const state = {
  greeting: '',
  greetingType: '',
  canStore: false,
  canUpdate: false,
  canDelete: false,
  pageLoading: true,
  domains: [{ active: [], inactive: [], managementOnly: [], transferred: [] }],
}

const mutations = {
  greeting: (state, value) => (state.greeting = value),
  greetingType: (state, value) => (state.greetingType = value),
  pageLoading: (state, value) => (state.pageLoading = value),
  domains: (state, domains) => (state.domains = domains),
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
      transferred: [],
      managementOnly: [],
      active: [],
      inactive: [],
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
    commit('pageLoading', false)
  },

  async updateDomain({ dispatch }, payload) {
    const result = await axios.put('/api/domains/' + payload.id, {
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
  domainHeaders: () => [
    {
      text: 'Name',
      value: 'name',
    },
    {
      text: 'Price',
      value: 'price',
    },
    {
      text: 'Active',
      value: 'is_active',
    },
    {
      text: 'Purchased Date',
      value: 'purchased_at',
    },
    {
      text: 'Expired Date',
      value: 'expired_at',
    },
    {
      text: 'Canceled Date',
      value: 'canceled_at',
    },
    {
      text: 'Action',
      value: 'action',
      sortable: false,
    },
  ],
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions,
}
