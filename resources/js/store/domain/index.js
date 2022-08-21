const state = {}

const mutations = {}

const actions = {}

const getters = {
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
