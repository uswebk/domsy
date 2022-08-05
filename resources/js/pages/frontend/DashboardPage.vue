<template>
  <v-main>
    <v-container>
      <h1 class="text-h5 font-weight-bold">
        <v-icon large>mdi-monitor-dashboard</v-icon> Dashboard
      </h1>

      <div class="py-5"></div>

      <v-row class="pa-5" justify="center">
        <v-col cols="4">
          <v-card class="pa-5">
            <v-card-title>Domain Active</v-card-title>
            <domain-active-pie-chart />
          </v-card>
        </v-col>
        <v-col cols="8">
          <v-card class="pa-5">
            <v-card-title>Domain Transition</v-card-title>
            <domain-line-chart />
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </v-main>
</template>

<script>
import DomainLineChart from '../../components/chart/DomainLineChart.vue'
import DomainActivePieChart from '../../components/chart/DomainActivePieChart.vue'

export default {
  name: 'LineChartContainer',
  components: { DomainLineChart, DomainActivePieChart },
}
</script>
