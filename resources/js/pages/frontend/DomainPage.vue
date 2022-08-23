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
        <v-tab href="#active">Active</v-tab>
        <v-tab href="#inactive">InActive</v-tab>
        <v-tab href="#transferred">Transferred</v-tab>
        <v-tab href="#managementOnly">ManagementOnly</v-tab>
      </v-tabs>

      <v-container class="py-1"></v-container>

      <v-tabs-items v-model="tab">
        <div v-for="(_domain, index) in domains" :key="_domain.id">
          <v-tab-item :value="index">
            <list-table :domains="_domain" @delete="deleteDomain"></list-table>
          </v-tab-item>
        </div>
      </v-tabs-items>

      <new-dialog
        :isOpen="newDialog"
        @close="closeNewModal"
        @sendMessage="sendMessage"
      ></new-dialog>

      <delete-dialog
        :isOpen="deleteDialog"
        :domain="domain"
        @close="closeDeleteModal"
        @sendMessage="sendMessage"
      ></delete-dialog>
    </v-container>
  </v-main>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import IconHeadLine from '../../components/common/IconHeadLine'
import GreetingMessage from '../../components/common/GreetingMessage'
import ListTable from '../../components/domain/ListTable'
import NewDialog from '../../components/domain/NewDialog'
import DeleteDialog from '../../components/domain/DeleteDialog'

export default {
  components: {
    IconHeadLine,
    GreetingMessage,
    ListTable,
    NewDialog,
    DeleteDialog,
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
    ]),
  },

  methods: {
    ...mapActions('domain', ['fetchDomains', 'initRole']),
    openNewModal() {
      this.newDialog = true
    },

    openDeleteModal() {
      this.deleteDialog = true
    },

    closeNewModal() {
      this.newDialog = false
    },

    closeDeleteModal() {
      this.deleteDialog = false
    },

    sendMessage(result) {
      if (result.status === 200) {
        this.greetingType = 'success'
      } else {
        this.greetingType = 'error'
      }

      this.message = result.message
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
