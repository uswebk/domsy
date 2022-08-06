<template>
  <v-main>
    <v-container>
      <h1 class="text-h5 font-weight-bold">
        <v-icon large>mdi-monitor-dashboard</v-icon> Dashboard
      </h1>

      <div class="py-5"></div>

      <v-row class="pa-5" justify="center">
        <v-col cols="3">
          <v-card color="#2EBFAF" dark>
            <v-card-title class="text-h5">
              <v-avatar size="32" class="mr-4">
                <v-btn color="#e8c46a">
                  <v-icon>mdi-database</v-icon>
                </v-btn>
              </v-avatar>
              ¥ 12,010
            </v-card-title>
            <v-card-subtitle>Domain Seller</v-card-subtitle>
          </v-card>

          <div class="mb-6"></div>

          <v-card class="pb-4">
            <v-card-title>Domain Status</v-card-title>
            <domain-active-pie-chart />
            <v-card-subtitle style="text-align: center"
              >Summary: 40</v-card-subtitle
            >
          </v-card>
        </v-col>
        <v-col cols="9">
          <v-card class="pa-5">
            <v-card-title>Domain Transition</v-card-title>
            <domain-line-chart />
          </v-card>
        </v-col>
      </v-row>
      <v-row class="pa-5 mt-0" justify="center">
        <v-col>
          <v-card class="pa-5">
            <v-card-title>Billing Transition</v-card-title>
            <billing-line-chart />
          </v-card>
        </v-col>
      </v-row>
      <v-row class="pa-5 mt-0" justify="center">
        <v-col>
          <v-card class="pa-5">
            <v-card-title>Domain List</v-card-title>
            <v-simple-table>
              <thead>
                <tr>
                  <th class="text-left">Name</th>
                  <th class="text-left">Expired</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>split-man.net</td>
                  <td>2022-08-20</td>
                </tr>
                <tr>
                  <td>split-man.net</td>
                  <td>2022-08-20</td>
                </tr>
                <tr>
                  <td>split-man.net</td>
                  <td>2022-08-20</td>
                </tr>
              </tbody>
            </v-simple-table>
          </v-card>
        </v-col>
        <v-col>
          <v-card class="pa-5">
            <v-card-title>Dealing List</v-card-title>
            <v-simple-table>
              <thead>
                <tr>
                  <th class="text-left">Domain Name</th>
                  <th class="text-left">Billing Date</th>
                  <th class="text-left">Price</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>split-man.net</td>
                  <td>2022-08-20</td>
                  <td>¥1,000</td>
                </tr>
              </tbody>
            </v-simple-table>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </v-main>
</template>

<script>
import DomainLineChart from '../../components/chart/DomainLineChart.vue'
import DomainActivePieChart from '../../components/chart/DomainActivePieChart.vue'
import BillingLineChart from '../../components/chart/BillingLineChart.vue'

export default {
  name: 'LineChartContainer',
  components: { DomainLineChart, DomainActivePieChart, BillingLineChart },
}
</script>
