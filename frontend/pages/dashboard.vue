<template>
  <common-base-frame>
    <template #main>
      <v-main>
        <v-container>
          <common-icon-head-line
            :icon="'mdi-monitor-dashboard'"
            :headline-text="'Dashboard'"
          ></common-icon-head-line>
          <div class="py-5"></div>
          <v-row class="pa-5" justify="center">
            <v-col cols="3">
              <dashboard-domain-summary></dashboard-domain-summary>
            </v-col>
            <v-col cols="9">
              <dashboard-domain-transaction></dashboard-domain-transaction>
            </v-col>
          </v-row>
          <v-row class="pa-5 mt-0" justify="center">
            <v-col>
              <dashboard-domain-billings></dashboard-domain-billings>
            </v-col>
          </v-row>
          <v-row class="pa-5 mt-0" justify="center">
            <v-col>
              <dashboard-domain-expired-list></dashboard-domain-expired-list>
            </v-col>
            <v-col>
              <dashboard-domain-billing-date-list></dashboard-domain-billing-date-list>
            </v-col>
          </v-row>
        </v-container>
      </v-main>
    </template>
  </common-base-frame>
</template>

<script>
export default {
  name: 'DashboardPage',
}
</script>
