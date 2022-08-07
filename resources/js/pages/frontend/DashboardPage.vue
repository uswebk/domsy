<template>
  <v-main>
    <v-container>
      <h1 class="text-h5 font-weight-bold">
        <v-icon large>mdi-monitor-dashboard</v-icon> Dashboard
      </h1>

      <div class="py-5"></div>

      <v-row class="pa-5" justify="center">
        <v-col cols="3">
          <domain-summary></domain-summary>
        </v-col>
        <v-col cols="9">
          <domain-transaction></domain-transaction>
        </v-col>
      </v-row>
      <v-row class="pa-5 mt-0" justify="center">
        <v-col>
          <domain-billings></domain-billings>
        </v-col>
      </v-row>
      <v-row class="pa-5 mt-0" justify="center">
        <v-col>
          <domain-expired-list></domain-expired-list>
        </v-col>
        <v-col>
          <domain-billing-date-list></domain-billing-date-list>
        </v-col>
      </v-row>
    </v-container>
  </v-main>
</template>

<script>
import DomainSummary from '../../components/dashboard/DomainSummary.vue'
import DomainTransaction from '../../components/dashboard/DomainTransaction.vue'
import DomainBillings from '../../components/dashboard/DomainBillings.vue'
import DomainExpiredList from '../../components/dashboard/DomainExpiredList.vue'
import DomainBillingDateList from '../../components/dashboard/DomainBillingDateList.vue'

export default {
  name: 'LineChartContainer',
  components: {
    DomainSummary,
    DomainTransaction,
    DomainBillings,
    DomainExpiredList,
    DomainBillingDateList,
  },
}
</script>
