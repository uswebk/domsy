export const state = () => ({
  pageLoading: false,
  isLogin: false,
  finishedLoginCheck: false,
  me: {},
})

export const mutations = {
  pageLoading: (state, value) => (state.pageLoading = value),
  isLogin: (state, value) => (state.isLogin = value),
  finishedLoginCheck: (state, value) => (state.finishedLoginCheck = value),
  me: (state, value) => (state.me = value),
}

export const actions = {
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
}

export const getters = {
  pageLoading: (state) => state.pageLoading,
  isLogin: (state) => state.isLogin,
  finishedLoginCheck: (state) => state.finishedLoginCheck,
  me: (state) => state.me,
}
