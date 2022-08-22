import axios from 'axios'

const state = {
  domains: [{ active: [], inactive: [], managementOnly: [], transferred: [] }],
  canStore: false,
  canUpdate: false,
  canDelete: false,
}

const mutations = {
  domains: (state, domains) => (state.domains = domains),
  canStore: (state, value) => (state.canStore = value),
  canUpdate: (state, value) => (state.canUpdate = value),
  canDelete: (state, value) => (state.canDelete = value),
}

const actions = {
  async fetchDomains({ commit }) {
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
  },

  async checkRole({ commit }) {
    let result = await axios.get('/api/roles/user/?menu_id=2')

    commit('canStore', result.data.store)
    commit('canUpdate', result.data.update)
    commit('canDelete', result.data.delete)
  },
}

const getters = {
  domains: (state) => state.domains,
  canStore: (state) => state.canStore,
  canUpdate: (state) => state.canUpdate,
  canDelete: (state) => state.canDelete,
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
