<template>
  <common-base-frame>
    <template #main>
      <v-main>
        <v-container>
          <common-icon-head-line
            :icon="'mdi-handshake'"
            :headline-text="'Dealing'"
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
            @click="openNewDialog()"
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
            <div v-for="(dealing, index) in dealings" :key="dealing.id">
              <v-tab-item :value="index">
                <dealing-list-table :dealings="dealing"></dealing-list-table>
              </v-tab-item>
            </div>
          </v-tabs-items>
          <dealing-new-dialog
            :is-open="isOpenNewDialog"
            @close="closeNewDialog"
          ></dealing-new-dialog>
        </v-container>
      </v-main>
    </template>
  </common-base-frame>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'DealingPage',
  data() {
    return {
      tab: '',
      isOpenNewDialog: false,
    }
  },
  computed: {
    ...mapGetters('dealing', [
      'dealings',
      'canStore',
      'pageLoading',
      'greeting',
      'greetingType',
    ]),
    tabs() {
      return Object.keys(this.dealings)
    },
  },
  created() {
    this.fetchDealings()
    this.fetchDomains()
    this.fetchClients()
    this.initRole()
  },
  methods: {
    ...mapActions('dealing', ['fetchDealings', 'initRole']),
    ...mapActions('domain', ['fetchDomains']),
    ...mapActions('client', ['fetchClients']),
    openNewDialog() {
      this.isOpenNewDialog = true
    },
    closeNewDialog() {
      this.isOpenNewDialog = false
    },
  },
}
</script>
