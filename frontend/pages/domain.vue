<template>
  <common-base-frame>
    <template #main>
      <v-main>
        <v-container>
          <common-icon-head-line
            :icon="'mdi-database'"
            :headline-text="'Domain'"
          ></common-icon-head-line>
          <common-greeting-message
            :type="greetingType"
            :message="greeting"
          ></common-greeting-message>
          <v-progress-linear
            v-show="pageLoading"
            color="yellow darken-2"
            indeterminate
            rounded
            height="6"
          ></v-progress-linear>
          <v-btn
            v-if="canStore"
            class="ma-2"
            color="primary"
            small
            @click="openNewDialog"
          >
            <v-icon dark left> mdi-plus-circle </v-icon>New
          </v-btn>
          <v-tabs v-model="tab">
            <v-tab
              v-for="(_tab, index) in tabs"
              :key="index"
              :href="'#' + _tab"
              >{{ _tab }}</v-tab
            >
          </v-tabs>
          <v-container class="py-1"></v-container>
          <v-tabs-items v-model="tab">
            <div v-for="(domain, index) in categorizedDomains" :key="domain.id">
              <v-tab-item :value="index">
                <domain-list-table :domains="domain"></domain-list-table>
              </v-tab-item>
            </div>
          </v-tabs-items>
          <domain-new-dialog
            :is-open="isOpenNewDialog"
            @close="closeNewDialog"
          ></domain-new-dialog>
        </v-container>
      </v-main>
    </template>
  </common-base-frame>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'DomainPage',
  data() {
    return {
      tab: '',
      isOpenNewDialog: false,
    }
  },
  computed: {
    ...mapGetters('domain', [
      'categorizedDomains',
      'canStore',
      'pageLoading',
      'greeting',
      'greetingType',
    ]),
    tabs() {
      return Object.keys(this.categorizedDomains)
    },
  },
  created() {
    this.fetchCategorizedDomains()
    this.fetchRegistrars()
    this.initRole()
  },
  methods: {
    ...mapActions('domain', ['fetchCategorizedDomains', 'initRole']),
    ...mapActions('registrar', ['fetchRegistrars']),
    openNewDialog() {
      this.isOpenNewDialog = true
    },
    closeNewDialog() {
      this.isOpenNewDialog = false
    },
  },
}
</script>
