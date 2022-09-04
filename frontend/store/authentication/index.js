export const state = () => ({
  greeting: '',
  greetingType: '',
  pageLoading: false,
  isLogin: false,
  finishedLoginCheck: false,
  me: {},
})

export const mutations = {
  greeting: (state, value) => (state.greeting = value),
  greetingType: (state, value) => (state.greetingType = value),
  pageLoading: (state, value) => (state.pageLoading = value),
  isLogin: (state, value) => (state.isLogin = value),
  finishedLoginCheck: (state, value) => (state.finishedLoginCheck = value),
  me: (state, value) => (state.me = value),
}

export const actions = {
  sendMessage({ commit }, payload) {
    commit('greeting', payload.greeting)
    commit('greetingType', payload.greetingType)
  },

  async fetchMe({ commit }) {
    try {
      const result = await this.$axios.get('api/me')
      const me = result.data
      me.avatarName = me.name.charAt(0)
      commit('me', me)
    } catch (error) {
      commit('me', null)
    }
  },

  async checkLogin({ commit }) {
    try {
      const result = await this.$axios.get('api/me')
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
    const result = await this.$axios.post('/api/login', {
      ...payload,
    })
    commit('pageLoading', false)

    return result
  },

  async logout({ commit }) {
    commit('pageLoading', true)
    await this.$axios.post('/api/logout')
    commit('pageLoading', false)
  },

  async register({ commit }, payload) {
    commit('pageLoading', true)
    const result = await this.$axios.post('/api/register', {
      ...payload,
    })
    commit('pageLoading', false)

    return result
  },

  async registerCorporation({ commit }, payload) {
    commit('pageLoading', true)
    const result = await this.$axios.post('/api/corporation/register', {
      ...payload,
    })
    commit('pageLoading', false)

    return result
  },

  async resendEmail({ commit }) {
    commit('pageLoading', true)
    const result = await this.$axios.post('/api/email/resend', {})
    commit('pageLoading', false)

    return result
  },

  async sendResetLink({ commit }, email) {
    commit('pageLoading', true)
    const result = await this.$axios.post('/api/password/email', { email })
    commit('pageLoading', false)

    return result
  },

  async resetPassword({ commit }, payload) {
    commit('pageLoading', true)
    const result = await this.$axios.post('/api/password/reset', { ...payload })
    commit('pageLoading', false)

    return result
  },
}

export const getters = {
  greeting: (state) => state.greeting,
  greetingType: (state) => state.greetingType,
  pageLoading: (state) => state.pageLoading,
  isLogin: (state) => state.isLogin,
  finishedLoginCheck: (state) => state.finishedLoginCheck,
  me: (state) => state.me,
}
