import axios from 'axios'

const state = {
  greeting: '',
  greetingType: '',
  canStore: false,
  canUpdate: false,
  canDelete: false,
  pageLoading: true,
  dealings: [{ active: [], stop: [] }],
  tabs: [],
}

const mutations = {
  greeting: (state, value) => (state.greeting = value),
  greetingType: (state, value) => (state.greetingType = value),
  pageLoading: (state, value) => (state.pageLoading = value),
  dealings: (state, value) => (state.dealings = value),
  tabs: (state, value) => (state.tabs = value),
  canStore: (state, value) => (state.canStore = value),
  canUpdate: (state, value) => (state.canUpdate = value),
  canDelete: (state, value) => (state.canDelete = value),
}

const actions = {
  sendMessage({ commit }, payload) {
    commit('greeting', payload.greeting)
    commit('greetingType', payload.greetingType)
  },

  async fetchDealings({ commit }) {
    commit('pageLoading', true)
    const result = await axios.get('/api/dealings')

    let dealings = {
      active: [],
      stop: [],
    }

    result.data.forEach((domain) => {
      domain.domain_dealings.forEach((dealing) => {
        dealing.domain = domain.name
        if (dealing.is_halt) {
          dealings.stop.push(dealing)
        } else {
          dealings.active.push(dealing)
        }
      })
    })

    // for (let key in result.data) {
    //   for (let key2 in result.data[key].domain_dealings) {
    //     let dealing = result.data[key].domain_dealings[key2]
    //     dealing.domain = result.data[key].name

    //     if (dealing.is_halt) {
    //       dealings_stops.push(dealing)
    //     } else {
    //       dealings_actives.push(dealing)
    //     }
    //   }
    // }

    commit('dealings', dealings)
    commit('tabs', Object.keys(dealings))
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
  dealings: (state) => state.dealings,
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
