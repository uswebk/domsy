import axios from 'axios'

const state = {
  greeting: '',
  greetingType: '',
  pageLoading: false,
  finishedLoginCheck: false,
}

const mutations = {
  greeting: (state, value) => (state.greeting = value),
  greetingType: (state, value) => (state.greetingType = value),
  pageLoading: (state, value) => (state.pageLoading = value),
  isLogin: (state, value) => (state.isLogin = value),
  finishedLoginCheck: (state, value) => (state.finishedLoginCheck = value),
}

const actions = {
  sendMessage({ commit }, payload) {
    commit('greeting', payload.greeting)
    commit('greetingType', payload.greetingType)
  },

  async checkLogin({ commit }) {
    try {
      const result = await axios.get('api/me')
      if (result.status === 200) {
        commit('isLogin', true)
      }
    } catch (error) {
      commit('isLogin', false)
    }

    commit('finishedLoginCheck', true)
  },

  async login({ commit }, payload) {
    commit('pageLoading', true)
    const result = await axios.post('/api/login/', {
      ...payload,
    })
    commit('pageLoading', false)

    return result
  },
}

const getters = {
  greeting: (state) => state.greeting,
  greetingType: (state) => state.greetingType,
  pageLoading: (state) => state.pageLoading,
  isLogin: (state) => state.isLogin,
  finishedLoginCheck: (state) => state.finishedLoginCheck,
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions,
}
