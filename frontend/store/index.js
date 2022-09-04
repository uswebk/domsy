export const state = () => ({
  pageLoading: false,
})

export const mutations = {
  pageLoading: (state, value) => (state.pageLoading = value),
}

export const actions = {
  async verifyUrl({commit},payload) {
    const result = await this.$axios.get(
      '/api/verify/url/' +
        payload.params.id +
        '/' +
        payload.params.hash +
        '?expires=' +
        payload.query.expires +
        '&signature=' +
        payload.query.signature
    )

    return result
  },
}

export const getters = {
  pageLoading: (state) => state.pageLoading,
}
