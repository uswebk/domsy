<template>
  <div v-if="loading" style="text-align: center">
    <v-sheet color="grey lighten-4" class="pa-3">
      <v-progress-circular indeterminate color="#2EBFAF"></v-progress-circular>
    </v-sheet>
  </div>
  <div v-else>
    <v-card color="#5684d5" dark tile style="box-shadow: none">
      <v-card-title class="justify-end"> Domain </v-card-title>
      <v-card-subtitle>Domain Seller </v-card-subtitle>
      <v-card-title class="text-h5 pt-0">
        <v-avatar size="32" class="mr-4" color="#e8c46a">
          <v-icon>mdi-database</v-icon>
        </v-avatar>
        {{ $formattedPriceYen(totalPrice) }}
      </v-card-title>
    </v-card>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'DomainSeller',
  data() {
    return {
      loading: true,
    }
  },
  computed: {
    ...mapGetters('dashboard/domains', ['totalPrice']),
  },
  async created() {
    this.loading = true
    await this.fetchTotalSeller()
    this.loading = false
  },
  methods: {
    ...mapActions('dashboard/domains', ['fetchTotalSeller']),
  },
}
</script>
