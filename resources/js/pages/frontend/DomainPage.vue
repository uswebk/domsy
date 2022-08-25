<template>
  <v-main>
    <v-container>
      <icon-head-line
        :icon="'mdi-database'"
        :headlineText="'Domain'"
      ></icon-head-line>

      <div class="py-5"></div>

      <greeting-message
        :type="greetingType"
        :message="greeting"
      ></greeting-message>

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
        @click="openNewModal"
      >
        <v-icon dark left> mdi-plus-circle </v-icon>New
      </v-btn>

      <v-tabs v-model="tab">
        <v-tab v-for="(tab, index) in tabs" :key="index" :href="'#' + tab">{{
          tab
        }}</v-tab>
      </v-tabs>

      <v-container class="py-1"></v-container>

      <v-tabs-items v-model="tab">
        <div v-for="(domain, index) in domains" :key="domain.id">
          <v-tab-item :value="index">
            <list-table :domains="domain" @delete="deleteDomain"></list-table>
          </v-tab-item>
        </div>
      </v-tabs-items>

      <new-dialog :isOpen="newDialog" @close="closeNewModal"></new-dialog>
    </v-container>
  </v-main>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import IconHeadLine from '../../components/common/IconHeadLine'
import GreetingMessage from '../../components/common/GreetingMessage'
import ListTable from '../../components/domain/ListTable'
import NewDialog from '../../components/domain/NewDialog'

export default {
  components: {
    IconHeadLine,
    GreetingMessage,
    ListTable,
    NewDialog,
  },

  data() {
    return {
      tab: '',
      domain: {},
      newDialog: false,
      deleteDialog: false,
    }
  },

  computed: {
    ...mapGetters('domain', [
      'domains',
      'canStore',
      'pageLoading',
      'greeting',
      'greetingType',
      'tabs',
    ]),
  },

  methods: {
    ...mapActions('domain', ['fetchDomains', 'initRole']),
    openNewModal() {
      this.newDialog = true
    },

    closeNewModal() {
      this.newDialog = false
    },

    async deleteDomain(domain) {
      this.domain = domain

      this.openDeleteModal()
    },
  },

  async created() {
    this.fetchDomains()
    this.initRole()
  },
}
</script>
