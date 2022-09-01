import axios from 'axios'

const state = {
  greeting: '',
  greetingType: '',
  pageLoading: false,
  finishedLoginCheck: false,
  me: {},
}

const mutations = {
  greeting: (state, value) => (state.greeting = value),
  greetingType: (state, value) => (state.greetingType = value),
  pageLoading: (state, value) => (state.pageLoading = value),
  isLogin: (state, value) => (state.isLogin = value),
  finishedLoginCheck: (state, value) => (state.finishedLoginCheck = value),
  me: (state, value) => (state.me = value),
}

const actions = {
  sendMessage({ commit }, payload) {
    commit('greeting', payload.greeting)
    commit('greetingType', payload.greetingType)
  },

  async fetchMe({ commit }) {
    const result = await axios.get('api/me')
    const me = result.data
    me.avatarName = me.name.charAt(0)
    commit('me', me)
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
    const result = await axios.post('/api/login', {
      ...payload,
    })
    commit('pageLoading', false)

    return result
  },
  async logout({ commit }) {
    commit('pageLoading', true)
    await axios.post('/logout')
    commit('pageLoading', false)
  },

  async register({ commit }, payload) {
    commit('pageLoading', true)
    const result = await axios.post('/api/register', {
      ...payload,
    })
    commit('pageLoading', false)

    return result
  },
  async registerCorporation({ commit }, payload) {
    commit('pageLoading', true)
    const result = await axios.post('/api/corporation/register', {
      ...payload,
    })
    commit('pageLoading', false)

    return result
  },

  async resendEmail({ commit }) {
    commit('pageLoading', true)
    const result = await axios.post('/email/resend', {})
    commit('pageLoading', false)

    return result
  },

  async sendResetLink({ commit }, email) {
    commit('pageLoading', true)
    const result = await axios.post('/password/email', { email: email })
    commit('pageLoading', false)

    return result
  },

  async resetPassword({ commit }, payload) {
    commit('pageLoading', true)
    const result = await axios.post('/password/reset', { ...payload })
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
  me: (state) => state.me,
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions,
}
