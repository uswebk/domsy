<template>
  <div>
    <div v-if="loading" style="text-align: center">
      <v-sheet color="grey lighten-4" class="pa-3">
        <v-progress-circular
          indeterminate
          color="#2EBFAF"
        ></v-progress-circular>
      </v-sheet>
    </div>
    <div v-else>
      <v-card class="pa-5">
        <v-card-title>Expiring Soon Domain List</v-card-title>
        <v-simple-table>
          <thead>
            <tr>
              <th class="text-left">Name</th>
              <th class="text-left">Expired</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="domain in domains" :key="domain.id">
              <td>{{ domain.name }}</td>
              <td>{{ $dateHelper.dateHyphen(domain.expired_at) }}</td>
            </tr>
          </tbody>
        </v-simple-table>
      </v-card>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'DomainExpiredList',
  data() {
    return {
      loading: true,
      domains: {},
    }
  },

  methods: {
    async initDomains() {
      const result = await axios.get('/api/domains/sort-expired?count=5')

      this.domains = result.data
    },
  },

  async created() {
    this.loading = true

    await this.initDomains()

    this.loading = false
  },
}
</script>
