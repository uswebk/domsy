export const state = () => ({
  greeting: '',
  greetingType: '',
  pageLoading: false,
  mailSettings: [],
  generalSettings: [],
})

export const mutations = {
  greeting: (state, value) => (state.greeting = value),
  greetingType: (state, value) => (state.greetingType = value),
  pageLoading: (state, value) => (state.pageLoading = value),
  mailSettings: (state, value) => (state.mailSettings = value),
  generalSettings: (state, value) => (state.generalSettings = value),
}

export const actions  = {
  sendMessage({ commit }, payload) {
    commit('greeting', payload.greeting)
    commit('greetingType', payload.greetingType)
  },

  async fetchMailSettings({ commit }) {
    commit('pageLoading', true)
    const result = await this.$axios.get('/api/setting/user-mails')
    const settings = {}
    for (const key in result.data) {
      settings[result.data[key].name] = result.data[key]
    }
    commit('mailSettings', settings)
    commit('pageLoading', false)
  },

  async fetchGeneralSettings({ commit }) {
    commit('pageLoading', true)
    const result = await this.$axios.get('/api/setting/user-generals')
    const settings = {}
    for (const key in result.data) {
      settings[result.data[key].name] = result.data[key]
    }
    commit('generalSettings', settings)
    commit('pageLoading', false)
  },

  async updateMailSetting({ dispatch }, payload) {
    const result = await this.$axios.put('/api/setting/user-mails/', {
      ...payload,
    })
    await dispatch('fetchMailSettings')

    return result
  },

  async updateGeneralSetting({ dispatch }, payload) {
    const result = await this.$axios.put('/api/setting/user-generals/', {
      ...payload,
    })
    await dispatch('fetchGeneralSettings')

    return result
  },
}

export const getters = {
  greeting: (state) => state.greeting,
  greetingType: (state) => state.greetingType,
  mailSettings: (state) => state.mailSettings,
  pageLoading: (state) => state.pageLoading,
  generalSettings: (state) => state.generalSettings,
}