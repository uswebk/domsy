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
        <v-card-title>Billing Soon Dealing List</v-card-title>
        <v-simple-table>
          <thead>
            <tr>
              <th class="text-left">Domain Name</th>
              <th class="text-left">Billing Date</th>
              <th class="text-left">Price</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="billing in billings" :key="billing.id">
              <td>{{ billing.domain_name }}</td>
              <td>{{ formattedDate(billing.billing_date) }}</td>
              <td>{{ formattedPrice(billing.total) }}</td>
            </tr>
          </tbody>
        </v-simple-table>
      </v-card>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import { shortHyphenDate } from '../../modules/DateHelper'
import { priceFormat } from '../../modules/AppHelper'

export default {
  data() {
    return {
      loading: true,
      billings: {},
    }
  },

  methods: {
    async initBillings() {
      const result = await axios.get(
        '/api/dealings/billings/sort-billing-date?count=5'
      )

      this.billings = result.data
    },
    formattedDate(dateTime) {
      return shortHyphenDate(dateTime)
    },

    formattedPrice(price) {
      return priceFormat(price)
    },
  },

  async created() {
    this.loading = true

    await this.initBillings()

    this.loading = false
  },
}
</script>
