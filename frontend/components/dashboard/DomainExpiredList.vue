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
        <v-card-title class="light-blue--text text--darken-2">
          <v-avatar class="mr-3 light-blue darken-2">
            <v-icon dark>mdi-calendar-clock</v-icon>
          </v-avatar>
          Expiring Soon Domain List</v-card-title
        >
        <v-simple-table>
          <thead>
            <tr>
              <th class="text-left">Name</th>
              <th class="text-center">Expired</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="domain in soonExpiredDomains" :key="domain.id">
              <td>{{ domain.name }}</td>
              <td class="text-center">{{ $dateHyphen(domain.expired_at) }}</td>
            </tr>
          </tbody>
        </v-simple-table>
      </v-card>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'DomainExpiredList',
  data() {
    return {
      loading: true,
    }
  },
  computed: {
    ...mapGetters('dashboard/domains', ['soonExpiredDomains']),
  },
  async created() {
    this.loading = true
    await this.fetchSortedExpiryByCount(5)
    this.loading = false
  },
  methods: {
    ...mapActions('dashboard/domains', ['fetchSortedExpiryByCount']),
  },
}
</script>
